<?php

// echo "xin chao";


require('../db/conn.php');

//lay du lieu tu form
$id = $_POST['nhanvien_id'];
$name = $_POST['nhanvien_ten'];
$gioitinh = $_POST['nhanvien_gioitinh'];
$namsinh = $_POST['nhanvien_namsinh'];
$chucvu = $_POST['nhanvien_chucvu'];
$sdt = $_POST['nhanvien_sdt'];
$diachi = $_POST['nhanvien_diachi'];
$Email = $_POST['nhanvien_Email'];
$password = $_POST['nhanvien_matkhau'];
// cau lenh them vao bang
$sql_str = "INSERT INTO `tbl_nhanvien` (`nhanvien_id`, `nhanvien_ten`, `nhanvien_gioitinh`, `nhanvien_namsinh`,
 `nhanvien_chucvu`, `nhanvien_sdt`, `nhanvien_diachi`, `nhanvien_Email`,`nhanvien_matkhau`,`created_at`) VALUES 
    ('$id',
    '$name', 
    '$gioitinh',
    '$namsinh',
    '$chucvu',
    '$sdt',
    '$diachi',
    '$Email',
    '$password', 
    NOW());";

// echo $sql_str;
// exit;

//thuc thi cau lenh
mysqli_query($conn, $sql_str);

//tro ve trang 
header("location: ./listusers.php");
?>