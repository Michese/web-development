<template>
  <div class="card mb-1">
    <div class="card-header bg-custom-gray">
      <span class="card-header__name"><b>{{ item.first_name }}</b></span> <i>{{ createdAt }}</i>
    </div>
    <div class="card-body">
      <blockquote class="blockquote mb-0">
        <p v-html="item.text"/>
      </blockquote>
    </div>
  </div>
</template>

<script>
export default {
  name: "Comment",
  props: {
    item: {
      type: Object,
      required: true,
    },
  },
  created() {
    console.log('item', this.item);
  },
  computed: {
    createdAt() {
      return this.item?.createdAt?.date ? new Date(this.item.createdAt.date).toLocaleString() : '';
    }
  }
}
</script>

<style lang="scss" scoped>
.card {
  &-header_custom {
    background-color: var(--custom-blue);
  }

  &-header__name {
    font-size: 1.2em;
  }
}

</style>