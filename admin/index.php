<?php
include '../config.php';
if(!isset($_SESSION['user']) || $_SESSION['role']!='admin'){ header("Location: ../login.php"); exit(); }

$sql="SELECT * FROM products";
$result=$conn->query($sql);
?>
<h1>Quản trị sản phẩm</h1>
<a href="add_product.php">Thêm sản phẩm</a> | <a href="logout.php">Đơn hàng</a> | <a href="../logout.php">Đăng xuất</a>
<table border="1" cellpadding="5">
<tr><th>ID</th><th>Tên</th><th>Giá</th><th>Mô tả</th><th>Hành động</th></tr>
<?php while($row=$result->fetch_assoc()): ?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['name']; ?></td>
<td><?php echo number_format($row['price']); ?></td>
<td><?php echo $row['description']; ?></td>
<td>
<a href="edit_product.php?id=<?php echo $row['id']; ?>">Sửa</a> |
<a href="delete_product.php?id=<?php echo $row['id']; ?>">Xóa</a>
</td>
</tr>
<?php endwhile; ?>
</table>
<?php
include '../config.php';
if(!isset($_SESSION['user']) || $_SESSION['role']!='admin'){ 
    header("Location: ../login.php"); 
    exit(); 
}

$sql = "SELECT * FROM orders ORDER BY created_at DESC";
$result = $conn->query($sql);

echo "<h2>Đơn hàng</h2>";
echo "<table border='1' cellpadding='5'>
<tr><th>ID</th><th>Khách hàng</th><th>Sản phẩm</th><th>Tổng tiền</th><th>Thời gian</th></tr>";

while($row=$result->fetch_assoc()){
    $products = json_decode($row['products'], true); // chuyển JSON về mảng
    $prod_list = "";
    foreach($products as $pid=>$qty){
        $r=$conn->query("SELECT name FROM products WHERE id=$pid")->fetch_assoc();
        $prod_list .= $r['name']." x".$qty."<br>";
    }
    echo "<tr>
    <td>{$row['id']}</td>
    <td>{$row['fullname']}</td>
    <td>$prod_list</td>
    <td>".number_format($row['total_price'])."</td>
    <td>{$row['created_at']}</td>
    </tr>";
}
echo "</table>";

