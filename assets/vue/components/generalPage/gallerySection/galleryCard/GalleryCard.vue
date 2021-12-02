<template>
  <router-link :to="link" class="gallery-card">
    <div class="gallery-card__header">
      <img :src="image" :alt="post.title" class="gallery-card__img" />
      <heart class="gallery-card__heart" :rating="rating" />
    </div>
    <div class="gallery-card__content">
      <span class="gallery-card__title oronia" :title="post.title">{{ post.title }}</span>
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
    return toDateFormat(this.post.created_at.date);
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
</style>
