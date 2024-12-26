<?php
// kết nối dữ liệu
require_once('../db/config.php');
include('class/brand_class.php')
?>
<?php
$brand = new brand;
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $danhmuc_id =$_POST['danhmuc_id'];
    $loaisanpham_ten = $_POST['loaisanpham_ten'];
    $insert_brand = $brand -> insert_brand($danhmuc_id,$loaisanpham_ten);
    
}
?>
<?php
require('includes/header.php');

?>

<h1>Thêm Loại Sản Phẩm</h1>
<div class="admin-content-right">
    <div class="brand-add-content">
        <form action="" method="POST" enctype ="multipart/form-data">
            <label for="">Chọn danh mục <span style="color: red">*</span></label> <br>
            <select name="danhmuc_id" id="">
                <option value="">Vui lòng chọn danh mục</option>
                <?php
                $show_cartegory = $brand -> show_cartegory();
                if($show_cartegory) {while($result = $show_cartegory -> fetch_assoc()){
                ?>
                <option value="<?php echo $result['danhmuc_id'] ?>"><?php echo $result['danhmuc_name'] ?></option>
                <?php
                    }}
                ?>
                
            </select><br><br>
            <label for="">Vui lòng điền loại sản phẩm <span style="color: red">*</span></label> <br>
            <input type="text" name="loaisanpham_ten">
            <button class="admin-btn" type="submit">Thêm</button>

        </form>
    </div>
</div>
<?php
require('includes/footer.php');
?>