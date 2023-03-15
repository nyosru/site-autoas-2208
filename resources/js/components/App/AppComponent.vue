<template>
  <!-- <br /> -->
  <!-- <br /> -->

  <!-- <router-link :to="{ name: 'index' }">index</router-link>    / -->
  <!-- <router-link :to="{ name: 'cat', params: { cat_id: '111' } }">      Register    </router-link>    / -->
  <!-- <router-link :to="'/cat/333'">Register2</router-link> -->
  <!-- <br /> -->
  <!-- {{ $route.params.cat_id ?? 'xx' }} -->
  <!-- <br /> -->
  <!-- <br /> -->

  <header>
    <header-component></header-component>
  </header>

  <warn-component></warn-component>

  <div class="content1">
    <!-- <router-view name="blockHeader" /> -->

    <router-view name="BreadcrumbsComponent" />
    <router-view name="adver" />
    <router-view name="adverList" />
    <router-view name="starter" />
    <router-view name="page" />
    <router-view name="cart" />
    <router-view name="vitrin" />

    <!-- <router-view name="blockFooter" /> -->
  </div>

  <footer>
    <footer-component></footer-component>
  </footer>
</template>

<script setup>

import HeaderComponent from './HeaderComponent.vue'
import FooterComponent from './FooterComponent.vue'
import WarnComponent from './WarnComponent.vue'

import cart from './../../use/cart.js'

import { onMounted } from 'vue'

const { cartCashRead } = cart()

onMounted(() => {
  cartCashRead()
})
</script>

<style scoped>
.content1 {
  display: block;
  min-height: 60vh;
}
</style>
