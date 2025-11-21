<?php
include 'config.php';
if(!isset($_SESSION['user']) || $_SESSION['role']!='user'){ header("Location: login.php"); exit(); }
$sql="SELECT * FROM products";
$result=$conn->query($sql);
?>
<h1>Chào <?php echo $_SESSION['user']; ?>, Tiệm Cà Phê</h1>
<a href="cart.php">Giỏ hàng(<?php echo count($_SESSION['cart']??[]); ?>)</a> |
<a href="logout.php">Đăng xuất</a>
<div class="products">
<?php while($row=$result->fetch_assoc()): ?>
<div class="product">
<h3><?php echo $row['name']; ?></h3>
<p><?php echo $row['description']; ?></p>
<p>Giá: <?php echo number_format($row['price']); ?> VNĐ</p>
<form method="POST" action="add_to_cart.php">
<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
<input type="number" name="quantity" value="1" min="1">
<input type="submit" value="Thêm vào giỏ">
</form>
</div>
<?php endwhile; ?>
</div>
