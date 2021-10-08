<template>
  <router-link :to="link" class="gallery-card">
    <div class="gallery-card__header">
      <img :src="image" :alt="post.title" class="gallery-card__img" />
      <heart class="gallery-card__heart" :rating="rating" />
    </div>
    <span class="gallery-card__title oronia">{{ post.title }}</span>
    <span class="gallery-card__date oronia">{{ post.created_at.date }}</span>
  </router-link>
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component';
import { Prop } from 'vue-property-decorator';
import Heart from '@/vue/components/heart/Heart.vue';
import { TGalleryItem } from '@/types';
import { routerEnum } from '@/enums';
import { addBse64Naming } from '@/helpers';

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
}
</script>

<style lang="scss" scoped>
.gallery-card {
  max-width: 300px;

  &__header {
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
    align-self: center;
    max-height: 330px;
    border-radius: 15px;
    transition: transform 0.1s linear;
  }

  &__title {
    margin-bottom: 10px;
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
