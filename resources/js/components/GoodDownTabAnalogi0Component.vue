<template>
  <!-- <div>{{ tab }}</div> -->

  <div v-if="analogi && analogi.length">
    <h2>
      {{ tab.name ?? 'x' }}
    </h2>

    <div
      v-for="a in analogi"
      :key="a.id"
      class="col-xs-12 col-sm-6 col-md-4 col-xl-3 col-lg-2 xproduct-list-item"
      style="margin-bottom: 3vh; margin-top: 3vh;"
    >
      <vitrin-goods-list-item :i="a" />
    </div>
  </div>
</template>

<script setup>
import VitrinGoodsListItem from './VitrinGoodsListItemComponent.vue'

const props = defineProps({
  tab: Object,
  analogi: Object,
})
</script>

<style scoped>
h2 {
  margin-top: 3vh;
  margin-bottom: 3vh;
}
</style>
