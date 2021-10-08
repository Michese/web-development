<template>
  <section class="gallery-section container">
    <ul class="gallery-section__list">
      <li v-for="post in posts" class="gallery-section__item" :key="post.id">
        <gallery-card :item="post" />
      </li>
    </ul>

    <div class="gallery-section__center">
      <button class="showing-more">
        <img src="./assets/showing-more.svg" class="showing-more__img" alt="showing-more" />
        <span class="showing-more__text crephusa">Показать еще</span>
      </button>
    </div>
    <loader />
  </section>
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component';
import GalleryCard from '@/vue/components/generalPage/gallerySection/galleryCard/GalleryCard.vue';
import Loader from '@/vue/components/loader/Loader.vue';
import { TGalleryItem } from '@/types';
import imgItem1 from '@/vue/components/generalPage/gallerySection/assets/img-item-1.jpg';
import imgItem2 from '@/vue/components/generalPage/gallerySection/assets/img-item-2.jpg';
import imgItem3 from '@/vue/components/generalPage/gallerySection/assets/img-item-3.jpg';
import imgItem4 from '@/vue/components/generalPage/gallerySection/assets/img-item-4.jpg';
import imgItem5 from '@/vue/components/generalPage/gallerySection/assets/img-item-5.jpg';
import imgItem6 from '@/vue/components/generalPage/gallerySection/assets/img-item-6.jpg';
import imgItem7 from '@/vue/components/generalPage/gallerySection/assets/img-item-7.jpg';
import imgItem8 from '@/vue/components/generalPage/gallerySection/assets/img-item-8.jpg';
import imgItem9 from '@/vue/components/generalPage/gallerySection/assets/img-item-9.jpg';
import HomeApi from '@/api/HomeApi';

@Options({
  name: 'GallerySection',
  components: { GalleryCard, Loader },
})
export default class GallerySection extends Vue {
  posts: TGalleryItem[] | null = [
    {
      id: 1,
      title: 'Человеку надо мало',
      date: '01.10.2021',
      image: imgItem1,
      rating: 3,
    },
    {
      id: 2,
      title: 'Когда мне говорят о красоте',
      date: '01.10.2021',
      image: imgItem2,
      rating: 4,
    },
    {
      id: 3,
      title: 'А полюбят тебя обязательно',
      date: '30.09.2021',
      image: imgItem3,
      rating: 4,
    },
    {
      id: 4,
      title: 'Я сама себя нашла',
      date: '30.09.2021',
      image: imgItem4,
      rating: 3,
    },
    {
      id: 5,
      title: 'Как я нашёл себя',
      date: '28.09.2021',
      image: imgItem5,
      rating: 3,
    },
    {
      id: 6,
      title: 'Жизнь',
      date: '25.09.2021',
      image: imgItem6,
      rating: 5,
    },
    {
      id: 7,
      title: 'Красивая женщина',
      date: '20.09.2021',
      image: imgItem7,
      rating: 3,
    },
    {
      id: 8,
      title: 'Моя душа настроена на осень',
      date: '15.09.2021',
      image: imgItem8,
      rating: 4,
    },
    {
      id: 9,
      title: 'Я бываю такая разная',
      date: '10.09.2021',
      image: imgItem9,
      rating: 4,
    },
  ];

  page = 1;

  async created(): Promise<void> {
    // const posts = await this.getPosts();
    // if (posts) this.posts = posts;
  }

  async getPosts(): Promise<TGalleryItem[]> {
    const { posts } = await HomeApi.getPosts({ limit: 9, page: this.page });
    return posts;
  }
}
</script>

<style lang="scss" scoped>
@import '/assets/css/media';
.gallery-section {
  min-height: 100vh;
  padding: 15px;

  &__list {
    display: grid;
    grid-template-columns: 1fr;
    grid-gap: 30px;
    margin-bottom: 39px;
  }

  &__item {
    display: flex;
    justify-content: center;
  }

  &__center {
    display: flex;
    justify-content: center;
  }
}

.showing-more {
  display: flex;
  flex-direction: column;
  align-items: center;
  cursor: pointer;

  &:hover &__img {
    animation: rotation 1s linear infinite;
  }

  &__img {
    text-align: center;
    display: block;
    margin-bottom: 5px;
  }
  &__text {
    color: var(--color-green);
  }
}

@include media(sm) {
  .gallery-section {
    padding: 40px 15px 25px;

    &__list {
      grid-template-columns: 1fr 1fr;
    }
  }
}

@include media(lg) {
  .gallery-section {
    padding: 134px 15px 25px;

    &__list {
      grid-template-columns: 1fr 1fr 1fr;
      grid-gap: 55px 30px;
    }
  }
}
</style>
