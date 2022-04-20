<template>
  <div class="container d-flex flex-column align-items-center">
    <h1 class="text-center mb-3">Авторизация</h1>
    <form action="#" method="post" class="user-login__form d-flex flex-column align-items-center" @submit.prevent="onSubmit">
      <div class="input-group mb-3">
        <span class="input-group-text" id="email">@</span>
        <input v-model="email" type="email" name="username" class="form-control" placeholder="Электронная почта" aria-label="email" aria-describedby="email">
      </div>

      <div class="input-group mb-3">
        <input v-model="firstName" type="text" name="firstName" class="form-control" placeholder="Имя" aria-label="firstName" aria-describedby="firstName">
      </div>

      <div class="input-group mb-3">
        <input v-model="lastName" type="text" name="lastName" class="form-control" placeholder="Фамилия" aria-label="lastName" aria-describedby="lastName">
      </div>

      <div class="input-group mb-3">
        <input v-model="phone" type="tel" name="phone" class="form-control" placeholder="Номер телефона" aria-label="phone" aria-describedby="phone">
      </div>

      <div class="input-group mb-3">
        <input v-model="password" type="password" name="password" class="form-control" placeholder="Пароль" aria-label="password" aria-describedby="password">
      </div>

      <input type="submit" value="Войти" class="btn btn-primary">
    </form>
  </div>
</template>

<script>
import {userSymbol} from "../../../store";

export default {
  name: "UserRegister",
  data: () => ({
    email: '',
    firstName: '',
    lastName: '',
    phone: '',
    password: '',
  }),
  inject: {
    stateUser: {
      from: userSymbol,
    },
  },
  watch: {
    user: {
      immediate: true,
      handler() {
        if (this.user) this.$router.push({ name: 'Home' });
      }
    }
  },
  methods: {
    onSubmit() {
      this.stateUser.registerUser({
        email: this.email,
        firstName: this.firstName,
        lastName: this.lastName,
        phone: this.phone,
        password: this.password,
      });
    },
  },
  computed: {
    user() {
      return this.stateUser.state.user;
    },
  },
}
</script>

<style lang="scss" scoped>

</style>