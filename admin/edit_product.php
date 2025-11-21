<?php
include '../config.php';
if(!isset($_SESSION['user']) || $_SESSION['role']!='admin'){ header("Location: ../login.php"); exit(); }

$id = $_GET['id'];
$sql = "SELECT * FROM products WHERE id=$id";
$result = $conn->query($sql);
$product = $result->fetch_assoc();

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $price = $_POST['price'];
    $desc = $_POST['description'];

    $sql = "UPDATE products SET name='$name', price='$price', description='$desc' WHERE id=$id";
    if($conn->query($sql)) header("Location: index.php");
    else echo "Lỗi: ".$conn->error;
}
?>

<h2>Sửa sản phẩm</h2>
<form method="POST">
Tên sản phẩm: <input type="text" name="name" value="<?php echo $product['name']; ?>" required><br>
Giá: <input type="number" name="price" value="<?php echo $product['price']; ?>" required><br>
Mô tả: <textarea name="description" required><?php echo $product['description']; ?></textarea><br>
<input type="submit" name="submit" value="Cập nhật">
</form>
<a href="index.php">Quay lại</a>
