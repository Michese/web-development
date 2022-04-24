<template>
  <div class="toast show w-100" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <strong class="me-auto">{{ message.caption }}</strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close" />
    </div>
    <div class="toast-body">
      {{ message.text }}
    </div>
  </div>
</template>

<script>
export default {
  name: "MimMessage",
  props: {
    message: {
      type: Object,
      required: true,
    }
  },
}
</script>

<style scoped>

</style>