<template>
  <section class="detailed-page">
    <loader v-if="isLoading" class="detailed-page__loader container" />
    <div v-else class="detailed-page__container container">
      <heart class="detailed-page__heart" :rating="rating" :size="24" />
      <header>
        <h2 class="detailed-page__section-caption section-caption">{{ detailedPost.title }}</h2>
      </header>
      <div class="detailed-page__inner">
        <img :src="image" alt="big-img" class="detailed-page__img" />
        <p v-if="!!description" class="detailed-page__description italico" v-html="description" />
      </div>
      <footer class="detailed-page__footer">
        <div class="detailed-page__rating">
          <span class="detailed-page__stars">
            <svg
              v-for="index in 5"
              :key="index"
              class="detailed-page__star"
              :class="{
                'detailed-page__star_my-rating': index === 6 - detailedPost.myRating,
                'detailed-page__star_change-rating': isChangingRating,
              }"
              width="48"
              height="48"
              viewBox="0 0 48 48"
              xmlns="http://www.w3.org/2000/svg"
              @click="addRating(6 - index)"
            >
              <mask id="mask0" style="mask-type: alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="48" height="48">
                <g clip-path="url(#clip0)">
                  <path
                    d="M26.2849 2.48588L31.6919 13.4419C32.0679 14.2039 32.7949 14.7319 33.6359 14.8539L45.7269 16.6109C47.8449 16.9189 48.6899 19.5209 47.1579 21.0139L38.4089 29.5419C37.8009 30.1349 37.5229 30.9899 37.6669 31.8269L39.7319 43.8689C40.0939 45.9779 37.8799 47.5859 35.9859 46.5909L25.1719 40.9059C24.4199 40.5109 23.5209 40.5109 22.7689 40.9059L11.9549 46.5909C10.0609 47.5869 7.84688 45.9779 8.20888 43.8689L10.2739 31.8269C10.4179 30.9899 10.1399 30.1349 9.53188 29.5419L0.782879 21.0139C-0.749121 19.5199 0.0958788 16.9179 2.21388 16.6109L14.3049 14.8539C15.1459 14.7319 15.8729 14.2039 16.2489 13.4419L21.6559 2.48588C22.6019 0.566881 25.3379 0.566881 26.2849 2.48588Z"
                  />
                </g>
              </mask>
              <g mask="url(#mask0)"></g>
              <g clip-path="url(#clip1)">
                <path
                  d="M26.2849 2.48588L31.6919 13.4419C32.0679 14.2039 32.7949 14.7319 33.6359 14.8539L45.7269 16.6109C47.8449 16.9189 48.6899 19.5209 47.1579 21.0139L38.4089 29.5419C37.8009 30.1349 37.5229 30.9899 37.6669 31.8269L39.7319 43.8689C40.0939 45.9779 37.8799 47.5859 35.9859 46.5909L25.1719 40.9059C24.4199 40.5109 23.5209 40.5109 22.7689 40.9059L11.9549 46.5909C10.0609 47.5869 7.84688 45.9779 8.20888 43.8689L10.2739 31.8269C10.4179 30.9899 10.1399 30.1349 9.53188 29.5419L0.782879 21.0139C-0.749121 19.5199 0.0958788 16.9179 2.21388 16.6109L14.3049 14.8539C15.1459 14.7319 15.8729 14.2039 16.2489 13.4419L21.6559 2.48588C22.6019 0.566881 25.3379 0.566881 26.2849 2.48588Z"
                />
              </g>
              <defs>
                <clipPath id="clip0">
                  <rect width="47.94" height="47.94" />
                </clipPath>
                <clipPath id="clip1">
                  <rect width="47.94" height="47.94" />
                </clipPath>
              </defs>
            </svg>
          </span>

          <div class="detailed-page__followers maria">{{ detailedPost.countVoted }}</div>
        </div>
        <span v-if="!!detailedPost.author" class="detailed-page__author italico">{{ detailedPost.author }}</span>
      </footer>
    </div>
  </section>
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component';
import { InjectReactive, Prop, Watch } from 'vue-property-decorator';
import Heart from '@/vue/components/heart/Heart.vue';
import Loader from '@/vue/components/loader/Loader.vue';
import { TDetailedPost } from '@/types/TDetailedPost';
import HomeApi from '@/api/HomeApi';
import { TUser } from '@/types';
import { addBse64Naming } from '@/helpers';

@Options({
  name: 'DetailedPage',
  components: { Heart, Loader },
})
export default class DetailedPage extends Vue {
  @Prop({
    type: String,
    required: true,
  })
  post!: string;
  @InjectReactive('user') user!: TUser | null;

