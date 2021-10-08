import { Api } from '@/api/Api';
import { TDetailedPost } from '@/types/TDetailedPost';
import { TCreatePostData } from '@/types/TCreatePostData';
import { TGalleryItem } from '@/types';

class HomeApi extends Api {
  async getColors(): Promise<{ colors: string[] }> {
    return this.get('/api/colors');
  }

  async getPost(postId: number): Promise<{ detailedPost: TDetailedPost; success: boolean }> {
    return this.get(`api/getPost/${postId}`);
  }

  async getPosts(data: {
    limit: number;
    page: number;
  }): Promise<{ posts: TGalleryItem[]; success: boolean }> {
    return this.get('api/getPosts', data);
  }

  async createPost(data: TCreatePostData): Promise<{ data: { success: boolean } }> {
    return this.post('api/createPost', data);
  }
}
export default new HomeApi();
