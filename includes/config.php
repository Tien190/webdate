<?php
// CẤU HÌNH DATABASE (InfinityFree hoặc Localhost)
$host = "sql100.infinityfree.com";           // InfinityFree
$username = "if0_39432405";
$password = "hsWVr1VoLFY";
$database = "if0_39432405_HeartMatchDB";

// Kết nối database
$conn = new mysqli($host, $username, $password, $database);
$conn->set_charset("utf8mb4");

// Kiểm tra lỗi
if ($conn->connect_error) {
    die("❌ Kết nối thất bại: " . $conn->connect_error);
}
?>
