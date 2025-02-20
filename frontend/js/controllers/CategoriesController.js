import CategoriesService from '../services/CategoriesService.js';
import { renderListElements } from "../utils.js";

class CategoriesController {
    constructor() {
        this.categoriesService = new CategoriesService();
        this.categoriesList = document.getElementById('categories-list');
    }

    loadCategories() {
        this.categoriesService.getAllCategories().then(categories => {
            renderListElements(this.categoriesList, categories, 'id');
        }).catch(error => {
            console.error('Error fetching categories:', error);
            this.categoriesList.innerHTML = '<li>Error loading categories.</li>';
        });
    }
}

export default CategoriesController;
