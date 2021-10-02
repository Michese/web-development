<template>
  <footer class="footer-page">
    <div class="footer-page__container container">
      <a href="mailto:tea-room@mail.ru" class="footer-page__text maria">tea-room@mail.ru</a>
      <a href="tel:+79046867942" class="footer-page__text maria">
        Куликов Вадим <br />
        +79046867942
      </a>
      <a href="mailto:tea-room@mail.ru" class="footer-page__text maria">
        Зубкова Надежда <br />
        +79997501590
      </a>
    </div>
  </footer>
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component';

@Options({
  name: 'FooterPage',
})
export default class FooterPage extends Vue {}
</script>

<style lang="scss" scoped>
@import '/assets/css/media';
.footer-page {
  background-color: var(--color-green);

  &__container {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 21px 15px;
  }

  &__text {
    margin-bottom: 15px;
    color: var(--color-yellow);
    text-align: center;
  }
}

@include media(lg) {
  .footer-page {
    &__container {
      flex-direction: row;
      justify-content: space-between;
    }

    &__text {
      margin-bottom: 0;
    }
  }
}
</style>
