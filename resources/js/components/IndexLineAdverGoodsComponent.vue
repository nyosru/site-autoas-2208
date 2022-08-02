<template>
  <div>
    <!-- <div style="max-height: 100px; overflow: auto;">items: {{ items }}</div> -->
    <!-- <br /> -->

    <!-- loading: {{ loading }} -->
    <!-- <br /> -->
    <!-- items: {{ items }} -->
    <!-- <br /> -->
    <!-- <br /> -->
    <!-- Slider main container -->

    <swiper
      :slidesPerView="slidesPerView"
      :loop="true"
      :spaceBetween="20"
      xcenteredSlides="true"
      :autoplay="{
        delay: timeD,
        disableOnInteraction: false,
      }"
      :pagination="{
        clickable: true,
      }"
      :navigation="true"
      :modules="modules"
      class="mySwiper"
    >
      <swiper-slide v-for="i in items" :key="i.id">
        <div class="carusel-item text-center">
          <index-line-adver-goods-item-component :i="i" />
        </div>
      </swiper-slide>
    </swiper>
  </div>
</template>

<script setup>
// Import Swiper Vue.js components
import { Swiper, SwiperSlide } from 'swiper/vue'

// Import Swiper styles
import 'swiper/css'

// import required modules
import {
  Autoplay,
  // Pagination,
  // Navigation
} from 'swiper'

import IndexLineAdverGoodsItemComponent from './IndexLineAdverGoodsItemComponent.vue'
const props = defineProps({
  items: Object,
})

const timeD0 = [4000, 5500, 2500, 3000]
timeD0.sort(() => Math.random() - 0.5)
const timeD = timeD0[0]

// сколько показывать слайдов в зависимости от ширины экана
let slidesPerView = 1
//console.log(window.screen.width, window.screen.availWidth, window.innerWidth)
if (window.innerWidth < 800) {
  slidesPerView = 2
} else if (window.innerWidth < 1200) {
  slidesPerView = 4
} else if (window.innerWidth < 1600) {
  slidesPerView = 5
} else {
  slidesPerView = 7
}

const modules = [
  Autoplay,
  // Pagination,
  // Navigation
]
</script>

<style scoped>
.carusel-item {
  background-position: center center;
  background-size: contain;
  height: 100px;
  background-repeat: no-repeat;
}
.swiper {
  width: 100%;
  height: 30vh;
  margin-top: 5vh;
  /* margin-bottom: 2vh; */
}
</style>
