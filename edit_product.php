<?php
require_once 'includes/auth.php';
require_login();
require_once 'config.php';

$page_title = 'Edit Product';
$error = '';
$id = (int) ($_GET['id'] ?? 0);

if ($id <= 0) {
    header('Location: products.php');
    exit;
}

$sql = 'SELECT * FROM products WHERE id = ?';
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    header('Location: products.php?message=Product not found');
    exit;
}

$product_name = $product['product_name'];
$category = $product['category'];
$quantity = $product['quantity'];
$price = $product['price'];
$date_added = $product['date_added'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = trim($_POST['product_name'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $quantity = trim($_POST['quantity'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $date_added = trim($_POST['date_added'] ?? '');

    if ($product_name === '' || $category === '' || $quantity === '' || $price === '' || $date_added === '') {
        $error = 'All fields are required.';
    } elseif (!is_numeric($quantity) || (int) $quantity < 0) {
        $error = 'Quantity must be a number of 0 or more.';
    } elseif (!is_numeric($price) || (float) $price < 0) {
        $error = 'Price must be a number of 0 or more.';
    } else {
        $sql = 'UPDATE products SET product_name = ?, category = ?, quantity = ?, price = ?, date_added = ? WHERE id = ?';
        $stmt = mysqli_prepare($conn, $sql);
        $quantity_value = (int) $quantity;
        $price_value = (float) $price;
        mysqli_stmt_bind_param($stmt, 'ssidsi', $product_name, $category, $quantity_value, $price_value, $date_added, $id);

        if (mysqli_stmt_execute($stmt)) {
            header('Location: products.php?message=Product updated successfully');
            exit;
        }

        $error = 'Could not update product. Please try again.';
    }
}

include 'includes/header.php';
?>

<section class="box form-card narrow">
    <h2>Edit Product</h2>
    <p>Update product details and save the changes to the inventory list.</p>
    <?php if ($error !== '') : ?>
        <div class="message error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="post" action="edit_product.php?id=<?php echo $id; ?>">
        <label for="product_name">Product Name</label>
        <input type="text" id="product_name" name="product_name" value="<?php echo htmlspecialchars($product_name); ?>">

        <label for="category">Category</label>
        <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($category); ?>">

        <label for="quantity">Quantity</label>
        <input type="number" id="quantity" name="quantity" min="0" value="<?php echo htmlspecialchars($quantity); ?>">

        <label for="price">Price</label>
        <input type="number" id="price" name="price" min="0" step="0.01" value="<?php echo htmlspecialchars($price); ?>">

        <label for="date_added">Date Added</label>
        <input type="date" id="date_added" name="date_added" value="<?php echo htmlspecialchars($date_added); ?>">

        <div class="form-actions">
            <button type="submit">Update Product</button>
            <a class="button secondary" href="products.php">Cancel</a>
        </div>
    </form>
</section>

<?php include 'includes/footer.php'; ?>
