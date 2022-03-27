<template>
  <div class="card offset-1 mb-3">
    <div class="card-body">
      <h5 class="card-title">{{ newItem.title }}</h5>
      <h6 class="card-subtitle mb-2 text-muted">{{ newItem.description }}</h6>
      <p class="card-text">{{ newItem.text }}</p>
      <router-link :to="`/news/${newItem.id}`" class="card-link">Перейти</router-link>
<!--      <a href="#" class="card-link">Another link</a>-->
    </div>
  </div>
</template>

<script>
export default {
  name: "NewsCard",
  props: {
    newItem: {
      type: Object,
      required: true,
    }
  }
}
</script>

<style scoped>
.card {
  /*width: 22em;*/
}
</style>