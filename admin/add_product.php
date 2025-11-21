<?php
include '../config.php';
if(!isset($_SESSION['user']) || $_SESSION['role']!='admin'){ header("Location: ../login.php"); exit(); }

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $price = $_POST['price'];
    $desc = $_POST['description'];

    $sql = "INSERT INTO products (name, price, description) VALUES ('$name','$price','$desc')";
    if($conn->query($sql)) header("Location: index.php");
    else echo "Lỗi: ".$conn->error;
}
?>

<h2>Thêm sản phẩm mới</h2>
<form method="POST">
Tên sản phẩm: <input type="text" name="name" required><br>
Giá: <input type="number" name="price" required><br>
Mô tả: <textarea name="description" required></textarea><br>
<input type="submit" name="submit" value="Thêm sản phẩm">
</form>
<a href="index.php">Quay lại</a>
