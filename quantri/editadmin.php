<?php 


//lay id goi edit
$id = $_GET['nhanvien_id'];

//tim trong CSDL tbl_nhanvien co nhanvien_id trung
//ket noi csdl
require('../db/conn.php');

$sql_str = "select * from tbl_nhanvien where nhanvien_id=$id";
$res = mysqli_query($conn, $sql_str);

$nhanvien = mysqli_fetch_assoc($res);
if (isset($_POST['btnUpdate'])){
    echo $_GET['nhanvien_id'];
    // neu nut Cap nhat duoc nhan   
    // lay name
    $id = $_GET['nhanvien_id'];
    $name = $_POST['nhanvien_ten'];
    $gioitinh = $_POST['nhanvien_gioitinh'];
    $namsinh = $_POST['nhanvien_namsinh'];
    $chucvu = $_POST['nhanvien_chucvu'];
    $sdt = $_POST['nhanvien_sdt'];
    $diachi = $_POST['nhanvien_diachi'];
    $Email = $_POST['nhanvien_Email'];
    $password = $_POST['nhanvien_matkhau'];
    //thuc hien viec cap nhat
    $sql_str2 = "update tbl_nhanvien set nhanvien_ten='$name',nhanvien_gioitinh='$giotinh',nhanvien_namsinh='$namsinh',
    nhanvien_chucvu='$chucvu',nhanvien_sdt='$sdt',nhanvien_diachi='$diachi',nhanvien_Email='$Email',nhanvien_matkhau='$password' where nhanvien_id=$id";
    
    mysqli_query($conn, $sql_str2);
    
    //chuyen qua trang listusers
    header("location: listusers.php");
    } else {
        require('includes/header.php');
        if($_SESSION['user']['nhanvien_chucvu'] !='Quản Lý'){
            echo"<h2>Bạn Không Có Quyền Truy Cập Chức Năng Này</h2>";
        }else{
?>

<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Cập nhật nhân viên</h1>
                        </div>
                        <form class="user" method="post" action="" >
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="nhanvien_ten" name="nhanvien_ten" value="<?=$nhanvien['nhanvien_ten']?>"
                                    aria-describedby="emailHelp" placeholder="Tên nhân viên">
                            </div>
                            <!--<div class="form-group">
                                <input type="text" class="form-control form-control-user" id="nhanvien_id" name="nhanvien_id" value=""
                                    aria-describedby="emailHelp" placeholder="Mã Nhân Viên">
                            </div>-->
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="nhanvien_Email" name="nhanvien_Email" value="<?=$nhanvien['nhanvien_Email']?>"
                                    aria-describedby="emailHelp" placeholder="Email">
                            </div><div class="form-group">
                                <input type="password" class="form-control form-control-user" id="nhanvien_matkhau" name="nhanvien_matkhau" value="<?=$nhanvien['nhanvien_matkhau']?>"
                                    aria-describedby="emailHelp" placeholder="Mật Khẩu">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="nhanvien_diachi" name="nhanvien_diachi" value="<?=$nhanvien['nhanvien_diachi']?>"
                                    aria-describedby="emailHelp" placeholder="Địa Chỉ">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="nhanvien_sdt" name="nhanvien_sdt" value="<?=$nhanvien['nhanvien_sdt']?>"
                                    aria-describedby="emailHelp" placeholder="Số Điện Thoại">
                            </div>
                            <div class="form-group">
                                <input type="datetime-local" class="form-control form-control-user" id="nhanvien_namsinh" name="nhanvien_namsinh" value="<?=$nhanvien['nhanvien_namsinh']?>"
                                    aria-describedby="emailHelp" placeholder="Năm sinh">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="nhanvien_gioitinh" name="nhanvien_gioitinh" value="<?=$nhanvien['nhanvien_gioitinh']?>"
                                    aria-describedby="emailHelp" placeholder="Giới tính">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Quyền</label>
                                <select class="form-control" name="nhanvien_chucvu">
                                    <option value="Nhân Viên" <?php if ($nhanvien=['nhanvien_chucvu'] == 'Nhân Viên') echo"selected"; ?>>Nhân Viên</option>
                                    <option value="Quản Lý" <?php if ($nhanvien=['nhanvien_chucvu'] == 'Quản Lý') echo"selected"; ?>>Quản Lý</option>
                                </select>
                            </div>

                            <button class="btn btn-primary" name="btnUpdate">Cập Nhật</button>
                        </form>
                        <hr>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php
    }
require('includes/footer.php');
}
?>