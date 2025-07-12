<?php
// ✅ Xử lý đăng ký
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  require_once("includes/config.php");

  $username = $_POST['username'] ?? '';
  $email = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';

  if ($username && $email && $password) {
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed);

    if ($stmt->execute()) {
      echo "<script>alert('✅ Đăng ký thành công');</script>";
    } else {
      echo "<script>alert('❌ Đăng ký thất bại: " . $stmt->error . "');</script>";
    }

    $stmt->close();
    $conn->close();
  } else {
    echo "<script>alert('❌ Vui lòng nhập đầy đủ thông tin');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng ký</title>
  <link rel="stylesheet" href="assets/css/login.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
  <section class="header">
    <nav>
  <a href="index.php" class="logo-box" style="display: flex; align-items: center; text-decoration: none;">
<img src="assets/img/Logo.png" alt="Logo" style="height: 100px; width: 190px;">
    <span class="logo-text" style="margin-left: -38px; font-size: 40px; font-weight: bold; color: #e91e63;">HeartMatch</span>
  </a>
</nav>

    <div class="ctn">
      <form action="signup.php" method="post" id="form-2" class="form">
        <h3 class="title">Đăng ký</h3>

        <div class="form-group">
          <label for="register-username" class="form-label">Tên đăng nhập</label>
          <input type="text" id="register-username" name="username" placeholder="Nhập tên đăng nhập" required>
        </div>

        <div class="form-group">
          <label for="register-email" class="form-label">Email</label>
          <input type="email" id="register-email" name="email" placeholder="Nhập email" required>
        </div>

        <div class="form-group">
          <label for="register-password" class="form-label">Mật khẩu</label>
          <input type="password" id="register-password" name="password" placeholder="Nhập mật khẩu" required>
        </div>

        <div class="form-btn">
          <button type="submit" class="form-btn__it">ĐĂNG KÝ</button>
        </div>
      </form>

      <div class="other">
        <span>Đã có tài khoản?</span>
        <a href="signin.php" class="other__link"><span>ĐĂNG NHẬP</span></a>
      </div>
    </div>
  </section>
</body>
</html>
