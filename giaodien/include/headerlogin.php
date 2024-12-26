
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <title>Ivy-Project</title>
    <link rel="stylesheet" href="font/fontawesome-free-6.6.0-web/fontawesome-free-6.6.0-web/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="login.css">
</head>
<body>
<header>
        <div class ="logo">
         <a href="index.php"><img src="img/logo-kate.png" ></a>
        </div>
        <div class="menu">
        <?php
        include('../class/class.php');
        ?>
        
        <?php
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

            <!-- <li><a href="">DRESS</a>
                <ul class="sub-menu">
                    <li><a href="">Váy liền </a></li>
                    <li><a href=""> Váy dài </a></li>
                    <li><a href=""> Chân váy </a></li>
                </ul></li>
            <li><a href="">SET</a>
                <ul class="sub-menu">
                <li><a href="">Set tweed </a></li>
                <li><a href=""> Set dài </a></li>
                <li><a href=""> Set kèm chân váy ngắn </a></li>
            </ul>
            </li>
            <li><a href="">TROUSER</a>
                <ul class="sub-menu">
                    <li><a href="">Quần short </a></li>
                    <li><a href=""> Quần len </a></li>
                    <li><a href=""> Quần dài </a></li>
                </ul>
            </li>
            <li><a href="">SHIRT</a>
                <ul class="sub-menu">
                    <li><a href="">Váy tơ </a></li>
                    <li><a href=""> Váy liền dài </a></li>
                </ul></li>
            <li><a href="">JACKET</a>
                <ul class="sub-menu">
                    <li><a href="">Blazer </a></li>
                    <li><a href=""> Cashmere </a></li>
                    <li><a href=""> Tweed </a></li>
                </ul>
            </li>
            <li><a href="">PRODUCT SALE</a></li> -->
        </div>
        <div class="others">
            <li><input placeholder="Tim Kiem" type="text"></li>
            <li><a class="fas fa-search" href=""></a></li>
            <li><a class="fa fa-paw" href=""></a></li>
            <li>
        <a class="fa fa-user" id="user-menu-toggle"></a>
        <ul class="user-dropdown" id="user-dropdown">
            <?php if (isset($_SESSION['username'])) { ?>
                <li>Xin chào, <?php echo htmlspecialchars($_SESSION['username']); ?></li>
                <li><a href="logout.php">Đăng xuất</a></li>
            <?php } else { ?>
                <li><a href="login.php">Đăng nhập</a></li>
                <li><a href="register.php">Đăng ký</a></li>
            <?php } ?>
        </ul>
    </li>            <li><a class="fa fa-shopping-bag" href="cart.php"></a></li>

            
        </div>
        </header>
        <script>
    document.addEventListener('DOMContentLoaded', function () {
        const userMenuToggle = document.getElementById('user-menu-toggle');
        const userDropdown = document.getElementById('user-dropdown');

        // Hiển thị hoặc ẩn menu khi bấm vào biểu tượng
        userMenuToggle.addEventListener('click', function (e) {
            e.preventDefault();
            userDropdown.style.display = userDropdown.style.display === 'block' ? 'none' : 'block';
        });

        // Ẩn menu khi nhấp ra ngoài
        document.addEventListener('click', function (e) {
            if (!userMenuToggle.contains(e.target) && !userDropdown.contains(e.target)) {
                userDropdown.style.display = 'none';
            }
        });
    });
</script>

    
