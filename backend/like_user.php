<?php
session_start();
require_once('includes/config.php');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Bạn chưa đăng nhập.']);
    exit;
}

$liker_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents("php://input"), true);
$liked_id = intval($data['liked_id']);

if ($liker_id === $liked_id) {
    echo json_encode(['success' => false, 'message' => 'Không thể tự thích chính mình.']);
    exit;
}

// 1. Ghi lượt thích vào bảng likes (nếu chưa tồn tại)
$stmt = $conn->prepare("INSERT IGNORE INTO likes (liker_id, liked_id) VALUES (?, ?)");
$stmt->bind_param("ii", $liker_id, $liked_id);
$stmt->execute();

// 2. Kiểm tra người kia có like lại chưa
$stmt2 = $conn->prepare("SELECT * FROM likes WHERE liker_id = ? AND liked_id = ?");
$stmt2->bind_param("ii", $liked_id, $liker_id);
$stmt2->execute();
$result = $stmt2->get_result();

if ($result->num_rows > 0) {
    // 3. Nếu có, tạo match (dựa vào min/max)
    $min_id = min($liker_id, $liked_id);
    $max_id = max($liker_id, $liked_id);

    $stmt3 = $conn->prepare("INSERT IGNORE INTO matches (user1_id, user2_id, user_min, user_max) VALUES (?, ?, ?, ?)");
    $stmt3->bind_param("iiii", $liker_id, $liked_id, $min_id, $max_id);
    $stmt3->execute();

    echo json_encode(['success' => true, 'matched' => true, 'message' => '🎉 Hai bạn đã ghép đôi thành công!']);
} else {
    echo json_encode(['success' => true, 'matched' => false, 'message' => 'Bạn đã thích người này!']);
}

$conn->close();
?>
