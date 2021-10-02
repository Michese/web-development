<template>
  <router-link :to="link" class="gallery-card">
    <div class="gallery-card__header">
      <img :src="item.img" :alt="item.title" class="gallery-card__img" />
      <heart class="gallery-card__heart" :rating="item.rating" />
    </div>
    <span class="gallery-card__title oronia">{{ item.title }}</span>
    <span class="gallery-card__date oronia">{{ item.date }}</span>
  </router-link>
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component';
import { Prop } from 'vue-property-decorator';
import Heart from '@/vue/components/heart/Heart.vue';
import { TGalleryItem } from '@/types';
import { routerEnum } from '@/enums';

@Options({
  name: 'GalleryCard',
  components: { Heart },
})
export default class GalleryCard extends Vue {
  @Prop({
    type: Object,
    required: true,
  })
  item!: TGalleryItem;

  get link(): string {
    return `${routerEnum.detailedPage}/${this.item.id}`;
  }
}
</script>

<style lang="scss" scoped>
.gallery-card {
  max-width: 300px;

  &__header {
    position: relative;
    margin-bottom: 13px;
  }

  &__heart {
    position: absolute;
    top: 5px;
    right: 5px;
  }

  &__img {
    border-radius: 15px;
  }

  &__title {
    margin-bottom: 10px;
  }

  &__title,
  &__date {
    display: block;
    color: var(--color-dark-green);
  }
}
</style>
