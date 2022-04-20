import { Api } from './Api';

class NewsApi extends Api {
    async getNews() {
        return this.get(`/api/new`);
    }

    async getNew(newId) {
        return this.get(`/api/new/${newId}`);
    }

    async createNew(data) {
        return this.post(`/api/new`, data);
    }

    async createComment(newId, data) {
        return this.post(`/api/new/${newId}/comment`, data);
    }

    async approveComment(newId, commentId) {
        return this.patch(`/api/new/${newId}/comment/${commentId}`);
    }

    async deleteComment(newId, commentId) {
        return this.delete(`/api/new/${newId}/comment/${commentId}`);
    }
}

export default new NewsApi();