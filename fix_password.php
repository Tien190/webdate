<?php
require_once('includes/config.php');

$email = 'admin@email.com';
$newPassword = '123456';

$hashed = password_hash($newPassword, PASSWORD_DEFAULT);

$stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
$stmt->bind_param("ss", $hashed, $email);

if ($stmt->execute()) {
    echo "✅ Đặt lại mật khẩu admin thành công.";
} else {
    echo "❌ Lỗi cập nhật: " . $stmt->error;
}

$conn->close();
