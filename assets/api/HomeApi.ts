import { Api } from '@/api/Api';

class HomeApi extends Api {
  async getColors(): Promise<{ colors: string[] }> {
    return this.get('/api/colors');
  }
}
export default new HomeApi();
