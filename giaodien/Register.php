<?php
require('../db/conn.php'); 

// Kiểm tra nếu form đã được gửi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form
    $khachhang_ten = mysqli_real_escape_string($conn, $_POST['khachhang_ten']);
    $khachhang_email = mysqli_real_escape_string($conn, $_POST['khachhang_email']);
    $khachhang_matkhau = mysqli_real_escape_string($conn, $_POST['khachhang_matkhau']);

    // Mã hóa mật khẩu
    $hashed_password = password_hash($khachhang_matkhau, PASSWORD_DEFAULT);

    $sql = "INSERT INTO tbl_khachhang (khachhang_ten, khachhang_email, khachhang_matkhau) 
            VALUES ('$khachhang_ten', '$khachhang_email', '$hashed_password')";

    if (mysqli_query($conn, $sql)) {
        $khachhang_id = mysqli_insert_id($conn); // Lấy ID khách hàng vừa tạo
        $_SESSION['user_id'] = $khachhang_id; // Lưu ID vào session
        header("Location: login.php?redirect_to=delivery.php"); // Điều hướng tới đăng nhập
        exit();
    }
}
?>

<?php
require('include/headerlogin.php');
?>

<div class="wrapper">
    <form action="" method="POST" enctype="multipart/form-data">
        <h1>Đăng Ký</h1>
        <div class="input-box">
            <input type="text" name="khachhang_ten" placeholder="Họ Tên" required>
            <i class="fa-solid fa-user"></i>
        </div>
        <div class="input-box">
            <input name="khachhang_email" type="text" placeholder="Email" required>
            <i class="fa-solid fa-envelope"></i>
        </div>
        <div class="input-box">
            <input name="khachhang_matkhau" type="password" placeholder="Mật khẩu" required>
            <i class="fa-solid fa-lock"></i>
        </div>
        <button onclick="showLoginAlert()" type="submit" class="btn">Đăng Ký</button>
        <div class="register-link">
            <p><a href="login.php">Quay lại</a></p>
        </div>
    </form>
</div>

<script>
    function showLoginAlert() {
        alert('Đăng Ký Thành Công');
        window.location.href = 'login.php';
    }
</script>
