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

    async uploadFile(data) {
        return this.post(`/api/file`, data, { headers: { 'Content-Type': 'multipart/form-data', 'Content-Disposition': 'form-data' } });
    }

    async changeNew(newId, data) {
        return this.put(`/api/new/${newId}`, data);
    }

    async deleteNew(newId) {
        return this.delete(`/api/new/${newId}`);
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