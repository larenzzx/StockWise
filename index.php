<?php
$page_title = 'Home';
include 'includes/header.php';
?>

<section class="hero">
    <div>
        <p class="eyebrow">Simple PHP Inventory Management</p>
        <h2>Track products, stock levels, and inventory value in one clean workspace.</h2>
        <p>StockWise helps small teams organize products, monitor low stock, and keep product records easy to find without complicated software.</p>
        <div class="hero-actions">
            <?php if (is_logged_in()) : ?>
                <a class="button" href="dashboard.php">Go to Dashboard</a>
                <a class="button secondary" href="products.php">View Products</a>
            <?php else : ?>
                <a class="button" href="login.php">Login to Manage Inventory</a>
                <a class="button secondary" href="#features">View Features</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="hero-panel">
        <h3>Inventory Snapshot</h3>
        <ul class="check-list">
            <li>Product records</li>
            <li>Stock status badges</li>
            <li>Search and update tools</li>
            <li>Dashboard summaries</li>
        </ul>
    </div>
</section>

<section class="box intro" id="features">
    <h2>What This System Does</h2>
    <p>This Inventory Management System stores product names, categories, quantities, prices, and dates added. Logged-in users can add new products, update existing items, search the inventory, and remove records that are no longer needed.</p>
</section>

<section class="grid three">
    <article class="box feature-card">
        <h3>Better Stock Awareness</h3>
        <p>Quickly see which items are in stock, running low, or out of stock before it affects daily operations.</p>
    </article>
    <article class="box feature-card">
        <h3>Cleaner Records</h3>
        <p>Keep product details in one searchable list instead of scattered notes, paper sheets, or spreadsheets.</p>
    </article>
    <article class="box feature-card">
        <h3>Beginner Friendly</h3>
        <p>The app uses pure PHP, MySQL, HTML, and CSS so it stays easy to understand, edit, and extend.</p>
    </article>
</section>

<section class="box cta-band">
    <div>
        <h2>Ready to manage your products?</h2>
        <p>Use the dashboard to review inventory health and the products page to maintain your stock list.</p>
    </div>
    <?php if (is_logged_in()) : ?>
        <a class="button" href="dashboard.php">Open Dashboard</a>
    <?php else : ?>
        <a class="button" href="login.php">Login</a>
    <?php endif; ?>
</section>

<?php include 'includes/footer.php'; ?>
