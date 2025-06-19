const form = document.getElementById('form-1');
const nameInput = document.getElementById('full-name');
const emailInput = document.getElementById('form-email');
const passInput = document.getElementById('form-password');
const rePassInput = document.getElementById('password-comfirmation');
const successBox = document.getElementById('success-message');
const submitBtn = document.querySelector('.form-btn__it');

submitBtn.addEventListener('click', function (e) {
    e.preventDefault();

    clearAllErrors();
    let valid = true;

    const name = nameInput.value.trim();
    const email = emailInput.value.trim();
    const pass = passInput.value;
    const rePass = rePassInput.value;

    if (!name) {
        showError(nameInput, 'Vui lòng nhập Họ và Tên');
        valid = false;
    }

    if (!email) {
        showError(emailInput, 'Vui lòng nhập Email');
        valid = false;
    } else if (!validateEmail(email)) {
        showError(emailInput, 'Email không hợp lệ');
        valid = false;
    } else if (getUserByEmail(email)) {
        showError(emailInput, 'Email đã tồn tại');
        valid = false;
    }

    if (!pass) {
        showError(passInput, 'Vui lòng nhập mật khẩu');
        valid = false;
    }

    if (pass !== rePass) {
        showError(rePassInput, 'Mật khẩu nhập lại không khớp');
        valid = false;
    }

    if (valid) {
        saveUser({ name, email, password: pass });
        successBox.style.display = 'block';
        setTimeout(() => {
            window.location.href = 'dang_nhap.html';
        }, 3000);
    }
});

function validateEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

function showError(input, message) {
    const msg = input.parentElement.querySelector('.form-mess');
    msg.innerText = message;
    input.parentElement.classList.add('invalid');
}

function clearAllErrors() {
    document.querySelectorAll('.form-mess').forEach(e => e.innerText = '');
    document.querySelectorAll('.form-group').forEach(e => e.classList.remove('invalid'));
}

function saveUser(user) {
    const users = JSON.parse(localStorage.getItem('users') || '[]');
    users.push(user);
    localStorage.setItem('users', JSON.stringify(users));
}

function getUserByEmail(email) {
    const users = JSON.parse(localStorage.getItem('users') || '[]');
    return users.find(u => u.email === email);
}
