<template>
  <ul class="pagination">
    <li class="page-item" >
      <button class="me-2 mt-3 not-full page-link" @click="changePage(page - 1)" :disabled="+page === 1">
        Назад
      </button>
    </li>
    <li class="page-item" :class="{ active: +item === +page }" v-for="(item, index) in items">
      <button
          class="paginator__link me-2 mt-3 not-full page-link"
          :key="`button_${index}`"
          @click="changePage(item)"
          :disabled="item === sprite || +item === +page"
      >{{ item }}</button
      >
    </li>
    <li class="page-item">
      <button class="me-2 mt-3 not-full page-link" @click="changePage(page + 1)" :disabled="+page === totalPages"
      >Далее</button
      >
    </li>
  </ul>
</template>

<script>
export default {
  name: 'Paginator',
  emits: ['change-page'],
  props: {
    page: {
      type: String,
      required: true,
    },
    totalCount: {
      type: Number,
      required: true,
    },
    limit: {
      type: Number,
      required: true,
    },
  },
  methods: {
    changePage(page) {
      this.$emit('change-page', page);
    },
  },
  computed: {
    totalPages() {
      return Math.ceil(this.totalCount / this.limit);
    },
    items() {
      let items = [];

      if (this.totalPages <= 6) {
        for (let i = 1; this.totalPages >= i; i++) {
          items.push(i);
        }
      } else if (this.page < 3) {
        items = [1, 2, 3, this.sprite, this.totalPages];
      } else if (this.page < this.totalPages - 2) {
        items = [
          1,
          this.page - 3 >= 2 ? this.sprite : false,
          this.page - 2,
          this.page - 1,
          this.page,
          this.page + 1,
          this.page + 2,
          this.page + 3 <= this.totalPages - 1 ? this.sprite : false,
          this.totalPages,
        ];
      } else {
        items = [1, this.sprite, this.totalPages - 2, this.totalPages - 1, this.totalPages];
      }

      return items.filter(item => !!item);
    },
    sprite() {
      return '...';
    },
  },
};
</script>

<style lang="scss" scoped>
//.paginator {
//  &__link {
//    &:disabled {
//      &:hover {
//        background-color: transparent;
//      }
//    }
//  }
//}

.pagination-container {
  display: flex;
  justify-content: flex-end;
}
</style>
