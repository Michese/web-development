<template>
  <section class="detailed-page">
    <div class="detailed-page__container container">
      <heart class="detailed-page__heart" :rating="3" :size="24" />
      <header>
        <h2 class="detailed-page__section-caption section-caption">Я бываю такая разная</h2>
      </header>
      <div class="detailed-page__inner">
        <img src="./assets/big-img-item-9.jpg" alt="big-img" class="detailed-page__img" />
        <p class="detailed-page__description italico">
          Я бываю такая разная – То капризная, то прекрасная, То страшилище опупенное, То красавица – мисс Вселенная, То
          покладиста, то с характером, то молчу, то ругаюсь матерно, то в горящие избы на лошади, то отчаянно требую
          помощи, дверью хлопну – расставлю все точки, то ласкаюсь пушистым комочком, то люблю и тотчас ненавижу, то
          боюсь высоты, но на крышу выхожу погулять тёмной ночкой, то жена, то примерная дочка, то смеюсь, то рыдаю
          белугой, то мирюсь, то ругаюсь с подругой. Не больна я, не в психике трещина… Просто Я – стопроцентная
          ЖЕНЩИНА! (Лариса Рубальская)
Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab, accusamus ad adipisci consequatur consequuntur ducimus impedit ipsam iste iure iusto maiores modi, nulla optio quasi quis ratione tempore vel veritatis vitae voluptatum. Distinctio esse illo praesentium soluta vel! Consectetur magnam nobis placeat repudiandae voluptate! Dolores ipsa nam reprehenderit vel vitae!
        </p>
      </div>
      <footer class="detailed-page__footer">
        <div class="detailed-page__rating">
          <span class="detailed-page__stars">
            <img src="./assets/star.svg" alt="star" class="detailed-page__star" />
            <img src="./assets/star.svg" alt="star" class="detailed-page__star" />
            <img src="./assets/star.svg" alt="star" class="detailed-page__star" />
            <img src="./assets/star.svg" alt="star" class="detailed-page__star" />
            <img src="./assets/star.svg" alt="star" class="detailed-page__star" />
          </span>

          <div class="detailed-page__followers maria">10</div>
        </div>
        <span class="detailed-page__author italico">Валентина Ким</span>
      </footer>
    </div>
  </section>
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component';
import Heart from '@/vue/components/heart/Heart.vue';

@Options({
  name: 'DetailedPage',
  components: { Heart },
})
export default class DetailedPage extends Vue {}
</script>

<style lang="scss" scoped>
@import '/assets/css/media';
.detailed-page {
  min-height: 100vh;
  padding: 150px 15px 60px;
  background-image: url('./assets/promo-background.jpg');
  background-size: cover;

  &__container {
    position: relative;
    padding: 15px;
    background-color: var(--color-promo-bg);
    border-radius: 5px;
  }

  &__heart {
    position: absolute;
    top: -45px;
    left: -10px;
  }

  &__section-caption {
    display: block;
    margin-bottom: 49px;
    text-align: center;
  }

  &__inner {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 31px;
  }

  &__img {
    border-radius: 15px;
    margin-bottom: 10px;
  }

  &__description {
    display: inline-block;
    max-height: 440px;
    padding: 12px;
    border-radius: 15px;
    background-color: var(--color-green-opacity);
    overflow-y: auto;
  }

  &__footer {
    display: flex;
    flex-direction: column-reverse;
  }

  &__rating {
    display: flex;
    align-items: center;
  }

  &__star:not(:last-child) {
    margin-right: 17px;
  }

  &__star {
    width: 20px;
    height: 20px;
  }

  &__followers {
    flex: 1 1;
    text-align: center;
  }

  &__author {
    align-self: flex-end;
    margin-bottom: 10px;
  }
}

@include media(sm) {
  .detailed-page {
    &__star {
      width: 48px;
      height: 48px;
    }

    &__description {
      padding: 12px 31px 10px;
    }
  }
}

@include media(lg) {
  .detailed-page {
    padding: 150px 15px 60px;

    &__container {
      padding: 29px 65px;
    }

    &__heart {
      top: 14px;
      left: 65px;
    }

    &__inner {
      flex-direction: row;
      justify-content: space-between;
    }

    &__img {
      max-width: 465px;
      margin-bottom: 0;
    }

    &__description {
      display: block;
      max-width: 465px;
    }

    &__footer {
      flex-direction: row;
      justify-content: space-between;
    }

    &__rating {
      flex: 1 1 465px;
      max-width: 465px;
    }

    &__author {
      margin-bottom: 0;
    }
  }
}
</style>
