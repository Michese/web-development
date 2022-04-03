<template>
  <div class="container">
    <div v-if="isLoading" class="spinner-container">
      <mim-spinner/>
    </div>
    <h2 v-else-if="!newItem">Такой новости не существует!</h2>
    <div v-else class="card text-center mt-2 mb-2">
      <div class="card-header d-flex justify-content-between bg-custom-blue text-white">
        <span>{{ createdAt }}</span>
        <span>Количество просмотров: {{ this.newItem.views }}</span>
      </div>
      <div class="card-body">
        <h3 class="card-title">{{ this.newItem.title }}</h3>
        <h5 class="card-title">{{ this.newItem.description }}</h5>
        <p class="card-text" v-html="this.newItem.text"/>
      </div>
      <div class="card-footer text-muted">
        {{ this.newItem.admin_name }}
      </div>
    </div>
    <div v-if="newItem" class="comments d-flex flex-column w-100">
      <comment v-for="(comment, index) in comments" :key="`comment_${index}`" :item="comment"/>
    </div>
  </div>
</template>

<script>
import Comment from "./Comment/Comment";
import {MimSpinner} from "../../ui";
import NewsApi from "../../api/NewsApi";

export default {
  name: "New",
  components: {Comment, MimSpinner},
  data: () => ({
    newItem: null,
    comments: [],
    isLoading: true,
  }),
  props: {
    newId: {
      type: String,
      required: true,
    }
  },
  async created() {
    const {newItem, comments} = (await NewsApi.getNew(this.newId).finally(() => {
      this.isLoading = false;
      return {newItem: null, comments: []}
    }));
    this.newItem = newItem;
    this.comments = comments;
    console.log('newItem', this.newItem);
    console.log('comments', this.comments);
    console.log('user', this.user);
  },
  computed: {
    createdAt() {
      return this.newItem ? new Date(this.newItem.created_at.date).toLocaleString() : '';
    }
  },
  inject: ['user'],
}
</script>

<style lang="scss" scoped>
.spinner-container {
  height: 300px;
}
</style>