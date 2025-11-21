<?php
session_start();
include 'config.php';
if(isset($_POST['id'],$_POST['quantity'])){
    $id=$_POST['id'];
    $qty=$_POST['quantity'];
    if(!isset($_SESSION['cart'][$id])) $_SESSION['cart'][$id]=0;
    $_SESSION['cart'][$id]+=$qty;
}
header("Location:index.php"); exit();
?>
