import AuthService from '../services/AuthService.js';

class AuthController {
    constructor() {
        this.authService = new AuthService();
    }

    init() {
        this.registerEventListeners();
    }

    registerEventListeners() {
        const form = document.getElementById('register-form');
        if (form) {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                this.registerUser(form);
            })
        }
    }

    registerUser(registerForm) {
        const formData = new FormData(registerForm);

        this.authService.registerUser(formData).then(response => {
            console.log('response:', response);
            window.location.href = '/views/index.html';
        }).catch(error => {
            this.displayErrors(error.details);
        });
    }

    displayErrors(messages) {
        // TODO: do something about the error display
        const errorsContainer = document.querySelector('.errors-container');
        errorsContainer.innerHTML = '';
        Object.entries(messages).forEach(([field, message]) => {
            console.log('message:', message);
            const errorElement = document.createElement('p');
            errorElement.textContent = message;
            errorsContainer.appendChild(errorElement);
        });
    }

}

export default AuthController;