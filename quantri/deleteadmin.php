<?php
session_start();
//lay id goi den
$delid = $_GET['nhanvien_id'];

//ket noi csdl
require('../db/conn.php');
if($_SESSION['user']['nhanvien_chucvu'] !='Quản Lý'){
    echo"<h2>Bạn Không Có Quyền Truy Cập Chức Năng Này</h2>";
}
else{
//xoa du lieu san pham trong CSDL
$sql_str = "delete from tbl_nhanvien where nhanvien_id=$delid";
mysqli_query($conn, $sql_str);

//trở về trang liệt kê brands
header("location: listusers.php");
    }