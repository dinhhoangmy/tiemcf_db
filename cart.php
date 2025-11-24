<?php
include 'config.php';
session_start();

if(!isset($_SESSION['user']) || $_SESSION['role']!='user'){ 
    header("Location: login.php"); 
    exit(); 
}

$cart = $_SESSION['cart'] ?? [];

// Xử lý xóa sản phẩm
if(isset($_GET['remove'])){
    $id = $_GET['remove'];
    if(isset($cart[$id])){
        unset($cart[$id]);
        $_SESSION['cart'] = $cart;
        header("Location: cart.php");
        exit();
    }
}

// Xóa toàn bộ giỏ hàng
if(isset($_GET['clear'])){
    $_SESSION['cart'] = [];
    header("Location: cart.php");
    exit();
}

$total = 0;
?>
<h1>Giỏ hàng của <?php echo $_SESSION['user']; ?></h1>
<a href="index.php">Tiếp tục mua</a> | 
<a href="?clear=1" onclick="return confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?')">Xóa tất cả</a> | 
<a href="logout.php">Đăng xuất</a>

<table border="1" cellpadding="5">
<tr>
    <th>Tên</th>
    <th>Giá</th>
    <th>Số lượng</th>
    <th>Thành tiền</th>
    <th>Thao tác</th>
</tr>
<?php
foreach($cart as $id=>$qty){
    $sql = "SELECT * FROM products WHERE id=$id";
    $result = $conn->query($sql);
    $p = $result->fetch_assoc();
    $subtotal = $p['price'] * $qty;
    $total += $subtotal;
    echo "<tr>
        <td>{$p['name']}</td>
        <td>".number_format($p['price'])."</td>
        <td>$qty</td>
        <td>".number_format($subtotal)."</td>
        <td><a href='cart.php?remove=$id' onclick=\"return confirm('Bạn có chắc muốn xóa sản phẩm này?')\">Xóa</a></td>
    </tr>";
}
?>
<tr>
    <td colspan="3"><b>Tổng tiền</b></td>
    <td colspan="2"><b><?php echo number_format($total); ?> VNĐ</b></td>
</tr>
</table>

<a href="checkout.php">Thanh toán</a>
