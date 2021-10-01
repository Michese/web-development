<template>
  <h1>Hello, world!</h1>
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component';

@Options({
  name: 'App',
})
export default class App extends Vue {
  created(): void {
    console.log('Hello');
  }
}
</script>

<style scoped>
body {
  background-color: red;
}
</style>
