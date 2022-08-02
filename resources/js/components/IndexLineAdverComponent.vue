<template>
  <div>
    <!-- <br />
    <br />
    <br />-->
    <!-- loading: {{ loading }}  -->
    <!-- <br />
    items: {{ items }}
    <br /> -->
    <index-line-adver-goods-component v-if="!loading" :items="items1" />
    <index-line-adver-goods-component v-if="!loading" :items="items2" />
    <index-line-adver-goods-component v-if="!loading" :items="items3" />
    <index-line-adver-goods-component v-if="!loading" :items="items4" />
    <br clear="all" />
    <br clear="all" />
    <br clear="all" />
  </div>
</template>

<script setup>
import IndexLineAdverGoodsComponent from './IndexLineAdverGoodsComponent.vue'

import adver from './../use/adver.ts'
import { onMounted, ref, watchEffect } from 'vue'

const { load, loading, items } = adver()

const items1 = ref({})
const items2 = ref({})
const items3 = ref({})
const items4 = ref({})

onMounted(() => {
  load()
})

watchEffect(() => {
  if (items.value && items.value.length) {
    items.value.sort(() => Math.random() - 0.5)
    items1.value = items.value.slice( 0 , 29)
    items2.value = items.value.slice(30, 59)
    items3.value = items.value.slice(60, 89)
    items4.value = items.value.slice(90, 119)
  }
})
</script>

<style scoped></style>
