document.addEventListener("DOMContentLoaded", function () {
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');
    const showLoginBtn = document.getElementById('login-button');
    const showRegisterBtn = document.getElementById('register-button');

    showLoginBtn.addEventListener('click', function () {
        loginForm.style.display = 'block';
        registerForm.style.display = 'none';
    });

    showRegisterBtn.addEventListener('click', function () {
        registerForm.style.display = 'block';
        loginForm.style.display = 'none';
    });

    loginForm.style.display = 'block';
    registerForm.style.display = 'none';
});

function togglePassword(type, field) {
    const passwordField = document.getElementById(`${field}-${type}`);
    const eyeIcon = document.querySelector(`[onclick="togglePassword('${type}', '${field}')"]`);

    if (passwordField.type === "password") {
        passwordField.type = "text";
        eyeIcon.textContent = "🙈";
    } else {
        passwordField.type = "password";
        eyeIcon.textContent = "👁️";
    }

}