<template>
  <section class="promo-section">
    <div class="promo-section__inner">
      <h2 class="promo-section__section-caption section-caption">Чайная комната</h2>
      <p class="promo-section__text maria">
        Порой в гостях за чашкой чая,<br />
        вращая ложечкой лимон,<br />
        я вздрогну,<br />
        втайне ощущая мир вечности,<br />
        полёт времен...
      </p>
      <span class="promo-section__author maria">(Е. Винокур)</span>
    </div>
  </section>
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component';

@Options({
  name: 'PromoSection',
})
export default class PromoSection extends Vue {}
</script>

<style lang="scss" scoped>
@import '/assets/css/media';
.promo-section {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-image: url('/assets/assets/promo-background.jpg');
  background-size: cover;

  &__container {
    margin: 0 10px;
  }

  &__inner {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    padding: 15px;
    margin: 0 5px;
    background-color: var(--color-promo-bg);
    border-radius: 5px;
  }

  &__section-caption {
    align-self: center;
    margin-bottom: 10px;
  }

  &__author {
    align-self: flex-end;
  }

  &__section-caption,
  &__text,
  &__author {
    font-size: 13px;
    color: var(--color-orange);
  }
}

@include media(sm) {
  .promo-section {
    &__inner {
      padding: 25px;
      margin: 0;
    }

    &__section-caption {
      margin-bottom: 15px;
    }

    &__section-caption,
    &__text,
    &__author {
      font-size: 24px;
    }
  }
}

@include media(lg) {
  .promo-section {
    &__inner {
      padding: 70px 150px 113px;
    }

    &__section-caption {
      margin-bottom: 45px;
    }

    &__section-caption,
    &__text,
    &__author {
      font-size: 24px;
    }
  }
}
</style>
