<template>
  <section class="gallery-section container">
    <ul class="gallery-section__list">
      <li v-for="item in items" class="gallery-section__item" :key="item.id">
        <gallery-card :item="item" />
      </li>
    </ul>

    <div class="gallery-section__center">
      <button class="showing-more">
        <img src="./assets/showing-more.svg" class="showing-more__img" alt="showing-more" />
        <span class="showing-more__text crephusa">Показать еще</span>
      </button>
    </div>
  </section>
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component';
import GalleryCard from '@/vue/components/generalPage/gallerySection/galleryCard/GalleryCard.vue';
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

@Options({
  name: 'GallerySection',
  components: { GalleryCard },
})
export default class GallerySection extends Vue {
  get items(): TGalleryItem[] {
    return [
      {
        id: 1,
        title: 'Человеку надо мало',
        date: '01.10.2021',
        img: imgItem1,
        link: '#',
        rating: 3,
      },
      {
        id: 2,
        title: 'Когда мне говорят о красоте',
        date: '01.10.2021',
        img: imgItem2,
        link: '#',
        rating: 4,
      },
      {
        id: 3,
        title: 'А полюбят тебя обязательно',
        date: '30.09.2021',
        img: imgItem3,
        link: '#',
        rating: 4,
      },
      {
        id: 4,
        title: 'Я сама себя нашла',
        date: '30.09.2021',
        img: imgItem4,
        link: '#',
        rating: 3,
      },
      {
        id: 5,
        title: 'Как я нашёл себя',
        date: '28.09.2021',
        img: imgItem5,
        link: '#',
        rating: 3,
      },
      {
        id: 6,
        title: 'Жизнь',
        date: '25.09.2021',
        img: imgItem6,
        link: '#',
        rating: 5,
      },
      {
        id: 7,
        title: 'Красивая женщина',
        date: '20.09.2021',
        img: imgItem7,
        link: '#',
        rating: 3,
      },
      {
        id: 8,
        title: 'Моя душа настроена на осень',
        date: '15.09.2021',
        img: imgItem8,
        link: '#',
        rating: 4,
      },
      {
        id: 9,
        title: 'Я бываю такая разная',
        date: '10.09.2021',
        img: imgItem9,
        link: '#',
        rating: 4,
      },
    ];
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
    margin-bottom: 39px;
  }

  &__item {
    display: flex;
    justify-content: center;
    margin-bottom: 30px;
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
      margin-bottom: 39px;
    }

    &__item:nth-child(2n) {
      margin: 0 0 30px 5px;
    }

    &__item:not(:nth-child(2n)) {
      margin: 0 5px 30px 0;
    }
  }
}

@include media(lg) {
  .gallery-section {
    padding: 134px 15px 25px;

    &__list {
      grid-template-columns: 1fr 1fr 1fr;
    }

    &__item:nth-child(3n - 2) {
      margin: 0 55px 30px 0;
    }

    &__item:nth-child(3n - 1) {
      margin: 0 27.5px 30px 27.5px;
    }

    &__item:nth-child(3n) {
      margin: 0 0 30px 55px;
    }

    &__item:not(:nth-child(3n)) {
      margin: 0 0 30px 5px;
    }
  }
}
</style>
