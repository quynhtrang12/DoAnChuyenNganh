<?php

// kết nối dữ liệu
require_once('../db/config.php');
include('class/product_class.php')
?>
<?php
$product = new product;
//lấy id
if(isset($_GET['product_id'])|| $_GET['product_id']!=NULL){
    $sanpham_id = $_GET['product_id'];
    }
    $detele_product = $product -> delete_product($sanpham_id);
    
?>
<?php
require('includes/header.php');

?>
