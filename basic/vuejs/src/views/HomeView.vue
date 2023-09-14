<template>
  <div class="home">
<!--    <img alt="Vue logo" src="../assets/logo.png">-->
    <cafes-component/>
  </div>
</template>

<script>
// @ is an alias to /src

import CafesComponent from "@/components/CafesComponent.vue";

export default {
  name: 'HomeView',
  components: {CafesComponent},
}
</script>

<style>
.home {
  //background-color: black;

}

</style>
