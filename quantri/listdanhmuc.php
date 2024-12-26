<?php
include('class/danhmuc_class.php')
?>
<?php
$cartegory = new cartegory;
$show_cartegory = $cartegory->show_cartegory();
?>
<?php
require('includes/header.php');
?>
<div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Danh Sách Danh Mục </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>ID</th>
                                            <th>Danh Mục </th>
                                            <th>Tùy Chỉnh</th>
                                        </tr>
                                    </thead>
                                    <?php 
                                    if($show_cartegory){$i=0; while($result =$show_cartegory->fetch_assoc()){
                                            $i++;
                                    ?>
                                        <thead>
                                            <tr>
                                                <th><?php echo $i ?></th>
                                                <th><?php  echo $result ["danhmuc_id"] ?></th>
                                                <th><?php  echo $result ["danhmuc_name"] ?> </th>
                                                <th><a href="cartegoryedit.php?danhmuc_id=<?php  echo $result ["danhmuc_id"] ?>">Sửa</a>|<a href="cartegorydelete.php?danhmuc_id=<?php  echo $result ["danhmuc_id"] ?>">Xóa</a></th>
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
