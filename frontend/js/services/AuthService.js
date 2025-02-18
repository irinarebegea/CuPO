import ApiService from "./ApiService.js";

class AuthService {
    constructor() {
        this.apiService = new ApiService('http://localhost:4000');
    }

    convertToJson(data) {
        const jsonData = {};
        for (let [key, value] of data.entries()) {
            jsonData[key] = value;
        }

        return jsonData;
    }

    registerUser(data) {
        let jsonData = this.convertToJson(data);
        return this.apiService.post('/users/register', jsonData, true);
    }

    loginUser(data) {
        let jsonData = this.convertToJson(data);
        return this.apiService.post('/users/login', jsonData, true);

    }

}

export default AuthService;