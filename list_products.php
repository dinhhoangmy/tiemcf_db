<?php
include 'config.php';

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<h2>Danh sách sản phẩm</h2>

<?php
while($row = $result->fetch_assoc()){
?>
    <div style="border:1px solid #ccc; padding:10px; width:250px; margin-bottom:10px;">
        <h3><?php echo $row['name']; ?></h3>

        <!-- Hiển thị hình ảnh -->
        <img src="images/<?php echo $row['image']; ?>" width="200"><br><br>
        <a href="edit_product.php?id=<?= $row['id'] ?>">Sửa</a>
        <strong>Giá:</strong> <?php echo $row['price']; ?>đ<br>
        <strong>Mô tả:</strong> <?php echo $row['description']; ?>
    </div>
<?php } ?>
