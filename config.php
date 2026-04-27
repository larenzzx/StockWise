<?php
// Database connection settings.
// Update these values if your MySQL username, password, or database name is different.
$host = 'localhost';
$database = 'inventory_db';
$username = 'root';
$password = '';

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die('Database connection failed: ' . mysqli_connect_error());
}
?>
