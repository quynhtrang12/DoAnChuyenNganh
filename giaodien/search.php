<?php
require('include/header.php');
?>
<?php
$product = new product();
 $cartegory = new cartegory;
 $show_cartegory = $cartegory->show_cartegory();
 // Lấy từ khóa tìm kiếm từ URL
$tukhoa = $_GET['tukhoa'] ?? "";
// Tìm kiếm sản phẩm dựa vào từ khóa
$search_results = $product->search_products($tukhoa);
 ?>
<section class="cartegory">
    <div class="container">
        <div class="cartegory-top row">
            <p>Trang chủ </p> <span>&#10230</span> <p> Tìm kiếm: "<?php echo htmlspecialchars($tukhoa); ?>"</p>
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
                <div class="cartegory-right" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 20px;">
                    <?php
                    // Hiển thị kết quả tìm kiếm
                    if ($search_results) {
                        while ($result = $search_results->fetch_assoc()) {
                            $images = json_decode($result["sanpham_anh"], true);
                            $first_image = !empty($images) ? $images[0] : '';
                    ?>
                            <div class="cartegory-right-content-item" style="display: flex; flex-direction: column; align-items: center; text-align: center;">
                                <a href="product.php?sanpham_id=<?php echo $result['sanpham_id']; ?>">
                                    <img src="../uploads/<?php echo htmlspecialchars($first_image); ?>" alt="Product Image" style="max-width: 100%; height: auto;">
                                </a>
                                <h1><?php echo htmlspecialchars($result["sanpham_ten"]); ?></h1>
                                <p><?php echo htmlspecialchars($result["sanpham_gia"]); ?><sup>đ</sup></p>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<p>Không tìm thấy sản phẩm nào phù hợp.</p>";
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
