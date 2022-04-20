<template>
<div class="container">
  <h1 class="text-center mb-3">Добавление новой новости</h1>
  <form action="#" method="post" class="user-login__form d-flex flex-column align-items-center mb-4" @submit.prevent="onSubmit">
    <div class="input-group mb-3 w-50">
      <input v-model="title" type="text" name="username" class="form-control" placeholder="Название" aria-label="email" aria-describedby="email">
    </div>

    <div class="input-group mb-3 w-50">
      <textarea v-model="description" name="description" class="form-control" placeholder="Описание" aria-label="description" aria-describedby="description" rows="5" />
    </div>

    <div class="input-group mb-3 w-50">
      <textarea v-model="text" name="text" class="form-control" placeholder="Текст" aria-label="text" aria-describedby="text" rows="20" />
    </div>

    <input type="submit" value="Добавить" class="btn btn-primary">
  </form>
</div>
</template>

<script>
import {userSymbol} from "../../store";
import NewsApi from "../../api/NewsApi";

export default {
  name: "CreateNew",
  inject: {
    stateUser: {
      from: userSymbol,
    }
  },
  watch: {
    user: {
      immediate: true,
      handler() {
        if (!this.user || !this.user.roles.includes("ROLE_ADMIN")) this.$router.push({ name: 'Home' });

      }
    }
  },
  data: () => ({
    title: '',
    description: '',
    text: '',
  }),
  computed: {
    user() {
      return this.stateUser.state.user;
    },
  },
  methods: {
    async onSubmit() {
      const { data: { result } } = await NewsApi.createNew({
        title: this.title,
        description: this.description,
        text: this.text,
      })

      console.log('response', result);

      if (result) await this.$router.push({ name: 'New', params: { newId: result } });
    },
  },
}
</script>

<style scoped>

</style>