<?php
include "../db/database.php";
?>
<?php
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
?>