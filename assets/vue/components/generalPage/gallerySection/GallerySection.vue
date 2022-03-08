<template>
  <section class="gallery-section container" id="gallery-section">
    <div class="gallery-section__search search">
      <input type="text" class="search__input" id="search" placeholder="Поиск" v-model="search" @change="searchApply" />
      <button class="search__button" @click.prevent="searchApply">
        <svg class="search__image" xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 512 512">
          <g>
            <path
              d="M493.25,402.75L393.094,302.562C407.625,274.172,416,242.094,416,208C416,93.125,322.875,0,208,0C93.109,0,0,93.125,0,208
		s93.109,208,208,208c33.953,0,65.906-8.312,94.219-22.719c-0.031,0-0.094,0.031-0.125,0.062c0.156-0.094,0.344-0.156,0.531-0.25
		L402.75,493.25c25.031,25,65.562,25,90.5,0C518.25,468.281,518.25,427.75,493.25,402.75z M48,208c0-88.219,71.781-160,160-160
		c88.219,0,160,71.781,160,160s-71.781,160-160,160S48,296.219,48,208z M459.312,436.656c-6.25,6.25-16.375,6.25-22.625,0
		l-45.25-45.25c-6.25-6.25-6.25-16.375,0-22.625s16.375-6.25,22.625,0l45.25,45.25C465.594,420.281,465.594,430.406,459.312,436.656
		z"
            />
          </g>
        </svg>
      </button>
    </div>

    <div v-if="!!user" class="gallery-section__center">
      <router-link :to="link" class="gallery-section__add-button" @click.prevent>Добавить запись</router-link>
    </div>
    <ul class="gallery-section__list">
      <li v-for="post in posts" class="gallery-section__item" :key="post.id">
        <gallery-card :post="post" />
      </li>
    </ul>

    <div class="gallery-section__center">
      <loader v-if="isLoading" />
      <button v-else-if="isDisplayShowingMore" class="showing-more" @click="showingMore">
        <svg
          class="showing-more__img"
          width="46"
          height="46"
          viewBox="0 0 46 46"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M17.5312 0.343693C17.9948 0.343693 18.4479 0.481152 18.8334 0.738686C19.2188 0.996221 19.5192 1.36226 19.6966 1.79053C19.874 2.21879 19.9204 2.69004 19.83 3.14469C19.7395 3.59933 19.5163 4.01695 19.1885 4.34472C18.8608 4.6725 18.4431 4.89572 17.9885 4.98616C17.5338 5.07659 17.0626 5.03018 16.6343 4.85279C16.2061 4.67539 15.84 4.37499 15.5825 3.98956C15.325 3.60413 15.1875 3.15099 15.1875 2.68744C15.1875 2.06584 15.4344 1.4697 15.874 1.03016C16.3135 0.590623 16.9096 0.343693 17.5312 0.343693ZM1.125 16.7499C1.125 17.2135 1.26246 17.6666 1.51999 18.0521C1.77753 18.4375 2.14357 18.7379 2.57184 18.9153C3.0001 19.0927 3.47135 19.1391 3.92599 19.0487C4.38064 18.9582 4.79825 18.735 5.12603 18.4072C5.45381 18.0794 5.67703 17.6618 5.76747 17.2072C5.8579 16.7525 5.81149 16.2813 5.63409 15.853C5.4567 15.4248 5.1563 15.0587 4.77087 14.8012C4.38544 14.5437 3.9323 14.4062 3.46875 14.4062C2.84715 14.4062 2.25101 14.6531 1.81147 15.0927C1.37193 15.5322 1.125 16.1283 1.125 16.7499ZM6.30078 7.86322C6.30078 8.32677 6.43824 8.77991 6.69577 9.16534C6.95331 9.55077 7.31935 9.85117 7.74762 10.0286C8.17588 10.206 8.64713 10.2524 9.10177 10.1619C9.55642 10.0715 9.97403 9.84829 10.3018 9.52051C10.6296 9.19273 10.8528 8.77511 10.9432 8.32047C11.0337 7.86582 10.9873 7.39457 10.8099 6.96631C10.6325 6.53805 10.3321 6.172 9.94665 5.91447C9.56122 5.65693 9.10808 5.51947 8.64453 5.51947C8.02293 5.51947 7.42679 5.7664 6.98725 6.20594C6.54771 6.64548 6.30078 7.24162 6.30078 7.86322ZM40.8749 8.57348C37.8297 4.63482 33.5988 1.77973 28.8067 0.429728C28.5096 0.345111 28.1987 0.320062 27.8919 0.356021C27.5851 0.39198 27.2884 0.488238 27.0189 0.63926C26.7495 0.790281 26.5125 0.993087 26.3217 1.23601C26.1308 1.47894 25.9899 1.75719 25.907 2.05478C25.8241 2.35236 25.8008 2.66339 25.8385 2.97C25.8762 3.2766 25.9742 3.57273 26.1268 3.84134C26.2793 4.10995 26.4835 4.34576 26.7275 4.53519C26.9715 4.72463 27.2506 4.86395 27.5486 4.94516C31.3665 6.02158 34.737 8.29707 37.1627 11.4357C39.6426 14.6356 40.9822 18.5723 40.9688 22.6206C40.9688 32.7378 32.7294 40.9687 22.6018 40.9687C18.5701 40.9821 14.648 39.6571 11.4505 37.2014C10.1152 36.1783 8.92612 34.9775 7.91621 33.6323L6.59375 33.3383V39.1934C10.9428 43.388 16.7642 45.7084 22.8063 45.6554C28.8483 45.6025 34.6282 43.1804 38.903 38.9102C42.8615 34.9565 45.2449 29.6966 45.6078 24.1137C45.9707 18.5307 44.2882 13.0066 40.8749 8.57367V8.57348ZM5.03125 42.5312V31.3905L16.2416 33.8817C16.8484 34.0165 17.4839 33.9048 18.0084 33.571C18.5328 33.2373 18.9032 32.7089 19.038 32.1021C19.1728 31.4953 19.0611 30.8598 18.7273 30.3353C18.3936 29.8109 17.8652 29.4405 17.2584 29.3057L3.1959 26.1807C2.85328 26.1046 2.49795 26.1064 2.15612 26.1859C1.81429 26.2655 1.49469 26.4208 1.22092 26.6405C0.947154 26.8601 0.726204 27.1384 0.574382 27.4548C0.42256 27.7712 0.343744 28.1177 0.34375 28.4687V42.5312C0.34375 43.1528 0.59068 43.7489 1.03022 44.1885C1.46976 44.628 2.0659 44.8749 2.6875 44.8749C3.3091 44.8749 3.90524 44.628 4.34478 44.1885C4.78432 43.7489 5.03125 43.1528 5.03125 42.5312Z"
            fill="#95973B"
          />
        </svg>

        <span class="showing-more__text crephusa">Показать еще</span>
      </button>
    </div>
  </section>
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component';
import GalleryCard from '@/vue/components/generalPage/gallerySection/galleryCard/GalleryCard.vue';
import Loader from '@/vue/components/loader/Loader.vue';
import { TGalleryItem, TUser } from '@/types';
import HomeApi from '@/api/HomeApi';
import { routerEnum } from '@/enums';
import { InjectReactive, Prop } from 'vue-property-decorator';

