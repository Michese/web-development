import axios from 'axios';
import {stateNotification} from "../store/notification";

const { addNotification } = stateNotification;

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
                        addNotification({ caption: err.response?.statusText, text: err.response?.data?.detail });
                        reject(err);
                    }
                )
                .catch((error) => reject(error));
        });
    }

    post(url, data, configure) {
        return new Promise((resolve, reject) => {
            axios
                .post(url, data, {...config, ...configure})
                .then(
                    (response) => resolve(response),
                    (err) => {
                        addNotification({ caption: err.response?.statusText, text: err.response?.data?.detail ?? err.response?.data?.error });
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
                        addNotification({ caption: err.response?.statusText, text: err.response?.data?.detail });
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
                        addNotification({ caption: err.response?.statusText, text: err.response?.data?.detail });
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
                        addNotification({ caption: err.response?.statusText, text: err.response?.data?.detail });
                        reject(err);
                    }
                )
                .catch((error) => reject(error));
        });
    }
}
