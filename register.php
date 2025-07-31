<?php
$conn = new mysqli("localhost", "root", "", "finance_web");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// รับค่าจากฟอร์ม
$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// ✅ ตรวจสอบว่าตาราง users และคอลัมน์ email มีจริงหรือไม่
$check = $conn->prepare("SELECT * FROM users WHERE email = ?");
if (!$check) {
    die("❌ Prepare failed: " . $conn->error); // 🔍 แสดง error แบบชัดเจน
}

$check->bind_param("s", $email);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    echo "<script>alert('Email นี้ถูกใช้แล้ว'); window.history.back();</script>";
} else {
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    if (!$stmt) {
        die("❌ Prepare failed (insert): " . $conn->error); // 🔍 ถ้ามี error ตรงนี้ จะบอกว่า insert ผิด
    }

    $stmt->bind_param("sss", $username, $email, $password);
    $stmt->execute();

    echo "<script>alert('สมัครสมาชิกสำเร็จ!'); window.location.href='login.html';</script>";
}
$conn->close();
?>