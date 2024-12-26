<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <title>Ivy-Project</title>
    <link rel="stylesheet" href="font/fontawesome-free-6.6.0-web/fontawesome-free-6.6.0-web/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .user-menu {
            display: none;
            position: absolute;
            top: 50px;
            right: 0;
            background: white;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .user-menu li {
            list-style: none;
            padding: 10px;
            cursor: pointer;
        }
        .user-menu li:hover {
            background: #eee;
        }
    </style>
</head>
<body>
<header>
        <div class="logo">
            <a href="index.php"><img src="img/logo-kate.png"></a>
        </div>
        <div class="menu">
            <?php
            include('../class/class.php');
            
            $cartegory = new cartegory;
            $show_cartegory = $cartegory->show_cartegory();
            ?>
            <?php if ($show_cartegory) { ?>
                <?php while ($result_cartegory = $show_cartegory->fetch_assoc()) { ?>
                    <li>
                        <a href="#"><?php echo $result_cartegory["danhmuc_name"]; ?></a>
                        <?php
                        $brand = new brand;
                        $show_brand = $brand->show_brand_by_cartegory($result_cartegory['danhmuc_id']);
                        ?>
                        <?php if ($show_brand) { ?>
                            <ul class="sub-menu">
                                <?php while ($result_brand = $show_brand->fetch_assoc()) { ?>
                                    <li>
                                        <a href="cartegory.php?danhmuc_id=<?php echo $result_cartegory['danhmuc_id']; ?>&loaisanpham_id=<?php echo $result_brand['loaisanpham_id']; ?>">
                                            <?php echo $result_brand["loaisanpham_ten"]; ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </li>
                <?php } ?>
            <?php } ?>
        </div>
        <div class="others">
            <form action="search.php" method="GET" class="search-form" style="display: flex">
                <input placeholder="Tìm Kiếm" type="text" name="tukhoa" class="search-input">
                <button type="submit" class="search-btn">
                    <i class="fas fa-search"></i>
                </button>
            </form>
            <li><a class="fa fa-paw" href=""></a></li>
            <li><a class="fa fa-user" id="user-icon">
                <?php
                if (isset($_SESSION['username'])) {
                    echo "Xin chào, " . htmlspecialchars($_SESSION['username']);
                }
                ?>
            </a></li>
            <li><a class="fa fa-shopping-bag" href="cart.php"></a></li>
            <ul class="user-menu" id="user-menu">
                <?php if (isset($_SESSION['username'])): ?>
                    <li><a href="logout.php">Đăng Xuất</a></li>
                <?php else: ?>
                    <li><a href="register.php">Đăng Ký</a></li>
                    <li><a href="login.php">Đăng Nhập</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </header>

<script>
    document.getElementById('user-icon').addEventListener('click', function() {
        var userMenu = document.getElementById('user-menu');
        userMenu.style.display = (userMenu.style.display === 'none' || userMenu.style.display === '') ? 'block' : 'none';
    });
</script>
</body>
</html>
