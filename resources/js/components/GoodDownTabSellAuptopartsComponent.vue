<template>
  <div>
    good_articul: {{ good_articul }}
    <br />
    <br />

    <!-- <div
    v-for="a in analogi"
    :key="a.id"
    class="col-xs-12 col-sm-6 col-md-4 col-xl-3 col-lg-2 xproduct-list-item"
    style="margin-bottom: 3vh; margin-top: 3vh;"  >
    <vitrin-goods-list-item :i="a" />
  </div> -->
  </div>
</template>

<script setup>
// import VitrinGoodsListItem from './VitrinGoodsListItemComponent.vue'

import { onMounted } from '@vue/runtime-core'

// import goodsAllautoparts from './../use/goodsAllautoparts.ts'
import goodsAllautoparts from './../use/goodsAllautoparts.ts'
const { load, items, loading } = goodsAllautoparts()

const props = defineProps({
  good_articul: String,
})

onMounted(() => {
  load(props.good_articul)
  console.log(77)
})
</script>

<style scoped></style>