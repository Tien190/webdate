<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profile - <?php
                    if (isset($user['full_name']) && $user['full_name']) {
                      echo htmlspecialchars($user['full_name']);
                    } else {
                      echo 'Người dùng';
                    }
                    ?></title>
  <link rel="stylesheet" href="assets/css/hoso.css">

</head>

<body>
  <nav class="header-nav">
  <a href="index.php" class="logo-box" style="display: flex; align-items: center; text-decoration: none;">
    <img src="assets/img/Logo.png" alt="Logo" style="height: 100px; width: 190px;">
    <span class="logo-text" style="margin-left: -38px; font-size: 40px; font-weight: bold; color: #e91e63;">HeartMatch</span>
  </a>

  <a href="logout.php" class="logout-btn">Đăng xuất</a>
</nav>


  <?php if ($user): ?>
    <div class="profile-card">
      <div class="profile-header">
        <div class="avatar">
          <?php if (!empty($user['avatar'])): ?>
            <img src="uploads/<?= htmlspecialchars($user['avatar']) ?>" style="width:100%;height:100%;border-radius:50%;object-fit:cover;">
          <?php else: ?>
            <?= strtoupper($user['full_name'][0] ?? 'U') ?>
          <?php endif; ?>
        </div>
        <h1 class="name"><?= htmlspecialchars($user['full_name']) ?></h1>
        <div class="status">💙 Đang trong mối quan hệ</div>
      </div>

      <div class="profile-info" id="profileDisplay">
        <div class="info-item">
          <div class="icon">🎓</div>
          <div class="info-content">
            <div class="label">Học vấn</div>
            <div class="value"><?= htmlspecialchars($user['education']) ?></div>
          </div>
        </div>
        <div class="info-item">
          <div class="icon">📏</div>
          <div class="info-content">
            <div class="label">Chiều cao</div>
            <div class="value"><?= htmlspecialchars($user['height']) ?> cm</div>
          </div>
        </div>
        <div class="info-item">
          <div class="icon">📍</div>
          <div class="info-content">
            <div class="label">Nơi ở hiện tại</div>
            <div class="value"><?= htmlspecialchars($user['current_residence']) ?></div>
          </div>
        </div>
        <div class="info-item">
          <div class="icon">🏠</div>
          <div class="info-content">
            <div class="label">Quê quán</div>
            <div class="value"><?= htmlspecialchars($user['hometown']) ?></div>
          </div>
        </div>
        <div class="info-item">
          <div class="icon">💼</div>
          <div class="info-content">
            <div class="label">Nghề nghiệp</div>
            <div class="value"><?= htmlspecialchars($user['job']) ?></div>
          </div>
        </div>
        <div class="info-item">
<button id="editBtn" type="button">✏️ Sửa thông tin</button>
        </div>
      </div>
    </div>

  <?php else: ?>
    <div class="profile-card">
      <div class="profile-header">
        <div class="avatar">
          <?php if (!empty($user['avatar'])): ?>
            <img src="uploads/<?= htmlspecialchars($user['avatar']) ?>" style="width:100%;height:100%;border-radius:50%;object-fit:cover;">
          <?php else: ?>
            <?= strtoupper($user['full_name'][0] ?? 'U') ?>
          <?php endif; ?>
        </div>
        <h1 class="name">Chưa có hồ sơ</h1>
        <div class="status">📄 Vui lòng điền thông tin bên dưới</div>
      </div>

      <form class="profile-info" action="save_info.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
        <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
        <div class="info-item"><input type="text" name="full_name" placeholder="Họ tên đầy đủ" required></div>
        <div class="info-item"><input type="text" name="education" placeholder="Học vấn" required></div>
        <div class="info-item"><input type="number" name="height" placeholder="Chiều cao (cm)" required></div>
        <div class="info-item"><input type="text" name="current_residence" placeholder="Nơi ở hiện tại" required></div>
        <div class="info-item"><input type="text" name="hometown" placeholder="Quê quán" required></div>
        <div class="info-item"><input type="text" name="job" placeholder="Nghề nghiệp" required></div>
        <div class="info-item">
          <label for="avatar" class="upload-label">
            📷 Chọn ảnh đại diện
            <input type="file" name="avatar" id="avatar" accept="image/*" required>
          </label>
        </div>
        <div class="info-item">
          <button type="submit" style="width:100%;padding:10px;background:#4facfe;color:#fff;border:none;border-radius:10px;">Lưu thông tin</button>
        </div>
      </form>
    </div>
  <?php endif; ?>
  <form id="editForm" class="profile-info" action="update_info.php" method="post" enctype="multipart/form-data" style="display:none;">
    <div class="info-item">
      <input type="text" name="full_name" value="<?= htmlspecialchars($user['full_name']) ?>" required placeholder="Họ tên đầy đủ">
    </div>
    <div class="info-item">
      <input type="text" name="education" value="<?= htmlspecialchars($user['education']) ?>" required placeholder="Học vấn">
    </div>
    <div class="info-item">
      <input type="number" name="height" value="<?= htmlspecialchars($user['height']) ?>" required placeholder="Chiều cao">
    </div>
    <div class="info-item">
      <input type="text" name="current_residence" value="<?= htmlspecialchars($user['current_residence']) ?>" required placeholder="Nơi ở hiện tại">
    </div>
    <div class="info-item">
<input type="text" name="hometown" value="<?= htmlspecialchars($user['hometown']) ?>" required placeholder="Quê quán">
    </div>
    <div class="info-item">
      <input type="text" name="job" value="<?= htmlspecialchars($user['job']) ?>" required placeholder="Nghề nghiệp">
    </div>
    <div class="info-item">
      <label class="upload-label">
        📷 Cập nhật ảnh đại diện (tùy chọn)
        <input type="file" name="avatar" accept="image/*">
      </label>
    </div>
    <div class="info-item">
      <button type="submit">💾 Lưu thay đổi</button>
    </div>
  </form>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const input = document.getElementById('avatar');
      const fileNameDisplay = document.getElementById('file-name');

      if (input && fileNameDisplay) {
        input.addEventListener('change', function() {
          fileNameDisplay.textContent = input.files[0]?.name || '';
        });
      }
      const editBtn = document.getElementById('editBtn');
      const cancelBtn = document.getElementById('cancelBtn');
      const profileDisplay = document.getElementById('profileDisplay');
      const editForm = document.getElementById('editForm');
      console.log("editForm:", editForm);

      editBtn.addEventListener('click', function() {
        profileDisplay.style.display = 'none';
        editForm.style.display = 'block';
      });

      cancelBtn.addEventListener('click', function() {
        editForm.style.display = 'none';
        profileDisplay.style.display = 'block';
      });
    });
  </script>



</body>

</html>