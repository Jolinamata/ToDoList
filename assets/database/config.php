<?php
$host = 'localhost';  // Hostname of the database server
$dbname = 'your_database';  // Your database name
$username = 'root';  // Database username
$password = '';  // Database password (leave empty if you use default)

try {
    // Create a PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  // Enable error handling
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}
?>
