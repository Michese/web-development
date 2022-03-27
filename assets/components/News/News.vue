<template>
  <section class="container">
    <mim-spinner v-if="isLoading" />
    <div v-else class="cards row row-cols-4 ">
      <news-card v-for="(newItem, index) in news" :key="`new_${index}`" :new-item="newItem" />
    </div>
  </section>
</template>

<script>
import NewsCard from "./NewsCard/NewsCard";
import NewsApi from "../../api/NewsApi";
import { MimSpinner } from "../../ui";
export default {
  name: "News",
  components: {MimSpinner, NewsCard },
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
.cards {
  margin-top: 20px;
}
</style>