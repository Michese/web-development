<template>
  <section class="container">
    <div v-if="isLoading" class="spinner-container">
      <mim-spinner/>
    </div>
    <div v-else class="news">
      <div id="carouselExampleControls" class="news__carousel carousel slide mt-2 mb-2" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="./images/1.jpg" class="carousel__image d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="./images/1.jpg" class="carousel__image d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="./images/1.jpg" class="carousel__image d-block w-100" alt="...">
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>

      <div class="cards d-grid">
        <news-card v-for="(newItem, index) in news" :key="`new_${index}`" :new-item="newItem"/>
      </div>
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
  }
}
</script>

<style lang="scss" scoped>
.spinner-container {
  height: 300px;
}

//.news {
//  &__carousel {
//    max-height: 400px;
//  }
//}

.carousel {
  &__image {
    max-height: 600px;
  }
}

.cards {
  margin-top: 20px;
  grid-template-columns: repeat(3, 1fr);
  grid-gap: 20px;
}
</style>