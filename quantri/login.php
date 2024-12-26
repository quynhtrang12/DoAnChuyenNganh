<?php
    session_start();
    $errorMess= "";
    if(isset($_POST["btnSubmit"])){
        //Lấy dữ liệu từ form
        $Email=$_POST["nhanvien_Email"];
        $Password=$_POST["nhanvien_matkhau"];
        //Kết nối csld
        require_once('../db/conn.php');
        //Câu Lệnh Truy Vấn
        $sql="select * from tbl_nhanvien where nhanvien_Email='$Email' and nhanvien_matkhau='$Password'";
        //Thực thi câu lệnh
        $result= mysqli_query($conn,$sql);
        //Kiểm tra số lượng trả về:Đăng nhập thành công
        if(mysqli_num_rows($result)> 0){
            //echo"<h1>Đăng nhập thành công</h1>";
            //Lưu trữ thông tin đăng nhập
            $row = mysqli_fetch_assoc($result);
            $_SESSION['user'] = $row;
            //Chuyển trang giao diện quản trị
            header("Location:index.php");

        }
        else{
            $errorMess="Sai tài Khoản hoặc mật khẩu";
            require_once("includes/loginform.php");
        }

    }
    else{
        require_once("includes/loginform.php");
}
?>