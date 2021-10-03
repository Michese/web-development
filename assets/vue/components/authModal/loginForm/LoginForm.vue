<template>
  <form class="login-form" @submit.prevent>
    <header class="login-form__header">
      <img src="./assets/avatar.svg" alt="avatar" class="login-form__avatar" />
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
import { TInput } from '@/types';
import { Emit } from 'vue-property-decorator';

const inputs: TInput[] = [
  {
    type: 'email',
    name: 'login',
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

  onSubmit(): void {
    if (!this.formIsValid) return;

    const data: any = {};

    inputs.forEach((input, index) => {
      data[input.name] = this.inputValues[index];
    });

    console.log(data);

    this.clearForm();
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
  background-color: #f3da6b;
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
