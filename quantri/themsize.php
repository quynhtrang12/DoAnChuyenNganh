<?php
// kết nối dữ liệu
require_once('../db/config.php');
include('class/size_class.php');
$size = new size ;
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $size_ten =$_POST['size_ten'];
    $insert_size =$size ->insert_size($size_ten);
}
$show_size = $size->show_size();
?>
<?php
require('includes/header.php');
?>
<h1>Thêm Size Sản Phẩm </h1>
<div class="admin-content-right">
    <div class="cartegory-add-content">
        <form action="" method="POST" enctype ="multipart/form-data">
            <label for="">Điền size Sản phẩm  <span style="color: red">*</span></label> <br>
            <input type="text" name="size_ten">
            <button class="admin-btn" type="submit">Thêm</button>
        </form>
    </div>
</div>
<div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Danh Sách size </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>ID</th>
                                            <th>Tên Size </th>
                                            <th>Tùy Chỉnh</th>
                                        </tr>
                                    </thead>
                                    <?php 
                                    if($show_size){$i=0; while($result =$show_size->fetch_assoc()){
                                            $i++;
                                    ?>
                                        <thead>
                                            <tr>
                                                <th><?php echo $i ?></th>
                                                <th><?php  echo $result ["size_id"] ?></th>
                                                <th><?php echo htmlspecialchars($result["size_ten"]); ?></th>
                                                <th><a href="sizedelete.php?size_id=<?php echo $result['size_id'] ?>">Xóa</a></th>
                                                </tr>
                                        </thead>
                                    <?php
                                    }}
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
<?php

require('includes/footer.php');
?>