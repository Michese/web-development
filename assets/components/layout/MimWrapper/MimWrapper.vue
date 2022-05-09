<template>
  <div v-if="isLoading" class="container spinner-container">
    <mim-spinner />
  </div>
  <slot v-else />
  <mim-notification />
</template>

<script>
import MimSpinner from "../../../ui/MimSpinner/MimSpinner";
import {userSymbol} from "../../../store/user";
import MimNotification from "../MimNotification/MimNotification";

export default {
  name: "MimWrapper",
  components: {MimNotification, MimSpinner},
  data: () => ({
    isLoading: true,
  }),
  inject: {
    stateUser: {
      from: userSymbol,
    }
  },
  async created() {
    await this.stateUser.fetchUser().finally(() => {
      this.isLoading = false;
    });
  },
}
</script>

<style lang="scss" scoped>
.spinner-container {
  height: 300px;
}
</style>