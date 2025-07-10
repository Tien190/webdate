<?php
require_once('../../includes/config.php');

$email = 'test@gmail.com';
$password = '1234';

$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    echo "Password trong DB (hash): " . $user['password'] . "<br>";

    if (password_verify($password, $user['password'])) {
        echo "<h3 style='color: green;'>✅ Đăng nhập thành công</h3>";
    } else {
        echo "<h3 style='color: red;'>❌ Sai mật khẩu</h3>";
    }
} else {
    echo "<h3 style='color: red;'>❌ Không tìm thấy tài khoản</h3>";
}

$conn->close();
?>
