<script>

export default {
  name: "RandomCafeButton",
  methods: {
  }
}
</script>

<template>
   <button @click="randomCafe" class="random-cafe-btn">
     Выбрать случайное кафе
   </button>
</template>

<style lang="scss" scoped>
.random-cafe-btn{
  font-size: 16px;
  display: block;

  margin-left: auto;
  margin-right: auto;
  width: 10em;
}


</style>