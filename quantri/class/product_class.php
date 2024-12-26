<?php
include "../db/database.php";

class product {
    private $db;

    public function __construct() {
        $this->db = new Database(); // Kết nối mysqli thông qua lớp Database
    }

    public function show_cartegory() {
        $query = "SELECT * FROM tbl_danhmuc";
        return $this->db->select($query);
    }

    public function show_size() {
        $query = "SELECT * FROM tbl_size";
        return $this->db->select($query);
    }

    public function show_loaisanpham_ajax($danhmuc_id) {
        $query = "SELECT * FROM tbl_loaisanpham WHERE danhmuc_id = $danhmuc_id ORDER BY loaisanpham_id DESC";
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
?>
