import CategoriesController from './controllers/CategoriesController.js';

document.addEventListener('DOMContentLoaded', function() {
    const categoriesController = new CategoriesController();
    categoriesController.loadCategories();
});
