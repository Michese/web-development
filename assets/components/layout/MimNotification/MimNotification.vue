<template>
<section class="mim-notification position-fixed">
  <mim-message v-for="(notification, index) in notifications" :key="`notification_${index}`" :message="notification" />
</section>
</template>

<script>
import MimMessage from "./MimMessage/MimMessage";
import {notificationSymbol} from "../../../store";

export default {
  name: "MimNotification",
  inject: {
    stateNotification: {
      from: notificationSymbol,
    }
  },
  components: { MimMessage },
  computed: {
    notifications() {
      return this.stateNotification.state.notifications;
    },
  },
}
</script>

<style lang="scss" scoped>
.mim-notification {
  width: 500px;
  right: 0;
  bottom: 0;
  z-index: 10;
}
</style>