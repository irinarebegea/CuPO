import CategoriesController from './controllers/CategoriesController.js';
import AuthController from './controllers/AuthController.js';

document.addEventListener('DOMContentLoaded', function() {
    const path = window.location.pathname;
    console.log('found path', path);

    if (path.includes('/index.html')) {
        const categoriesController = new CategoriesController();
        categoriesController.loadCategories();
    }

    if (path.includes('/front-page.html')) {
        const authController = new AuthController();
        authController.init();
    }

});


