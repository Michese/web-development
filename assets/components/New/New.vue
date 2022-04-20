<template>
  <div class="container">
    <div v-if="isLoading" class="spinner-container">
      <mim-spinner/>
    </div>
    <h2 v-else-if="!newItem">Такой новости не существует!</h2>
    <template v-else>
      <div class="card text-center mt-2 mb-2">
        <div class="card-header d-flex justify-content-between bg-custom-blue text-white">
          <span>{{ createdAt }}</span>
          <span>Количество просмотров: {{ this.newItem.views }}</span>
        </div>
        <div class="card-body">
          <h3 class="card-title">{{ this.newItem.title }}</h3>
          <h5 class="card-title">{{ this.newItem.description }}</h5>
          <p class="card-text text-start" v-html="this.newItem.text"/>
        </div>
        <div class="card-footer text-muted text-end">
          {{ adminFullName  }}
        </div>
      </div>
      <div v-if="newItem" class="comments d-flex flex-column w-100 mb-3">
        <comment v-for="(comment, index) in comments" :key="`comment_${index}`" :item="comment" :new-id="newId" @fetch-new="fetchNew" />
        <create-comment @fetch-new="fetchNew" :new-id="newId" />
      </div>
    </template>

  </div>
</template>

<script>
import Comment from "./Comment/Comment";
import {MimSpinner} from "../../ui";
import NewsApi from "../../api/NewsApi";
import { userSymbol } from '@/store';
import CreateComment from "./Comment/CreateComment";

export default {
  name: "New",
  components: {Comment, MimSpinner, CreateComment},
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
  inject: {
    stateUser: {
      from: userSymbol,
    }
  },
  created() {
    this.fetchNew();
  },
  computed: {
    createdAt() {
      return this.newItem ? new Date(this.newItem.createdAt).toLocaleString() : '';
    },
    adminFullName() {
      return `${this.newItem.admin.firstName} ${this.newItem.admin.lastName}`;
    }
  },
  methods: {
    async fetchNew() {
      this.isLoading = true;
      NewsApi.getNew(this.newId).then(({newItem, comments}) => {
        if (newItem && comments) {
          this.newItem = newItem;
          this.comments = comments;
        }
      }).finally(() => {
        this.isLoading = false;
      });
    },
  }
}
</script>

<style lang="scss" scoped>
.spinner-container {
  height: 300px;
}
</style>