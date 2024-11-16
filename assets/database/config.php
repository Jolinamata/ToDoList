<?php
// Database configuration
$host = 'localhost'; // Database host
$db = 'todo'; // Database name (updated)
$user = 'root'; // Database user
$pass = ''; // Database password (for XAMPP, use an empty string)

try {
    // Create a PDO instance to connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
