<?php
require_once('../db/config.php');
include('class/size_class.php');

$size = new size;

if (isset($_GET['size_id'])) {
    $size_id = $_GET['size_id'];
    $delete_size = $size->delete_size($size_id);

    if ($delete_size) {
        echo "<script>alert('Xóa size thành công!'); window.location.href='themsize.php';</script>";
    } else {
        echo "<script>alert('Xóa size thất bại!'); window.location.href='themsize.php';</script>";
    }
} else {
    echo "<script>window.location.href='themsizethemsize.php';</script>";
}
?>
