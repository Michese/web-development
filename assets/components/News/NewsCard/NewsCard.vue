<template>
  <div class="card mb-3 card_custom">
    <div class="card-body">
      <img :src="newItem.image" alt="" />
      <h5 class="card-title">{{ newItem.title }}</h5>
      <h6 class="card-subtitle mb-2 text-muted">{{ newItem.description }}</h6>
      <p class="card-text">{{ newItem.text }}</p>
      <router-link :to="{ name: 'New', params: { newId: newItem.id } }" class="card-link">Перейти</router-link>
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
  },
}
</script>

<style lang="scss" scoped>
.card {
  &_custom {
    border: 3px solid var(--custom-blue);
    border-right-width: 50px;
    transition: box-shadow linear 0.1s;

    &:hover {
      box-shadow: 0 0 5px black;
    }
  }
}
</style>