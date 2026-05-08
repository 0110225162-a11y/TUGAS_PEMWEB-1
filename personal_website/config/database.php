<?php
// config/database.php
$host = 'localhost';
$dbname = 'personal_website';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("KONEKSI DATABASE GAGAL: " . $e->getMessage());
}
?>