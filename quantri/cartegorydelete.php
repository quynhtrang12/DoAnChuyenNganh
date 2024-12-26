<?php

// kết nối dữ liệu
require_once('../db/config.php');
include('class/danhmuc_class.php')
?>
<?php
$cartegory = new cartegory;
//lấy id
if(isset($_GET['danhmuc_id'])|| $_GET['danhmuc_id']!=NULL){
    $danhmuc_id = $_GET['danhmuc_id'];
    }
    $detele_cartegory = $cartegory -> delete_cartegory($danhmuc_id);
?>
<?php
require('includes/header.php');
?>
