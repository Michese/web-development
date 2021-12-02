import { Api } from '@/api/Api';
import { TDetailedPost } from '@/types/TDetailedPost';
import { TCreatePostData } from '@/types/TCreatePostData';
import { TGalleryItem } from '@/types';
import { TDropdownItem } from '@/vue/components/creatingPage/dropdown/types';
import { TComment } from '@/types/TComment';

class HomeApi extends Api {
  async getPost(post: number): Promise<{ detailedPost: TDetailedPost; success: boolean }> {
    return this.get(`/api/getPost`, { post });
  }

  async getPosts(data: {
    limit: number;
    page: number;
  }): Promise<{ posts: TGalleryItem[]; success: boolean; totalCount: number }> {
    return this.get('/api/getPosts', data);
  }

  async getMyRating(data: { post: number }): Promise<{ myRating: number; success: boolean }> {
    return this.get('/api/getMyRating', data);
  }

  async getComments(post: number): Promise<{ comments: TComment[]; success: boolean }> {
    return this.get('/api/getComments', { post });
  }

  async createComment(data: { text: string; post_id: number }): Promise<{ data: { comments: TComment[]; success: boolean } }> {
    return this.post('/api/createComment', data);
  }

  async createPost(data: TCreatePostData): Promise<{ data: { success: boolean } }> {
    return this.post('/api/createPost', data);
  }

  async addRating(data: {
    post: number;
    rating: number;
  }): Promise<{ data: { rating: number; countVoted: number; myRating: number; success: boolean } }> {
    return this.post('/api/addRating', data);
  }

  async getTags(): Promise<{ tags: TDropdownItem[]; success: boolean }> {
    return this.get('/api/getTags');
  }
}
export default new HomeApi();
