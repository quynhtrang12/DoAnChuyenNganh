<?php
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
                            <h1 class="h4 text-gray-900 mb-4">Thêm mới nhân viên</h1>
                        </div>
                        <form class="user" method="post" action="adduser.php" >
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="nhanvien_ten" name="nhanvien_ten"
                                    aria-describedby="emailHelp" placeholder="Tên nhân viên">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="nhanvien_id" name="nhanvien_id"
                                    aria-describedby="emailHelp" placeholder="Mã Nhân Viên">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="nhanvien_Email" name="nhanvien_Email"
                                    aria-describedby="emailHelp" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user" id="nhanvien_matkhau" name="nhanvien_matkhau"
                                    aria-describedby="emailHelp" placeholder="Mật Khẩu">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="nhanvien_diachi" name="nhanvien_diachi"
                                    aria-describedby="emailHelp" placeholder="Địa Chỉ">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="nhanvien_sdt" name="nhanvien_sdt"
                                    aria-describedby="emailHelp" placeholder="Số Điện Thoại">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="nhanvien_namsinh" name="nhanvien_namsinh"
                                    aria-describedby="emailHelp" placeholder="Năm sinh">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="nhanvien_gioitinh" name="nhanvien_gioitinh"
                                    aria-describedby="emailHelp" placeholder="Giới tính">
                            </div>



            




                            <div class="form-group">
                                <label class="form-label">Quyền</label>
                                <select class="form-control" name="nhanvien_chucvu">
                                    <option value="Nhân Viên">Nhân Viên</option>
                                    <option value="Quản Lý">Quản Lý</option>
                                </select>
                            </div>

                            <button class="btn btn-primary">Tạo mới</button>
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
?>