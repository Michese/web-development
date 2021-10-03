<template>
  <header class="header-page">
    <div class="header-page__container container">
      <router-link :to="linkToGeneralPage" class="header-page__logo logo">
        <img src="./assets/logo.svg" alt="logo" class="logo__img" />
        <span class="logo__text maria">Чайная комната</span>
      </router-link>

      <auth-modal>
        <button type="button" class="header-page__btn maria">
          <span class="header-page__auth">Вход/Регистрация</span>
          <img src="./assets/avatar.svg" alt="avatar" class="header-page__avatar" />
        </button>
      </auth-modal>
    </div>
  </header>
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component';
import AuthModal from '@/vue/components/authModal/AuthModal.vue';
import { routerEnum } from '@/enums';

@Options({
  name: 'HeaderPage',
  components: { AuthModal },
})
export default class HeaderPage extends Vue {
  get linkToGeneralPage(): string {
    return routerEnum.generalPage;
  }
}
</script>

<style lang="scss" scoped>
@import '/assets/css/media';
.header-page {
  position: fixed;
  top: 0;
  right: 0;
  left: 0;
  z-index: 5;
  background-color: var(--color-green);

  &__container {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    padding: 15px 15px 25px;
  }

  &__btn {
    cursor: pointer;
  }

  &__auth {
    display: none;
    color: var(--color-yellow);
    margin-right: 8px;
  }
}

.logo {
  display: flex;
  align-items: flex-end;

  &__img {
    color: var(--color-yellow);
  }

  &__text {
    display: none;
    color: var(--color-yellow);
  }
}

@include media(sm) {
  .header-page {
    &__auth {
      display: inline;
    }

    &__avatar {
      display: none;
    }
  }

  .logo {
    &__img {
      margin-right: 12px;
    }

    &__text {
      display: inline;
    }
  }
}
</style>
