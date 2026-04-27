<?php
require_once __DIR__ . '/auth.php';

if (!isset($page_title)) {
    $page_title = 'Inventory Management System';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="site-header">
        <div class="container">
            <h1>Inventory Management System</h1>
            <nav class="nav">
                <a href="index.php">Home</a>
                <a href="about.php">About</a>
                <a href="contact.php">Contact</a>
                <?php if (is_logged_in()) : ?>
                    <a href="dashboard.php">Dashboard</a>
                    <a href="products.php">Products</a>
                    <a href="add_product.php">Add Product</a>
                    <a href="logout.php">Logout</a>
                <?php else : ?>
                    <a href="login.php">Login</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    <main class="container">
