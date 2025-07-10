<?php
session_start();

// Bật hiển thị lỗi khi debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Kiểm tra quyền admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../signin.php");
    exit;
}

require_once('../includes/config.php');

// Helper an toàn
function getCount($conn, $sql) {
    $result = $conn->query($sql);
    if ($result && $row = $result->fetch_assoc()) {
        return $row['count'] ?? 0;
    }
    return 0;
}

// Tổng người dùng
$total = getCount($conn, "SELECT COUNT(*) AS count FROM users");

// Người dùng thường
$userCount = getCount($conn, "SELECT COUNT(*) AS count FROM users WHERE role = 'user'");

// Quản trị viên
$adminCount = getCount($conn, "SELECT COUNT(*) AS count FROM users WHERE role = 'admin'");

// Đăng ký hôm nay
$today = date('Y-m-d');
$todayCount = getCount($conn, "SELECT COUNT(*) AS count FROM users WHERE DATE(created_at) = '$today'");

// Đăng ký trong tháng
$thisMonth = date('Y-m');
$monthCount = getCount($conn, "SELECT COUNT(*) AS count FROM users WHERE DATE_FORMAT(created_at, '%Y-%m') = '$thisMonth'");

// Tài khoản bị khoá
$lockedCount = getCount($conn, "SELECT COUNT(*) AS count FROM users WHERE is_locked = 1");

// Tài khoản bị báo cáo
$reportedCount = getCount($conn, "SELECT COUNT(*) AS count FROM reports");

// Lượt like hôm nay
$likeToday = getCount($conn, "SELECT COUNT(*) AS count FROM likes WHERE DATE(created_at) = '$today'");

// Số lượt match thành công
$matchCount = getCount($conn, "SELECT COUNT(*) AS count FROM matches");

// Top người được like nhiều nhất
$topLiked = $conn->query("
    SELECT u.username, COUNT(l.id) AS likes
    FROM likes l
    JOIN users u ON l.receiver_id = u.id
    GROUP BY l.receiver_id
    ORDER BY likes DESC
    LIMIT 5
");

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f2f4f7;
      padding: 30px;
      color: #333;
    }

    h1 {
      text-align: center;
      margin-bottom: 30px;
      color: #2c3e50;
    }

    .logout-btn {
      float: right;
      background-color: #e74c3c;
      color: white;
      padding: 8px 12px;
      border: none;
      border-radius: 5px;
      text-decoration: none;
      font-size: 14px;
    }

    table {
      width: 100%;
      max-width: 700px;
      margin: 0 auto 30px;
      border-collapse: collapse;
      background-color: white;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      border-radius: 8px;
      overflow: hidden;
    }

    th {
      background-color: #3498db;
      color: white;
      padding: 15px;
      font-size: 16px;
    }

    td {
      padding: 14px 20px;
      border-bottom: 1px solid #ddd;
      text-align: left;
    }

    tr:last-child td {
      border-bottom: none;
    }

    .stat-label {
      font-weight: bold;
    }

    .stat-value {
      color: #2c3e50;
    }

    .header-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 20px;
      align-items: center;
    }

    .top-liked {
      width: 100%;
      max-width: 500px;
      margin: 0 auto;
    }

    .top-liked th {
      background: #e67e22;
    }
  </style>
</head>
<body>

  <div class="header-row">
    <h1>🎯 Bảng Thống Kê Quản Trị</h1>
    <a href="../logout.php" class="logout-btn">Đăng xuất</a>
  </div>

  <table>
    <tr><th colspan="2">📊 Thống kê hệ thống</th></tr>
    <tr><td class="stat-label">👥 Tổng người dùng</td><td class="stat-value"><?= $total ?></td></tr>
    <tr><td class="stat-label">🧑 Người dùng thường</td><td class="stat-value"><?= $userCount ?></td></tr>
    <tr><td class="stat-label">🛡️ Quản trị viên</td><td class="stat-value"><?= $adminCount ?></td></tr>
    <tr><td class="stat-label">🕓 Đăng ký hôm nay</td><td class="stat-value"><?= $todayCount ?></td></tr>
    <tr><td class="stat-label">📆 Đăng ký tháng này</td><td class="stat-value"><?= $monthCount ?></td></tr>
    <tr><td class="stat-label">❤️ Số cặp đã match</td><td class="stat-value"><?= $matchCount ?></td></tr>
    <tr><td class="stat-label">🔒 Tài khoản bị khoá</td><td class="stat-value"><?= $lockedCount ?></td></tr>
    <tr><td class="stat-label">🚩 Tài khoản bị báo cáo</td><td class="stat-value"><?= $reportedCount ?></td></tr>
    <tr><td class="stat-label">💘 Lượt like hôm nay</td><td class="stat-value"><?= $likeToday ?></td></tr>
  </table>

  <br>
  <table class="top-liked">
    <tr><th colspan="2">🏆 Top 5 người được like nhiều nhất</th></tr>
    <tr><th>Tên người dùng</th><th>Lượt thích</th></tr>
    <?php if ($topLiked && $topLiked->num_rows > 0): ?>
      <?php while ($row = $topLiked->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['username']) ?></td>
          <td><?= $row['likes'] ?></td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="2">Không có dữ liệu.</td></tr>
    <?php endif; ?>
  </table>

</body>
</html>
