<?php
session_start();
require('../db/conn.php');
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_GET['action']) && $_GET['action'] === 'checkout') {
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php?redirect_to=cart.php?action=checkout');
        exit();
    } else {
        header('Location: delivery.php');
        exit();
    }
}

if (isset($_GET['key'])) {
    $key = (int)$_GET['key'];
    if (isset($_SESSION['cart'][$key])) {
        unset($_SESSION['cart'][$key]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sanpham_id'], $_POST['sanpham_size'], $_POST['sanpham_quantity'])) {
    $sanpham_id = (int)$_POST['sanpham_id'];
    $sanpham_size = htmlspecialchars($_POST['sanpham_size']);
    $sanpham_quantity = (int)$_POST['sanpham_quantity'];

    $sql = "SELECT sp.sanpham_id, sp.sanpham_ten, sp.sanpham_gia, sp.sanpham_anh FROM tbl_sanpham sp WHERE sp.sanpham_id = $sanpham_id";
    $result = mysqli_query($conn, $sql);
    $product = mysqli_fetch_assoc($result);

    if ($product) {
        $product['sanpham_size'] = $sanpham_size;
        $product['sanpham_quantity'] = $sanpham_quantity;

        
        $found = false;
        foreach ($_SESSION['cart'] as $key => $item) {
            if ((int)$item['sanpham_id'] === $sanpham_id && $item['sanpham_size'] === $sanpham_size) {
                
                $_SESSION['cart'][$key]['sanpham_quantity'] += $sanpham_quantity;
                $found = true;
                break;
            }
        }
        
        if (!$found) {
            $_SESSION['cart'][] = [
                'sanpham_id' => $product['sanpham_id'],
                'sanpham_ten' => $product['sanpham_ten'],
                'sanpham_gia' => $product['sanpham_gia'],
                'sanpham_anh' => $product['sanpham_anh'],
                'sanpham_size' => $sanpham_size,
                'sanpham_quantity' => $sanpham_quantity,
            ];
        }
    }
}

require('include/header.php');
?>
<section class="cart">
    <div class="container">
        <div class="cart-top-wrap">
            <div class="cart-top">
                <div class="cart-top-cart cart-top-item">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
                <div class="cart-top-adress cart-top-item">
                    <i class="fa-solid fa-map-location-dot"></i>
                </div>
                <div class="cart-top-payment cart-top-item">
                    <i class="fa-solid fa-money-bill-wave"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="cart-content row">
           
            <div class="cart-content-left col-md-8">
                <table>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Tên sản phẩm</th>
                        <th>Size</th>
                        <th>SL</th>
                        <th>Thành Tiền</th>
                        <th>Xóa</th>
                    </tr>
                    <?php 
                    $total = 0;
                    if (!empty($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $key => $item) {
                            // Loại bỏ dấu '.' nếu có trong giá trị sanpham_gia
                            $sanpham_gia = str_replace('.', '', $item['sanpham_gia']);

                            // Kiểm tra giá trị hợp lệ
                            $sanpham_gia = is_numeric($sanpham_gia) ? (float)$sanpham_gia : 0;
                            $sanpham_quantity = is_numeric($item['sanpham_quantity']) ? (int)$item['sanpham_quantity'] : 0;

                            // Tính thành tiền
                            $item_total = $sanpham_gia * $sanpham_quantity;
                            $total += $item_total;

                            // Lấy ảnh đầu tiên
                            $images = json_decode($item['sanpham_anh'], true);
                            $first_image = !empty($images) ? $images[0] : '';
                    ?>
                    <tr data-key="<?php echo $key; ?>">
                        <td><img src="../uploads/<?php echo htmlspecialchars($first_image); ?>" alt="Product Image"></td>
                        <td><p><?php echo htmlspecialchars($item['sanpham_ten']); ?></p></td>
                        <td><p><?php echo htmlspecialchars($item['sanpham_size']); ?></p></td>
                        <td><input type="number" class="quantity" value="<?php echo $sanpham_quantity; ?>" min="1"></td>
                        <td class="item-total"><?php echo number_format($item_total); ?> <sup>đ</sup></td>
                        <td><a href="cart.php?key=<?php echo $key; ?>">X</a></td> 
                    </tr>
                    <?php
                        }
                    }
                    ?>
                </table>
            </div>
            <div class="cart-content-right col-md-4">
                <table>
                    <tr>
                        <th colspan="2">TỔNG TIỀN GIỎ HÀNG</th>
                    </tr>
                    <tr>
                        <td>TỔNG SẢN PHẨM</td>
                        <td><?php echo count($_SESSION['cart']); ?></td>
                    </tr>
                    <tr>
                        <td>TỔNG TIỀN HÀNG</td>
                        <td><p id="cart-total"><?php echo number_format($total); ?><sup>đ</sup></p></td>
                    </tr>
                </table>
                <div class="cart-content-right-button">
                    <a href="cartegory.php?danhmuc_id=7&loaisanpham_id=6">
                        <button>TIẾP TỤC MUA SẮM</button>
                    </a>
                    <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="delivery.php">
                        <button>THANH TOÁN</button>
                    </a>
                <?php else: ?>
                    <button onclick="showLoginAlert()">THANH TOÁN</button>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
require('include/foter.php');
?>
<script>
    function showLoginAlert() {
        alert('Vui lòng đăng nhập để tiếp tục!');
        window.location.href = 'login.php'; 
    }

    document.addEventListener("DOMContentLoaded", function() {
        const quantities = document.querySelectorAll('.quantity');

        quantities.forEach(quantity => {
            quantity.addEventListener('input', function() {
                const row = this.closest('tr');
                const price = parseFloat(row.querySelector('.item-total').innerText.replace(/[,.đ]/g, '')) / this.defaultValue;
                const itemTotal = row.querySelector('.item-total');
                const newTotal = price * this.value;

                this.defaultValue = this.value;
                itemTotal.innerText = newTotal.toLocaleString('vi-VN') + ' đ';

                updateCartTotal();
            });
        });

        function updateCartTotal() {
            let total = 0;
            const itemTotals = document.querySelectorAll('.item-total');

            itemTotals.forEach(itemTotal => {
                total += parseFloat(itemTotal.innerText.replace(/[,.đ]/g, ''));
            });

            document.getElementById('cart-total').innerText = total.toLocaleString('vi-VN') + ' đ';
        }
    });
</script>


<?php
if (!isset($_SESSION['user_id'])) {
    exit();
}
?>
