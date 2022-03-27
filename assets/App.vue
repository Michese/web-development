<template>
<!--  <h2>Hello</h2>-->
  <mim-wrapper >
    <mim-header />
    <router-view />
<!--    <mim-main />-->
    <mim-footer />
  </mim-wrapper>
</template>

<script>
import MimHeader from "./components/layout/MimHeader/MimHeader";
import MimMain from "./components/layout/MimMain/MimMain";
import MimFooter from "./components/layout/MimFooter/MimFooter";
import MimWrapper from "./components/layout/MimWrapper/MimWrapper";

export default {
  name: "App",
  components: { MimWrapper, MimHeader, MimMain, MimFooter },
}
</script>

<style scoped>

</style>