<?php
include('class/product_class.php');

$product = new product;
$show_product = $product->show_all_products();
?>
<?php
require('includes/header.php');
?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh Sách Sản Phẩm</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>ID Sản Phẩm</th>
                        <th>Tên Sản Phẩm</th>
                        <th>Mã Sản Phẩm</th>
                        <th>Danh Mục Sản Phẩm</th>
                        <th>Loại Sản Phẩm</th>
                        <th>Size</th>
                        <th>Số lượng</th>
                        <th>Giá Sản Phẩm</th>
                        <th>Mô Tả</th>
                        <th>Ảnh Sản Phẩm</th>
                        <th>Tùy Chỉnh</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                if ($show_product) {
                    $i = 0;
                    while ($result = $show_product->fetch_assoc()) {
                        $i++;
                        // Lấy danh sách các size nếu không null
                        $size_ids = !empty($result['size_ids']) ? explode(',', $result['size_ids']) : [];
                        $size_names = $product->getSizeNames($size_ids);
                        $formatted_price = number_format($result['sanpham_gia'], 0, ',', '.');
                ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo htmlspecialchars($result['sanpham_id']); ?></td>
                        <td><?php echo htmlspecialchars($result['sanpham_ten']); ?></td>
                        <td><?php echo htmlspecialchars($result['sanpham_ma']); ?></td>
                        <td><?php echo htmlspecialchars($result['danhmuc_name']); ?></td>
                        <td><?php echo htmlspecialchars($result['loaisanpham_ten']); ?></td>
                        <td><?php echo implode(', ', $size_names); ?></td> <!-- Hiển thị tên size -->
                        <td><?php echo htmlspecialchars($result['sanpham_soluong']); ?></td>
                        <td><?php echo $formatted_price; ?><sup>đ</sup></td>
                        <td>
                            <div class="container">
                                <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal<?php echo $i; ?>">Open description <i class="far fa-hand-pointer"></i></button>
                                <div class="modal fade" id="myModal<?php echo $i; ?>" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Mô Tả Sản Phẩm: <?php echo htmlspecialchars($result['sanpham_ten']); ?></h4>
                                            </div>
                                            <div class="modal-body">
                                                <p><?php echo htmlspecialchars($result['sanpham_mota']); ?></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?php
                            $images = json_decode($result['sanpham_anh'], true);
                            if (!empty($images)) {
                                $first_image = $images[0];
                                echo '<img style="width: 100px; height: 120px;" src="../uploads/' . htmlspecialchars($first_image) . '" alt="Ảnh sản phẩm">';
                            } else {
                                echo "Không có ảnh.";
                            }
                            ?>
                        </td>
                        <td><a href="productdelete.php?product_id=<?php echo htmlspecialchars($result['sanpham_id']); ?>">Xóa</a></td>
                    </tr>
                <?php
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
require('includes/footer.php');
?>
