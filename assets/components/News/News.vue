<template>
  <section class="container">
    <div class="news">
      <div id="carouselExampleControls" class="news__carousel carousel slide mt-2 mb-2" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="./images/1.jpg" class="carousel__image d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="./images/2.jpg" class="carousel__image d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="./images/3.jpg" class="carousel__image d-block w-100" alt="...">
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

      <div v-if="isLoading" class="spinner-container">
        <mim-spinner/>
      </div>
      <div v-else class="cards d-grid">
        <news-card v-for="(newItem, index) in news" :key="`new_${index}`" :new-item="newItem"/>
      </div>
      <div v-if="totalCount >= 3" class="d-flex justify-content-center">
        <paginator :limit="3" :total-count="totalCount" :page="page" @change-page="changePage" />
      </div>
    </div>
  </section>
</template>

<script>
import NewsCard from "./NewsCard/NewsCard";
import NewsApi from "../../api/NewsApi";
import {MimSpinner} from "../../ui";
import Paginator from "./Paginator/Paginator";

export default {
  name: "News",
  components: {MimSpinner, NewsCard, Paginator},
  props: {
    page: {
      type: String,
      required: false,
      default: '1',
    }
  },
  watch: {
    page: {
      immediate: true,
      handler() {
        this.fetchNews().finally(() => {
          this.isLoading = false;
        });
      },
    }
  },
  data: () => ({
    isLoading: true,
    totalCount: 0,
    news: [],
  }),
  methods: {
    changePage(page) {
      this.isLoading = true;
      this.$router.push({ name: 'News', params: { page } })
    },
    async fetchNews() {
      const newItems = await NewsApi.getNews(this.page);
      if (newItems) {
        this.news = newItems['hydra:member'];
        this.totalCount = newItems['hydra:totalItems'];
      }
    }
  },
}
</script>

<style lang="scss" scoped>
.spinner-container {
  height: 300px;
}

.carousel {
  &__image {
    max-height: 600px;
    object-fit: cover;
  }
}

.cards {
  margin-top: 20px;
  grid-template-columns: repeat(3, 1fr);
  grid-gap: 20px;
}
</style>