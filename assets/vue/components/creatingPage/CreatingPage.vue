<template>
  <section class="creating-page">
    <form class="creating-page__container container">
      <header class="creating-page__header">
        <label for="title" class="creating-page__title">
          <input type="text" class="creating-page__input" :class="{ 'to-up': !!title }" v-model="title" id="title" />
          <span class="creating-page__placeholder">*Название</span>
        </label>
      </header>

      <label for="img" class="creating-page__upload upload" :style="uploadStyle">
        <span class="upload__wrapper">
          <span class="upload__placeholder">*Добавьте фотографию</span>
          <img src="./assets/cloud.svg" alt="cloud" class="upload__img" />
          <input type="file" class="upload__input" id="img" accept="image/jpeg" @change="uploadFile" ref="upload" />
          <ul class="upload__hints">
            <li v-for="hint in uploadHints" class="upload__hint crephusa" :key="hint">{{ hint }}</li>
          </ul>
        </span>
      </label>

      <label for="poem" class="creating-page__poem">
        <textarea class="creating-page__textarea" :class="{ 'to-up': !!title }" id="poem" v-model="description" />
        <span class="creating-page__placeholder">Стихотворение</span>
      </label>

      <label for="author" class="creating-page__author">
        <input type="text" class="creating-page__input" :class="{ 'to-up': !!title }" id="author" v-model="author" />
        <span class="creating-page__placeholder">Автор</span>
      </label>

      <div class="creating-page__footer">
        <button type="submit" class="creating-page__submit oronia" @click.prevent="onSubmit" :disabled="!formIsValid">
          Отправить
        </button>
      </div>
    </form>
  </section>
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component';
import { toBase64 } from '@/helpers';
import { InjectReactive } from 'vue-property-decorator';
import { TUser } from '@/types';
import HomeApi from '@/api/HomeApi';
import { TCreatePostData } from '@/types/TCreatePostData';

@Options({
  name: 'CreatingPage',
})
export default class CreatingPage extends Vue {
  @InjectReactive('user') readonly user!: TUser | null;
  title = '';
  description = '';
  author = '';
  image = '';
  files: File[] = [];

  get uploadHints(): string[] {
    return ['в формате .jpg', 'размером не более 3Мб'];
  }

  get uploadStyle(): { 'background-image': string } {
    return {
      'background-image': `url("${this.image}")`,
    };
  }

  async onSubmit(): Promise<void> {
    if (!this.formIsValid || !this.user) return;
    const [, encodedStr] = this.image.split(',');
    const formData: TCreatePostData = {
      title: this.title,
      description: this.description || undefined,
      author: this.author || undefined,
      image: encodedStr,
      user_id: this.user.id,
    };

    const {
      data: { success },
    } = await HomeApi.createPost(formData);

    console.log(success);

    this.clearForm();
  }

  async uploadFile(e: Event): Promise<void> {
    if ((this.$refs.upload as { value: string }).value) console.log((this.$refs.upload as { value: string }).value);

    const { files } = e.target as HTMLInputElement;

    if (files) {
      for (const file of files) {
        if (file.size > 3145728) {
          console.error('Слишком большой файл!');
          return;
        }

        this.image = (await toBase64(file)) as string;
      }
    }
  }

  get formIsValid(): boolean {
    return !!this.title && !!this.image;
  }

  clearForm(): void {
    this.title = '';
    this.description = '';
    this.image = '';
    this.author = '';
    (this.$refs.upload as { value: string }).value = '';
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
    color: var(--color-gray);
  }

  &__author {
    grid-area: author;
  }

  &__title,
  &__poem,
  &__author {
    background-color: rgba(157, 161, 87, 0.72);
  }

  &__title,
  &__upload,
  &__poem,
  &__author {
    position: relative;
    padding: 52px 15px 29px;
    border-radius: 15px;
    box-sizing: content-box;
  }

  &__placeholder {
    display: inline-block;
    position: absolute;
    top: 52px;
    left: 0;
    width: 100%;
    color: var(--color-gray);
    text-align: center;
    transition: transform 0.1s linear;
  }

  &__textarea,
  &__input {
    width: 100%;
    color: var(--color-gray);
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
    color: var(--color-gray);
    cursor: pointer;

    &:hover {
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.8);
    }

    &:disabled {
      color: #7c7c7c;
      background-color: #c9c7c7;
      box-shadow: none;
      cursor: default;
    }
  }
}

.upload {
  position: relative;
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;
  border-radius: 5px;
  overflow: hidden;
  cursor: pointer;

  &__wrapper {
    display: flex;
    flex-direction: column;
    justify-content: space-evenly;
    align-items: center;
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-color: rgba(157, 161, 87, 0.72);
  }

  &__input {
    display: none;
  }

  &__placeholder,
  &__hint {
    color: var(--color-gray);
  }

  &__placeholder {
    text-align: center;
  }

  &__hint {
    font-style: italic;
    text-align: center;
  }

  &:hover &__img {
    animation: to-up-to-down 1.4s infinite ease;
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
