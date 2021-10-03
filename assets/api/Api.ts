import axios from 'axios';

const config = {
  headers: { 'Content-Type': 'application/json' },
  timeout: 30000,
};

export class Api {
  get(url: string, params?: unknown): Promise<any> {
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

  post(url: string, data?: any): Promise<any> {
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

  put(url: string, data?: any): Promise<any> {
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

  delete(url: string): Promise<any> {
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
