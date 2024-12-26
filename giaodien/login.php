<?php
session_start();
require('../db/conn.php'); 

if (isset($_SESSION['success'])) {
    echo '<p style="color: green;">' . $_SESSION['success'] . '</p>';
    unset($_SESSION['success']);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM tbl_khachhang WHERE khachhang_email = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['khachhang_matkhau'])) {
            $_SESSION['user_id'] = $user['khachhang_id'];
            $_SESSION['username'] = $user['khachhang_ten'];
            $_SESSION['success'] = "Đăng nhập thành công!";
            if (isset($_GET['redirect_to'])) {
                header('Location: ' . $_GET['redirect_to']); 
            } else {
                header('Location: cart.php'); 
            }
            exit(); 
        } else {
            $error = "Mật khẩu không đúng!";
        }
    } else {
        $error = "Email không tồn tại!";
    }
}
?>

<?php
require('include/headerlogin.php');
?>
<div class="wrapper">
    <form action="login.php" method="POST">
        <h1>Đăng Nhập</h1>
        <div class="input-box">
            <input type="text" name="username" placeholder="Email" required> 
            <i class="fa-solid fa-user"></i>
        </div>
        <div class="input-box">
            <input type="password" name="password" placeholder="Mật khẩu" required>
            <i class="fa-solid fa-lock"></i>
        </div>
        <div class="remember-forgot">
            <label> <input type="checkbox"> Ghi nhớ mật khẩu </label>
            <a href="#">Quên mật khẩu</a>
        </div>
        <button type="submit" class="btn">Đăng Nhập</button>
        <?php if (isset($error)) { echo '<p style="color:red;">' . $error . '</p>'; } ?>
        <div class="register-link">
            <p>Không có tài khoản? <a href="register.php">Đăng ký</a></p>
        </div>
    </form>
</div>

<script src="script.js"></script>
