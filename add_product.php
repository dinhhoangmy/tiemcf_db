<?php
include 'config.php'; // kết nối database

if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $price = $_POST['price'];
    $desc = $_POST['description'];

    // --- XỬ LÝ HÌNH ẢNH ---
    $imageName = "";
    if (!empty($_FILES['image']['name'])) {

        // thư mục lưu ảnh
        $folder = "images/";

        // nếu chưa có thư mục -> tạo
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        // lấy tên file
        $imageName = basename($_FILES['image']['name']);
        $target = $folder . $imageName;

        // upload ảnh
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            die("❌ Lỗi upload ảnh!");
        }
    }

    // --- LƯU DATABASE ---
    $sql = "INSERT INTO products (name, price, description, image)
            VALUES ('$name', '$price', '$desc', '$imageName')";

    if ($conn->query($sql) === TRUE) {
        echo "✅ Đã thêm sản phẩm thành công!";
    } else {
        echo "❌ Lỗi database: " . $conn->error;
    }
}
?>

<!-- FORM HTML -->
<form method="POST" enctype="multipart/form-data">
    <h2>Thêm sản phẩm mới</h2>

    Tên sản phẩm:<br>
    <input type="text" name="name" required><br><br>

    Giá:<br>
    <input type="number" name="price" required><br><br>

    Mô tả:<br>
    <textarea name="description"></textarea><br><br>

    Ảnh sản phẩm:<br>
    <input type="file" name="image"><br><br>

    <input type="submit" name="submit" value="Thêm sản phẩm">
</form>
