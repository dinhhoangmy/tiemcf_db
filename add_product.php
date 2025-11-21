<?php
include 'config.php';

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $price = $_POST['price'];
    $desc = $_POST['description'];
    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    move_uploaded_file($tmp, "images/".$image);

    $sql = "INSERT INTO products (name, price, description, image) VALUES ('$name', '$price', '$desc', '$image')";
    $conn->query($sql);
    echo "Đã thêm sản phẩm!";
}
?>

<form method="POST" enctype="multipart/form-data">
    Tên: <input type="text" name="name"><br>
    Giá: <input type="number" name="price"><br>
    Mô tả: <textarea name="description"></textarea><br>
    Ảnh: <input type="file" name="image"><br>
    <input type="submit" name="submit" value="Thêm sản phẩm">
</form>
