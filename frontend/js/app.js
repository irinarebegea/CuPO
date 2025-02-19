import CategoriesController from './controllers/CategoriesController.js';
import AuthController from './controllers/AuthController.js';

document.addEventListener('DOMContentLoaded', function() {
    const path = window.location.pathname;
    console.log('found path', path);

    if (path.includes('/dashboard.html')) {
        const categoriesController = new CategoriesController();
        categoriesController.loadCategories();
    }

    if (path === '/') {
        const authController = new AuthController();
        authController.init();
    }

});


