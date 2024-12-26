<?php
include('class/brand_class.php');
?>
<?php
$brand = new brand;
$show_brand = $brand->show_brand();
?>
<?php
require('includes/header.php');
?>
<div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Danh Sách Loại Sản Phẩm </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>ID Loại Sản Phẩm</th>
                                            <th>Danh Mục </th>
                                            <th>Loại Sản Phẩm </th>
                                            <th>Tùy Chỉnh</th>
                                        </tr>
                                    </thead>
                                    <?php 
                                    if($show_brand){$i=0; while($result =$show_brand->fetch_assoc()){
                                            $i++;
                                    ?>
                                        <thead>
                                            <tr>
                                                <th><?php echo $i ?></th>
                                                <th><?php  echo $result ["loaisanpham_id"] ?></th>
                                                <th><?php  echo $result ["danhmuc_name"] ?> </th>
                                                <th><?php  echo $result ["loaisanpham_ten"] ?> </th>
                                                <th><a href="brandedit.php?brand_id=<?php  echo $result ["loaisanpham_id"] ?>">Sửa</a>|<a href="branddelete.php?brand_id=<?php  echo $result ["loaisanpham_id"] ?>">Xóa</a></th>
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
