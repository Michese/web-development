export type TDetailedPost = {
  id: number;
  user_id: number;
  author: string;
  image: string;
  title: string;
  description: string;
  created_at: number;
  deleted_at: number | null;
  rating: number;
  myRating: number | null;
  countVoted: number;
  name: string;
};
