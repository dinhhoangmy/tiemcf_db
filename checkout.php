<?php
include 'config.php';
if(!isset($_SESSION['user']) || $_SESSION['role']!='user'){ 
    header("Location: login.php"); 
    exit(); 
}

$cart = $_SESSION['cart'] ?? [];
$total = 0;

foreach($cart as $id=>$qty){
    $sql="SELECT * FROM products WHERE id=$id";
    $result=$conn->query($sql);
    $p=$result->fetch_assoc();
    $subtotal = $p['price'] * $qty;
    $total += $subtotal;
}

if(isset($_POST['submit'])){
    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $products_json = json_encode($cart);

    $sql = "INSERT INTO orders (username, products, total_price, fullname, phone, address)
            VALUES ('".$_SESSION['user']."', '$products_json', '$total', '$fullname', '$phone', '$address')";
    
    if($conn->query($sql)){
        $_SESSION['cart'] = [];
        echo "Thanh toán thành công! Tổng tiền: ".number_format($total)." VNĐ";
        echo "<br><a href='index.php'>Quay lại trang chủ</a>";
        exit();
    } else echo "Lỗi: ".$conn->error;
}
?>
<h2>Thanh toán</h2>
<table border="1" cellpadding="5">
<tr><th>Sản phẩm</th><th>Giá</th><th>Số lượng</th><th>Thành tiền</th></tr>
<?php
foreach($cart as $id=>$qty){
    $sql="SELECT * FROM products WHERE id=$id";
    $result=$conn->query($sql);
    $p=$result->fetch_assoc();
    $subtotal = $p['price'] * $qty;
    echo "<tr>
    <td>{$p['name']}</td>
    <td>".number_format($p['price'])."</td>
    <td>$qty</td>
    <td>".number_format($subtotal)."</td>
    </tr>";
}
?>
<tr><td colspan="3"><b>Tổng tiền</b></td><td><b><?php echo number_format($total); ?> VNĐ</b></td></tr>
</table>

<h3>Thông tin khách hàng</h3>
<form method="POST">
Họ và tên: <input type="text" name="fullname" required><br>
Số điện thoại: <input type="text" name="phone" required><br>
Địa chỉ: <textarea name="address" required></textarea><br>
<input type="submit" name="submit" value="Thanh toán">
</form>
<a href="cart.php">Quay lại giỏ hàng</a>
