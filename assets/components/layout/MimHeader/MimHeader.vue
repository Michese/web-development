<template>
  <header class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
<!--        <router-link class="navbar-brand" to="/">Новости</router-link>-->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <router-link class="nav-link" active-class="active" to="/">Новости</router-link>
<!--              <a class="nav-link active" aria-current="page" href="#">Home</a>-->
            </li>
            <li class="nav-item">
              <router-link class="nav-link" active-class="active" to="/news/create">Добавить новость</router-link>
            </li>
          </ul>
          <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              {{ helloMessage }}
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <template v-if="user">
                <!--                <li><router-link class="dropdown-item" to="/user/login">Личный кабинет</router-link></li>-->
                <li><button class="dropdown-item" @click="logout">Выйти</button></li>
              </template>
              <template v-else>
                <li><router-link class="dropdown-item" to="/user/login">Авторизоваться</router-link></li>
                <li><router-link class="dropdown-item" to="/user/register">Зарегистрироваться</router-link></li>
              </template>
            </ul>
          </div>
        </div>
      </div>
    </nav>
  </header>
</template>

<script>
import UserApi from "../../../api/UserApi";

export default {
  name: "MimHeader",
  inject: ['user', 'getUser'],
  computed: {
    helloMessage() {
      return this.user ? `Добро пожаловать, ${this.user.first_name}!` : 'Авторизоваться';
    }
  },
  methods: {
    async logout() {
      await UserApi.logout();
      await this.getUser();
    }
  }
}
</script>

<style scoped>

</style>