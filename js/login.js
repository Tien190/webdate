$(document).ready(function () {
  $('#form-2').on('submit', function (e) {
    e.preventDefault();

    const email = $('#login-email').val();
    const password = $('#login-password').val();

    $.post('backend/api/login.php', {
      email: email,
      password: password
    }, function (data) {
      let res;
      try {
        res = typeof data === "string" ? JSON.parse(data) : data;
      } catch (e) {
        alert("❌ Server trả về dữ liệu lỗi");
        console.error("Lỗi JSON:", data);
        return;
      }

      if (res.success) {
        $('#success-message').show();
        setTimeout(() => {
          window.location.href = "profile.html"; // chuyển sang trang chính nếu cần
        }, 1000);
      } else {
        alert("❌ " + res.message);
      }
    }).fail(function () {
      alert("❌ Không thể kết nối đến server.");
    });
  });
});
