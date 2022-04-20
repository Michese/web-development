<template>
  <div class="container d-flex flex-column align-items-center">
    <h1 class="text-center mb-3">Авторизация</h1>
    <form action="#" method="post" class="user-login__form d-flex flex-column align-items-center" @submit.prevent="onSubmit">
      <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">@</span>
        <input v-model="username" type="email" name="username" class="form-control" placeholder="Электронная почта" aria-label="email" aria-describedby="email">
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
  name: "UserLogin",
  inject: {
    stateUser: {
      from: userSymbol,
    }
  },
  data: () => ({
    username: '',
    password: '',
  }),
  watch: {
    user: {
      immediate: true,
      handler() {
        if (this.user) this.$router.push({ name: 'Home' });
      }
    }
  },
  methods: {
    async onSubmit() {
      await this.stateUser.loginUser({
        username: this.username,
        password: this.password,
      })
    }
  },
  computed: {
    user() {
      return this.stateUser.state.user;
    }
  }
}
</script>

<style lang="scss" scoped>
.user-login {
  &__form {
    width: 400px;
  }
}
</style>