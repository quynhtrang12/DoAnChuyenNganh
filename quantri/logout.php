<?php
session_start(); // Bắt đầu phiên
session_unset(); // Xóa tất cả các biến phiên
session_destroy(); // Kết thúc phiên

// Chuyển hướng về trang đăng nhập hoặc trang chủ
header('Location: login.php');
exit();
?>
