<template>
  <button type="button" class="auth-modal__btn" @click="openModal">
    <slot></slot>
  </button>

  <teleport to="body">
    <transition name="modal">
      <div v-if="isOpen" v-bodyoverflow class="auth-modal" @click.self="closeModal">
        <section class="auth-modal__inner">
          <header class="auth-modal__header">
            <input v-model="view" type="radio" value="LoginForm" id="login" class="auth-modal__radio" />
            <label for="login" class="auth-modal__label auth-modal__label_type_login"><span>Вход</span></label>
            <input v-model="view" type="radio" value="RegisterForm" id="register" class="auth-modal__radio" />
            <label for="register" class="auth-modal__label auth-modal__label_type_register">
              <span>Регистрация</span>
            </label>
          </header>
          <transition name="auth-toggle" mode="out-in">
            <component :is="view"></component>
          </transition>
        </section>
      </div>
    </transition>
  </teleport>
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component';
import LoginForm from '@/vue/components/authModal/loginForm/LoginForm.vue';
import RegisterForm from '@/vue/components/authModal/registerForm/RegisterForm.vue';

@Options({
  name: 'AuthModal',
  components: { LoginForm, RegisterForm },
})
export default class AuthModal extends Vue {
  isOpen = false;
  view = 'LoginForm';

  openModal(): void {
    this.isOpen = true;
  }

  closeModal(): void {
    this.isOpen = false;
  }
}
</script>

<style lang="scss" scoped>
@import '/assets/css/media';
.auth-modal {
  position: fixed;
  top: 0;
  right: 0;
  left: 0;
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 100;
  background-color: rgba(#3b3b3b, 0.8);

  &__btn {
    cursor: pointer;
  }

  &__inner {
    height: 550px;
    margin: 10px;
    border-radius: 5px;
  }

  &__header {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-template-rows: 56px;
  }

  &__radio {
    display: none;
  }

  &__label {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    cursor: pointer;

    &_type {
      &_login {
        box-shadow: inset -3px -3px 5px;
        background-color: #f3da6b;
        border-radius: 5px 0 0 0;
      }

      &_register {
        box-shadow: inset 3px -3px 5px;
        background-color: #c4c970;
        border-radius: 0 5px 0 0;
      }
    }
  }

  &__radio:checked + &__label {
    text-shadow: 0 4px 4px rgba(0, 0, 0, 0.25);

    &_type {
      &_login {
        box-shadow: none;
      }

      &_register {
        box-shadow: none;
      }
    }
  }
}

@include media(sm) {
  .auth-modal {
    &__inner {
      width: 500px;
    }
  }
}
@include media(lg) {}
</style>
