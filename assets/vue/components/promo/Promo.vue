<template>
  <section class="promo">
    <div class="promo__inner">
      <h2 class="promo__section-caption section-caption">Чайная комната</h2>
      <p class="promo__text maria">
        Порой в гостях за чашкой чая,<br />
        вращая ложечкой лимон,<br />
        я вздрогну,<br />
        втайне ощущая мир вечности,<br />
        полёт времен...
      </p>
      <span class="promo__author maria">(Е. Винокур)</span>
    </div>
  </section>
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component';

@Options({
  name: 'Promo',
})
export default class Promo extends Vue {}
</script>

<style lang="scss" scoped>
.promo {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-image: url('./assets/promo-background.jpg');
  background-size: cover;

  &__inner {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    padding: 70px 150px 113px;
    background-color: var(--color-promo-bg);
    border-radius: 5px;
  }

  &__section-caption {
    align-self: center;
    margin-bottom: 45px;
  }

  &__author {
    align-self: flex-end;
  }

  &__section-caption,
  &__text,
  &__author {
    color: var(--color-orange);
  }
}
</style>
