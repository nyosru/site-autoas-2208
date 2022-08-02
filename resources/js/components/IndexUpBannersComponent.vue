<template>
  <div>
    
    <!-- loading: {{ loading }} -->
    <!-- <br /> -->
    <!-- items: {{ items }} -->
    <!-- <br /> -->
    <!-- <br /> -->
    <!-- Slider main container -->

    <swiper
      :spaceBetween="30"
      :centeredSlides="true"
      :loop="true"
      :autoplay="{
        delay: 2500,
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
        <div
          class="carusel-item"
          :style="
            'background-image:url(\'/storage/module_items_image/' +
            i.img +
            '\');'
          "
        >
          &nbsp;
          <!-- <a href="/111" >123123</a> -->
        </div>
      </swiper-slide>
      <!-- <swiper-slide>Slide 2</swiper-slide> -->
      <!-- <swiper-slide>Slide 3</swiper-slide> -->
    </swiper>
  </div>
</template>

<script setup>
// Import Swiper Vue.js components
import { Swiper, SwiperSlide } from 'swiper/vue'

// Import Swiper styles
import 'swiper/css'

// import "swiper/css/pagination";
// import "swiper/css/navigation";

// import "./style.css";

// import required modules
import {
  Autoplay,
  // Pagination,
  // Navigation
} from 'swiper'

import banner from './../use/banner.ts'
import { onMounted } from 'vue'

const { load: loadBanner, loading, items } = banner()

onMounted(() => {
  loadBanner()
})

// export default {
//   components: {
//     Swiper,
//     SwiperSlide,
//   },
//   setup() {
// return {
const modules = [
  Autoplay,
  // Pagination,
  // Navigation
]
// const emit = defineEmits(['change', 'delete'])
// const modules = defineEmits([Autoplay, Pagination, Navigation])
//     };
//   },
// };
</script>

<style scoped>
.carusel-item {
  background-position: center center;
  background-size: contain;
  xheight: 30rem;
  height: 100%;
  background-repeat: no-repeat;
}
.swiper {
  width: 100%;
  xheight: 30rem;
  xheight: auto;
  height: 30vh;
  /* border: 1px solid green; */
}
</style>
