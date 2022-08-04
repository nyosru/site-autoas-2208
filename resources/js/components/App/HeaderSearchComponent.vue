<template>
  <span style="text-align: center; display: block;">
    <br />
    <form
      action="/index.php"
      class="search-form"
      method="GET"
      style="display: inline-block;"
      @submit.prevent="goSearch"
    >
      <input
        type="text"
        xname="search"
        v-model="searchString"
        class="text-center form-control"
        placeholder="поиск по названию или артикулу детали"
      />
      <input type="hidden" name="level" value="show" />
      <button type="submit" class="search-icon"></button>
    </form>
  </span>
</template>

<script setup>
import { ref } from "@vue/reactivity"

import { useRouter } from 'vue-router';
const router = useRouter();

import goods from './../../use/goods.ts';
const { searchString } = goods();

// const searchString = ref('')

const goSearch = () => {
  // console.log(222 , search.value )
  router.push({ name: 'search', params: { search: searchString.value } })
  return false
}
</script>

<style scoped></style>
