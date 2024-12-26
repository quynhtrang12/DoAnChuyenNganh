<?php
require_once('../db/config.php');
include('class/product_class.php');

$product = new product;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sanpham_ten = htmlspecialchars($_POST['sanpham_ten']);
    $sanpham_ma = htmlspecialchars($_POST['sanpham_ma']);
    $danhmuc_id = (int)$_POST['danhmuc_id'];
    $loaisanpham_id = (int)$_POST['loaisanpham_id'];
    $size_id = isset($_POST['size_id']) ? $_POST['size_id'] : [];
    $sanpham_soluong = (int)$_POST['sanpham_soluong'];
    $sanpham_gia = (float)str_replace('.', '', $_POST['sanpham_gia']);
    $sanpham_mota = htmlspecialchars($_POST['sanpham_mota']);

    if (isset($_FILES['sanpham_anh']) && !empty($_FILES['sanpham_anh']['name'][0])) {
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
        $upload_dir = "../uploads/";
        $uploaded_files = [];

        foreach ($_FILES['sanpham_anh']['name'] as $key => $file_name) {
            $file_temp = $_FILES['sanpham_anh']['tmp_name'][$key];
            $div = explode('.', $file_name);
            $file_ext = strtolower(end($div));

            if (in_array($file_ext, $allowed_ext)) {
                $sanpham_anh = substr(md5(time() . $key), 0, 10) . '.' . $file_ext;
                $upload_image = $upload_dir . $sanpham_anh;

                if (move_uploaded_file($file_temp, $upload_image)) {
                    $uploaded_files[] = $sanpham_anh;
                }
            }
        }

        if (!empty($uploaded_files)) {
            $sanpham_anh = json_encode($uploaded_files);
            $insert_product = $product->insert_product(
                $sanpham_ten, $sanpham_ma, $danhmuc_id, $loaisanpham_id, $sanpham_soluong, $sanpham_gia, $sanpham_mota, $sanpham_anh, $size_id 
            );

            if ($insert_product) {
                $sanpham_id = $product->getLastInsertedId();
                foreach ($size_id as $size) {
                    $product->insertProductSize($sanpham_id, $size);
                }
                echo "Product inserted successfully.";
            } else {
                echo "Failed to insert product.";
            }
        } else {
            echo "No valid files uploaded.";
        }
    } else {
        echo "No files uploaded.";
    }
}
?>
<?php
require('includes/header.php');
?>

<h1>Trang Thêm Sản Phẩm</h1>
<div class="admin-content-right">
    <div class="product-add-content">
        <form action="themsanpham.php" method="POST" enctype="multipart/form-data">
            <label for="">Tên sản phẩm <span style="color:red">*</span></label> <br>
            <input required type="text" name="sanpham_ten"><br>
            <label for="">Mã sản phẩm <span style="color:red">*</span></label> <br>
            <input required type="text" name="sanpham_ma"><br>
            <label for="">Chọn danh mục <span style="color:red">*</span></label> <br>
            <select style="width: 200px;" required name="danhmuc_id" id="danhmuc_id">
                <option value="">--Chọn--</option>
                <?php
                $show_cartegory = $product->show_cartegory();
                if ($show_cartegory) {
                    while ($result = $show_cartegory->fetch_assoc()) {
                ?>
                <option value="<?php echo htmlspecialchars($result['danhmuc_id']); ?>"><?php echo htmlspecialchars($result['danhmuc_name']); ?></option>
                <?php
                    }
                }
                ?>
            </select><br>
            <label for="">Chọn loại sản phẩm <span style="color:red">*</span></label> <br>
            <select style="width: 200px;" required name="loaisanpham_id" id="loaisanpham_id">
                <option value="">--Chọn--</option>
            </select><br>

            <label for="">Chọn size sản phẩm <span style="color:red">*</span></label> <br>
            <div class="sanpham-size">
                <?php
                $show_size = $product->show_size();
                if ($show_size) {
                    while ($result = $show_size->fetch_assoc()) {
                        echo '<label><input type="checkbox" name="size_id[]" value="' . htmlspecialchars($result['size_id']) . '">' . htmlspecialchars($result['size_ten']) . '</label><br>';
                    }
                } else {
                    echo '<p>Không có size nào để hiển thị.</p>';
                }
                ?>
            </div>

            <label for="">Số lượng <span style="color:red">*</span></label> <br>
            <input required type="number" min="0" name="sanpham_soluong"><br>
            <label for="">Giá sản phẩm <span style="color:red">*</span></label> <br>
            <input required type="text" name="sanpham_gia" pattern="\d{1,3}(\.\d{3})*"><br>
            <label for="">Mô tả sản phẩm <span style="color:red">*</span></label> <br>
            <textarea cols="60" rows="5" name="sanpham_mota"></textarea><br>
            <label for="">Ảnh sản phẩm <span style="color:red">*</span></label> <br>
            <input required type="file" name="sanpham_anh[]" id="sanpham_anh" multiple><br><br>
            <button style="width: 150px;" class="admin-btn" name="submit" type="submit">Gửi</button>
        </form>
    </div>
</div>
<?php
require('includes/footer.php');
?>
<script src="http://cdnjs.Cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $("#danhmuc_id").change(function(){
            var x = $(this).val();
            $.get("ajax/productadd_ajax.php", {danhmuc_id: x}, function(data){
                $("#loaisanpham_id").html(data);
            });
        });
    });
</script>
