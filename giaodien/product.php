<?php
require('../db/conn.php'); 
require('../class/class.php');

$product = new product;

if (isset($_GET['sanpham_id']) && is_numeric($_GET['sanpham_id'])) {
    $sanpham_id = (int)$_GET['sanpham_id'];
    $product_info = $product->getProductById($sanpham_id);
    $size_ids = $product->getProductSizes($sanpham_id);
    $size_names = $product->getSizeNames($size_ids);
    
    $images = json_decode($product_info['sanpham_anh'], true);
    $first_image = !empty($images) ? $images[0] : ''; 
    $formatted_price = number_format($product_info['sanpham_gia'], 0, ',', '.');
}
?>
<?php
require('include/header.php');
?>
<section class="product">
    <div class="container">
        <div class="product-top row">
            <p>Trang chủ </p> <span>&#10230</span> <p>Hàng Thiết Kế </p><span>&#10230</span><p><?php echo htmlspecialchars($product_info['sanpham_ten']) ?></p>
        </div>

        <div class="product-content row">
            <div class="product-content-left row">
                <div class="product-content-left-big-img">
                    <a href="../uploads/<?php echo htmlspecialchars($first_image); ?>" data-lightbox="product-image">
                        <img src="../uploads/<?php echo htmlspecialchars($first_image); ?>" alt="Product Image">
                    </a>
                </div>
                <div class="product-content-left-small-img">
                    <?php 
                    if (!empty($images)) {
                        foreach ($images as $img) { 
                    ?>
                        <a href="../uploads/<?php echo htmlspecialchars($img); ?>" data-lightbox="product-image">
                            <img src="../uploads/<?php echo htmlspecialchars($img); ?>" alt="Product Image">
                        </a>
                    <?php 
                        }
                    } 
                    ?>
                </div>
            </div>
            
            <div class="product-content-right">
                <div class="product-content-right-product-name">
                    <h1><?php echo htmlspecialchars($product_info['sanpham_ten']) ?></h1>
                    <p><?php echo htmlspecialchars($product_info['sanpham_ma']) ?></p>
                </div>
                <div class="product-content-right-product-price">
                    <p><?php echo $formatted_price; ?><sup>đ</sup></p>
                </div>
                <div class="product-content-right-product-size">
                    <p style="font-weight: bold;">Size</p>
                    <div class="size">
                        <?php foreach ($size_names as $size_name) { ?>
                            <span class="size-option" onclick="selectSize(this)"><?php echo htmlspecialchars($size_name); ?></span>
                        <?php } ?>
                    </div>
                </div>
                <div class="product-content-right-product-buttom">
                    <form method="POST" action="cart.php" onsubmit="return validateForm()">
                        <input type="hidden" name="sanpham_id" value="<?php echo $product_info['sanpham_id']; ?>">
                        <input type="hidden" name="sanpham_size" id="selectedSize" value="">
                        <div class="quantity">
                            <p style="font-weight: bold;">Số Lượng</p>
                            <input type="number" name="sanpham_quantity" min="1" value="1">
                        </div>
                        <button type="submit"><i class="fa-solid fa-cart-shopping"></i> <p>Mua Hàng</p></button>
                    </form>
                </div>
                <div class="product-content-right-buttom">
                    <div class="product-content-right-buttom-top">
                        &#8744; 
                    </div>
                    <div class="product-content-right-buttom-content-big">
                        <div class="product-content-right-buttom-content-title row">
                            <div class="product-content-right-buttom-content-title-item chitiet">
                                <p>Mô tả sản phẩm</p>
                            </div>
                            <div class="product-content-right-buttom-content-title-item baoquan">
                                <p>Bảo quản</p>
                            </div>
                            <div class="product-content-right-buttom-content-title-item size">
                                <p>Tham khảo size</p>
                            </div>
                        </div>
                        <div class="product-content-right-buttom-content">
                            <div class="product-content-right-buttom-content-chitiet">
                                <p style="font-size: 15px;">
                                    <p style="font-weight: bold; font-size: 20px;"><?php echo htmlspecialchars($product_info['sanpham_ten']) ?></p><br>
                                    <?php echo htmlspecialchars($product_info['sanpham_mota']) ?>
                                </p>
                            </div>
                            <div class="product-content-right-buttom-content-baoquan">
                                <p>
                                    <p style="font-weight: bold; font-size: 15px;">CÁCH BẢO QUẢN:</p><br>
                                    01. Nên được làm sạch bằng phương pháp giặt khô để đảm bảo về độ bền của chất liệu vải, hạn chế vấn đề co rút sợi vải, tăng độ bền cho sản phẩm và giữ phom dáng luôn đẹp theo thời gian<br>
                                    <br>
                                    02. Trước khi giặt khô, nên xử lý sơ qua các vết bẩn, không sử dụng các hóa chất tẩy rửa mạnh.<br>
                                    <br>
                                    03. Sử dụng máy là hơi chế độ nhiệt thấp nhất, không để bề mặt máy tiếp xúc trực tiếp với bề mặt vải, giúp hạn chế biến dạng sợi vải, giữ cho bề mặt luôn bền màu.<br>
                                    <br>
                                    04. Không bảo quản ở nơi có độ ẩm cao dễ gây mốc, trước khi lưu giữ Áo Dài phải đủ khô, tránh để sản phẩm còn ẩm.<br>
                                    <br>
                                    05. Đối với sản phẩm thêu đính, tránh để bề mặt thêu đính tiếp xúc trực tiếp với các bề mặt khác khi treo, gấp trong tủ
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> 
<section class="product-related">
    <div class="product-related-title">
        <p style="font-weight: bold; font-size: 20px;">Sản phẩm mới nhất</p>
    </div>
    <div class="product-content row">
        <?php
        $sql_str = "SELECT * FROM tbl_sanpham ORDER BY sanpham_id DESC LIMIT 1, 5;";
        $result = mysqli_query($conn, $sql_str);                
        while ($row = mysqli_fetch_assoc($result)) {
            $images = json_decode($row["sanpham_anh"], true);
            $first_image = !empty($images) ? $images[0] : ''; 
            $formatted_price = number_format($row['sanpham_gia'], 0, ',', '.');
        ?>
           <div class="product-related-item">
                <a href="product.php?sanpham_id=<?php echo $row['sanpham_id']; ?>">
                    <img src="<?php echo "../uploads/" . htmlspecialchars($first_image); ?>" alt="">
                    <h1><?php echo htmlspecialchars($row['sanpham_ten']) ?></h1>
                    <p><?php echo $formatted_price; ?><sup>đ</sup></p>
                </a>
            </div>
        <?php 
         }
         ?>
    </div>
