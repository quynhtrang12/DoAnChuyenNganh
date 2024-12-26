<?php
session_start();
require('../db/conn.php');
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
$khachhang_id = $_SESSION['user_id'];
$sql = "SELECT khachhang_ten, khachhang_email FROM tbl_khachhang WHERE khachhang_id = $khachhang_id";
$result = mysqli_query($conn, $sql);
$khachhang = mysqli_fetch_assoc($result);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $khachhang_namsinh = mysqli_real_escape_string($conn, $_POST['khachhang_namsinh']);
    $khachhang_sdt = mysqli_real_escape_string($conn, $_POST['khachhang_sdt']);
    $khachhang_diachi = mysqli_real_escape_string($conn, $_POST['khachhang_diachi']);
    $sql_update = "UPDATE tbl_khachhang 
                   SET khachhang_namsinh = '$khachhang_namsinh', khachhang_sdt = '$khachhang_sdt', khachhang_diachi = '$khachhang_diachi' 
                   WHERE khachhang_id = $khachhang_id";
    if (mysqli_query($conn, $sql_update)) {
        // Tạo đơn hàng
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $sanpham_gia = (float)str_replace('.', '', $item['sanpham_gia']);
            $total += $sanpham_gia * $item['sanpham_quantity'];
        }

        $sql_donhang = "INSERT INTO tbl_donhang (khachhang_id, tong_tien) VALUES ($khachhang_id, $total)";
        if (mysqli_query($conn, $sql_donhang)) {
            $donhang_id = mysqli_insert_id($conn);

            // Lưu chi tiết đơn hàng
            foreach ($_SESSION['cart'] as $item) {
                $sanpham_id = $item['sanpham_id'];

                // Kiểm tra `sanpham_id` tồn tại trong bảng `tbl_sanpham`
                $sql_check = "SELECT COUNT(*) as count FROM tbl_sanpham WHERE sanpham_id = $sanpham_id";
                $result_check = mysqli_query($conn, $sql_check);
                $row_check = mysqli_fetch_assoc($result_check);

                if ($row_check['count'] > 0) {
                    $sanpham_size = $item['sanpham_size'];
                    $sanpham_soluong = $item['sanpham_quantity'];
                    $sanpham_gia = (float)str_replace('.', '', $item['sanpham_gia']);

                    $sql_chitietdonhang = "INSERT INTO tbl_chitietdonhang (donhang_id, sanpham_id, sanpham_size, sanpham_soluong, sanpham_gia) 
                                           VALUES ($donhang_id, $sanpham_id, '$sanpham_size', $sanpham_soluong, $sanpham_gia)";
                    if (!mysqli_query($conn, $sql_chitietdonhang)) {
                        echo "Lỗi: " . mysqli_error($conn);
                    }
                } else {
                    echo "Sản phẩm với ID $sanpham_id không tồn tại.";
                }
            }

            // Xóa giỏ hàng sau khi đã lưu đơn hàng
            unset($_SESSION['cart']);

            // Chuyển hướng đến trang thanh toán thành công
            echo "<script>alert('Đặt hàng thành công.'); window.location.href='payment.php';</script>";
        } else {
            echo "Lỗi: " . mysqli_error($conn);
        }
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
}

require('include/header.php');
?>

<!----------------Delivery----------------------->    
<section class="delivery">
    <div class="container">
        <div class="delivery-top-wrap">
            <div class="delivery-top">
                <div class="delivery-top-cart delivery-top-item">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
                <div class="delivery-top-adress delivery-top-item">
                    <i class="fa-solid fa-map-location-dot"></i>     
                </div>
                <div class="delivery-top-payment delivery-top-item">
                    <i class="fa-solid fa-money-bill-wave"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="delivery-content row">
            <div class="delivery-content-left">
                <p>Vui lòng chọn địa chỉ giao hàng </p>
                <form action="" method="POST">
                    <div class="delivery-content-left-input-top row">
                        <div class="delivery-content-left-input-top-item">
                            <label for="khachhang_ten">Họ Tên <span style="color: red;">*</span></label>
                            <input type="text" name="khachhang_ten" value="<?php echo htmlspecialchars($khachhang['khachhang_ten']); ?>" readonly>
                        </div>
                        <div class="delivery-content-left-input-top-item">
                            <label for="khachhang_namsinh">Năm Sinh <span style="color: red;">*</span></label>
                            <input type="text" name="khachhang_namsinh" required>
                        </div>
                        <div class="delivery-content-left-input-top-item">
                            <label for="khachhang_sdt">Điện Thoại <span style="color: red;">*</span></label>
                            <input type="text" name="khachhang_sdt" required>
                        </div>
                    </div>
                    <div class="delivery-content-left-input-buttom">
                        <label for="khachhang_diachi">Địa Chỉ <span style="color: red;">*</span></label>
                        <input type="text" name="khachhang_diachi" required>
                    </div>
                    <div class="payment-content-left">
                <div class="payment-content-left-method-delivery">
                    <p style="font-weight: bold;">Phương Thức Giao Hàng </p>
                    <div class="payment-content-left-method-delivery-item">
                        <input type="radio">
                        <label for="">Giao hàng chuyển phát nhanh</label>
                    </div>
                </div>
                <div class="payment-content-left-method-payment">
                    <p style="font-weight: bold;">Phương Thức Thanh Toán </p>
                    <div class="payment-content-left-method-payment-item">
                        <input type="radio">
                        <label for="">Trả tiền mặt khi nhận hàng </label>
                    </div>
                </div>
                </div>
                    <div class="delivery-content-left-buttom row">
                        <a href="cart.php"><span>&#171;</span><p>Quay lại giỏ hàng</p></a>
                        <button type="submit"><p style="font-weight: bold;">Thanh Toán và giao hàng</p></button>
                    </div>
                </form>
            </div>
            <div class="delivery-content-right">
                <table>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Size</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                    <?php 
                    $total = 0; // Khởi tạo tổng tiền
                    if (!empty($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $item) {
                            $sanpham_ten = htmlspecialchars($item['sanpham_ten']);
                            $sanpham_size = htmlspecialchars($item['sanpham_size']);
                            $sanpham_quantity = (int)$item['sanpham_quantity'];
                            $sanpham_gia = (float)str_replace('.', '', $item['sanpham_gia']);
                            $item_total = $sanpham_gia * $sanpham_quantity; // Thành tiền mỗi sản phẩm
                            $total += $item_total; // Cộng dồn vào tổng tiền
                    ?>
                    <tr>
                        <td><?php echo $sanpham_ten; ?></td>
                        <td><?php echo $sanpham_size; ?></td>
                        <td><?php echo $sanpham_quantity; ?></td>
                        <td><?php echo number_format($item_total); ?> <sup>đ</sup></td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                    <tr>
                        <td style="font-weight: bold;" colspan="3">Tạm Tính</td>
                        <td style="font-weight: bold;"><?php echo number_format($total); ?> <sup>đ</sup></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;" colspan="3">Tổng</td>
                        <td style="font-weight: bold;"><?php echo number_format($total); ?> <sup>đ</sup></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</section>
<!----------------app-container----------------------->   
<?php
require('include/foter.php');
?>
