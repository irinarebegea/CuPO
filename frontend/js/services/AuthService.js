import ApiService from "./ApiService.js";

class AuthService {
    constructor() {
        this.apiService = new ApiService('http://localhost:4000');
    }

    registerUser(data) {
        const jsonData = {};
        for (let [key, value] of data.entries()) {
            jsonData[key] = value;
        }
        return this.apiService.post('/users', jsonData, true);
    }

}

export default AuthService;