import axios from 'axios';

const config = {
    headers: { 'Content-Type': 'application/json', "Access-Control-Allow-Origin": "*" },
    timeout: 30000,
};

export class Api {
    get(url, params) {
        return new Promise((resolve, reject) => {
            axios
                .get(url, { ...config, params })
                .then(
                    (response) => resolve(response.data),
                    (err) => {
                        reject(err);
                    }
                )
                .catch((error) => reject(error));
        });
    }

    post(url, data) {
        return new Promise((resolve, reject) => {
            axios
                .post(url, data, config)
                .then(
                    (response) => resolve(response),
                    (err) => {
                        reject(err);
                    }
                )
                .catch((error) => reject(error));
        });
    }

    put(url, data) {
        return new Promise((resolve, reject) => {
            axios
                .put(url, data, config)
                .then(
                    (response) => resolve(response),
                    (err) => {
                        reject(err);
                    }
                )
                .catch((error) => reject(error));
        });
    }

    patch(url, data) {
        return new Promise((resolve, reject) => {
            axios
                .patch(url, data, config)
                .then(
                    (response) => resolve(response),
                    (err) => {
                        reject(err);
                    }
                )
                .catch((error) => reject(error));
        });
    }

    delete(url) {
        return new Promise((resolve, reject) => {
            axios
                .delete(url, config)
                .then(
                    (response) => resolve(response.data),
                    (err) => {
                        reject(err);
                    }
                )
                .catch((error) => reject(error));
        });
    }
}
