<?php
session_start();
session_destroy();
header("Location: login.html");
exit();
?>
<?php
$conn = new mysqli("localhost", "root", "", "finance_web");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    if (password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<script>alert('รหัสผ่านไม่ถูกต้อง'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('ไม่พบผู้ใช้งาน'); window.history.back();</script>";
}
$conn->close();
?>