<template>
  <header-page />
  <main>
    <router-view />
  </main>
  <footer-page />
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component';
import { Provide, ProvideReactive } from 'vue-property-decorator';
import HeaderPage from '@/vue/components/headerPage/HeaderPage.vue';
import FooterPage from '@/vue/components/footerPage/FooterPage.vue';
// import HomeApi from '@/api/HomeApi';
import { TUser } from '@/types';
import SecurityApi from '@/api/SecurityApi';
// import SecurityApi from '@/api/SecurityApi';

@Options({
  name: 'App',
  components: { HeaderPage, FooterPage },
})
export default class App extends Vue {
  @ProvideReactive('user') user: TUser | null = null;

  @Provide()
  setUser(user: TUser): void {
    this.user = user;
  }

  async created(): Promise<void> {
    // const { user } = await SecurityApi.getUser();
    //
    // this.setUser(user);
    //
    // console.log(user);


    // const result = await SecurityApi.logout();
    // console.log('result', result);
    // const result = await HomeApi.getColors();
    // console.log('result', result);
    // const result = await SecurityApi.register({ data: { name: 'Hello' } });
    // console.log(result);
  }
}
</script>

<style lang="scss" scoped></style>
