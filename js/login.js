document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('form-2');
    const emailField = document.getElementById('login-email');
    const passwordField = document.getElementById('login-password');
    const successBox = document.getElementById('success-message'); 

    form.addEventListener('submit', function(event) {
        let valid = true;

        clearError(emailField);
        clearError(passwordField);

        
        if (!validateEmail(emailField.value)) {
            valid = false;
            showError(emailField, 'Email không hợp lệ');
        }

        if (passwordField.value.trim() === '') {
            valid = false;
            showError(passwordField, 'Mật khẩu không được để trống');
        }

        
        if (!valid) {
            event.preventDefault();
        } else {
            event.preventDefault(); 

            
            if (successBox) {
                successBox.style.display = 'block';
            }

           
            setTimeout(function() {
                window.location.href = 'Index.html';
            }, 3000);
        }
    });

   
    function validateEmail(email) {
        const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return regex.test(email);
    }

    
    function showError(input, message) {
        const errorElement = document.createElement('div');
        errorElement.classList.add('error-message');
        errorElement.innerText = message;
        input.parentElement.appendChild(errorElement);
        input.parentElement.classList.add('invalid');
    }

    
    function clearError(input) {
        const errorElements = input.parentElement.querySelectorAll('.error-message');
        errorElements.forEach(function(element) {
            element.remove();
        });
        input.parentElement.classList.remove('invalid');
    }
});
