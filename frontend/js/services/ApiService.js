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

    post(url, data, includeCredentials = false) {
        const fetchOptions = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        };

        if (includeCredentials) {
            fetchOptions.credentials = 'include';
        }

        return this.fetch(url, fetchOptions);
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
