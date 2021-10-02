<template>
  <header-page />
  <main>
    <promo />
  </main>
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component';
import HeaderPage from '@/vue/components/headerPage/HeaderPage.vue';
import Promo from '@/vue/components/promo/Promo.vue';

@Options({
  name: 'App',
  components: { HeaderPage, Promo },
})
export default class App extends Vue {}
</script>

<style lang="scss" scoped></style>
