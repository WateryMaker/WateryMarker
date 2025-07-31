<?php
session_start();
require 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$date = date('Y-m-d');

$income = $_POST['income'];
$savings = $_POST['savings'];

// เพิ่มรายรับ (type = income)
$sql1 = "INSERT INTO savings (user_id, amount, type, description, date) 
         VALUES (?, ?, 'income', 'รายรับต่อเดือน', ?)";
$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param("ids", $user_id, $income, $date);
$stmt1->execute();

// เพิ่มเงินเก็บ (type = saving)
$sql2 = "INSERT INTO savings (user_id, amount, type, description, date) 
         VALUES (?, ?, 'expense', 'เงินเก็บปัจจุบัน', ?)";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param("ids", $user_id, $savings, $date);
$stmt2->execute();

header("Location: dashboard.php?success=1");
exit();
?>