<?php
require('include/header.php');
?>
<?php
 $cartegory = new cartegory;
 $show_cartegory = $cartegory->show_cartegory();
 ?>
<section class="cartegory">
    <div class="container">
        <div class="cartegory-top row">
            <p>Trang chủ </p> <span>&#10230</span> <p> Hàng Thiết Kế</p>
        </div>
    </div>
    
    <div class="container">
        <div class="row">
            <div class="cartegory-left">
                <ul>
                    
                    <?php if ($show_cartegory) { ?>
                        <?php while ($result_cartegory = $show_cartegory->fetch_assoc()) { ?>
                            <li class="cartegory-left-li block">
                                <a href="#" class="toggle-btn"><?php echo htmlspecialchars($result_cartegory["danhmuc_name"]); ?></a>
                                <?php
                                $brand = new brand;
                                $show_brand = $brand->show_brand_by_cartegory($result_cartegory['danhmuc_id']);
                                ?>
                                <?php if ($show_brand) { ?>
                                    <ul class="dropdown hidden">
                                        <?php while ($result_brand = $show_brand->fetch_assoc()) { ?>
                                            <li>
                                                <a href="cartegory.php?danhmuc_id=<?php echo $result_cartegory['danhmuc_id']; ?>&loaisanpham_id=<?php echo $result_brand['loaisanpham_id']; ?>">
                                                    <?php echo htmlspecialchars($result_brand["loaisanpham_ten"]); ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                <?php } ?>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </div>

            <div class="cartegory-right row">
                <div class="cartegory-right-top-item">
                    <p>Hàng Thiết Kế </p>
                </div>
                <div class="cartegory-right-top-item">
                    <button><span>Bộ Lọc </span><i class="fa-solid fa-sort-down"></i></button>
                </div>
                <div class="cartegory-right-top-item">
                    <select name="" id="">
                        <option value="">Sắp xếp</option>
                        <option value="">Giá cao đến thấp</option>
                        <option value="">Giá thấp đến cao</option>
                    </select>
                </div>

                <?php
                include('../class/class.php');
                $product = new product();

                // Lấy các tham số danh mục và loại sản phẩm từ URL
                $danhmuc_id = $_GET['danhmuc_id'] ?? 0;
                $loaisanpham_id = $_GET['loaisanpham_id'] ?? 0;

                // Lọc sản phẩm theo danh mục và loại sản phẩm
                $filtered_products = $product->get_products_by_category_and_type($danhmuc_id, $loaisanpham_id);
                ?>

                <div class="cartegory-right-content row">
                    <?php
                    if ($filtered_products) {
                        while ($result = $filtered_products->fetch_assoc()) {
                            $images = json_decode($result["sanpham_anh"], true);
                            $first_image = !empty($images) ? $images[0] : '';
                            // Định dạng lại giá sản phẩm
                            $formatted_price = number_format($result['sanpham_gia'], 0, ',', '.');
                    ?>
                            <div class="cartegory-right-content-item">
                                <a href="product.php?sanpham_id=<?php echo $result['sanpham_id']; ?>">
                                    <img src="../uploads/<?php echo htmlspecialchars($first_image); ?>" alt="Product Image">
                                </a>
                                <h1><?php echo htmlspecialchars($result["sanpham_ten"]); ?></h1>
                                <p><?php echo $formatted_price; ?><sup>đ</sup></p> <!-- Hiển thị giá sản phẩm đã định dạng -->
                            </div>
                    <?php
                        }
                    } else {
                        echo "<p>Chưa có sản phẩm nào.</p>";
                    }
                    ?>
                </div>

                <div class="cartegory-right-bottom row">
                    <div class="cartegory-right-bottom-iten">
                        <p>Hiển thị 2 <span>|</span> 4 sản phẩm </p>
                    </div>
                    <div class="cartegory-right-bottom-iten">
                        <p><span>&#171;<span>1 2 3 4 5 </span>&#187;</span> Trang cuối </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Lấy tất cả các nút toggle
        const toggleButtons = document.querySelectorAll(".toggle-btn");

        toggleButtons.forEach((btn) => {
            btn.addEventListener("click", function (e) {
                e.preventDefault(); // Ngăn chặn hành vi mặc định của thẻ <a>

                // Lấy dropdown (danh mục con) tương ứng
                const dropdown = this.nextElementSibling;

                if (dropdown) {
                    // Toggle class "active"
                    dropdown.classList.toggle("active");
                    dropdown.classList.toggle("hidden");
                }
            });
        });
    });
</script>

<?php
require('include/foter.php');
?>
