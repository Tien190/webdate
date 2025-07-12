<?php
$host = "localhost";
$username = "rjvjotw_rjvjotw";
$password = "4A#^sAfpv$Qe";
$dbname = "rjvjotw_heart";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("❌ Kết nối thất bại: " . $conn->connect_error);
}
echo "✅ Kết nối CSDL thành công!";
?>
