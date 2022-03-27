import { Api } from '@/api/Api';

class UserApi extends Api {
    async getUser() {
        return this.get(`/api/user`);
    }

    async login(data) {
        return this.post(`/api/login`, data);
    }

    async register(data) {
        return this.post(`/api/register`, data);
    }

    async logout() {
        return this.post('/api/logout');
    }
}

export default new UserApi();