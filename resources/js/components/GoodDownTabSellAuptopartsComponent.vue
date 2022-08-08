<template>
  <div>
    <div v-if="loading">.. загрузка предложений ..</div>
    <div v-else style="max-height: 400px; overflow: auto;">
      <!-- good_articul: {{ good_articul }} -->
      <!-- <br /> -->
      <!-- <br /> -->
      <!-- items: {{ items }} -->
      <!-- <br /> -->
      <!-- <br /> -->

      <table>
        <thead>
          <tr>
            <th>название</th>
            <th>на складе</th>
            <th>дней на доставку</th>
            <th>цена</th>
            <th>кол-во</th>
            <th>заказать</th>
          </tr>
        </thead>
        <tbody>
          <template v-for="(a, ind ) in items" :key="a.AnalogueCode">
            <good-down-tab-sell-auptoparts-item-component :a="a" :ind="ind" />
          </template>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import GoodDownTabSellAuptopartsItemComponent from './GoodDownTabSellAuptopartsItemComponent.vue'
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

<style scoped>
thead > tr {
  position: sticky;
  top: 0;
  border-bottom: 2px solid rgb(100,100,100);
  margin-bottom: 3px;
}
thead th {
  padding-left: 10px;
  text-align: left;
  background-color: rgb(210,210,210);
  xbox-shadow: 10px 10px gray;
}
tbody tr.n2 td{
  background-color: rgb(230,230,230);
}
</style>
