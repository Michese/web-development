import { Api } from '@/api/Api';

class NewsApi extends Api {
    async getNews() {
        return this.get(`/api/getNews`);
    }

    async getNew(newId) {
        return this.get(`/api/getNew/${newId}`);
    }

    async createNew(data) {
        return this.post(`/api/createNew`, data);
    }

    async createComment(data) {
        return this.post(`/api/createComment`, data);
    }

    async approveComment(commentId) {
        return this.put(`/api/approveComment/${commentId}`);
    }

    async deleteComment(commentId) {
        return this.delete(`/api/deleteComment/${commentId}`);
    }
}

export default new NewsApi();