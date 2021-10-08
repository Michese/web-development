export type TGalleryItem = {
  id: number;
  title: string;
  image: string;
  rating: number;
  created_at: {
    date: string;
    timezone: number;
  };
};
