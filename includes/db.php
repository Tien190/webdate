<?php
$host = "localhost";
$user = "root";
$pass = ""; // nếu bạn không đổi mật khẩu
$db = "webdata";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Kết nối thất bại: " . $conn->connect_error);
}
?>
