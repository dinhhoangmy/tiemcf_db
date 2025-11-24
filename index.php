<?php
include 'config.php';
if(!isset($_SESSION['user']) || $_SESSION['role']!='user'){ 
    header("Location: login.php"); 
    exit(); 
}
$sql="SELECT * FROM products";
$result=$conn->query($sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Tiệm Cà Phê - Quản lý</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f2f5;
        margin: 0;
        padding: 0;
    }
    header {
        background-color: #6f4e37;
        color: white;
        padding: 20px;
        text-align: center;
    }
    header a {
        color: white;
        margin: 0 10px;
        text-decoration: none;
        font-weight: bold;
    }
    header a:hover {
        text-decoration: underline;
    }
    .container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        padding: 20px;
    }
    .card {
        background-color: #fff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 6px 12px rgba(0,0,0,0.1);
        width: 300px;
        box-sizing: border-box;
    }
    h2 {
        text-align: center;
        color: #6f4e37;
    }
    label {
        font-weight: bold;
    }
    input[type="text"], input[type="email"], input[type="number"], textarea {
        width: 100%;
        padding: 8px;
        margin: 6px 0 12px 0;
        border: 1px solid #ccc;
        border-radius: 6px;
        box-sizing: border-box;
    }
    textarea {
        resize: vertical;
    }
    input[type="submit"] {
        width: 100%;
        padding: 10px;
        background-color: #6f4e37;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 16px;
    }
    input[type="submit"]:hover {
        background-color: #533727;
    }
    .products {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        margin-bottom: 30px;
    }
    .product {
        background-color: #fff;
        padding: 15px;
        border-radius: 12px;
        width: 250px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        text-align: center;
    }
    .product h3 {
        color: #6f4e37;
        margin-bottom: 10px;
    }
    .product p {
        margin: 5px 0;
    }
    .product input[type="number"] {
        width: 60px;
        display: inline-block;
    }
    .product input[type="submit"] {
        width: auto;
        padding: 6px 12px;
        margin-top: 6px;
    }
</style>
</head>
<body>

<header>
    <h1>Chào <?php echo $_SESSION['user']; ?>, Chào Mừng Đến Với Tiệm Cà Phê</h1>
    <div>
        <a href="cart.php">Giỏ hàng(<?php echo count($_SESSION['cart']??[]); ?>)</a> |
        <a href="logout.php">Đăng xuất</a>
    </div>
</header>

<!-- Sản phẩm -->
<div class="products">
<?php while($row=$result->fetch_assoc()): ?>
    <div class="product">
        <h3><?php echo $row['name']; ?></h3>
        <p><?php echo $row['description']; ?></p>
        <p>Giá: <?php echo number_format($row['price']); ?> VNĐ</p>
        <form method="POST" action="add_to_cart.php">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <input type="number" name="quantity" value="1" min="1">
            <input type="submit" value="Thêm vào giỏ">
        </form>
    </div>
<?php endwhile; ?>
</div>

<div class="container">
    <!-- Form liên hệ -->
    <div class="card">
        <h2>Liên hệ quán cà phê</h2>
        <form action="contact.php" method="post">
            <label>Họ và tên:</label>
            <input type="text" name="name" required>
            <label>Email:</label>
            <input type="email" name="email" required>
            <label>Số điện thoại:</label>
            <input type="text" name="phone">
            <label>Nội dung:</label>
            <textarea name="message" required></textarea>
            <input type="submit" value="Gửi liên hệ">
        </form>
    </div>

    <!-- Form nhập kho -->
    <div class="card">
        <h2>Nhập kho sản phẩm</h2>
        <form action="warehouse_import.php" method="post">
            <label>Tên sản phẩm:</label>
            <input type="text" name="product_name" required>
            <label>Số lượng:</label>
            <input type="number" name="quantity" required>
            <label>Giá mỗi sản phẩm:</label>
            <input type="number" name="price_each" required>
            <label>Nhà cung cấp:</label>
            <input type="text" name="supplier">
            <input type="submit" value="Nhập kho">
        </form>
    </div>

    <!-- Form đơn hàng chờ -->
    <div class="card">
        <h2>Thêm đơn hàng chờ</h2>
        <form action="pending_order.php" method="post">
            <label>Bàn:</label>
            <input type="text" name="table_name" required>
            <label>Sản phẩm:</label>
            <input type="text" name="product_name" required>
            <label>Số lượng:</label>
            <input type="number" name="quantity" required>
            <label>Giá mỗi sản phẩm:</label>
            <input type="number" name="price_each" required>
            <input type="submit" value="Thêm đơn hàng">
        </form>
    </div>

    <!-- Form thêm chuyên mục bài viết -->
    <div class="card">
        <h2>Thêm chuyên mục bài viết</h2>
        <form action="post_category.php" method="post">
            <label>Tên chuyên mục:</label>
            <input type="text" name="category_name" required>
            <label>Mô tả:</label>
            <textarea name="description"></textarea>
            <input type="submit" value="Thêm chuyên mục">
        </form>
    </div>
</div>

</body>
</html>
