<?php
//include($_SERVER['DOCUMENT_ROOT'] . '/DOANCHUYENNGANH/db/database.php');
// include('../db/database.php');
require_once '../db/database.php';
?>
<?php

if (!class_exists('product')) {
class product{
    private $db;
    public function __construct()
    {
        $this->db= new Database();
    }
    public function search_products($keyword) {
        $conn = $this->db->link; // Truy cập trực tiếp vào $link
    
        $query = "SELECT * FROM tbl_sanpham
                  WHERE sanpham_ten LIKE ? 
                     OR sanpham_mota LIKE ?";
    
        $stmt = $conn->prepare($query);
        $like_keyword = "%$keyword%";
        $stmt->bind_param("ss", $like_keyword, $like_keyword);
    
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
    
    public function insert_register($danhmuc_ten){
        $query = "INSERT INTO tbl_danhmuc (danhmuc_name) VALUES ('$danhmuc_ten')";
        $result = $this ->db ->insert($query);
        if ($result) {
            header('Location:listdanhmuc.php');
            exit; // Đảm bảo PHP dừng lại sau khi chuyển hướng
        }
    
        return $result;
    }
    public function get_products_by_category_and_type($danhmuc_id, $loaisanpham_id) {
        $query = "SELECT tbl_sanpham.*, 
                         tbl_danhmuc.danhmuc_name, 
                         tbl_loaisanpham.loaisanpham_ten
                  FROM tbl_sanpham
                  JOIN tbl_danhmuc ON tbl_sanpham.danhmuc_id = tbl_danhmuc.danhmuc_id
                  JOIN tbl_loaisanpham ON tbl_sanpham.loaisanpham_id = tbl_loaisanpham.loaisanpham_id
                  WHERE tbl_sanpham.danhmuc_id = '$danhmuc_id' 
                  AND tbl_sanpham.loaisanpham_id = '$loaisanpham_id'
                  ORDER BY tbl_sanpham.sanpham_id DESC";
        $result = $this->db->select($query);
        return $result;
    }
    public function get_product_by_id($sanpham_id) {
        $query = "SELECT * FROM tbl_sanpham WHERE sanpham_id = ?";
        echo "Truy vấn: " . $query; // Debug
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("i", $sanpham_id); 
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            return $result; 
        } else {
            return false; 
        }
    }
    
    
    public function show_cartegory() {
        $query = "SELECT * FROM tbl_danhmuc";
        return $this->db->select($query);
    }
    
    public function insert_product($sanpham_ten, $sanpham_ma, $danhmuc_id, $loaisanpham_id, $sanpham_soluong, $sanpham_gia, $sanpham_mota, $sanpham_anh, $size_id) {
        $query = "INSERT INTO tbl_sanpham (sanpham_ten, sanpham_ma, danhmuc_id, loaisanpham_id, sanpham_soluong, sanpham_gia, sanpham_mota, sanpham_anh) 
                  VALUES ('$sanpham_ten', '$sanpham_ma', '$danhmuc_id', '$loaisanpham_id', '$sanpham_soluong', '$sanpham_gia', '$sanpham_mota', '$sanpham_anh')";
        $this->db->insert($query);
        $sanpham_id = $this->db->link->insert_id; // Lấy ID sản phẩm vừa chèn

        // Thêm kích thước vào bảng trung gian tbl_sanpham_size
        foreach ($size_id as $size) {
            $query = "INSERT INTO tbl_sanpham_size (sanpham_id, size_id) VALUES ('$sanpham_id', '$size')";
            $this->db->insert($query);
        }
        header('Location: listsanpham.php');
    }

    public function getLastInsertedId() {
        return $this->db->link->insert_id;
    }

    public function insertProductSize($sanpham_id, $size_id) {
        $query = "INSERT INTO tbl_sanpham_size (sanpham_id, size_id) VALUES ('$sanpham_id', '$size_id')";
        if (!$this->db->insert($query)) {
            echo "Error inserting size $size_id: " . $this->db->link->error;
        }
        return $this->db->link->insert_id;
    }

    public function show_all_products() {
        $query = "SELECT p.*, GROUP_CONCAT(ps.size_id) as size_ids, d.danhmuc_name, l.loaisanpham_ten 
                  FROM tbl_sanpham p
                  LEFT JOIN tbl_sanpham_size ps ON p.sanpham_id = ps.sanpham_id
                  LEFT JOIN tbl_danhmuc d ON p.danhmuc_id = d.danhmuc_id
                  LEFT JOIN tbl_loaisanpham l ON p.loaisanpham_id = l.loaisanpham_id
                  GROUP BY p.sanpham_id";
        return $this->db->select($query);
    }
    public function getProductById($sanpham_id) {
        $query = "SELECT p.*, d.danhmuc_name, l.loaisanpham_ten 
                  FROM tbl_sanpham p
                  LEFT JOIN tbl_danhmuc d ON p.danhmuc_id = d.danhmuc_id
                  LEFT JOIN tbl_loaisanpham l ON p.loaisanpham_id = l.loaisanpham_id
                  WHERE p.sanpham_id = $sanpham_id";
        return $this->db->select($query)->fetch_assoc();
    }
    
    public function getProductSizes($sanpham_id) {
        $query = "SELECT size_id FROM tbl_sanpham_size WHERE sanpham_id = $sanpham_id";
        $result = $this->db->select($query);
        $size_ids = [];
        while ($row = $result->fetch_assoc()) {
            $size_ids[] = $row['size_id'];
        }
        return $size_ids;
    }
    

    public function getSizeNames($size_ids) {
        $size_names = [];
        if (!empty($size_ids)) {
            $placeholders = implode(',', array_fill(0, count($size_ids), '?'));
            $query = "SELECT size_ten FROM tbl_size WHERE size_id IN ($placeholders)";
            $stmt = $this->db->link->prepare($query);
            $types = str_repeat('i', count($size_ids));
            $stmt->bind_param($types, ...$size_ids);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $size_names[] = $row['size_ten'];
            }
        }
        return $size_names;
    }

    public function delete_product($sanpham_id) {
        $query = "DELETE FROM tbl_sanpham WHERE sanpham_id = '$sanpham_id'";
        $this->db->delete($query);
        header('Location: listsanpham.php');
    }
}
}
if (!class_exists('cartegory')) {
class cartegory{
    private $db;
    public function __construct()
    {
        $this->db= new Database();
    }
    public function insert_cartegory($danhmuc_ten){
        $query = "INSERT INTO tbl_danhmuc (danhmuc_name) VALUES ('$danhmuc_ten')";
        $result = $this ->db ->insert($query);
        if ($result) {
            header('Location:listdanhmuc.php');
            exit; // Đảm bảo PHP dừng lại sau khi chuyển hướng
        }
    
        return $result;
    }
    public function show_cartegory(){
        $query = "SELECT * FROM tbl_danhmuc ORDER BY danhmuc_id DESC";
        $result = $this ->db ->select($query);
        return $result;
    }
    public function get_cartegory($danhmuc_id){
        $query = "SELECT * FROM tbl_danhmuc WHERE danhmuc_id ='$danhmuc_id'";
        $result=$this->db ->select($query);
        return $result;
    }
    public function update_cartegory($danhmuc_ten,$danhmuc_id){
        $query ="UPDATE tbl_danhmuc SET danhmuc_name ='$danhmuc_ten' WHERE danhmuc_id = '$danhmuc_id'";
        $result = $this ->db ->update($query);
        header('Location:listdanhmuc.php');
        return $result;
    }
    public function delete_cartegory ($danhmuc_id){
        $query ="DELETE FROM tbl_danhmuc WHERE danhmuc_id ='$danhmuc_id'";
        $result =$this->db->delete($query);
        header('Location:listdanhmuc.php');
        return $result;
    }
}
}
if (!class_exists('brand')) {
class brand{
    private $db;
    public function __construct()
    {
        $this->db= new Database();
    }
    public function show_cartegory(){
        $query = "SELECT * FROM tbl_danhmuc ORDER BY danhmuc_id DESC";
        $result = $this ->db ->select($query);
        return $result;
    }
    public function insert_brand($danhmuc_id,$loaisanpham_ten){
        $query = "INSERT INTO tbl_loaisanpham (danhmuc_id,loaisanpham_ten) VALUES ('$danhmuc_id','$loaisanpham_ten')";
        $result = $this ->db ->insert($query);
         header('Location:listloaisp.php');
        return $result;
    }
    public function show_brand_by_cartegory($danhmuc_id){
        $query = "SELECT * FROM tbl_loaisanpham WHERE danhmuc_id = '$danhmuc_id' ORDER BY loaisanpham_id DESC";
        $result = $this->db->select($query);
        return $result;
    }
    
    public function show_brand(){
        $query = "SELECT tbl_loaisanpham.*, tbl_danhmuc.danhmuc_name
        FROM tbl_loaisanpham INNER JOIN tbl_danhmuc ON tbl_loaisanpham.danhmuc_id = tbl_danhmuc.danhmuc_id
        ORDER BY tbl_loaisanpham.loaisanpham_id DESC ";
        $result = $this ->db ->select($query);
        return $result;
    }
    public function get_brand($brand_id){
        $query = "SELECT * FROM tbl_loaisanpham WHERE loaisanpham_id ='$brand_id'";
        $result=$this->db ->select($query);
        return $result;
    }
    public function update_brand($danhmuc_id,$loaisanpham_ten,$brand_id){
        $query ="UPDATE tbl_loaisanpham SET danhmuc_id ='$danhmuc_id', loaisanpham_ten ='$loaisanpham_ten'  WHERE loaisanpham_id = '$brand_id'";
        $result = $this ->db ->update($query);
        header('Location:listloaisp.php');
        return $result;
    }
    public function delete_brand($brand_id){
        $query ="DELETE FROM tbl_loaisanpham WHERE loaisanpham_id ='$brand_id'";
        $result =$this->db->delete($query);
        header('Location:listloaisp.php');
        return $result;
    }
}

}
?>



