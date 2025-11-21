<?php
include 'config.php';

$username = "admin";
$password = password_hash(" ", PASSWORD_DEFAULT);
$role = "admin";

$conn->query("INSERT INTO users (username,password,role) VALUES ('$username','$password','$role')");
echo "Admin tạo xong! Username: admin, Password: 123456";
?>
