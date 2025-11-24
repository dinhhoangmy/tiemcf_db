<?php
include 'config.php';

// START SESSION AN TOÀN
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra user đăng nhập
if(!isset($_SESSION['user']) || $_SESSION['role'] != 'user'){
    header("Location: login.php");
    exit();
}

$cart = $_SESSION['cart'] ?? [];
$total = 0;

// Tính tổng tiền giỏ hàng
foreach($cart as $id => $qty){
    $sql = "SELECT * FROM products WHERE id=$id";
    $result = $conn->query($sql);
    $p = $result->fetch_assoc();
    $subtotal = $p['price'] * $qty;
    $total += $subtotal;
}

// Xử lý submit checkout
if(isset($_POST['submit'])){
    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $discount_code = $_POST['discount_code'] ?? null;
    $discount_amount = 0;

    // Nếu có mã giảm giá, kiểm tra trong database
    if($discount_code){
        $sql = "SELECT * FROM discount_codes WHERE code='$discount_code' 
                AND start_date <= CURDATE() AND end_date >= CURDATE()";
        $res = $conn->query($sql);
        if($res->num_rows > 0){
            $dc = $res->fetch_assoc();
            if($dc['discount_type'] == 'percent'){
                $discount_amount = $total * ($dc['discount_value']/100);
            } else {
                $discount_amount = $dc['discount_value'];
            }
        } else {
            $discount_code = null; // mã không hợp lệ
        }
    }

    $total_after_discount = $total - $discount_amount;
    $products_json = json_encode($cart);

    // Lưu đơn hàng với status = 'paid'
    $sql = "INSERT INTO orders (username, products, total_price, fullname, phone, address, discount_code, discount_amount, status)
            VALUES ('".$_SESSION['user']."', '$products_json', '$total_after_discount', '$fullname', '$phone', '$address', '$discount_code', '$discount_amount', 'paid')";

    if($conn->query($sql)){
        $_SESSION['cart'] = [];
        echo "Thanh toán thành công! Tổng tiền: ".number_format($total_after_discount)." VNĐ";
        echo "<br><a href='index.php'>Quay lại trang chủ</a>";
        exit();
    } else {
        echo "Lỗi: ".$conn->error;
    }
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
Mã giảm giá: <input type="text" name="discount_code"><br>
<input type="submit" name="submit" value="Thanh toán">
</form>
<a href="cart.php">Quay lại giỏ hàng</a>
