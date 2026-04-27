<?php
require_once 'includes/auth.php';
require_login();
require_once 'config.php';

$page_title = 'Products';
$search = trim($_GET['search'] ?? '');
$message = $_GET['message'] ?? '';

function stock_status($quantity)
{
    if ($quantity == 0) {
        return ['Out of Stock', 'out'];
    }

    if ($quantity >= 1 && $quantity <= 5) {
        return ['Low Stock', 'low'];
    }

    return ['In Stock', 'in'];
}

if ($search !== '') {
    $search_value = '%' . $search . '%';
    $sql = 'SELECT * FROM products WHERE product_name LIKE ? OR category LIKE ? ORDER BY date_added DESC';
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ss', $search_value, $search_value);
    mysqli_stmt_execute($stmt);
    $products = mysqli_stmt_get_result($stmt);
} else {
    $products = mysqli_query($conn, 'SELECT * FROM products ORDER BY date_added DESC');
}

include 'includes/header.php';
?>

<section class="box">
    <h2>Products</h2>

    <?php if ($message !== '') : ?>
        <div class="message success"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form method="get" action="products.php" class="actions">
        <input type="text" name="search" placeholder="Search by product or category" value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Search</button>
        <a class="button" href="products.php">Clear</a>
        <a class="button" href="add_product.php">Add Product</a>
    </form>
</section>

<table>
    <thead>
        <tr>
            <th>Product Name</th>
            <th>Category</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Date Added</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (mysqli_num_rows($products) > 0) : ?>
            <?php while ($product = mysqli_fetch_assoc($products)) : ?>
                <?php [$status_text, $status_class] = stock_status($product['quantity']); ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($product['category']); ?></td>
                    <td><?php echo (int) $product['quantity']; ?></td>
                    <td>$<?php echo number_format((float) $product['price'], 2); ?></td>
                    <td><?php echo htmlspecialchars($product['date_added']); ?></td>
                    <td><span class="status <?php echo $status_class; ?>"><?php echo $status_text; ?></span></td>
                    <td class="actions">
                        <a class="button" href="edit_product.php?id=<?php echo $product['id']; ?>">Edit</a>
                        <a class="button danger" href="delete_product.php?id=<?php echo $product['id']; ?>" onclick="return confirm('Delete this product?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else : ?>
            <tr>
                <td colspan="7">No products found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include 'includes/footer.php'; ?>
