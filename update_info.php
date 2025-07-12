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
$gender = $_POST['gender'] ?? '';

if (empty($full_name) || empty($education) || empty($current_residence) || empty($hometown) || empty($job) || $height <= 0) {
    die("❌ Vui lòng điền đầy đủ thông tin.");
}

// Kiểm tra đã có thông tin cá nhân chưa
$stmt = $conn->prepare("SELECT id, avatar FROM personal_information WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$hasInfo = $result->num_rows > 0;
$row = $result->fetch_assoc();
$old_avatar = $row['avatar'] ?? null;
$stmt->close();

// Xử lý avatar
$avatar_file = $_FILES['avatar'] ?? null;
$avatar_filename = $old_avatar;

if ($avatar_file && $avatar_file['error'] === 0) {
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($avatar_file['type'], $allowed_types)) {
        die("❌ Ảnh không đúng định dạng JPG/PNG/GIF.");
    }

    $ext = pathinfo($avatar_file['name'], PATHINFO_EXTENSION);
    $avatar_filename = "avatar_user_" . $user_id . "_" . time() . "." . $ext;
    $upload_dir = __DIR__ . "/uploads/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    move_uploaded_file($avatar_file['tmp_name'], $upload_dir . $avatar_filename);

    if (!empty($old_avatar) && file_exists($upload_dir . $old_avatar)) {
        unlink($upload_dir . $old_avatar);
    }
}

// Nếu chưa có -> INSERT
if (!$hasInfo) {
    $insert = $conn->prepare("INSERT INTO personal_information 
    (full_name, education, height, current_residence, hometown, job, avatar, gender, user_id)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $insert->bind_param("ssisssssi", $full_name, $education, $height, $current_residence, $hometown, $job, $avatar_filename, $gender, $user_id);
    
    if ($insert->execute()) {
        echo "✅ Đã lưu thông tin thành công. <a href='ho_so.php'>Xem hồ sơ</a>";
    } else {
        echo "❌ Lỗi thêm mới: " . $insert->error;
    }
    $insert->close();
} else {
    // Nếu đã có -> UPDATE
    $update = $conn->prepare("UPDATE personal_information SET 
        full_name=?, education=?, height=?, current_residence=?, hometown=?, job=?, avatar=?, gender=? 
        WHERE user_id=?");
    $update->bind_param("ssisssssi", $full_name, $education, $height, $current_residence, $hometown, $job, $avatar_filename, $gender, $user_id);
    
    if ($update->execute()) {
        echo "✅ Đã cập nhật thành công. <a href='ho_so.php'>Xem hồ sơ</a>";
    } else {
        echo "❌ Cập nhật thất bại: " . $update->error;
    }
    $update->close();
}

$conn->close();
?>
