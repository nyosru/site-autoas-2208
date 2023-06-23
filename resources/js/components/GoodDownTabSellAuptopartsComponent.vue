<template>

<div>
777777
  <!-- <h2 v-if="(items && items.length) || loading"> -->
  <h2 v-if="itemsCount > 0 || loading">
    {{ tab.name ?? 'x' }}
  </h2>
  <div>
    <div v-if="loading">.. загрузка предложений ..</div>
    <div
      v-else-if="itemsCount > 0"
      style="max-height: 400px; overflow: auto; border: 1px sold green;"
    >
      <!-- good_articul: {{ good_articul }} -->
      <!-- <br /> -->
      <!-- <br /> -->
      <!-- items: {{ items }} -->
      <!-- <br /> -->
      <!-- <br /> -->

      <table style="margin: 0 auto;">
        <thead>
          <tr>
            <th>Название</th>
            <th><p class="text-center"><div class="nobr">На складе</div></p></th>
            <th><p class="text-center">
              Дней
              <br />
              <div class="nobr">на доставку</div>
              </p>
            </th>
            <th><p class="text-center">Цена</p></th>
            <th><p class="text-center">Кол-во</p></th>
            <th>&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          <template v-for="(a, ind) in items" :key="a.OfferName">
          <!-- <tr><td>{{ a }}</td></tr> -->
            <good-down-tab-sell-auptoparts-item-component :a="a" :ind="ind" />
          </template>
        </tbody>
      </table>
    </div>
  </div>
  </div>
</template>

<script setup>
import GoodDownTabSellAuptopartsItemComponent from './GoodDownTabSellAuptopartsItemComponent.vue'
// import VitrinGoodsListItem from './VitrinGoodsListItemComponent.vue'

import { onMounted } from '@vue/runtime-core'

// import goodsAllautoparts from './../use/goodsAllautoparts.ts'
import goodsAllautoparts from './../use/goodsAllautoparts.ts'
const { load, items, itemsCount, loading } = goodsAllautoparts()

const props = defineProps({
  tab: Object,
  good_articul: String,
})

onMounted(() => {
  load(props.good_articul)
  console.log(77)
})


</script>

<style scoped>
h2 {
  margin-top: 3vh;
  margin-bottom: 3vh;
}
thead > tr {
  position: sticky;
  top: 0;
  border-bottom: 2px solid rgb(100, 100, 100);
  margin-bottom: 3px;
}
thead th {
  padding-left: 10px;
  text-align: left;
  background-color: rgb(210, 210, 210);
}
tbody tr.n2 td {
  background-color: rgb(230, 230, 230);
}
.nobr {
  white-space: pre;
}
</style>
