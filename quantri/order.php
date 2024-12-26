<?php
require('../db/conn.php');
require('includes/header.php');

// Kiểm tra xem có `donhang_id` trong URL không
if (isset($_GET['donhang_id'])) {
    $donhang_id = (int)$_GET['donhang_id'];

    // Truy vấn thông tin chi tiết đơn hàng
    $sql_order_details = "
        SELECT dh.donhang_id, dh.khachhang_id, kh.khachhang_ten, kh.khachhang_diachi, kh.khachhang_sdt, dh.ngay_tao, dh.tong_tien, dh.trang_thai, 
               ct.sanpham_id, sp.sanpham_ten, ct.sanpham_size, ct.sanpham_soluong, ct.sanpham_gia
        FROM tbl_donhang dh
        JOIN tbl_khachhang kh ON dh.khachhang_id = kh.khachhang_id
        JOIN tbl_chitietdonhang ct ON dh.donhang_id = ct.donhang_id
        JOIN tbl_sanpham sp ON ct.sanpham_id = sp.sanpham_id
        WHERE dh.donhang_id = $donhang_id
    ";
    $result_order_details = mysqli_query($conn, $sql_order_details);

    if ($result_order_details) {
        $order_details = mysqli_fetch_assoc($result_order_details);
    } else {
        echo "Không tìm thấy chi tiết đơn hàng.";
    }
} else {
    echo "Không có đơn hàng nào được chọn.";
    exit();
}
?>

<div class="container">
    <h1>Chi Tiết Đơn Hàng <?php echo htmlspecialchars($order_details['donhang_id']); ?></h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Đơn Hàng</th>
                <th>Tên Khách Hàng</th>
                <th>Địa chỉ Khách Hàng</th>
                <th>Số điện thoại</th>
                <th>Ngày Tạo</th>
                <th>Tổng Tiền</th>
                <th>Trạng Thái</th>
                <th>Sản Phẩm</th>
                <th>Size</th>
                <th>Số Lượng</th>
                <th>Giá</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if ($result_order_details) {
            do {
        ?>
            <tr>
                <td><?php echo htmlspecialchars($order_details['donhang_id']); ?></td>
                <td><?php echo htmlspecialchars($order_details['khachhang_ten']); ?></td>
                <td><?php echo htmlspecialchars($order_details['khachhang_diachi']); ?></td>
                <td><?php echo htmlspecialchars($order_details['khachhang_sdt']); ?></td>
                <td><?php echo htmlspecialchars($order_details['ngay_tao']); ?></td>
                <td><?php echo number_format($order_details['tong_tien']); ?> <sup>đ</sup></td>
                <td><?php echo htmlspecialchars($order_details['trang_thai']); ?></td>
                <td><?php echo htmlspecialchars($order_details['sanpham_ten']); ?></td>
                <td><?php echo htmlspecialchars($order_details['sanpham_size']); ?></td>
                <td><?php echo $order_details['sanpham_soluong']; ?></td>
                <td><?php echo number_format($order_details['sanpham_gia']); ?> <sup>đ</sup></td>
            </tr>
        <?php
            } while ($order_details = mysqli_fetch_assoc($result_order_details));
        }
        ?>
        </tbody>
    </table>
    <a href="listdonhang.php" class="btn btn-primary">Quay lại danh sách đơn hàng</a>
</div>

<?php
require('includes/footer.php');
?>
