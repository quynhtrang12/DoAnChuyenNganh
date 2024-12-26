<?php
include "../db/database.php";
?>
<?php
class size{
    private $db;
    public function __construct()
    {
        $this->db= new Database();
    }
    public function insert_size($size_ten){
        $query = "INSERT INTO tbl_size (size_ten) VALUES ('$size_ten')";
        $result = $this ->db ->insert($query);
        
    }
    public function show_size(){
        $query = "SELECT * FROM tbl_size ORDER BY size_id DESC";
        $result = $this ->db ->select($query);
        return $result;
    }
    
    public function delete_size ($size_id){
        $query ="DELETE FROM tbl_size WHERE size_id ='$size_id'";
        $result =$this->db->delete($query);
        //header('Location:listdanhmuc.php');
        return $result;
    }



    
}
?>