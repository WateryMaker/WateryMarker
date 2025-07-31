<?php
$host = 'localhost';
$dbname = 'finance_web';
$username = 'root';
$password = ''; // หรือใส่รหัสผ่านของคุณ

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>