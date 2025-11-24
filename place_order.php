<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Kết nối database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tiemcf";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Dữ liệu giả lập giỏ hàng từ web
$customer_name = "Rin";
$cart = [
    ['product_id' => 1, 'quantity' => 2], // 2 ly Cà phê sữa
    ['product_id' => 2, 'quantity' => 1]  // 1 cái Bánh mì
];

// Bước 1: Tạo đơn hàng
$sql_order = "INSERT INTO orders (customer_name) VALUES (?)";
$stmt_order = $conn->prepare($sql_order);
$stmt_order->bind_param("s", $customer_name);
$stmt_order->execute();
$order_id = $stmt_order->insert_id;
$stmt_order->close();

// Bước 2: Thêm chi tiết vào order_items và tính tổng tiền
$total = 0;
foreach ($cart as $item) {
    $product_id = $item['product_id'];
    $quantity = $item['quantity'];

    $result = $conn->query("SELECT price FROM products WHERE id = $product_id");
    $row = $result->fetch_assoc();
    $price = $row['price'];

    $sql_item = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
    $stmt_item = $conn->prepare($sql_item);
    $stmt_item->bind_param("iiid", $order_id, $product_id, $quantity, $price);
    $stmt_item->execute();
    $stmt_item->close();

    $total += $price * $quantity;
}

// Bước 3: Cập nhật tổng tiền đơn hàng
$conn->query("UPDATE orders SET total = $total WHERE id = $order_id");

echo "Đặt hàng thành công! Order ID: $order_id, Tổng tiền: $total";

$conn->close();
?>
