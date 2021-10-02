<template>
  <header class="header-page">
    <div class="header-page__container container">
      <a href="#" class="header-page__logo logo">
        <img src="./assets/logo.svg" alt="logo" class="logo__img" />
        <span class="logo__text maria">Чайная комната</span>
      </a>

      <button type="button" class="header-page__btn maria">Вход/Регистрация</button>
    </div>
  </header>
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component';

@Options({
  name: 'HeaderPage',
})
export default class HeaderPage extends Vue {}
</script>

<style lang="scss" scoped>
.header-page {
  position: fixed;
  top: 0;
  right: 0;
  left: 0;
  background-color: var(--color-green);

  &__container {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    padding: 15px 15px 25px;
  }

  &__btn {
    color: var(--color-yellow);
    cursor: pointer;
  }
}

.logo {
  display: flex;
  align-items: flex-end;

  &__img {
    margin-right: 12px;
    color: var(--color-yellow);
  }

  &__text {
    color: var(--color-yellow);
  }
}
</style>
