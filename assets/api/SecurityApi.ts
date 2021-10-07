import { Api } from '@/api/Api';
import { TRegisterData, TUser } from '@/types';
import { TLoginData } from '@/types/TLoginData';

class SecurityApi extends Api {
  async register(data: TRegisterData): Promise<{ user: TUser }> {
    return this.post('/api/register', data);
  }

  async login(data: TLoginData): Promise<{ user: TUser }> {
    return this.post('/api/login', data);
  }

  async logout(): Promise<{ success: boolean; exception?: string }> {
    return this.post('/api/logout');
  }

  async getUser(): Promise<{ success: boolean; exception?: string; user: TUser }> {
    return this.get('/api/getUser');
  }
}
export default new SecurityApi();
