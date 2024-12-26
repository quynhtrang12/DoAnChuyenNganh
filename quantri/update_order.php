<?php
require('../db/conn.php');

// Kiểm tra nếu có dữ liệu POST và donhang_id
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['donhang_id'])) {
    $donhang_id = (int)$_POST['donhang_id'];
    $trang_thai = mysqli_real_escape_string($conn, $_POST['trang_thai']);

    // Cập nhật trạng thái đơn hàng
    $sql_update_status = "UPDATE tbl_donhang SET trang_thai = '$trang_thai' WHERE donhang_id = $donhang_id";
    if (mysqli_query($conn, $sql_update_status)) {
        echo json_encode(['status' => 'success', 'message' => 'Cập nhật đơn hàng thành công.']);
    } 
}
?>
