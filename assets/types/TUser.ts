export type TUser = {
  id: number;
  name: string;
  email: string;
  phone: number;
  role: string;
  last_login_date: {
    date: string;
    timezone: string;
    timezone_type: number;
  };
};
