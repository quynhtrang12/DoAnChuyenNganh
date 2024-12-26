<?php
require('../db/conn.php');
require('includes/header.php');

$sql_donhang = "SELECT donhang_id, khachhang_id, ngay_tao, tong_tien, trang_thai FROM tbl_donhang"; 
$result_donhang = mysqli_query($conn, $sql_donhang);
?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh Sách Đơn Hàng</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID đơn hàng</th>
                        <th>ID Khách Hàng</th>
                        <th>Ngày Tạo</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Chi Tiết</th>
                        <th>Cập Nhật Trạng Thái</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($row_donhang = mysqli_fetch_assoc($result_donhang)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row_donhang['donhang_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row_donhang['khachhang_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row_donhang['ngay_tao']) . "</td>";
                    echo "<td>" . number_format($row_donhang['tong_tien']) . " đ</td>"; 
                    echo "<td id='status-" . $row_donhang['donhang_id'] . "'>" . htmlspecialchars($row_donhang['trang_thai']) . "</td>"; 
                    echo "<td><a href='order.php?donhang_id=" . $row_donhang['donhang_id'] . "'>Xem Chi Tiết</a></td>";
                    echo "<td>
                        <form onsubmit='return updateStatus(event, " . $row_donhang['donhang_id'] . ")'>
                            <select name='trang_thai' id='status-select-" . $row_donhang['donhang_id'] . "'>
                                <option value='Đang xử lý'" . ($row_donhang['trang_thai'] == 'Đang xử lý' ? ' selected' : '') . ">Đang xử lý</option>
                                <option value='Đã hoàn thành'" . ($row_donhang['trang_thai'] == 'Đã hoàn thành' ? ' selected' : '') . ">Đã hoàn thành</option>
                            </select>
                            <button type='submit'>Cập Nhật</button>
                        </form>
                    </td>";
                    echo "</tr>";
                } 
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function updateStatus(event, donhang_id) {
    event.preventDefault();
    var status = document.getElementById('status-select-' + donhang_id).value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_order.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.status === 'success') {
                document.getElementById('status-' + donhang_id).innerText = status;
                alert(response.message);
            } else {
                alert(response.message);
            }
        }
    };
    xhr.send('donhang_id=' + donhang_id + '&trang_thai=' + status);
}
</script>

<?php
require('includes/footer.php');
?>
