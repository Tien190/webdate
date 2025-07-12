<?php
session_start();
require_once('includes/config.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: signin.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$full_name = trim($_POST['full_name'] ?? '');
$education = trim($_POST['education'] ?? '');
$height = intval($_POST['height'] ?? 0);
$current_residence = trim($_POST['current_residence'] ?? '');
$hometown = trim($_POST['hometown'] ?? '');
$job = trim($_POST['job'] ?? '');
$gender = $_POST['gender'];

if (empty($full_name) || empty($education) || empty($current_residence) || empty($hometown) || empty($job) || $height <= 0) {
    die("❌ Vui lòng điền đầy đủ thông tin hợp lệ.");
}

$check = $conn->prepare("SELECT id FROM personal_information WHERE user_id = ?");
$check->bind_param("i", $user_id);
$check->execute();
$check->store_result();
if ($check->num_rows > 0) {
    die("⚠️ Thông tin cá nhân đã tồn tại.");
}
$check->close();

$avatar_file = $_FILES['avatar'] ?? null;
$avatar_filename = null;
if ($avatar_file && $avatar_file['error'] === 0) {
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($avatar_file['type'], $allowed_types)) {
        die("❌ Chỉ cho phép ảnh JPG, PNG, GIF.");
    }

    $ext = pathinfo($avatar_file['name'], PATHINFO_EXTENSION);
    $avatar_filename = "avatar_user_" . $user_id . "_" . time() . "." . $ext;

    $upload_dir = __DIR__ . "/uploads/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    move_uploaded_file($avatar_file['tmp_name'], $upload_dir . $avatar_filename);
} else {
    die("❌ Vui lòng chọn ảnh đại diện.");
}

$stmt = $conn->prepare("INSERT INTO personal_information (user_id, full_name, education, height, current_residence, hometown, job, avatar) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ississss", $user_id, $full_name, $education, $height, $current_residence, $hometown, $job, $avatar_filename);
$stmt = $conn->prepare("INSERT INTO personal_information 
(full_name, education, height, current_residence, hometown, job, avatar, gender, user_id)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssisssssi", $full_name, $education, $height, $current_residence, $hometown, $job, $avatar_filename, $gender, $user_id);

if ($stmt->execute()) {
    echo "✅ Đã lưu thông tin & ảnh avatar thành công. <a href='ho_so.php'>Quay lại</a>";
} else {
    echo "❌ Lỗi khi lưu thông tin: " . $stmt->error;
}

$stmt->close();
$conn->close();
