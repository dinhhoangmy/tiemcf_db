<?php
// Kết nối database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tiemcf_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xử lý form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_name = $conn->real_escape_string($_POST['category_name']);
    $description = $conn->real_escape_string($_POST['description']);

    $sql = "INSERT INTO post_categories (category_name, description)
            VALUES ('$category_name', '$description')";

    if ($conn->query($sql) === TRUE) {
        echo "Thêm chuyên mục thành công!";
    } else {
        if ($conn->errno == 1062) { // Duplicate entry
            echo "Chuyên mục này đã tồn tại!";
        } else {
            echo "Lỗi: " . $conn->error;
        }
    }
}

$conn->close();
?>
