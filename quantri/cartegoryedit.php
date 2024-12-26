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
    $get_cartegory = $cartegory -> get_cartegory($danhmuc_id);
    if($get_cartegory){$result = $get_cartegory ->fetch_assoc();}
?>

<?php
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $danhmuc_ten =$_POST['danhmuc_ten'];
    $update_cartegory =$cartegory ->update_cartegory($danhmuc_ten,$danhmuc_id);
}
?>
<?php
require('includes/header.php');
?>
<h1>Trang Sửa Danh Mục</h1>
<div class="admin-content-right">
    <div class="cartegory-add-content">
        <form action="" method="POST" enctype ="multipart/form-data">
            <label for="">Vui lòng điền danh mục <span style="color: red">*</span></label> <br>
            <input type="text" name="danhmuc_ten" value ="<?php echo $result['danhmuc_name']  ?>">
            <button class="admin-btn" type="submit">Sửa</button>

        </form>
    </div>
</div>
<?php
require('includes/footer.php');
?>