<?php
require('../db/conn.php');
require('includes/header.php');

// Truy vấn lấy danh sách khách hàng từ bảng tbl_khachhang
$sql = "SELECT khachhang_ten, khachhang_sdt, khachhang_namsinh, khachhang_email, khachhang_diachi FROM tbl_khachhang";
$result = mysqli_query($conn, $sql);

?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh Sách Khách Hàng </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên Khách Hàng </th>
                        <th>Số Điện Thoại </th>
                        <th>Năm Sinh  </th>
                        <th>Email  </th>
                        <th>Địa Chỉ </th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Kiểm tra nếu có dữ liệu
                    if (mysqli_num_rows($result) > 0) {
                        $stt = 1; // Biến đếm thứ tự
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $stt++ . "</td>";
                            echo "<td>" . htmlspecialchars($row['khachhang_ten']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['khachhang_sdt']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['khachhang_namsinh']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['khachhang_email']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['khachhang_diachi']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Không có dữ liệu.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
require('includes/footer.php');
?>
