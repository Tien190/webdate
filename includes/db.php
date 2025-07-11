<?php
$host = "sql100.infinityfree.com";       // Host MySQL của InfinityFree
$username = "if0_39432405";              // Username MySQL
$password = "hsWVr1VoLFY";               // Mật khẩu
$database = "if0_39432405_HeartMatchDB"; // Tên database

$conn = new mysqli($host, $username, $password, $database);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("❌ Kết nối thất bại: " . $conn->connect_error);
}
?>
