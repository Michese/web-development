<template>
  <div class="spinner">
    <div class="spinner-border text-custom-blue" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>
</template>

<script>
export default {
  name: "MimSpinner"
}
</script>

<style lang="scss" scoped>
.spinner {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  min-height: 100%;
  width: 100%;
}
</style>