  @Watch('user') async wUser(): Promise<void> {
    if (this.user === null && !!this.detailedPost && !!this.detailedPost.myRating) {
      this.detailedPost.myRating = null;
    } else if (!!this.user && !!this.detailedPost) {
      this.isLoading = true;

      try {
        const { myRating } = await HomeApi.getMyRating({ post: this.post });
        if (myRating) this.detailedPost.myRating = myRating;
      } catch (error) {
        console.error(error);
      } finally {
        this.isLoading = false;
      }
    }
  }

  detailedPost: TDetailedPost | null = null;
  isLoading = false;

  get image(): string {
    return this.detailedPost ? addBse64Naming(this.detailedPost?.image) : '';
  }

  get rating(): number {
    return this.detailedPost?.rating ? Math.round(this.detailedPost.rating) : 0;
  }

  get isChangingRating(): boolean {
    return !!this.user && !!this.detailedPost && this.detailedPost?.myRating === null;
  }
  //
  get description(): string {
    return this.detailedPost ? this.detailedPost.description.replaceAll('\n', '<br />') : '';
  }

  async addRating(newRating: number): Promise<void> {
    if (!!this.user && !!this.detailedPost && this.detailedPost.myRating === null) {
      this.isLoading = true;

      try {
        const {
          data: { rating, myRating, countVoted },
        } = await HomeApi.addRating({ post: this.post, rating: newRating });
        this.detailedPost.rating = rating;
        this.detailedPost.myRating = myRating;
        this.detailedPost.countVoted = countVoted;
      } catch (error) {
        console.error(error);
      }

      this.isLoading = false;
    }
  }

  async created(): Promise<void> {
    this.isLoading = true;

    try {
      const { detailedPost } = await HomeApi.getPost(this.post);
      if (detailedPost) this.detailedPost = detailedPost;
    } catch (error) {
      console.error(error);
    } finally {
      this.isLoading = false;
    }
  }
}
</script>

<style lang="scss" scoped>
@import '/assets/css/media';
.detailed-page {
  display: flex;
  align-items: center;
  min-height: 100vh;
  padding: 150px 15px 60px;
  background-image: url('/assets/assets/promo-background.jpg');
  background-size: cover;

  &__loader {
    background-color: var(--color-promo-bg);
    padding: 15px;
    border-radius: 5px;
  }

  &__container {
    position: relative;
    width: 100%;
    padding: 15px;
    background-color: var(--color-promo-bg);
    border-radius: 5px;
  }

  &__heart {
    position: absolute;
    top: -45px;
    left: -10px;
  }

  &__section-caption {
    display: block;
    margin-bottom: 49px;
    text-align: center;
  }

  &__inner {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 31px;
  }

  &__img {
    min-height: 220px;
    max-height: 500px;
    width: 100%;
    border-radius: 15px;
    margin-bottom: 10px;
  }

  &__description {
    display: inline-block;
    max-height: 440px;
    padding: 12px;
    border-radius: 15px;
    background-color: var(--color-green-opacity);
    overflow-y: auto;
    overflow-x: hidden;
    overflow-wrap: anywhere;
  }

  &__footer {
    display: flex;
    flex-direction: column-reverse;
  }

  &__rating {
    display: flex;
    align-items: center;
  }

  &__stars {
    display: flex;
    flex-direction: row-reverse;
  }

  &__star:not(:last-child) {
    margin-left: 17px;
  }

  &__star {
    width: 1.11111111em;
    height: 1.11111111em;
    fill: #e5e4d9;

    &_change-rating {
      cursor: pointer;
    }

    &_change-rating:hover,
    &_change-rating:hover ~ &,
    &_my-rating,
    &_my-rating ~ & {
      fill: #ed8a19;
    }
  }

  &__followers {
    flex: 1 1;
    padding: 0.5em 1em;
    text-align: center;
  }

  &__author {
    align-self: flex-end;
    margin-bottom: 10px;
  }
}

@include media(sm) {
  .detailed-page {
    &__container {
      width: auto;
    }

    &__star {
      width: 48px;
      height: 48px;
    }

    &__description {
      padding: 12px 31px 10px;
    }
  }
}

@include media(lg) {
  .detailed-page {
    padding: 150px 15px 60px;

    &__container {
      padding: 29px 65px;
    }

    &__heart {
      top: 14px;
      left: 65px;
    }

    &__inner {
      flex-direction: row;
      justify-content: space-between;
      gap: 50px;
    }

    &__img {
      max-width: 465px;
      margin-bottom: 0;
    }

    &__description {
      display: block;
      width: 100%;
      max-width: 465px;
    }

    &__footer {
      flex-direction: row;
      justify-content: space-between;
    }

    &__rating {
      flex: 1 1 465px;
      max-width: 465px;
    }

    &__author {
      margin-bottom: 0;
    }
  }
}
</style>
