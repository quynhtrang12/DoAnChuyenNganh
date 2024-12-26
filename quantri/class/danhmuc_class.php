<?php
include "../db/database.php";
?>
<?php
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
            exit; 
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
?>