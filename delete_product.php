<?php
require_once 'includes/auth.php';
require_login();
require_once 'config.php';

$id = (int) ($_GET['id'] ?? 0);

if ($id > 0) {
    $sql = 'DELETE FROM products WHERE id = ?';
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
}

header('Location: products.php?message=Product deleted successfully');
exit;
?>