const limit = 3;

@Options({
  name: 'GallerySection',
  components: { GalleryCard, Loader },
})
export default class GallerySection extends Vue {
  @InjectReactive('user') readonly user!: TUser | null;
  @Prop({
    type: Boolean,
    required: false,
    default: () => false,
  })
  isProfile!: boolean;

  posts: TGalleryItem[] | null = null;
  isLoading = false;
  page = 1;
  totalCount = 0;
  search = '';

  get link(): string {
    return routerEnum.creatingPage;
  }

  async created(): Promise<void> {
    const { posts, totalCount } = await this.getPosts(this.page);
    this.posts = posts ?? ([] as TGalleryItem[]);
    this.totalCount = totalCount;
  }

  async searchApply(): Promise<void> {
    this.page = 1;
    this.posts = [];
    this.totalCount = 0;
    const { posts, totalCount } = await this.getPosts(this.page);

    if (totalCount && posts) {
      this.totalCount = totalCount;
      this.posts = posts;
    }
  }

  async getPosts(page: number): Promise<{ posts: TGalleryItem[]; totalCount: number }> {
    this.isLoading = true;
    const { posts, totalCount } = await HomeApi.getPosts({
      limit: limit,
      page,
      isProfile: this.isProfile ? 1 : 0,
      search: this.search,
    }).finally(() => {
      this.isLoading = false;
    });

    return { posts, totalCount };
  }

  async showingMore(): Promise<void> {
    if (this.isLoading) return;

    this.isLoading = true;
    let page = this.page + 1;
    try {
      const { posts } = await this.getPosts(page);
      this.posts?.push(...posts);
      this.page = page;
    } catch (error) {
      console.error(error);
    }
    this.isLoading = false;
  }

  get isDisplayShowingMore(): boolean {
    return this.page * limit < this.totalCount;
  }
}
</script>

<style lang="scss" scoped>
@import '/assets/css/media';
.gallery-section {
  min-height: 100vh;
  padding: 15px;

  &__search {
    margin-bottom: 20px;
  }

  &__center {
    display: flex;
    justify-content: center;
  }

  &__add-button {
    padding: 11px 40px;
    margin-bottom: 20px;
    background-color: rgba(157, 161, 87, 0.72);
    box-shadow: 0 0 4px rgba(0, 0, 0, 0.25);
    border-radius: 5px;
    color: var(--color-dark-green);
    cursor: pointer;

    &:hover {
      box-shadow: 0 0 100px #fff;
    }
  }

  &__list {
    display: grid;
    grid-template-columns: 1fr;
    grid-gap: 30px;
    margin-bottom: 39px;
  }

  &__item {
    display: flex;
    flex-direction: column;
  }

  &__center {
    display: flex;
    justify-content: center;
  }
}

.search {
  display: flex;
  &__input {
    flex: 1 1;
    padding: 10px 15px;
    background-color: rgba(157, 161, 87, 0.72);
    color: var(--color-dark-green);
    border: none;
    border-radius: 15px;
    box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.5);
    &:focus {
      outline: 1px solid var(--color-dark-green);
    }

    &::placeholder {
      color: var(--color-green);
    }
  }

  &__button {
    flex: 0 0 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
  }

  &__image {
    fill: rgba(157, 161, 87, 0.72);
    &:hover {
      fill: var(--color-dark-green);
    }
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
    margin-top: -25px;

    &__list {
      grid-template-columns: 1fr 1fr;
    }
  }
}

@include media(lg) {
  .gallery-section {
    padding: 114px 15px 25px;
    margin-top: -100px;

    &__list {
      grid-template-columns: 1fr 1fr 1fr;
      grid-gap: 55px 30px;
    }
  }
}
</style>
