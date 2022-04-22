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
          <div class="card__items">
            <span>Количество просмотров: {{ this.newItem.views }}</span>
            <template v-if="isAdmin">
              <router-link :to="{ name: 'EditNew', params: { newId } }" class="ms-2">
                <svg height="25px" width="25px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 490 490">
                  <path d="M486.945,142.045L347.906,2.934c-3.911-3.912-10.836-3.912-14.746,0L72.455,263.764c-1.209,1.21-2.051,2.645-2.542,4.168
	c-0.001-0.001-0.002-0.002-0.004-0.003L0.415,476.504c-1.75,6.382,1.926,15.232,13.189,13.2l208.473-69.523
	c-0.002-0.003-0.003-0.005-0.005-0.008c1.557-0.503,2.99-1.365,4.169-2.544l260.705-260.83
	C491.018,152.723,491.018,146.121,486.945,142.045z M421.372,105.952L175.417,352.026l-37.394-37.414L383.977,68.539
	L421.372,105.952z M340.533,25.064l28.703,28.717L123.277,299.859l-28.703-28.718L340.533,25.064z M26.791,463.31l57.59-172.851
	l115.178,115.234L26.791,463.31z M218.868,395.499l-28.706-28.72l245.958-246.077l28.705,28.72L218.868,395.499z"/>
                </svg>
              </router-link>
              <button class="ms-2" @click="deleteNew">
                <svg fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="25px" height="25px">
                  <path
                      d="M 10 2 L 9 3 L 4 3 L 4 5 L 20 5 L 20 3 L 15 3 L 14 2 L 10 2 z M 5 7 L 5 22 L 19 22 L 19 7 L 5 7 z M 8 9 L 10 9 L 10 20 L 8 20 L 8 9 z M 14 9 L 16 9 L 16 20 L 14 20 L 14 9 z"/>
                </svg>
              </button>
            </template>
          </div>
        </div>
        <div class="card-body d-flex flex-column align-items-center">
          <img :src="newItem.image" alt="" class="card__image" />

          <h3 class="card-title">{{ newItem.title }}</h3>
          <h5 class="card-title">{{ newItem.description }}</h5>
          <p class="card-text align-items-start text-start" v-html="newItem.text"/>
        </div>
        <div class="card-footer text-muted text-end">
          {{ adminFullName }}
        </div>
      </div>
      <div v-if="newItem" class="comments d-flex flex-column w-100 mb-3">
        <comment v-for="(comment, index) in comments" :key="`comment_${index}`" :item="comment" :new-id="newId"
                 @fetch-new="fetchNew"/>
        <create-comment v-if="user" @fetch-new="fetchNew" :new-id="newId"/>
      </div>
    </template>

  </div>
</template>

<script>
import Comment from "./Comment/Comment";
import {MimSpinner} from "../../ui";
import NewsApi from "../../api/NewsApi";
import {userSymbol} from '@/store';
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
    },
    user() {
      return this.stateUser.state.user;
    },
    isAdmin() {
      return this.user?.roles?.includes('ROLE_ADMIN') ?? false;
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

    async deleteNew() {
      const { result } = await NewsApi.deleteNew(this.newId);

      if (result) await this.$router.push({ name: 'Home' });
    }
  }
}
</script>

<style lang="scss" scoped>
.spinner-container {
  height: 300px;
}

.card {
  &__image {
    max-width: 100%;
    min-height: 200px;
    max-height: 500px;
  }
}
</style>