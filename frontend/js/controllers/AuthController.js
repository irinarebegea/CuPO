import AuthService from '../services/AuthService.js';

class AuthController {
    constructor() {
        this.authService = new AuthService();
    }

    init() {
        console.log('reached init');
        this.registerEventListeners();
    }

    registerEventListeners() {
        const form = document.getElementById('register-form');
        console.log('register form:', form);
        console.log('current working directory:', window.location.pathname);
        if (form) {
            form.addEventListener('submit', (e) => {
                console.log('submitting form');
                e.preventDefault();
                this.registerUser(form);
            })
        }
    }

    registerUser(registerForm) {
        const formData = new FormData(registerForm);
        for (let [key, value] of formData.entries()) {
            console.log(key, value);
        }

        this.authService.registerUser(formData).then(response => {
            console.log(response);
            window.location.href = '/views/index.html';
        }).catch(error => {
            console.error('Error registering user:', error);
        });
    }

}

export default AuthController;