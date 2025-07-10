<?php
session_start();
include 'includes/db.php';

$data = json_decode(file_get_contents("php://input"), true);
$sender_id = $_SESSION['user_id'];
$receiver_id = $data['receiver_id'];
$message = $conn->real_escape_string($data['message']);

$sql = "INSERT INTO messages (sender_id, receiver_id, message) 
        VALUES ($sender_id, $receiver_id, '$message')";
$conn->query($sql);

echo json_encode(["success" => true]);
?>
