<template>
  <form class="login-form" @submit.prevent>
    <header class="login-form__header">
      <svg
        class="login-form__avatar"
        width="109"
        height="109"
        viewBox="0 0 109 109"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <g filter="url(#filter0_d)">
          <circle cx="50" cy="50" r="50" fill="#F6F6F4" />
        </g>
        <path
          d="M50 0C22.4299 0 0 22.4299 0 50C0 77.5701 22.4299 100 50 100C77.5701 100 100 77.5701 100 50C100 22.4299 77.5701 0 50 0ZM50 94.1406C25.6607 94.1406 5.85938 74.3393 5.85938 50C5.85938 25.6607 25.6607 5.85938 50 5.85938C74.3393 5.85938 94.1406 25.6607 94.1406 50C94.1406 74.3393 74.3393 94.1406 50 94.1406Z"
          fill="#71631D"
        />
        <path
          d="M50 52.7344C61.308 52.7344 70.5078 43.5346 70.5078 32.2266C70.5078 20.9186 61.308 11.7188 50 11.7188C38.692 11.7188 29.4922 20.9186 29.4922 32.2266C29.4922 43.5346 38.692 52.7344 50 52.7344ZM50 17.5781C58.0771 17.5781 64.6484 24.1494 64.6484 32.2266C64.6484 40.3037 58.0771 46.875 50 46.875C41.9229 46.875 35.3516 40.3037 35.3516 32.2266C35.3516 24.1494 41.9229 17.5781 50 17.5781Z"
          fill="#71631D"
        />
        <path
          d="M82.9393 65.5162C79.0461 61.1168 73.4471 58.5938 67.5782 58.5938H32.4219C26.553 58.5938 20.954 61.1168 17.0608 65.5162L15.6721 67.0855L16.7084 68.9068C23.5086 80.8574 36.2653 88.2812 50 88.2812C63.7348 88.2812 76.4915 80.8574 83.2918 68.9066L84.3282 67.0854L82.9393 65.5162ZM50 82.4219C39.1141 82.4219 28.953 76.9146 22.9721 67.9111C25.5995 65.6939 28.9446 64.4531 32.4219 64.4531H67.5782C71.0555 64.4531 74.4006 65.6939 77.028 67.9111C71.0471 76.9146 60.886 82.4219 50 82.4219Z"
          fill="#71631D"
        />
        <defs>
          <filter
            id="filter0_d"
            x="0"
            y="0"
            width="109"
            height="109"
            filterUnits="userSpaceOnUse"
            color-interpolation-filters="sRGB"
          >
            <feFlood flood-opacity="0" result="BackgroundImageFix" />
            <feColorMatrix
              in="SourceAlpha"
              type="matrix"
              values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
              result="hardAlpha"
            />
            <feOffset dx="5" dy="5" />
            <feGaussianBlur stdDeviation="2" />
            <feComposite in2="hardAlpha" operator="out" />
            <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0" />
            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow" />
            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow" result="shape" />
          </filter>
        </defs>
      </svg>
    </header>

    <main class="login-form__main">
      <Input
        v-for="(input, index) in getInputs"
        :key="input.name + index"
        class="login-form__margin"
        :input="input"
        :value="inputValues[index]"
        @updated-input="onInput(index, $event)"
      >
        {{ input.placeholder }}
      </Input>
    </main>

    <footer class="login-form__footer">
      <button type="submit" class="login-form__submit" @click.prevent="onSubmit" :disabled="!formIsValid">Войти</button>
    </footer>
  </form>
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component';
import Input from '@/vue/components/authModal/input/Input.vue';
import { TInput, TUser } from '@/types';
import { Emit, Inject, InjectReactive } from 'vue-property-decorator';
import { TLoginData } from '@/types/TLoginData';
import findBy from '@/helpers/findBy';
import SecurityApi from '@/api/SecurityApi';

const inputs: TInput[] = [
  {
    type: 'email',
    name: 'email',
    placeholder: 'Логин',
    pattern: /^[a-z]+.+@[a-z]{2,}.[a-z]{2,}$/i,
    defaultValue: '',
  },
  {
    type: 'password',
    name: 'password',
    placeholder: 'Пароль',
    pattern: /^(\D+.{5,})|(.{5,}\D+)|(.{3,}\D+.{2,})|(.{2,}\D+.{3,})&/i,
    defaultValue: '',
  },
];

@Options({
  name: 'LoginForm',
  components: { Input },
})
export default class LoginForm extends Vue {
  @Inject()
  setUser!: (user: TUser) => void;

  inputValues = inputs.map(({ defaultValue }: TInput) => defaultValue);

  @Emit('closeModal') closeModal(): void {
    return void 0;
  }

  get getInputs(): TInput[] {
    return inputs;
  }

  onInput(index: number, newValue: string): void {
    this.inputValues[index] = newValue;
  }

  async onSubmit(): Promise<void> {
    if (!this.formIsValid) return;

    const formData: TLoginData = {
      email: this.inputValues[inputs.findIndex(findBy('name', 'email'))],
      password: this.inputValues[inputs.findIndex(findBy('name', 'password'))],
    };

    const {
      data: { user },
    } = await SecurityApi.login(formData);

    if (user) {
      this.setUser(user);
      this.closeModal();
    }
  }

  get formIsValid(): boolean {
    return inputs.reduce((total: boolean, input: TInput, index: number) => {
      return total && input.pattern.test(this.inputValues[index]);
    }, true);
  }

  clearForm(): void {
    this.inputValues = inputs.map(({ defaultValue }: TInput) => defaultValue);
  }
}
</script>

<style lang="scss" scoped>
@import '/assets/css/media';
.login-form {
  padding: 15px;
  //background-color: #f3da6b;
  border-radius: 0 0 5px 5px;
  max-height: 80vh;
  overflow-y: auto;

  &__header {
    margin-bottom: 40px;
  }

  &__margin {
    margin-bottom: 20px;
  }

  &__header,
  &__footer {
    display: flex;
    justify-content: center;
  }

  &__submit {
    padding: 11px 40px;
    background-color: rgba(157, 161, 87, 0.72);
    box-shadow: 0 0 4px rgba(0, 0, 0, 0.25);
    border-radius: 5px;
    color: var(--color-dark-green);
    cursor: pointer;

    &:hover {
      box-shadow: 0 0 100px #fff;
    }

    &:disabled {
      color: #989898;
      background-color: #f1f1ef;
      box-shadow: none;
      cursor: default;
    }
  }
}

@include media(sm) {
  .login-form {
    padding: 45px 104px;
  }
}
@include media(lg) {
}
</style>
