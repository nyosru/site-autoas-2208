<template>
  <div>
    <!-- page // {{ $route.params.id ?? '-' }} -->
        <!-- <br /> -->
    <!-- pageLoading: {{ pageLoading ? 11 : 22 }} -->
    <!-- <br /> -->
    <!-- pageData: {{ pageData }} -->
    <div class="container">
      <transition>
      <div class="row" v-if="pageLoading">
        <div class="col-12">
          .. загружаю данные ..
        </div>
      </div>
      <div class="row" v-else-if="pageError">
        <div class="col-12 text-center">
          <p>
          <br/>
          <br/>
          ошибочка, заходите на эту страницу завтра, а пока выберите товары что вас интересуют
          <br/>
          <br/>
          <br/>          
          </p>
        </div>
      </div>
      <div class="row" v-else >
        <!-- <div class="col-12 text-center">
          <br/>
          <br/>
          <h2>{{ pageData.name }}</h2>
          <br/>
          <br/>
        </div> -->
        <div class="col-12">
          <div v-html="pageData.html"></div>
          <!-- {{ pageData.html }} -->
        </div>
      </div>
      </transition>
    </div>
    <!-- <br /> -->
    <!-- {{ nowPage }} -->
  </div>
</template>

<script setup>
import { ref, watchEffect } from 'vue'
import page from './../use/page.ts'

import { useRoute } from 'vue-router'

const route = useRoute()

const { whatThisPage, pageLoad, pageLoading, pageData , pageError} = page()

const nowPage = ref([])

const stopWatch = watchEffect(() => {
  nowPage.value = whatThisPage(route.params.id)
  pageLoad(route.params.id)
})
</script>

<style scoped></style>
