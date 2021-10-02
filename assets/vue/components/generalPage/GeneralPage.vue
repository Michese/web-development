<template>
  <promo-section />
  <gallery-section />
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component';
import PromoSection from '@/vue/components/generalPage/promoSection/PromoSection.vue';
import GallerySection from '@/vue/components/generalPage/gallerySection/GallerySection.vue';

@Options({
  name: 'GeneralPage',
  components: { PromoSection, GallerySection },
})
export default class GeneralPage extends Vue {}
</script>

<style lang="scss" scoped></style>
