<template>
  <section class="detailed-page">
    <loader v-if="isLoading" class="detailed-page__loader container" />
    <div v-else class="detailed-page__container container">
      <heart class="detailed-page__heart" :rating="rating" :size="24" />
      <header>
        <h2 class="detailed-page__section-caption section-caption">{{ detailedPost.title }}</h2>
      </header>
      <div class="detailed-page__inner">
        <img :src="image" alt="big-img" class="detailed-page__img" @click="openApproximation" />

        <teleport to="body">
          <transition name="approximation">
            <div class="approximation" v-if="showApproximation" v-bodyoverflow @click.stop="closeApproximation">
              <img :src="image" alt="full-img" class="approximation__full-image" />
            </div>
          </transition>
        </teleport>

        <div class="detailed-page__content">
          <strong v-if="!!detailedPost.author" class="detailed-page__author italico">{{ detailedPost.author }}</strong>
          <p v-if="!!description" class="detailed-page__description italico" v-html="description" />
        </div>
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
        <span v-if="!!detailedPost.author" class="detailed-page__user italico">{{ detailedPost.name }}</span>
      </footer>
      <div class="detailed-page__comment-section comment-section">
        <div v-if="user" class="comment-section__body">
          <textarea
            class="comment-section__textarea"
            id="comment"
            v-model="commentText"
            placeholder="Комментарий ..."
          />
          <button class="comment-section__button" @click.prevent="sendComment" />
        </div>
        <div v-for="comment in comments" :key="comment.id" class="comment-section__comment comment">
          <header class="comment__header">
            <span class="comment__author">{{ comment.user.name + (comment.user.id === user?.id ? ' (Вы)' : '') }}</span>
            <span class="comment__date">{{ toDateFormat(comment?.created_at?.date) }}</span>
          </header>
          <main class="comment__main">
            <p class="comment__content">{{ comment.text }}</p>
          </main>
        </div>
      </div>
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
import { addBse64Naming, toDateFormat } from '@/helpers';
import { TComment } from '@/types/TComment';

@Options({
  name: 'DetailedPage',
  components: { Heart, Loader },
})
export default class DetailedPage extends Vue {
  @InjectReactive('user') user!: TUser | null;
  comments: TComment[] = [];
  detailedPost: TDetailedPost | null = null;
  isLoading = false;
  showApproximation = false;
  commentText = '';
  @Prop({
    type: String,
    required: true,
  })
  post!: number;

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

  async sendComment(): Promise<void> {
    if (!this.commentText) return;

    const {
      data: { comments },
    } = await HomeApi.createComment({
      text: this.commentText,
      post_id: this.post,
    });
    this.comments = comments;
    this.commentText = '';
  }

  toDateFormat(date: string): string {
    return toDateFormat(date);
  }

  openApproximation(): void {
    this.showApproximation = true;
  }

  closeApproximation(): void {
    this.showApproximation = false;
  }

  async created(): Promise<void> {
    this.isLoading = true;

    try {
      const [{ detailedPost }, { comments }] = await Promise.all([
        HomeApi.getPost(this.post),
        HomeApi.getComments(this.post),
      ]);
      if (detailedPost) this.detailedPost = detailedPost;
      if (comments) this.comments = comments;
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
    cursor: pointer;
    &:hover {
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.6);
    }
  }

  &__content {
    display: flex;
    flex-direction: column;
  }

  &__author {
    align-self: center;
    margin-bottom: 10px;
    font-weight: 700;
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
    margin-bottom: 20px;
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

  &__user {
    align-self: flex-end;
    margin-bottom: 10px;
  }
}

.comment-section {

  max-width: 650px;

  &__body {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 10px;
  }

  &__textarea {
    flex: 1 1;
    padding: 15px;
    width: 100%;
    max-width: 100%;
    max-height: 800px;
    min-height: 80px;
    color: var(--color-gray);
    background-color: rgba(157, 161, 87, 0.6);
    border: none;
    border-radius: 5px;

    &:focus {
      outline: 1px solid #464512;
    }
  }

  &__button{
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
    height: 3em;
    width: 3em;
    border-radius: 50%;
    color: rgba(157, 161, 87, 0.6);
    border: 4px solid currentColor;
    cursor: pointer;

    &:before {
      display: block;
      position: absolute;
      content: '';
      height: 1.5em;
      width: 1.5em;
      color: currentColor;
      border-left: 4px solid currentColor;
      border-bottom: 4px solid currentColor;
      transform-origin: 40% 55%;
      transform: rotate(-135deg);
    }
    &:hover {
      color: #464512;
    }
  }
}

.approximation-enter-active,
.approximation-leave-active {
  transition: transform 0.2s ease;
}

.approximation-enter-from,
.approximation-leave-to {
  transform: scale(0);
}

.approximation {
  display: flex;
  justify-content: center;
  align-items: center;
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: 100;
  background-color: rgba(59, 59, 59, 0.8);

  &__full-image {
    max-height: 80vh;
    max-width: 90vw;
  }
}

.comment {
  padding-top: 10px;
  margin-bottom: 15px;
  border-top: 2px solid rgba(157, 161, 87, 0.6);

  &__header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 5px;
    font-style: italic;
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
      top: 5px;
      left: 5px;
    }

    &__inner {
      flex-direction: row;
      justify-content: space-between;
      align-items: flex-start;
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

    &__user{
      margin-bottom: 0;
    }
  }
}
</style>
