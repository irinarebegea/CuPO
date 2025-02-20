import IngredientsService from "../services/IngredientsService.js";
import {renderListElements} from "../utils.js";

class IngredientsController {
    constructor(categoryID) {
        this.categoryID = categoryID;
        this.ingredientsService = new IngredientsService();
        this.parentLiElement = document.querySelector(`li[data-id='${categoryID}']`);
        this.ingredientsList = null;
    }

    toggleIngredientsList() {
        if (!this.ingredientsList) {
            this.ingredientsList = document.createElement('ul');
            this.ingredientsList.id = `ingredients-list-${this.categoryID}`;
            this.parentLiElement.appendChild(this.ingredientsList);
            this.loadIngredientsFromCategory();
        } else {
            this.ingredientsList.style.display = this.ingredientsList.style.display === 'none' ? 'block' : 'none';
        }
    }

    loadIngredientsFromCategory() {
        this.ingredientsService.getIngredientsByCategory(this.categoryID).then(ingredients => {
            // Use the renderListElements utility to populate the list
            renderListElements(this.parentLiElement.firstElementChild, ingredients);
        }).catch(error => {
            console.error('Error fetching ingredients:', error);
            this.ingredientsList.innerHTML = '<li>Error loading ingredients.</li>';
        });
    }
}

export default IngredientsController;
