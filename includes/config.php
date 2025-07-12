<?php
$host = 'localhost';         // Máy chủ database, thường là localhost trong XAMPP
$db   = 'heartmatch';        // Tên cơ sở dữ liệu
$user = 'root';              // Tên người dùng mặc định của XAMPP
$pass = '';                  // Mật khẩu mặc định của XAMPP (để trống)
$charset = 'utf8mb4';        // Bộ mã ký tự

// Tạo kết nối mysqli
$conn = new mysqli($host, $user, $pass, $db);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối CSDL thất bại: " . $conn->connect_error);
}

// Thiết lập bộ mã ký tự
$conn->set_charset($charset);
?>
