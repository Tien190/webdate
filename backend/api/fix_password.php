<?php
require_once('../../includes/config.php');

$email = 'test@gmail.com';
$newPassword = '1234'; // mật khẩu mới bạn muốn đặt

$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

$stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
$stmt->bind_param("ss", $hashedPassword, $email);

if ($stmt->execute()) {
    echo "✅ Đã cập nhật lại mật khẩu thành công.";
} else {
    echo "❌ Lỗi cập nhật: " . $stmt->error;
}

$conn->close();
?>
