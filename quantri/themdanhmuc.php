<?php
// kết nối dữ liệu
require_once('../db/config.php');
include('class/danhmuc_class.php');
$cartegory = new cartegory;
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $danhmuc_ten =$_POST['danhmuc_ten'];
    $insert_cartegory =$cartegory ->insert_cartegory($danhmuc_ten);
}
?>
<?php
require('includes/header.php');
?>

<h1>Trang Thêm Danh Mục</h1>
<div class="admin-content-right">
    <div class="cartegory-add-content">
        <form action="" method="POST" enctype ="multipart/form-data">
            <label for="">Vui lòng điền danh mục <span style="color: red">*</span></label> <br>
            <input type="text" name="danhmuc_ten">
            <button class="admin-btn" type="submit">Thêm</button>

        </form>
    </div>
</div>
<?php
require('includes/footer.php');
?>