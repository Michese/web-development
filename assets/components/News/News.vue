<template>
  <section class="container">
    <div v-if="isLoading" class="spinner-container">
      <mim-spinner/>
    </div>
    <div v-else class="cards row row-cols-4 justify-content-around">
      <news-card v-for="(newItem, index) in news" :key="`new_${index}`" :new-item="newItem"/>
    </div>
  </section>
</template>

<script>
import NewsCard from "./NewsCard/NewsCard";
import NewsApi from "../../api/NewsApi";
import {MimSpinner} from "../../ui";

export default {
  name: "News",
  components: {MimSpinner, NewsCard},
  data: () => ({
    isLoading: true,
    news: [],
  }),
  async created() {
    this.news = (await NewsApi.getNews().finally(() => {
      this.isLoading = false;
      return {news: []};
    })).news;
    console.log('news', this.news);
  }
}
</script>

<style scoped>
.spinner-container {
  height: 300px;
}

.cards {
  margin-top: 20px;
}
</style>