<script>

import RandomCafeButton from "@/components/RandomCafeButton.vue";
import CafeComponent from "@/components/CafeComponent.vue";
import axios from "axios";

const host = 'http://193.32.203.137:7000'

export default {

  name: "Cafes-Component",
  components: {CafeComponent, RandomCafeButton},

  data() {
    return {
      cafes: [],
    }
  },
  mounted: async function () {
    try {
      //получаем от бэкенда список кафе
      const cafes = (JSON.parse((await axios.get(`${host}/api/default/get-cafes`))
          .data)).data
      //получаем от бэкенда количество отзывов
      const commentsCountMap = new Map();
      ((await axios.get(`${host}/api/default/get-feedbacks-count`)).data).forEach((v) => {
        commentsCountMap.set(v.id_cafe, v.count)
      })
      //добавляем к объектам "кафе" нужные поля "отображать" и "количество отзывов"
      cafes.forEach(e => {
        e['show'] = true;
        e['feedbacksCount'] = commentsCountMap.get(e.id) || 0
      })
      this.cafes.push(...cafes)
    } catch (e) {
      console.log(JSON.stringify(e))
    }
  },


  methods: {
    async getFeedbacks(id) {

      try {
        return (await axios.get(`${host}/api/default/get-feedbacks-by-id?id=${id}`)).data

      } catch (e) {
        console.log(JSON.stringify(e))
      }
    },
    async saveFeedback(feedback) {
      try {
        (await axios.post(`${host}/api/default/save-feedback`, feedback, {
          headers: {
            'content-type': 'multipart/form-data'
          }
        }))
      } catch (e) {
        console.log(e)
      }

    },
    randomCafe() {
      const id = Math.round(Math.random() * (this.cafes.length - 1))
      this.cafes.map((v, i) => {
        i != id ? v.show = false : v.show = true
      })

    },
  }
}

</script>

<template>
  <div class=".tc-cafes-wrapper">
    <div class="tc-cafes">
      <random-cafe-button @click="randomCafe"/>
      <cafe-component v-for="(cafe, index) in cafes" :key="index" :cafe="cafe"/>
    </div>
  </div>
</template>

<style lang="scss" scoped>
.tc-cafes-wrapper {
}

</style>