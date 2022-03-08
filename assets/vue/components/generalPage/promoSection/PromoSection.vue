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
    <a href="#gallery-section">
      <svg class="double-arrows" viewBox="0 0 50 50" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
        <g>
          <polygon points="48.707,19.353 47.293,17.94 25,40.232 2.707,17.94 1.293,19.353 25,43.06" />
          <polygon points="48.707,8.353 47.293,6.94 25,29.232 2.707,6.94 1.293,8.353 25,32.06" />
        </g>
      </svg>
    </a>
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
  flex-direction: column;
  justify-content: space-evenly;
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
    margin: 0 5px 30px;
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

.double-arrows {
  background-color: #fff;
  padding: 10px;
  border-radius: 50%;
  height: 140px;
  fill: var(--color-orange);
  animation: to-up-to-down 1.4s infinite ease;
}

@include media(sm) {
  .promo-section {
    &__inner {
      padding: 25px;
      margin: 0 0 30px;
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
