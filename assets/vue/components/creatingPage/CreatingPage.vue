<template>
  <section class="creating-page">
    <form class="creating-page__container container">
      <header class="creating-page__header">
        <label for="title" class="creating-page__title">
          <input type="text" class="creating-page__input" :class="{ 'to-up': !!title }" v-model="title" id="title" />
          <span class="creating-page__placeholder" :class="{ alert: !title }">*Название</span>
        </label>
      </header>

      <label for="img" class="creating-page__upload upload" :style="uploadStyle">
        <span class="upload__wrapper">
          <span class="upload__placeholder">*Добавьте фотографию</span>
          <svg
            class="upload__img"
            width="50"
            height="50"
            viewBox="0 0 50 50"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <mask id="mask0" style="mask-type: alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="50" height="50">
              <g clip-path="url(#clip0)">
                <path
                  d="M39.2498 14.6016C37.5116 6.15407 29.2543 0.715191 20.8068 2.45345C13.5733 3.94196 8.37159 10.2941 8.33841 17.6789C8.33841 18.0308 8.35295 18.391 8.38418 18.772C3.2382 19.3168 -0.491887 23.9299 0.0528203 29.0759C0.557707 33.8456 4.58304 37.464 9.37942 37.4593H10.4725C10.4476 37.1137 10.4205 36.7701 10.4205 36.4182C10.4205 28.9437 16.4798 22.8842 23.9545 22.8842C31.4291 22.8842 37.4883 28.9437 37.4883 36.4182C37.4883 36.77 37.4613 37.1136 37.4363 37.4593H38.5294C44.8471 37.4766 49.9826 32.369 49.9999 26.0513C50.0165 19.9892 45.301 14.9668 39.2498 14.6016Z"
                  fill="#BBDEFB"
                />
                <path
                  d="M23.9544 47.87C30.2791 47.87 35.4062 42.7429 35.4062 36.4183C35.4062 30.0937 30.2791 24.9666 23.9544 24.9666C17.6298 24.9666 12.5027 30.0937 12.5027 36.4183C12.5027 42.7429 17.6298 47.87 23.9544 47.87Z"
                  fill="#4CAF50"
                />
                <path
                  d="M23.9544 43.7057C23.3795 43.7057 22.9133 43.2395 22.9133 42.6646V30.1717C22.9133 29.5968 23.3795 29.1306 23.9544 29.1306C24.5294 29.1306 24.9955 29.5968 24.9955 30.1717V42.6646C24.9954 43.2395 24.5294 43.7057 23.9544 43.7057Z"
                  fill="#FAFAFA"
                />
                <path
                  d="M23.9544 43.7056C23.6781 43.7061 23.4129 43.5968 23.2173 43.4016L19.053 39.2373C18.6535 38.8238 18.665 38.1647 19.0786 37.7652C19.482 37.3755 20.1216 37.3755 20.5251 37.7652L23.9544 41.1924L27.3816 37.7652C27.7952 37.3657 28.4543 37.3772 28.8537 37.7908C29.2435 38.1942 29.2435 38.8338 28.8537 39.2373L24.6894 43.4016C24.4942 43.5962 24.2299 43.7055 23.9544 43.7056Z"
                  fill="#FAFAFA"
                />
              </g>
            </mask>
            <g mask="url(#mask0)"></g>
            <g clip-path="url(#clip1)">
              <path
                d="M39.2498 14.6016C37.5116 6.15407 29.2543 0.715191 20.8068 2.45345C13.5733 3.94196 8.37159 10.2941 8.33841 17.6789C8.33841 18.0308 8.35295 18.391 8.38418 18.772C3.2382 19.3168 -0.491887 23.9299 0.0528203 29.0759C0.557707 33.8456 4.58304 37.464 9.37942 37.4593H10.4725C10.4476 37.1137 10.4205 36.7701 10.4205 36.4182C10.4205 28.9437 16.4798 22.8842 23.9545 22.8842C31.4291 22.8842 37.4883 28.9437 37.4883 36.4182C37.4883 36.77 37.4613 37.1136 37.4363 37.4593H38.5294C44.8471 37.4766 49.9826 32.369 49.9999 26.0513C50.0165 19.9892 45.301 14.9668 39.2498 14.6016Z"
                fill="#F2F2F0"
              />
              <path
                d="M23.9544 47.87C30.2791 47.87 35.4062 42.7429 35.4062 36.4183C35.4062 30.0937 30.2791 24.9666 23.9544 24.9666C17.6298 24.9666 12.5027 30.0937 12.5027 36.4183C12.5027 42.7429 17.6298 47.87 23.9544 47.87Z"
                fill="#85881D"
              />
              <path
                d="M23.9544 43.7057C23.3795 43.7057 22.9133 43.2395 22.9133 42.6646V30.1717C22.9133 29.5968 23.3795 29.1306 23.9544 29.1306C24.5294 29.1306 24.9955 29.5968 24.9955 30.1717V42.6646C24.9954 43.2395 24.5294 43.7057 23.9544 43.7057Z"
                fill="#FAFAFA"
              />
              <path
                d="M23.9544 43.7056C23.6781 43.7061 23.4129 43.5968 23.2173 43.4016L19.053 39.2373C18.6535 38.8238 18.665 38.1647 19.0786 37.7652C19.482 37.3755 20.1216 37.3755 20.5251 37.7652L23.9544 41.1924L27.3816 37.7652C27.7952 37.3657 28.4543 37.3772 28.8537 37.7908C29.2435 38.1942 29.2435 38.8338 28.8537 39.2373L24.6894 43.4016C24.4942 43.5962 24.2299 43.7055 23.9544 43.7056Z"
                fill="#FAFAFA"
              />
            </g>
            <defs>
              <clipPath id="clip0">
                <rect width="50" height="50" fill="white" />
              </clipPath>
              <clipPath id="clip1">
                <rect width="50" height="50" fill="white" />
              </clipPath>
            </defs>
          </svg>

          <input type="file" class="upload__input" id="img" accept="image/jpeg" @change="uploadFile" ref="upload" />
          <ul class="upload__hints">
            <li
              v-for="uploadHint in uploadHints"
              class="upload__hint crephusa"
              :key="uploadHint.hint"
              :class="{ alert: uploadHint.alert }"
            >
              {{ uploadHint.hint }}
            </li>
          </ul>
        </span>
      </label>

      <label for="poem" class="creating-page__poem">
        <textarea class="creating-page__textarea" :class="{ 'to-up': !!description }" id="poem" v-model="description" />
        <span class="creating-page__placeholder">Стихотворение</span>
      </label>

      <label for="author" class="creating-page__author">
        <input type="text" class="creating-page__input" :class="{ 'to-up': !!author }" id="author" v-model="author" />
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

