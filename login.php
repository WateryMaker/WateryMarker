<?php
session_start();
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
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard.php");
        exit();
    } else {
        // ❌ รหัสผิด → ส่งกลับ login พร้อม error
        header("Location: login.html?error=wrongpass");
        exit();
    }
} else {
    // ❌ ไม่พบผู้ใช้
    header("Location: login.html?error=notfound");
    exit();
}
$conn->close();
?>

<script>
  const params = new URLSearchParams(window.location.search);
  const error = params.get("error");

  if (error) {
    const errorContainer = document.getElementById("login-error");
    if (error === "wrongpass") {
      errorContainer.innerText = "รหัสผ่านไม่ถูกต้อง";
    } else if (error === "notfound") {
      errorContainer.innerText = "ไม่พบบัญชีผู้ใช้";
    }
    errorContainer.style.display = "block";
  }
</script>