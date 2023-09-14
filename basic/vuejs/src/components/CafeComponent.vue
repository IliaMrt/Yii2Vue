<script>

import CafesComponent from "@/components/CafesComponent.vue";

export default {
  name: "CafeComponent",

  data() {
    return {
      show: false,
      success_show: false,
      f: '',
      feedbacks: [],
      feedbackCount: 0,

    }
  },

  props: {
    "cafe": {
      required: true,
      type: Object
    },
  },

  mounted() {
    this.feedbackCount = this.cafe.feedbacksCount

    function moveCaretToStart(inputObject) {
      if (inputObject.textarea) {
        let r = inputObject.textarea();
        r.collapse(true);
        r.select();
      }
    }
  },

  methods: {

    toggle: async function () {
      if (!this.show)
        this.feedbacks =
            await CafesComponent.methods.getFeedbacks(this.cafe.id)

      this.show = !this.show
      return this.show
    },

    saveFeedback: async function () {
      this.feedbacks.push({text: this.f})
      this.feedbackCount++
      this.success_show = true
      await CafesComponent.methods.saveFeedback({text: this.f, id_cafe: this.cafe.id})
      this.f = ''

      setTimeout(() => this.success_show = false, 2500)
    },

  }
}

</script>

<template>

  <div class="tc-cafe" v-show="cafe.show">
    <div class="tc-cafe-title" @click.prevent="toggle">
      {{ cafe.name }}
    </div>
    <div class="tc-cafe-body" @click.prevent="toggle">
      Отзывов: {{ this.feedbackCount }}
    </div>
    <img class="tc-cafe-image" @click.prevent="toggle" v-bind:src="cafe.photo" v-show="true" alt=""/>
    <div class="tc-cafe-modal" v-show="show&&cafe.show">
      <div>
        <div v-show="cafe.address">Адрес: {{ cafe.address }}</div>
        <div v-show="cafe.landmark">Ориентиры: {{ cafe.landmark }}</div>
        <div v-show="cafe.cuisine">Кухня: {{ cafe.cuisine }}</div>
        <div v-show="cafe.distance">Расстояние: {{ cafe.distance }}м.</div>
        <div v-show="cafe.time">Время в пути: {{ cafe.time }} мин.</div>
        <!--        <div v-show="cafe.hasOwnProperty('business_lunch')"> Бизнес-ланч: {{ business_lunch ? 'Да' : 'Нет' }}</div>-->
        <div v-show="cafe.price">Ср.чек: {{ cafe.price }} руб.</div>
        <p/>
        <div class="tc-feedbacks">

          <li v-for="n in feedbacks" v-bind:key="n">{{ n.text }}</li>

        </div>
        <div>
          <p></p>
          Оставить отзыв
        </div>
        <div class="tc-cafe-input">
              <textarea v-model="f" @click.prevent="">
                </textarea>
            <transition name="slide-fade" >
              <div class="success-message" v-if="success_show">
              Спасибо! Ваш отзыв сохранён
              </div>
            </transition>
          <div/>
          <button class="tc-cafe-btn" type=submit @click="saveFeedback">Сохранить</button>
        </div>
      </div>
    </div>
  </div>
  <hr class="hr">


</template>

<style lang="scss" scoped>

.tc-cafe {
  font-size: 16px;

  background-color: darkseagreen;
  margin: 10px 10% 10px 10%;
  border-radius: 8px;
  width: percentage(0.8);
  text-align: center;

  .tc-cafe-image {
    cursor: pointer;

    width: percentage(0.8);
    margin-bottom: 10px;

  }
}

.tc-cafe-modal {
  text-align: left;
  margin-left: 10%;
}

.hr {
  border: 0;
}

.tc-cafe-btn {
  font-size: 16px;
  margin-bottom: 10px;
}

.tc-cafe-input {
  font-size: 16px

}

.success-message {
  font-size: 24px;
  opacity: 0.7;

}

.slide-fade-enter-active {
  transition: all .8s ease;
}

.slide-fade-leave-active {
  transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}

.slide-fade-enter, .slide-fade-leave-to
{
  transform: translateX(10px);
  opacity: 0;
}
</style>