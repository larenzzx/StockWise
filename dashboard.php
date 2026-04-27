<?php
require_once 'includes/auth.php';
require_login();
require_once 'config.php';

$page_title = 'Dashboard';

$total_products = 0;
$out_of_stock = 0;
$low_stock = 0;

$result = mysqli_query($conn, 'SELECT COUNT(*) AS total FROM products');
if ($row = mysqli_fetch_assoc($result)) {
    $total_products = $row['total'];
}

$result = mysqli_query($conn, 'SELECT COUNT(*) AS total FROM products WHERE quantity = 0');
if ($row = mysqli_fetch_assoc($result)) {
    $out_of_stock = $row['total'];
}

$result = mysqli_query($conn, 'SELECT COUNT(*) AS total FROM products WHERE quantity BETWEEN 1 AND 5');
if ($row = mysqli_fetch_assoc($result)) {
    $low_stock = $row['total'];
}

include 'includes/header.php';
?>

<section class="box">
    <h2>Dashboard</h2>
    <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>.</p>
    <p>Total Products: <strong><?php echo $total_products; ?></strong></p>
    <p>Low Stock Products: <strong><?php echo $low_stock; ?></strong></p>
    <p>Out of Stock Products: <strong><?php echo $out_of_stock; ?></strong></p>
    <p class="actions">
        <a class="button" href="products.php">View Products</a>
        <a class="button" href="add_product.php">Add Product</a>
    </p>
</section>

<?php include 'includes/footer.php'; ?>
