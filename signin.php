<?php
session_start();
require_once('includes/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header("Content-Type: application/json");

    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        echo json_encode(["success" => false, "message" => "Vui lòng nhập đầy đủ thông tin."]);
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "Lỗi prepare: " . $conn->error]);
        exit;
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            echo json_encode([
                "success" => true,
                "message" => "Đăng nhập thành công!",
                "role" => $user['role']
            ]);
        } else {
            echo json_encode(["success" => false, "message" => "Sai mật khẩu."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Tài khoản không tồn tại."]);
    }

    $conn->close();
    exit;
}


?>


<!-- Nếu là GET request → hiển thị form đăng nhập -->
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng nhập</title>
  <link rel="stylesheet" href="assets/css/login.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>
<body>
  <div class="header">
    <nav>
      <a href="index.php"><img src="img/Logo.png" alt="Logo"></a>
    </nav>

    <div class="ctn">
      <form id="form-2" class="form" method="POST" action="signin.php">
        <h3 class="title">Đăng nhập</h3>

        <div class="form-group">
         <label for="login-username" class="form-label">Tên đăng nhập</label>
          <input type="text" id="login-username" name="username" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="login-password" class="form-label">Mật khẩu</label>
          <input type="password" id="login-password" name="password" class="form-control" required>
        </div>

        <div class="form-btn">
          <button type="submit" class="form-btn__it">ĐĂNG NHẬP</button>
        </div>
      </form>

      <div class="success-message" id="success-message" style="display: none; color: green; text-align: center;">
        Đăng nhập thành công!
      </div>

      <div class="other">
        <span>Bạn chưa có tài khoản?</span>
        <a href="signup.php" class="other__link">ĐĂNG KÝ</a>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#form-2').on('submit', function (e) {
        e.preventDefault();

        const username = $('#login-username').val();
        const password = $('#login-password').val();

        $.post('signin.php', {
        username: username,
        password: password
       }, function (res) {

          if (res.success) {
            $('#success-message').show();

            setTimeout(() => {
              // ✅ Điều hướng theo quyền
              if (res.role === 'admin') {
                window.location.href = 'admin/admin_dashboard.php';
              } else {
                window.location.href = 'ho_so.html';
              }
            }, 1000);
          } else {
            alert("❌ " + res.message);
          }
        }, 'json').fail(function () {
          alert("❌ Không thể kết nối đến server.");
        });
      });
    });
  </script>
</body>
</html>
