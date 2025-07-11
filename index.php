<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>LoveConnect - Trang chủ</title>
  <link rel="stylesheet" href="assets/css/style.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;
          0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;
          1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        </head>
<body class="landing-page"></body>
  <section class="header" >
    <nav>
      <a href="index.php" class="logo-box">
  <img src="assets/img/Logo.png" alt="Logo">
  <span class="logo-text">HeartMatch</span>
    </a>

      <div class="nav-link" id="navlink" >
        <i class="fa-solid fa-xmark" onclick ="hidenMenu()"></i>
        <ul>
          <li><a href = "Index.php"> Home </a></li>
          <li><a href = "signin.php"> Kết bạn </a></li>
          <li><a href =  "signup.php"> Đăng kí </a></li>
          <li><a href = "signin.php"> Đăng nhập </a></li>
        </ul> 
      </div>
      <i class="fa-solid fa-bars" onclick ="showMenu()"></i>
    </nav>

  <div class="text-box">
    <h1>Trăm ngàn lời chat
không bằng một lát bên nhau</h1>
    <p>Trang web hẹn hò giúp bạn tìm được nửa kia ưng ý</p><br>
      <a href="sign" class="hero-btn">BẮT ĐẦU</a> 
  </div>

  </section>

<section class="about-section">
  <div class="about-container">
    <div class="about-text">
      <h2>Waodate giúp bạn gặp gỡ những người cùng gu ngoài đời thật</h2>
      <p>
        LoveConnect được tạo ra nhằm kết nối những người cùng gu và đưa họ ra ngoài gặp mặt, hẹn hò với những cảm xúc thật – trải nghiệm thật. <br><br>
        Nhờ phương thức kết đôi cực kỳ độc đáo, LoveConnect đã "mai mối" cho rất nhiều người dùng đến nay. Giúp cho khoảng cách không còn là rào cản của tình yêu.
      </p>
    </div>
    <div class="about-image">
      <img src="assets/img/girl.png" alt="Ảnh minh họa">
    </div>
  </div>

  <div class="about-extra">
    <div class="about-extra-img">
      <img src="assets/img/ketnoi.jpeg" alt="Cặp đôi">
    </div>
    <div class="about-extra-text">
      <p>
        Cách dùng LoveConnect đơn giản: bạn thích đối phương, chỉ cần ấn trái tim → sẽ gửi yêu cầu đến người khác tham gia nếu hợp gu.  
        Cộng đồng LoveConnect hiện đã có hơn 200.000 người đăng ký khắp cả nước trong độ tuổi 18–35.  
        Sứ mệnh của LoveConnect là giúp bạn yêu đúng người nhanh nhất – thật nhất.
      </p>
    </div>
  </div>
</section>



<script>
  var navlink = document.getElementById("navlink");

  function showMenu() {
    navlink.style.right = "0";
  }

  function hidenMenu() {
    navlink.style.right = "-200px";
  }
</script>

<section class="footer">
    <h4 style="font-size: 25px;">About Us</h4>
    <p>Chúng tôi kết nối những trái tim cô đơn lại với nhau.  
<br>Nền tảng hẹn hò hiện đại, an toàn và dễ sử dụng – giúp bạn tìm được người phù hợp nhất. </p>
    <div class="icons">
  <i class="fa-brands fa-facebook"></i>
  <i class="fa-brands fa-twitter"></i>
  <i class="fa-brands fa-instagram"></i>
  <i class="fa-brands fa-linkedin"></i>
</div>
<p>Made with <i class="fa-regular fa-heart"></i> by Nhom 2</p>

</section>
    


</body>
</html>