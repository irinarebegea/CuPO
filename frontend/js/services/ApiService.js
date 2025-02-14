class ApiService {
    constructor(baseURL) {
        this.baseURL = baseURL;
    }

    async fetch(url, options = {}) {
        const response = await fetch(`${this.baseURL}${url}`, options);
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    }

    get(url) {
        return this.fetch(url);
    }

    post(url, data) {
        return this.fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
    }

    put(url, data) {
        return this.fetch(url, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
    }

    delete(url) {
        return this.fetch(url, {
            method: 'DELETE'
        });
    }
}

export default ApiService;
