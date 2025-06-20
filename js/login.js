document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('form-2');
    const emailField = document.getElementById('login-email');
    const passwordField = document.getElementById('login-password');
    const successBox = document.getElementById('success-message'); // Thông báo thành công

    form.addEventListener('submit', function(event) {
        let valid = true;

        clearError(emailField);
        clearError(passwordField);

        // Kiểm tra email hợp lệ
        if (!validateEmail(emailField.value)) {
            valid = false;
            showError(emailField, 'Email không hợp lệ');
        }

        // Kiểm tra mật khẩu không rỗng
        if (passwordField.value.trim() === '') {
            valid = false;
            showError(passwordField, 'Mật khẩu không được để trống');
        }

        // Nếu có lỗi, ngăn submit
        if (!valid) {
            event.preventDefault();
        } else {
            event.preventDefault(); // Chặn submit mặc định

            // ✅ Hiển thị thông báo thành công
            if (successBox) {
                successBox.style.display = 'block';
            }

            // ✅ Chuyển hướng sau 3 giây
            setTimeout(function() {
                window.location.href = 'Index.html'; // hoặc đường dẫn bạn muốn
            }, 3000);
        }
    });

    // Hàm kiểm tra định dạng email
    function validateEmail(email) {
        const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return regex.test(email);
    }

    // Hiển thị lỗi dưới input
    function showError(input, message) {
        const errorElement = document.createElement('div');
        errorElement.classList.add('error-message');
        errorElement.innerText = message;
        input.parentElement.appendChild(errorElement);
        input.parentElement.classList.add('invalid');
    }

    // Xóa tất cả lỗi cũ
    function clearError(input) {
        const errorElements = input.parentElement.querySelectorAll('.error-message');
        errorElements.forEach(function(element) {
            element.remove();
        });
        input.parentElement.classList.remove('invalid');
    }
});
