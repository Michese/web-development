import { Api } from '@/api/Api';
import { TDetailedPost } from '@/types/TDetailedPost';
import { TCreatePostData } from '@/types/TCreatePostData';
import { TGalleryItem } from '@/types';

class HomeApi extends Api {
  async getColors(): Promise<{ colors: string[] }> {
    return this.get('/api/colors');
  }

  async getPost(post: string): Promise<{ detailedPost: TDetailedPost; success: boolean }> {
    return this.get(`/api/getPost`, { post });
  }

  async getPosts(data: {
    limit: number;
    page: number;
  }): Promise<{ posts: TGalleryItem[]; success: boolean; totalCount: number }> {
    return this.get('/api/getPosts', data);
  }

  async getMyRating(data: { post: string }): Promise<{ myRating: number; success: boolean }> {
    return this.get('/api/getMyRating', data);
  }

  async createPost(data: TCreatePostData): Promise<{ data: { success: boolean } }> {
    return this.post('/api/createPost', data);
  }

  async addRating(data: {
    post: string;
    rating: number;
  }): Promise<{ data: { rating: number; countVoted: number; myRating: number; success: boolean } }> {
    return this.post('/api/addRating', data);
  }
}
export default new HomeApi();
