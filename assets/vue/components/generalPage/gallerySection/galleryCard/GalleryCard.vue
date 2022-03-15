<template>
  <router-link :to="link" class="gallery-card">
    <div class="gallery-card__header">
      <img :src="image" :alt="post.title" class="gallery-card__img" />
      <heart class="gallery-card__heart" :rating="rating" />
    </div>
    <div class="gallery-card__content content">
      <header class="content__header">
        <span class="gallery-card__title oronia" :title="post.title">{{ post.title }}</span>
        <div :title="post.tag">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <mask id="mask0_327_45" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
              <path d="M3 5.5C3 4.11929 4.11929 3 5.5 3H11.5C11.6326 3 11.7598 3.05268 11.8536 3.14645L20.1565 11.4494C21.289 12.5819 21.289 14.4181 20.1565 15.5506L15.5506 20.1565C14.4181 21.289 12.5819 21.289 11.4494 20.1565L3.14645 11.8536C3.05268 11.7598 3 11.6326 3 11.5V5.5ZM11.2929 4H5.5C4.67157 4 4 4.67157 4 5.5V11.2929L12.1565 19.4494C12.8985 20.1914 14.1015 20.1914 14.8435 19.4494L19.4494 14.8435C20.1914 14.1015 20.1914 12.8985 19.4494 12.1565L11.2929 4ZM8 7C7.44772 7 7 7.44772 7 8C7 8.55228 7.44772 9 8 9C8.55228 9 9 8.55228 9 8C9 7.44772 8.55228 7 8 7ZM8 6C9.10457 6 10 6.89543 10 8C10 9.10457 9.10457 10 8 10C6.89543 10 6 9.10457 6 8C6 6.89543 6.89543 6 8 6Z" fill="black"/>
            </mask>
            <g mask="url(#mask0_327_45)">
            </g>
            <path d="M3 5.5C3 4.11929 4.11929 3 5.5 3H11.5C11.6326 3 11.7598 3.05268 11.8536 3.14645L20.1565 11.4494C21.289 12.5819 21.289 14.4181 20.1565 15.5506L15.5506 20.1565C14.4181 21.289 12.5819 21.289 11.4494 20.1565L3.14645 11.8536C3.05268 11.7598 3 11.6326 3 11.5V5.5ZM11.2929 4H5.5C4.67157 4 4 4.67157 4 5.5V11.2929L12.1565 19.4494C12.8985 20.1914 14.1015 20.1914 14.8435 19.4494L19.4494 14.8435C20.1914 14.1015 20.1914 12.8985 19.4494 12.1565L11.2929 4ZM8 7C7.44772 7 7 7.44772 7 8C7 8.55228 7.44772 9 8 9C8.55228 9 9 8.55228 9 8C9 7.44772 8.55228 7 8 7ZM8 6C9.10457 6 10 6.89543 10 8C10 9.10457 9.10457 10 8 10C6.89543 10 6 9.10457 6 8C6 6.89543 6.89543 6 8 6Z" fill="#737510"/>
          </svg>
        </div>
      </header>
      <span class="gallery-card__date oronia">{{ date }}</span>
    </div>
  </router-link>
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component';
import { Prop } from 'vue-property-decorator';
import Heart from '@/vue/components/heart/Heart.vue';
import { TGalleryItem } from '@/types';
import { routerEnum } from '@/enums';
import { addBse64Naming, toDateFormat } from '@/helpers';

@Options({
  name: 'GalleryCard',
  components: { Heart },
})
export default class GalleryCard extends Vue {
  @Prop({
    type: Object,
    required: true,
  })
  post!: TGalleryItem;

  get link(): string {
    return `${routerEnum.detailedPage}/${this.post.id}`;
  }

  get rating(): number {
    return this.post.rating ? Math.round(this.post.rating) : 0;
  }

  get image(): string {
    return addBse64Naming(this.post.image);
  }

  get date(): string {
    return toDateFormat(this.post.created_at);
  }
}
</script>

<style lang="scss" scoped>
.gallery-card {
  flex: 1 0;
  display: flex;
  flex-direction: column;
  justify-content: space-between;

  &__header {
    flex: 1 0;
    display: flex;
    justify-content: center;
    position: relative;
    margin-bottom: 13px;
  }

  &__heart {
    position: absolute;
    top: 5px;
    right: 5px;
  }

  &__img {
    flex: 1 0;
    align-self: center;
    min-height: 280px;
    max-height: 330px;
    width: 100%;
    height: 100%;
    border-radius: 15px;
    transition: transform 0.1s linear;
  }

  &__title {
    display: -webkit-box;
    margin-bottom: 10px;
    max-height: 2.6em;
    overflow-y: hidden;
    text-overflow: ellipsis;
    overflow-wrap: break-word;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
  }

  &__title,
  &__date {
    display: block;
    color: var(--color-dark-green);
  }

  &:hover &__img {
    box-shadow: 0 0 10px #000;
    transform: scale(1.05);
  }
  &:hover &__title,
  &:hover &__date {
    text-shadow: 6px 4px 4px rgba(0, 0, 0, 0.25);
  }
}

.content {
  &__header {
    display: flex;
    justify-content: space-between;
  }
}
</style>
