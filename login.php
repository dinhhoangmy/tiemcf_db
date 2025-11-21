<?php
include 'config.php';
if(isset($_POST['submit'])){
    $username=$_POST['username'];
    $password=$_POST['password'];
    $sql="SELECT * FROM users WHERE username='$username'";
    $result=$conn->query($sql);
    if($result->num_rows>0){
        $user=$result->fetch_assoc();
        if(password_verify($password,$user['password'])){
            $_SESSION['user']=$username;
            $_SESSION['role']=$user['role'];
            if($user['role']=='admin') header("Location: admin/index.php");
            else{
                $_SESSION['cart']=[];
                header("Location: index.php");
            }
            exit();
        } else echo "Mật khẩu sai!";
    } else echo "Tài khoản không tồn tại!";
}
?>
<h2>Đăng nhập</h2>
<form method="POST">
Tài khoản: <input type="text" name="username" required><br>
Mật khẩu: <input type="password" name="password" required><br>
<input type="submit" name="submit" value="Đăng nhập">
</form>
