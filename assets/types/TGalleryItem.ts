export type TGalleryItem = {
  id: number;
  title: string;
  image: string;
  rating: number | null;
  tag: string;
  created_at: {
    date: string;
    timezone_type: number;
  };
};
