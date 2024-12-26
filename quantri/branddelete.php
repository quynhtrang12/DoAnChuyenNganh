<?php

// kết nối dữ liệu
require_once('../db/config.php');
include('class/brand_class.php')
?>
<?php
$brand = new brand;
//lấy id
if(isset($_GET['brand_id'])|| $_GET['brand_id']!=NULL){
    $brand_id = $_GET['brand_id'];
    }
    $detele_brand = $brand -> delete_brand($brand_id);
    
?>
<?php
require('includes/header.php');

?>
