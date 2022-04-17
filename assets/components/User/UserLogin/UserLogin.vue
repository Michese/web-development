<template>
  <div class="container d-flex flex-column align-items-center">
    <h1 class="text-center mb-3">Авторизация</h1>
    <form action="#" method="post" class="user-login__form d-flex flex-column align-items-center" @submit.prevent="onSubmit">
      <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">@</span>
        <input type="email" name="email" class="form-control" placeholder="Электронная почта" aria-label="email" aria-describedby="email">
      </div>

      <div class="input-group mb-3">
        <input type="password" name="password" class="form-control" placeholder="Пароль" aria-label="password" aria-describedby="password">
      </div>

      <input type="submit" value="Войти" class="btn btn-primary">
    </form>
  </div>
</template>

<script>
import UserApi from "../../../api/UserApi";

export default {
  name: "UserLogin",
  methods: {
    async onSubmit({ target }) {
      const data = new FormData(target);
      const response = await UserApi.login({
        username: 'michese@mail.ru',
        password: 'qwer1234',
      });
      console.log('response', response);
    }
  },
  async created() {
    console.log(await UserApi.getUser());
  },
}
</script>

<style lang="scss" scoped>
.user-login {
  &__form {
    width: 400px;
  }
}
</style>