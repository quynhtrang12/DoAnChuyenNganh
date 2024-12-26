<?php
require('includes/header.php');

if($_SESSION['user']['nhanvien_chucvu'] !='Quản Lý'){
    echo"<h2>Bạn Không Có Quyền Truy Cập Chức Năng Này</h2>";
}else{
?>
<div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Danh Sách Nhân Viên </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Mã Nhân Viên</th>
                                            <th>Họ và Tên</th>
                                            <th>Giới Tính </th>
                                            <th>Năm Sinh </th>
                                            <th>Chức Vụ</th>
                                            <th>SĐT</th>
                                            <th>Địa Chỉ</th>
                                            <th>Email</th>
                                            <th>Mật Khẩu</th>
                                            <th>Hành Động</th>
                                        </tr>
                                    </thead>
                                    <thead>
                                    <?php
require_once('../db/conn.php');
$sql_str="select * from tbl_nhanvien order by created_at";
$result = mysqli_query($conn,$sql_str);
$stt = 0;
while ($row = mysqli_fetch_assoc($result)){
    $stt++;
    ?>
    <tr>
        <td><?=$stt?></td>
        <td><?=$row['nhanvien_id']?></td>
        <td><?=$row['nhanvien_ten']?></td>
        <td><?=$row['nhanvien_gioitinh']?></td>
        <td><?=$row['nhanvien_namsinh']?></td>
        <td><?=$row['nhanvien_chucvu']?></td>
        <td><?=$row['nhanvien_sdt']?></td>
        <td><?=$row['nhanvien_diachi']?></td>
        <td><?=$row['nhanvien_Email']?></td>
        <td><?=$row['nhanvien_matkhau']?></td>
        <td>
                    <a class="btn btn-warning" href="editadmin.php?nhanvien_id=<?=$row['nhanvien_id']?>">Edit</a>  
                    <a class="btn btn-danger" 
                    href="deleteadmin.php?nhanvien_id=<?=$row['nhanvien_id']?>"
                    onclick="return confirm('Bạn chắc chắn xóa người dùng này?');">Delete</a>
        </td>
    </tr>
<?php
}
?>         
                                    </thead>
                                </table>
                            </div>
                        </div>
</div>

<?php
}
?>
<?php
require('includes/footer.php');
?>