<template>
  <div class="container-fluid">
    <!-- <div class="row">
      <div class="col-xs-12 py-4">
        <h3>vitrin mitrin</h3>
      </div>
    </div> -->
    <!-- <br /> -->
    <br />
    <!-- findedOnPartner    {{ findedOnPartner }}<br /> -->
    <!-- findedOnPartnerLoading    {{ findedOnPartnerLoading }} -->
    <!-- SearchString: {{ SearchString1 }} -->
    <h3 class="alert alert-success text-center">
      результаты поиска:
      <u>{{ searchStringNow }}</u>
    </h3>
    <br />
    <div class="row">
      <div class="col-12 text-center">
        <template v-if="!goodsLoading &&
          goodsData.meta &&
          goodsData.meta.links &&
          goodsData.meta.links.length > 3
          ">
          <vitrin-pagination-component v-if="!goodsLoading" :inf="goodsData.meta" />
        </template>
        <template v-else></template>
      </div>
    </div>
    <div class="row xproduct-list xgrid_full xgrid_sidebar xgrid-uniform xcontainer-fluid">
      <!-- <vitrin-menu-component-vue></vitrin-menu-component-vue> -->

      <div class="col-4 text-center" v-if="goodsLoading || findedOnPartnerLoading">
        <h2>.. ищем доступные варианты ..</h2>
        <br />
        <br />
        <!-- <img src="/storage/site/img/loader.gif" alt="" style="width: 120px;" /> -->
        <img src="/storage/img/12.gif" alt="" style="width: 120px;" />
      </div>

      <div class="col-4 text-center" v-if="goodsLoading">
        <!-- <h2>.. ищем доступные варианты ..</h2>
        <br />
        <br /> -->
        <!-- <img src="/storage/site/img/loader.gif" alt="" style="width: 120px;" /> -->
        <!-- <img src="/storage/img/12.gif" alt="" style="width: 120px;" /> -->
      </div>
      <template v-else>
        <!-- goodsData: {{ goodsData }} -->
        <!-- <br /> -->
        <!-- goodsLoading: {{ goodsLoading }} -->
        <!-- <vitrin-pagination-component /> -->
        <h3 v-if="goodsData.data && !goodsData.data.length && findedOnPartner == 0 && findedOnPartnerLoading == false"
          class="alert alert-warning text-center">
          найдено 0 позиций, измените поисковый запрос
        </h3>
        <!-- goodsData: {{ goodsData }} -->
        <!-- <br/>
        <br/> -->
        <!-- goodsData.dat: {{ goodsData.data }} -->
        <!-- <br/> -->
        <!-- <br/> -->
        <div v-for="i in goodsData.data" :key="i.key" class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
          <vitrin-goods-list-item :i="i" />
        </div>

        <!-- <vitrin-pagination-component :inf="goodsData.meta" /> -->

        <template v-if="!goodsLoading &&
          goodsData.meta &&
          goodsData.meta.links &&
          goodsData.meta.links.length > 3
          ">
          <br clear="all" />
          <vitrin-pagination-component v-if="!goodsLoading" :inf="goodsData.meta" />
        </template>
        <!-- <template v-else>
          <br />
          <br />
        </template> -->



        <!-- <br clear="all" /> -->

        <!-- <div class="col-4 text-center" v-if="findedOnPartnerLoading"> -->
          <!-- <h2>.. ищем доступные варианты ..</h2>          <br />          <br /> -->
          <!-- <img src="/storage/site/img/loader.gif" alt="" style="width: 120px;" /> -->
          <!-- <img src="/storage/img/12.gif" alt="" style="width: 120px;" /> -->
        <!-- </div> -->

        <!-- 111 -->
        <good-down-tab-all-autoparts-component :tab="{ name: '' }" :good_articul="searchStringNow" />
        <!-- 222<br/> -->
        <!-- 333 -->
        <br />
        <br />
        <br />

      </template>
    </div>
  </div>
</template>

<script setup>
// import VitrinGoodsListComponentVue from './VitrinGoodsListComponent.vue'
// import VitrinMenuComponentVue from './VitrinMenuComponent.vue'
import VitrinPaginationComponent from './VitrinGoodsListPaginationComponent.vue'

import GoodDownTabAllAutopartsComponent from './GoodDownTabSellAuptopartsComponent.vue'

// import ff from VitrinMenuComponentVue

import { watchEffect, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'

import catalogs from './../use/catalogs.ts'
import goods from './../use/goods.js'

import use_var from './../use/var.js'

const { findedOnPartner, findedOnPartnerLoading } = use_var()

import VitrinGoodsListItem from './VitrinGoodsListItemComponent.vue'

const route = useRoute()
const router = useRouter()

// const SearchString1 = ref(route.params.search)

// const GoodsLoading = ref(true)

// catsLevelLower
const { loading } = catalogs()

const {
  goodsLoading,
  goodsData,
  loadGoods,
  searchString,
  searchStringNow,
  loadSearchGoods,
} = goods()

// loadSearchGoods(route.params.search)

const stopWatch2 = watchEffect(() => {
  // console.log(1)
  if (loading.value == false) {
    // console.log(2 , loading.value)
    if (route.params.search && route.params.search.length) {
      // console.log(3, route.params.cat_id)
      // const toLevelCatalogs = catsLevelLower(route.params.cat_id)
      // console.log(31, route.params.cat_idtoLevelCatalogs )

      // const { catNow } = catalogs()
      // catNow.value = route.params.cat_id
      // loadGoods(route.params.cat_id, route.params.page)
      loadSearchGoods(route.params.search)
      // GoodsLoading.value = false
    }
  }
})

const stopWatch7 = watchEffect(() => {
  // console.log(1)

  if (loading.value == false) {
    // console.log(2 , loading.value)

    // console.log( 77 , goodsData.value.data);
    // console.log( 77 , goodsData.value);

    if (goodsData.value.data && Object.keys(goodsData.value.data).length == 1) {
      // console.log('itemsCount', itemsCount, goodsData.value.data[0]['head'])
      console.log('res search', goodsData.value.data[0])

      router.push({
        name: 'good',
        params: { good_id: goodsData.value.data[0]['a_id'], dop: 'showOrdersOnSklad' },
        // props: { showOrdersOnSklad: true },
      })
    }
  }
})
</script>

<style scoped></style>
