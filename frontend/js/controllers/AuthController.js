import AuthService from '../services/AuthService.js';

class AuthController {
    constructor() {
        this.authService = new AuthService();
    }

    init() {
        this.addFormEventListeners();
    }

    addFormEventListeners() {
        this.setupFormListener('register-form', (form) => this.handleUserForm(form, 'register'));
        this.setupFormListener('login-form', (form) => this.handleUserForm(form, 'login'));
    }

    setupFormListener(formID, callback) {
        const form = document.getElementById(formID);
        if (form) {
            form.addEventListener('submit', (e) => {
               e.preventDefault();
               callback(form);
            });
        }
    }

    handleUserForm(form, action) {
        const formData = new FormData(form);
        let actionPromise;

        if (action === 'login') {
            actionPromise = this.authService.loginUser(formData);
        } else if (action === 'register') {
            actionPromise = this.authService.registerUser(formData);
        }

        if (actionPromise) {
            actionPromise.then(response => {
                console.log('response:', response);
                // TODO change routing method
                window.location.href = '/views/dashboard.html';
            }).catch(error => {
                console.log('Error:', error);
                this.displayErrors(error.details);
            })
        }
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