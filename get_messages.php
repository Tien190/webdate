<?php
session_start();
include 'includes/db.php';

$receiver_id = $_GET['receiver_id'];
$sender_id = $_SESSION['user_id'];

$sql = "SELECT m.*, u.username AS sender_username
        FROM messages m
        JOIN users u ON m.sender_id = u.id
        WHERE (sender_id = $sender_id AND receiver_id = $receiver_id)
           OR (sender_id = $receiver_id AND receiver_id = $sender_id)
        ORDER BY created_at ASC";

$result = $conn->query($sql);
$messages = [];

while ($row = $result->fetch_assoc()) {
  $messages[] = [
    'sender' => $row['sender_id'] == $sender_id ? 'me' : 'them',
    'sender_username' => $row['sender_username'],
    'message' => $row['message']
  ];
}

echo json_encode($messages);
?>
