<?php
// Hiển thị lỗi khi debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Nhúng file config
require_once('includes/config.php');

$email = 'admin@gmail.com';
$password = password_hash('123', PASSWORD_DEFAULT);
$role = 'admin';

$sql = "INSERT INTO users (email, password, role) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $email, $password, $role);

if ($stmt->execute()) {
    echo "✅ Tạo tài khoản admin thành công!";
} else {
    echo "❌ Lỗi: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
