<!-- C:\xampp\htdocs\webdate\sign_up.php -->
<!DOCTYPE html>
<html>
<head>
  <title>Đăng ký</title>
</head>
<body>
  <h2>Form Đăng Ký</h2>
  <form method="POST" action="sign_up.php">
    <input type="text" name="username" placeholder="Tên đăng nhập" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Mật khẩu" required><br>
    <button type="submit">Đăng ký</button>
  </form>

  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "webdata");

    if ($conn->connect_error) {
      die("Lỗi kết nối DB: " . $conn->connect_error);
    }

    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Bảo mật

    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
      echo "✅ Đăng ký thành công!";
    } else {
      echo "❌ Lỗi: " . $conn->error;
    }

    $conn->close();
  }
  ?>
</body>
</html>
