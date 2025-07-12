<?php
session_start();
require_once('includes/config.php');

if (!isset($_SESSION['user_id']) || !isset($_GET['receiver_id'])) {
    echo json_encode([]);
    exit;
}

$current_user = $_SESSION['user_id'];
$other_user = intval($_GET['receiver_id']);

// Lấy cả tin nhắn gửi đi và nhận về giữa 2 người
$stmt = $conn->prepare("
  SELECT m.*, 
         CASE WHEN m.sender_id = ? THEN 'me' ELSE 'you' END AS sender,
         u.username AS sender_username
  FROM messages m
  JOIN users u ON m.sender_id = u.id
  WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)
  ORDER BY m.created_at ASC
");

$stmt->bind_param("iiiii", $current_user, $current_user, $other_user, $other_user, $current_user);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = [
        'message' => $row['message'],
        'sender' => $row['sender'],
        'sender_username' => $row['sender_username']
    ];
}

echo json_encode($messages);
?>
