<template>
  <form class="register-form">
    <div class="register-form__inner">
      <header class="register-form__header">
        <img src="./assets/avatar.svg" alt="avatar" class="register-form__avatar" />
      </header>

      <main class="register-form__main">
        <Input
          v-for="(input, index) in getInputs"
          :key="input.name + index"
          class="register-form__margin"
          :input="input"
          :value="inputValues[index]"
          @updated-input="onInput(index, $event)"
        >
          {{ input.placeholder }}
        </Input>
      </main>
    </div>
    <footer class="register-form__footer">
      <label class="register-form__approval approval">
        <input type="checkbox" name="approval" v-model="approval" class="approval__checkbox" id="approval" />
        Согласие на обработку персональных данных
      </label>
      <button type="submit" class="register-form__submit" @click.prevent="onSubmit" :disabled="!formIsValid">
        Зарегистрироваться
      </button>
    </footer>
  </form>
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component';
import Input from '@/vue/components/authModal/input/Input.vue';
import { TInput, TRegisterData, TUser } from '@/types';
import findBy from '@/helpers/findBy';
import SecurityApi from '@/api/SecurityApi';
import { Inject } from 'vue-property-decorator';

const inputs: TInput[] = [
  {
    type: 'text',
    name: 'name',
    placeholder: 'Имя',
    pattern: /^[a-zа-яА-ЯёЁ]{4,}$/i,
    defaultValue: '',
  },
  {
    type: 'email',
    name: 'email',
    placeholder: 'e-mail',
    pattern: /^[a-z]+.+@[a-z]{2,}.[a-z]{2,}$/i,
    defaultValue: '',
  },
  {
    type: 'tel',
    name: 'phone',
    placeholder: 'Телефон',
    pattern: /^\d{11}$/i,
    defaultValue: '',
  },
  {
    type: 'password',
    name: 'password',
    placeholder: 'Пароль',
    pattern: /^(\D+.{5,})|(.{5,}\D+)|(.{3,}\D+.{2,})|(.{2,}\D+.{3,})&/i,
    defaultValue: '',
  },
  {
    type: 'password',
    name: 'repeatedPassword',
    placeholder: 'Повторите пароль',
    pattern: /^(\D+.{5,})|(.{5,}\D+)|(.{3,}\D+.{2,})|(.{2,}\D+.{3,})&/i,
    defaultValue: '',
  },
];

@Options({
  name: 'RegisterForm',
  components: { Input },
})
export default class RegisterForm extends Vue {
  @Inject()
  setUser!: (user: TUser) => void;

  inputValues = inputs.map(({ defaultValue }: TInput) => defaultValue);
  approval = false;

  get getInputs(): TInput[] {
    return inputs;
  }

  onInput(index: number, newValue: string): void {
    this.inputValues[index] = newValue;
  }

  async onSubmit(): Promise<void> {
    if (!this.formIsValid) return;

    console.log('onSubmit');
    const formData: TRegisterData = {
      name: this.inputValues[inputs.findIndex(findBy('name', 'name'))],
      email: this.inputValues[inputs.findIndex(findBy('name', 'email'))],
      phone: +this.inputValues[inputs.findIndex(findBy('name', 'phone'))],
      password: this.inputValues[inputs.findIndex(findBy('name', 'password'))],
    };

    const {
      data: { user },
    } = await SecurityApi.register(formData);
    console.log('setUser', this.setUser, user);
    if (user) this.setUser(user);
    // try {

      // console.log(result);
    // } catch (exp) {
    //   const result = await SecurityApi.logout();
    //   console.log('logout', result);
    // }

    // this.clearForm();
  }

  async created(): Promise<void> {
    // try {
    //   const result = await SecurityApi.logout();
    //   console.log('logout', result);
    // } catch (err) {
    //   console.log('err', err);
    // }

  }

  get formIsValid(): boolean {
    return (
      this.approval &&
      inputs.every((input: TInput, index: number) => {
        return input.pattern.test(this.inputValues[index]);
      })
    );
  }

  clearForm(): void {
    this.inputValues = inputs.map(({ defaultValue }: TInput) => defaultValue);
    this.approval = false;
  }
}
</script>

<style lang="scss" scoped>
@import '/assets/css/media';
.register-form {
  padding: 30px 15px 40px;
  border-radius: 0 0 5px 5px;
  max-height: 60vh;
  overflow-y: auto;

  &__header {
    display: flex;
    justify-content: center;
  }

  &__inner {
    display: grid;
    grid-template-columns: 1fr;
    text-align: center;
  }

  &__margin {
    margin-bottom: 10px;
  }

  &__main {
    margin-bottom: 20px;
  }

  &__approval {
    display: flex;
    align-items: center;
    margin-bottom: 40px;
  }

  &__footer {
    display: flex;
    flex-direction: column;
  }

  &__submit {
    padding: 10px;
    background-color: rgba(#f3da6ba6, 0.65);
    box-shadow: 0 0 4px rgba(0, 0, 0, 0.25);
    border-radius: 5px;
    font-size: 14px;
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

.approval {
  &__checkbox {
    margin-right: 15px;
  }
}

@include media(sm) {
  .register-form {
    padding: 40px 25px;

    &__header {
      justify-content: flex-start;
    }

    &__inner {
      grid-template-columns: 1fr 2fr;
      grid-column-gap: 35px;
    }

    &__submit {
      padding: 11px 40px;
      font-size: 18px;
    }
  }
}
@include media(lg) {
}
</style>
