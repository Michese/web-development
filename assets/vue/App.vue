<template>
  <header-page />
  <main>
    <router-view />
<!--    <promo-section />-->
<!--    <gallery-section />-->
  </main>
  <footer-page />
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component';
import HeaderPage from '@/vue/components/headerPage/HeaderPage.vue';
// import PromoSection from '@/vue/components/generalPage/promoSection/PromoSection.vue';
// import GallerySection from '@/vue/components/generalPage/gallerySection/GallerySection.vue';
import FooterPage from '@/vue/components/footerPage/FooterPage.vue';

@Options({
  name: 'App',
  components: { HeaderPage, FooterPage },
})
export default class App extends Vue {}
</script>

<style lang="scss" scoped></style>
