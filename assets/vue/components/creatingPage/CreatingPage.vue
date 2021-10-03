<template>
  <section class="creating-page">
    <div class="creating-page__container container">
      <header class="creating-page__header">
        <label for="title" class="creating-page__title">
          <input type="text" class="creating-page__input" id="title" />
          <span class="creating-page__placeholder">Название</span>
        </label>
      </header>

      <label for="img" class="creating-page__upload upload">
        <span class="upload__placeholder">Добавьте фотографию</span>
        <img src="./assets/cloud.svg" alt="cloud" class="upload__img" />
        <input type="file" class="upload__input" id="img" accept="image/jpeg" />
        <ul class="upload__hints">
          <li v-for="hint in uploadHints" class="upload__hint crephusa" :key="hint">{{ hint }}</li>
        </ul>
      </label>

      <label for="poem" class="creating-page__poem">
        <textarea class="creating-page__textarea" id="poem" />
        <span class="creating-page__placeholder">Стихотворение</span>
      </label>

      <label for="author" class="creating-page__author">
        <input type="text" class="creating-page__input" id="author" />
        <span class="creating-page__placeholder">Автор</span>
      </label>

      <div class="creating-page__footer">
        <button type="submit" class="creating-page__submit oronia">Отправить</button>
      </div>
    </div>
  </section>
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component';

@Options({
  name: 'CreatingPage',
})
export default class CreatingPage extends Vue {

  get uploadHints(): string[] {
    return ['в формате .jpg', 'размером не более 3Мб'];
  }
}
</script>

<style lang="scss" scoped>
@import '/assets/css/media';
.creating-page {
  display: flex;
  align-items: center;
  min-height: 100vh;
  padding: 150px 15px 60px;
  background-image: url('./assets/promo-background.jpg');
  background-size: cover;

  &__container {
    display: grid;
    grid-template-areas:
      'header'
      'upload'
      'poem'
      'author'
      'footer';
    grid-template-columns: minmax(1px, 1fr);
    //grid-template-rows: repeat(4, auto);
    row-gap: 34px;
    column-gap: 50px;
    padding: 15px;
    background-color: var(--color-promo-bg);
    border-radius: 5px;
  }

  &__header {
    grid-area: header;
    display: flex;
    justify-content: center;
  }

  &__title {

  }

  &__upload {
    grid-area: upload;
    min-height: 250px;
  }

  &__poem {
    display: flex;
    flex-direction: column;
    grid-area: poem;
    min-height: 250px;
  }

  &__textarea {
    flex: 1 1;
    width: 100%;
    max-width: 100%;
    max-height: 800px;
  }

  &__author {
    grid-area: author;
  }

  &__title,
  &__upload,
  &__poem,
  &__author {
    position: relative;
    padding: 52px 15px 29px;
    background-color: var(--color-green-opacity);
    border-radius: 15px;
    box-sizing: content-box;
  }

  &__placeholder {
    display: inline-block;
    position: absolute;
    top: 52px;
    left: 0;
    width: 100%;
    color: var(--color-light-green);
    text-decoration: underline;
    text-align: center;
    transition: transform 0.1s linear;
  }

  &__textarea,
  &__input {
    width: 100%;
    background-color: transparent;
    border: none;
    outline: none;
    &:focus + .creating-page__placeholder,
    .to-up + .creating-page__placeholder {
      transform: translateY(-1.5em);
    }
  }

  &__footer {
    grid-area: footer;
    display: flex;
    justify-content: center;
    width: 100%;
  }

  &__submit {
    padding: 11px 40px;
    background-color: rgba(157, 161, 87, 0.72);
    box-shadow: 0 0 4px rgba(0, 0, 0, 0.25);
    border-radius: 5px;
    color: var(--color-dark-green);
    cursor: pointer;
  }
}

.upload {
  display: flex;
  flex-direction: column;
  justify-content: space-evenly;
  align-items: center;

  &__placeholder,
  &__hint {
    color: var(--color-light-green);
  }

  &__placeholder {
    text-align: center;
    text-decoration: underline;
  }

  &__hint {
    font-style: italic;
    text-align: center;
  }
}
@include media(sm) {
  .creating-page {
    &__title {
      min-width: 465px;
    }
  }
}

@include media(lg) {
  .creating-page {
    &__container {
      grid-template-areas:
        'header header'
        'upload poem'
        'upload author'
        'footer footer';
      grid-template-columns: 1fr minmax(465px, 1fr);
      padding: 29px 65px 65px;
    }
  }
}
</style>