enum hintFields {
  format = 'format',
  size = 'size',
}

const hints = {
  [hintFields.format]: 'в формате .jpg',
  [hintFields.size]: 'размером не более 3Мб',
};

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

  isAlertHints = {
    [hintFields.format]: true,
    [hintFields.size]: true,
  };

  get uploadHints(): { [key: string]: { hint: string; alert: boolean } } {
    return {
      [hintFields.format]: {
        hint: hints[hintFields.format],
        alert: this.isAlertHints[hintFields.format],
      },
      [hintFields.size]: {
        hint: hints[hintFields.size],
        alert: this.isAlertHints[hintFields.size],
      },
    };
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

    if (success) this.clearForm();
  }

  async uploadFile(e: Event): Promise<void> {
    const { files } = e.target as HTMLInputElement;

    if (files) {
      for (const file of files) {
        this.isAlertHints[hintFields.size] = file.size > 3145728;
        this.isAlertHints[hintFields.format] = !/image\/jpe?g/gi.test(file.type);

        if (this.isAlertHints[hintFields.size] || this.isAlertHints[hintFields.format]) {
          if (this.isAlertHints[hintFields.size]) console.error('Слишком большой файл!');
          if (this.isAlertHints[hintFields.format]) console.error('Слишком большой файл!');
          this.image = '';
          return;
        }

        this.image = (await toBase64(file)) as string;
      }
    }
  }

  get formIsValid(): boolean {
    return (
      !!this.title && !!this.image && !this.isAlertHints[hintFields.format] && !this.isAlertHints[hintFields.format]
    );
  }

  clearForm(): void {
    this.title = '';
    this.description = '';
    this.image = '';
    this.author = '';
    (this.$refs.upload as { value: string }).value = '';
    this.isAlertHints[hintFields.format] = true;
    this.isAlertHints[hintFields.size] = true;
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
  background-image: url('/assets/assets/promo-background.jpg');
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
    &.to-up + .creating-page__placeholder {
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

.alert {
  color: brown;
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
