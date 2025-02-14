import ApiService from './ApiService.js';

class CategoriesService {
    constructor() {
        this.apiService = new ApiService('http://localhost:4000');
    }

    getAllCategories() {
        return this.apiService.get('/categories');
    }

    getCategoryById(id) {
        return this.apiService.get(`/categories/${id}`);
    }

    createCategory(data) {
        return this.apiService.post('/categories', data);
    }

    updateCategory(id, data) {
        return this.apiService.put(`/categories/${id}`, data);
    }

    deleteCategory(id) {
        return this.apiService.delete(`/categories/${id}`);
    }
}

export default CategoriesService;
