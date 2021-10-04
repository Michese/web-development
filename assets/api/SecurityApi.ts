import { Api } from '@/api/Api';

class SecurityApi extends Api {
  async register(data: any): Promise<any> {
    return this.post('/api/register', data);
  }
}
export default new SecurityApi();
