export type TGalleryItem = {
  id: number;
  title: string;
  image: string;
  rating: number | null;
  created_at: {
    date: string;
  };
};
