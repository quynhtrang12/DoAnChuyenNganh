<?php

// kết nối dữ liệu
require_once('../db/config.php');
include('class/brand_class.php')
?>
<?php
//lấy id
$brand = new brand;
if(isset($_GET['brand_id'])|| $_GET['brand_id']!=NULL){
    $brand_id = $_GET['brand_id'];
    }
    $get_brand = $brand -> get_brand($brand_id);
    if($get_brand){$resultA = $get_brand ->fetch_assoc();}
    
?>
<?php
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $danhmuc_id =$_POST['danhmuc_id'];
    $loaisanpham_ten = $_POST['loaisanpham_ten'];
    $insert_brand = $brand -> update_brand($danhmuc_id,$loaisanpham_ten,$brand_id);
}
?>
<?php
require('includes/header.php');
?>

<h1>Sửa Loại Sản Phẩm</h1>
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
                <option <?php if($result['danhmuc_id']==$resultA['danhmuc_id']) {echo "selected";}?> value="<?php echo $result['danhmuc_id'] ?>"><?php echo $result['danhmuc_name'] ?></option>
                <?php
                    }}
                ?>
                
            </select><br><br>
            <label for="">Vui lòng sửa loại sản phẩm <span style="color: red">*</span></label> <br>
            <input type="text" value ="<?php echo $resultA['loaisanpham_ten'] ?>" name="loaisanpham_ten">
            <button class="admin-btn" type="submit">Sửa</button>

        </form>
    </div>
</div>
<?php
require('includes/footer.php');
?>