</section>

<script>
    let selectedSize = '';

    function selectSize(element) {
        document.querySelectorAll('.size-option').forEach(size => {
            size.classList.remove('selected');
        });
        element.classList.add('selected');
        selectedSize = element.innerText;
        document.getElementById('selectedSize').value = selectedSize;
    }

    function validateForm() {
        const selectedSize = document.getElementById('selectedSize').value;
        if (selectedSize === '') {
            alert('Vui lòng chọn kích thước sản phẩm.');
            return false;
        }
        return true;
    }

    //-----------------------------Product---------------
    const baoquan = document.querySelector(".baoquan");
    const chitiet = document.querySelector(".chitiet");
    if (baoquan) {
        baoquan.addEventListener("click", function(){
            document.querySelector(".product-content-right-buttom-content-chitiet").style.display = "none";
            document.querySelector(".product-content-right-buttom-content-baoquan").style.display = "block";
        });
    }
    if (chitiet) {
        chitiet.addEventListener("click", function(){
            document.querySelector(".product-content-right-buttom-content-chitiet").style.display = "block";
            document.querySelector(".product-content-right-buttom-content-baoquan").style.display = "none";
        });
    }
    const buttom = document.querySelector(".product-content-right-buttom-top");
    if (buttom) {
        buttom.addEventListener("click", function(){
            document.querySelector(".product-content-right-buttom-content-big").classList.toggle("activeB")

    })
}
const bigImg = document.querySelector(".product-content-left-big-img img")
const smallImg =document.querySelector(".product-content-left-small-img img")
smallImg.forEach(function(imgItem,x){
    imgItem.addEventListener("click",function(){
        bigImg.src=imgItem.src
    })
})
function selectSize(element) {
    // Xóa lớp 'selected' khỏi tất cả các size
    const sizeOptions = document.querySelectorAll('.size-option');
    sizeOptions.forEach(option => option.classList.remove('selected'));

    // Thêm lớp 'selected' vào size được chọn
    element.classList.add('selected');
}
function selectSize(element) {
        // Set selected size in hidden input
        const selectedSizeInput = document.getElementById('selectedSize');
        selectedSizeInput.value = element.textContent.trim();

        // Highlight selected size
        const sizeOptions = document.querySelectorAll('.size-option');
        sizeOptions.forEach(option => option.classList.remove('selected'));
        element.classList.add('selected');
    }
    document.querySelector('form').addEventListener('submit', function(event) {
    const selectedSize = document.getElementById('selectedSize').value;
    if (!selectedSize) {
        event.preventDefault();
        alert('Vui lòng chọn size trước khi thêm vào giỏ hàng.');
    }
});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox-plus-jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
<?php
require('include/foter.php');
?>
