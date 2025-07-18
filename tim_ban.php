<?php
session_start();
include 'includes/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] === 'admin') {
    // Không cho admin hoặc chưa đăng nhập vào trang này
    header("Location: signin.php");
    exit;
}

$currentUserId = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Tìm bạn</title>
  <link rel="stylesheet" href="Tim_ban.css">
</head>
<body>
  <div class="logo-bar">
  <img src="img/Logo.png" alt="Logo" class="logo-icon">
  <span class="logo-text">HeartMatch</span>
</div>
  <h1 class="title">Danh sách gợi ý</h1>

  <div class="filter">
    <label for="gender">Lọc theo giới tính: </label>
    <select id="genderFilter" onchange="filterGender()">
      <option value="all">Tất cả</option>
      <option value="Nam">Nam</option>
      <option value="Nữ">Nữ</option>
    </select>
  </div>

  <!-- Nút điều hướng -->
  <div class="carousel-wrapper-outer">
    <button class="carousel-btn left" onclick="scrollCarousel(-1)">❮</button>
    <div class="carousel-wrapper" id="friendList">
      <?php 
      $sql = "SELECT * FROM users WHERE id != $currentUserId";
      $result = $conn->query($sql);
      $sql = "SELECT id, username FROM users WHERE id != $currentUserId";
      $result = $conn->query($sql);
      while ($row = $result->fetch_assoc()):
      ?>
        <div class="profile-card" data-id="<?= $row['id'] ?>">
          <div class="profile-info">
            <h2><?= htmlspecialchars($row['username']) ?></h2>
          </div>
          <div class="actions">
            <button class="like" onclick="sendLike(<?= $row['id'] ?>, '<?= htmlspecialchars($row['username']) ?>')">❤️ Thích</button>
            <p class="liked-msg" style="display: none; color: green; margin-top: 5px;"></p>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
    <button class="carousel-btn right" onclick="scrollCarousel(1)">❯</button>
  </div>

  <!-- Chat Box -->
  <div id="chatBox" class="chat-popup">
    <div class="chat-header">
      <span id="chatWith">Đang chat với ...</span>
      <button onclick="closeChatBox()">✖</button>
    </div>
    <div id="chatMessages" class="chat-messages"></div>
    <div class="chat-input">
      <input type="text" id="chatInput" placeholder="Nhập tin nhắn...">
      <button onclick="sendMessage()">Gửi</button>
    </div>
  </div>

  <script>
    let currentReceiverId = null;
    let intervalId = null;

    function filterGender() {
      const gender = document.getElementById('genderFilter').value;
      const cards = document.querySelectorAll('.profile-card');
      cards.forEach(card => {
        const cardGender = card.getAttribute('data-gender');
        card.style.display = (gender === 'all' || gender === cardGender) ? 'block' : 'none';
      });
    }

    function scrollCarousel(direction) {
      const container = document.getElementById('friendList');
      const cardWidth = container.querySelector('.profile-card').offsetWidth + 20;
      container.scrollBy({ left: direction * cardWidth, behavior: 'smooth' });
    }

    function openChatBox(receiverId, username) {
      currentReceiverId = receiverId;
      document.getElementById('chatWith').innerText = "Đang chat với " + username;
      document.getElementById('chatBox').style.display = 'flex';
      loadMessages();
      intervalId = setInterval(loadMessages, 3000);
    }

    function closeChatBox() {
      document.getElementById('chatBox').style.display = 'none';
      document.getElementById('chatMessages').innerHTML = '';
      clearInterval(intervalId);
    }

    function sendMessage() {
      const message = document.getElementById('chatInput').value.trim();
      if (!message || !currentReceiverId) return;

      fetch('send_message.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ receiver_id: currentReceiverId, message: message })
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          loadMessages();
          document.getElementById('chatInput').value = '';
        }
      });
    }

    function loadMessages() {
      fetch('get_messages.php?receiver_id=' + currentReceiverId)
        .then(res => res.json())
        .then(data => {
          const box = document.getElementById('chatMessages');
          box.innerHTML = '';
          data.forEach(msg => {
            const side = msg.sender === 'me' ? 'me' : 'you';
            const name = msg.sender === 'me' ? 'Bạn' : msg.sender_username;
            box.innerHTML += `<div class="${side}"><b>${name}:</b> ${msg.message}</div>`;
          });
          box.scrollTop = box.scrollHeight;
        });
    }

    function showToast(message) {
      const toast = document.getElementById('toast');
      toast.innerText = message;
      toast.classList.add('show');
      setTimeout(() => toast.classList.remove('show'), 2500);
    }

   function sendLike(likedId, likedName) {
  fetch('like_user.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify({ liked_id: likedId })
  })
  .then(res => res.json())
  .then(data => {
    const card = document.querySelector(`.profile-card[data-id='${likedId}']`);
    const msg = card.querySelector('.liked-msg');

    if (data.success) {
      if (data.matches) {
        msg.innerText = `🎉 Bạn và ${likedName} đã match với nhau!`;
      } else {
        msg.innerText = `❤️ Bạn đã thích ${likedName}`;
      }
      msg.style.display = 'block';
    } else {
      msg.innerText = `❌ ${data.message}`;
      msg.style.display = 'block';
      msg.style.color = 'red';
    }
  })
  .catch(err => {
    console.error(err);
    alert("Lỗi kết nối server.");
  });
}



  </script>
</body>
</html>
