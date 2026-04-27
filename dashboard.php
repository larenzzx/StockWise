<?php
require_once 'includes/auth.php';
require_login();
require_once 'config.php';

$page_title = 'Dashboard';

$total_products = 0;
$out_of_stock = 0;
$low_stock = 0;
$inventory_value = 0;
$recent_products = false;

function dashboard_stock_status($quantity)
{
    if ($quantity == 0) {
        return ['Out of Stock', 'out'];
    }

    if ($quantity >= 1 && $quantity <= 5) {
        return ['Low Stock', 'low'];
    }

    return ['In Stock', 'in'];
}

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

$result = mysqli_query($conn, 'SELECT SUM(quantity * price) AS total_value FROM products');
if ($row = mysqli_fetch_assoc($result)) {
    $inventory_value = $row['total_value'] ?? 0;
}

$recent_products = mysqli_query($conn, 'SELECT * FROM products ORDER BY date_added DESC, id DESC LIMIT 5');

include 'includes/header.php';
?>

<section class="box dashboard-hero">
    <h2>Dashboard</h2>
    <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>.</p>
    <div class="actions">
        <a class="button" href="products.php">View Products</a>
        <a class="button" href="add_product.php">Add Product</a>
    </div>
</section>

<section class="summary-grid">
    <article class="summary-card">
        <span>Total Products</span>
        <strong><?php echo (int) $total_products; ?></strong>
    </article>
    <article class="summary-card warning">
        <span>Low Stock</span>
        <strong><?php echo (int) $low_stock; ?></strong>
    </article>
    <article class="summary-card danger">
        <span>Out of Stock</span>
        <strong><?php echo (int) $out_of_stock; ?></strong>
    </article>
    <article class="summary-card success">
        <span>Total Inventory Value</span>
        <strong>PHP <?php echo number_format((float) $inventory_value, 2); ?></strong>
    </article>
</section>

<section class="box">
    <div class="section-title-row">
        <div>
            <h2>Recent Products</h2>
            <p>Latest items added or updated in the inventory list.</p>
        </div>
        <a class="button secondary" href="products.php">View All</a>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($recent_products && mysqli_num_rows($recent_products) > 0) : ?>
                    <?php while ($product = mysqli_fetch_assoc($recent_products)) : ?>
                        <?php [$status_text, $status_class] = dashboard_stock_status($product['quantity']); ?>
                        <tr>
                            <td data-label="Product Name"><?php echo htmlspecialchars($product['product_name']); ?></td>
                            <td data-label="Category"><?php echo htmlspecialchars($product['category']); ?></td>
                            <td data-label="Quantity"><?php echo (int) $product['quantity']; ?></td>
                            <td data-label="Price">PHP <?php echo number_format((float) $product['price'], 2); ?></td>
                            <td data-label="Status"><span class="status <?php echo $status_class; ?>"><?php echo $status_text; ?></span></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5">No products found yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
