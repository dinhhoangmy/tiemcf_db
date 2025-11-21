<?php
include '../config.php';
if(!isset($_SESSION['user']) || $_SESSION['role']!='admin'){ header("Location: ../login.php"); exit(); }

$id = $_GET['id'];
$sql = "DELETE FROM products WHERE id=$id";
$conn->query($sql);

header("Location: index.php");
exit();
?>
