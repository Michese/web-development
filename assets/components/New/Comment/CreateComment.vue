<template>
  <form class="d-flex" action="#" method="post" @submit.prevent="onSubmit">
    <textarea class="form-control me-2 create-comment__textarea" v-model="text" rows="2" placeholder="Введите комментарий" />
    <input type="submit" value="Отправить" class="create-comment__btn btn bg-custom-blue text-white" />
  </form>
</template>

<script>
import NewsApi from "../../../api/NewsApi";

export default {
  name: "CreateComment",
  emits: ['fetch-new'],
  props: {
    newId: {
      type: String,
      required: true,
    }
  },
  data: () => ({
    text: '',
  }),
  methods: {
    async onSubmit() {
      if (this.text.trim()) {
        const { data: { result } } = await NewsApi.createComment(this.newId, {
          text: this.text,
        })

        if (result > 0) {
          this.text = '';
          this.$emit('fetch-new');
        }
      }
    }
  }
}
</script>

<style lang="scss" scoped>
.create-comment {
  &__textarea {
    max-height: 200px;
    resize: none;
    &:focus {
      box-shadow: 0 0 3px var(--custom-blue);
    }
  }

  &__btn {
    &:hover {
      box-shadow: 0 0 10px var(--custom-blue);
    }
  }
}
</style>