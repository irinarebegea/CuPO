import CategoriesService from '../services/CategoriesService.js';

class CategoriesController {
    constructor() {
        this.categoriesService = new CategoriesService();
        this.categoriesList = document.getElementById('categories-list');
    }

    loadCategories() {
        this.categoriesService.getAllCategories().then(categories => {
            this.renderCategories(categories);
        }).catch(error => {
            console.error('Error fetching categories:', error);
            this.categoriesList.innerHTML = '<li>Error loading categories.</li>';
        });
    }

    renderCategories(categories) {
        this.categoriesList.innerHTML = ''; // Clear existing entries
        categories.forEach(category => {
            const listItem = document.createElement('li');
            listItem.textContent = category.name;
            this.categoriesList.appendChild(listItem);
        });
    }
}

export default CategoriesController;
