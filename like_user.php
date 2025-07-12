<?php
session_start();
require_once('includes/config.php');

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Bạn chưa đăng nhập"]);
    exit;
}

$currentUserId = $_SESSION['user_id'];

// Nhận dữ liệu từ JS
$data = json_decode(file_get_contents("php://input"), true);
$likedId = $data['liked_id'] ?? null;

if (!$likedId || $likedId == $currentUserId) {
    echo json_encode(["success" => false, "message" => "Dữ liệu không hợp lệ"]);
    exit;
}

// Kiểm tra xem người kia đã thích mình chưa
$stmt = $conn->prepare("SELECT * FROM match WHERE user1_id = ? AND user2_id = ?");
$stmt->bind_param("ii", $likedId, $currentUserId);
$stmt->execute();
$result = $stmt->get_result();

$matched = false;

if ($result->num_rows > 0) {
    // Người kia đã thích mình => tạo match 2 chiều
    $matched = true;

    // Lưu cả chiều còn lại nếu chưa có
    $stmt = $conn->prepare("INSERT IGNORE INTO match (user1_id, user2_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $currentUserId, $likedId);
    $stmt->execute();
} else {
    // Chưa ai thích mình, lưu 1 chiều
    $stmt = $conn->prepare("INSERT IGNORE INTO match (user1_id, user2_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $currentUserId, $likedId);
    $stmt->execute();
}

echo json_encode(["success" => true, "matched" => $matched]);
$conn->close();
?>
