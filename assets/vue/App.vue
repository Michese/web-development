<template>
  <header-page />
  <main>
    <router-view />
  </main>
  <footer-page />
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component';
import HeaderPage from '@/vue/components/headerPage/HeaderPage.vue';
import FooterPage from '@/vue/components/footerPage/FooterPage.vue';
import HomeApi from '@/api/HomeApi';

@Options({
  name: 'App',
  components: { HeaderPage, FooterPage },
})
export default class App extends Vue {
  async created(): Promise<void> {
    const result = await HomeApi.getColors();
    console.log('result', result);
  }
}
</script>

<style lang="scss" scoped></style>
