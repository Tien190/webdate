<?php
session_start();
require_once('includes/config.php');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($_SESSION['user_id']) || empty($data['receiver_id']) || empty($data['message'])) {
    echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
    exit;
}

$sender_id = $_SESSION['user_id'];
$receiver_id = $data['receiver_id'];
$message = trim($data['message']);

$stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $sender_id, $receiver_id, $message);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Lỗi khi gửi tin nhắn']);
}
?>
