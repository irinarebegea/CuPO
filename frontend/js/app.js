import CategoriesController from './controllers/CategoriesController.js';
import IngredientsController from './controllers/IngredientsController.js';

import AuthController from './controllers/AuthController.js';


document.addEventListener('DOMContentLoaded', function () {
    const path = window.location.pathname;
    console.log('found path', path);

    if (path.includes('/dashboard.html')) {
        const categoriesController = new CategoriesController();
        categoriesController.loadCategories();

        const ingredientsControllersMap = {};

        document.getElementById('categories-list').addEventListener('click', (event) => {
            if (event.target.tagName === 'LI' && event.target.dataset.id) {
                const categoryID = event.target.dataset.id;
                if (!ingredientsControllersMap[categoryID]) {
                    ingredientsControllersMap[categoryID] = new IngredientsController(categoryID);
                }
                ingredientsControllersMap[categoryID].toggleIngredientsList();
            }
        });

    }

    if (path === '/') {
        const authController = new AuthController();
        authController.init();
    }

});


