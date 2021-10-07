import { Api } from '@/api/Api';
import { TDetailedPost } from '@/types/TDetailedPost';

class HomeApi extends Api {
  async getColors(): Promise<{ colors: string[] }> {
    return this.get('/api/colors');
  }

  async getPost(postId: number): Promise<{ detailedPost: TDetailedPost; success: boolean }> {
    return this.get(`api/getPost/${postId}`);
  }
}
export default new HomeApi();
