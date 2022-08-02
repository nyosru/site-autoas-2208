<template>
  <div>
    <index-line-adver-goods-component :items="items1" />
    <index-line-adver-goods-component :items="items2" />
    <index-line-adver-goods-component :items="items3" />
  </div>
</template>

<script setup>
import IndexLineAdverGoodsComponent from './IndexLineAdverGoodsComponent.vue'

const items1 = {}
const items2 = {}
const items3 = {}


import banner from './../use/banner.ts'
import { onMounted } from 'vue'

const { load: loadAdverItems, loading, items } = banner()

onMounted(() => {
  loadAdverItems('adverItems')
})


</script>

<style scoped></style>
