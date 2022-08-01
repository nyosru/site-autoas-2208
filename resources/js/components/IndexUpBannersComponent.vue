<template>
  <div>
    loading: {{ loading }}
    <br />
    <!-- items: {{ items }} -->
    <!-- <br /> -->
    <!-- <br /> -->
    <Carousel :autoplay="5000" :wrap-around="true">
      <Slide v-for="slide in items" :key="slide.id">
        <div class="carousel__item">
          <!-- {{ slide }} -->
          <img :src="'/storage/module_items_image/' + slide.img" />
        </div>
      </Slide>

      <template #addons>
        <Pagination />
      </template>
    </Carousel>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { Carousel, Pagination, Slide } from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'

import banner from './../use/banner.ts'

const { load: loadBanner, items, loading } = banner()

onMounted(() => {
  loadBanner()
})
</script>

<style scoped></style>
