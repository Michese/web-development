<template>
  <div v-if="isLoading" class="container spinner-container">
    <mim-spinner />
  </div>
  <slot v-else />
</template>

<script>
import UserApi from "../../../api/UserApi";
import MimSpinner from "../../../ui/MimSpinner/MimSpinner";

export default {
  name: "MimWrapper",
  components: {MimSpinner},
  data: () => ({
    isLoading: true,
    user: null,
  }),
  async created() {
    await this.getUser();
  },
  methods: {
    async getUser() {
      this.isLoading = true;
      this.user = (await UserApi.getUser().finally(() => {
        this.isLoading = false;
        return {user: null};
      })).user
    }
  },
  provide() {
    return {
      user: this.user,
      getUser: this.getUser,
    }
  }
}
</script>

<style lang="scss" scoped>
.spinner-container {
  height: 300px;
}
</style>