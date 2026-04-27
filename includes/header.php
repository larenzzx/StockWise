<?php
require_once __DIR__ . '/auth.php';

if (!isset($page_title)) {
    $page_title = 'Inventory Management System';
}

$current_page = basename($_SERVER['PHP_SELF']);

if (!function_exists('nav_class')) {
    function nav_class($page, $current_page)
    {
        return $page === $current_page ? ' class="active"' : '';
    }
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
            <h1><a href="index.php">StockWise Inventory</a></h1>
            <nav class="nav">
                <a href="index.php"<?php echo nav_class('index.php', $current_page); ?>>Home</a>
                <a href="about.php"<?php echo nav_class('about.php', $current_page); ?>>About</a>
                <a href="contact.php"<?php echo nav_class('contact.php', $current_page); ?>>Contact</a>
                <?php if (is_logged_in()) : ?>
                    <a href="dashboard.php"<?php echo nav_class('dashboard.php', $current_page); ?>>Dashboard</a>
                    <a href="products.php"<?php echo nav_class('products.php', $current_page); ?>>Products</a>
                    <a href="add_product.php"<?php echo nav_class('add_product.php', $current_page); ?>>Add Product</a>
                    <a href="logout.php">Logout</a>
                <?php else : ?>
                    <a href="login.php"<?php echo nav_class('login.php', $current_page); ?>>Login</a>
                    <a href="register.php"<?php echo nav_class('register.php', $current_page); ?>>Register</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    <main class="container">
