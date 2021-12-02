export type TComment = {
  id: number;
  user: {
    id: number;
    name: string;
  };
  text: string;
  created_at: {
    date: string;
  };
};
