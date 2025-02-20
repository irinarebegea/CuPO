import ApiService from "./ApiService.js";

class IngredientsService {
    constructor() {
        this.apiService = new ApiService('http://localhost:4000');
    }

    getIngredientsByCategory(categoryID) {
        return this.apiService.get(`/categories/${categoryID}/ingredients`);
    }
}

export default IngredientsService;
