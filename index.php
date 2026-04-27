<?php
$page_title = 'Home';
include 'includes/header.php';
?>

<section class="box">
    <h2>Home</h2>
    <p>This simple Inventory Management System helps you track products, quantities, prices, and stock status.</p>
    <?php if (is_logged_in()) : ?>
        <p><a class="button" href="dashboard.php">Go to Dashboard</a></p>
    <?php else : ?>
        <p><a class="button" href="login.php">Login to Manage Inventory</a></p>
    <?php endif; ?>
</section>

<?php include 'includes/footer.php'; ?>
