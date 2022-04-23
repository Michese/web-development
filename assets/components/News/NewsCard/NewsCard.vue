<template>
  <article class="card mb-3 card_custom">
    <div class="card-body d-flex flex-column justify-content-between">
      <main>
        <img :src="newItem.image" alt="" class="card__image" />
        <h5 class="card-title text-custom-blue">{{ newItem.title }}</h5>
        <h6 class="card-subtitle mb-2 text-muted">{{ newItem.description }}</h6>
        <p class="card-text">{{ newItem.text }}</p>
      </main>
      <footer class="d-flex justify-content-between">
        <router-link :to="{ name: 'New', params: { newId: newItem.id } }" class="card-link">Перейти</router-link>
        <div class="card__settles">
          <span class="card__date">{{ createdAt }}</span>
          <span class="card__comments ms-2">{{ newItem.countComments }}</span>
        </div>
      </footer>
    </div>
  </article>
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
  computed: {
    createdAt() {
      return this.newItem.createdAt ? new Date(this.newItem.createdAt).toLocaleString() : '';
    }
  }
}
</script>

<style lang="scss" scoped>
.card {
  &_custom {
    border: 3px solid var(--custom-blue);
    //border-right-width: 50px;
    transition: box-shadow linear 0.1s;

    &:hover {
      box-shadow: 0 0 5px black;
    }
  }

  &__image {
    width: 100%;
    height: 255px;
  }
}
</style>