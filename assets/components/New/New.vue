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
              <router-link :to="{ name: 'EditNew', params: { newId } }" class="ms-4">
                <svg fill="#fff" height="25px" width="25px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 490 490">
                  <path d="M486.945,142.045L347.906,2.934c-3.911-3.912-10.836-3.912-14.746,0L72.455,263.764c-1.209,1.21-2.051,2.645-2.542,4.168
	c-0.001-0.001-0.002-0.002-0.004-0.003L0.415,476.504c-1.75,6.382,1.926,15.232,13.189,13.2l208.473-69.523
	c-0.002-0.003-0.003-0.005-0.005-0.008c1.557-0.503,2.99-1.365,4.169-2.544l260.705-260.83
	C491.018,152.723,491.018,146.121,486.945,142.045z M421.372,105.952L175.417,352.026l-37.394-37.414L383.977,68.539
	L421.372,105.952z M340.533,25.064l28.703,28.717L123.277,299.859l-28.703-28.718L340.533,25.064z M26.791,463.31l57.59-172.851
	l115.178,115.234L26.791,463.31z M218.868,395.499l-28.706-28.72l245.958-246.077l28.705,28.72L218.868,395.499z"/>
                </svg>
              </router-link>
              <button class="ms-2 bg-transparent border-0 text-white" @click="deleteNew">
                <svg width="25" height="25" viewBox="0 0 15 15" fill="#fff" xmlns="http://www.w3.org/2000/svg">
                  <path d="M10.4999 15H4.4249C3.1874 15 2.2124 13.9875 2.2124 12.7875V6C2.2124 5.775 2.3624 5.625 2.5874 5.625C2.8124 5.625 2.9624 5.775 2.9624 6V12.7875C2.9624 13.6125 3.6374 14.25 4.4249 14.25H10.4999C11.3249 14.25 11.9624 13.575 11.9624 12.7875V6C11.9624 5.775 12.1124 5.625 12.3374 5.625C12.5624 5.625 12.7124 5.775 12.7124 6V12.7875C12.7124 13.9875 11.6999 15 10.4999 15Z" />
                  <path d="M12.4874 1.8375H9.6374C9.4499 0.7875 8.5499 0 7.4624 0C6.3749 0 5.4749 0.7875 5.2874 1.8375H2.4374C1.5749 1.8375 0.899902 2.5125 0.899902 3.375C0.899902 4.2375 1.5749 4.875 2.4374 4.875H12.5249C13.3874 4.875 14.0624 4.2 14.0624 3.3375C14.0624 2.475 13.3499 1.8375 12.4874 1.8375ZM7.4624 0.75C8.1374 0.75 8.6999 1.2 8.8499 1.8375H6.0374C6.2249 1.2 6.7874 0.75 7.4624 0.75ZM12.4874 4.125H2.4374C2.0249 4.125 1.6499 3.7875 1.6499 3.3375C1.6499 2.925 1.9874 2.55 2.4374 2.55H12.5249C12.9374 2.55 13.3124 2.8875 13.3124 3.3375C13.2749 3.7875 12.9374 4.125 12.4874 4.125Z" />
                  <path d="M4.8374 13.1629C4.6124 13.1629 4.4624 13.0129 4.4624 12.7879V6.52539C4.4624 6.30039 4.6124 6.15039 4.8374 6.15039C5.0624 6.15039 5.2124 6.30039 5.2124 6.52539V12.7879C5.2124 12.9754 5.0249 13.1629 4.8374 13.1629Z" />
                  <path d="M10.0874 13.1629C9.8624 13.1629 9.7124 13.0129 9.7124 12.7879V6.52539C9.7124 6.30039 9.8624 6.15039 10.0874 6.15039C10.3124 6.15039 10.4624 6.30039 10.4624 6.52539V12.7879C10.4624 12.9754 10.2749 13.1629 10.0874 13.1629Z" />
                  <path d="M7.4624 13.1629C7.2374 13.1629 7.0874 13.0129 7.0874 12.7879V6.52539C7.0874 6.30039 7.2374 6.15039 7.4624 6.15039C7.6874 6.15039 7.8374 6.30039 7.8374 6.52539V12.7879C7.8374 12.9754 7.6499 13.1629 7.4624 13.1629Z" />
                </svg>
              </button>
            </template>
          </div>
        </div>
        <div class="card-body d-flex flex-column align-items-center">
          <img :src="newItem.image" alt="" class="card__image" />

          <h3 class="card-title">{{ newItem.title }}</h3>
          <h5 class="card-title">{{ newItem.description }}</h5>
          <p class="card-text align-items-start text-start" v-html="itemText"/>
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
import {userSymbol} from '../../store/user';
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
    },
    itemText() {
      return this.newItem?.text.replaceAll('\n', '<br />') ?? ''
    }
  },
  methods: {
    async fetchNew() {
      this.isLoading = true;
      NewsApi.getNew(this.newId).then(({newItem, comments}) => {
        if (newItem && comments) {
          this.newItem = newItem;
          this.comments = comments;
          console.log('text', this.newItem.text.replaceAll('\n', ''));
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