<?php
include 'config.php';
if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username,password,role) VALUES ('$username','$password','user')";
    if($conn->query($sql)) echo "Đăng ký thành công! <a href='login.php'>Đăng nhập</a>";
    else echo "Lỗi: ".$conn->error;
}
?>
<h2>Đăng ký</h2>
<form method="POST">
Tài khoản: <input type="text" name="username" required><br>
Mật khẩu: <input type="password" name="password" required><br>
<input type="submit" name="submit" value="Đăng ký">
</form>
