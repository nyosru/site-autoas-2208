<template>
  <div class="container">
    <!-- page // {{ $route.params.id ?? '-' }} -->
    <!-- <br /> -->
    <!-- pageLoading: {{ pageLoading ? 11 : 22 }} -->
    <!-- <br /> -->
    <!-- pageData: {{ pageData }} -->

    <transition>
      <div class="row" v-if="pageLoading">
        <div class="col-12 text-center">
          .. загружаю данные ..
          <br/>
        <img src="/storage/site/img/loader.gif" alt="" style="width:120px;" />
        </div>
      </div>
      <div class="row" v-else-if="pageError">
        <div class="col-12 text-center">
          <p>
            <br />
            <br />
            ошибочка, заходите на эту страницу завтра, а пока выберите товары
            что вас интересуют
            <br />
            <br />
            <br />
          </p>
        </div>
      </div>
      <template v-else>
        <div class="row" v-if="$route.params.id == 'contact'">

        <!-- <div class="col-12"><page_contact></page_contact></div> -->

          <div class="col-6">
            <div v-html="pageData.html"></div>
          </div>
          <div class="col-6">
            <!-- map -->
            <!-- <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Aa1c21a22720667468e2e00b1009b667e2403d7dfe330b5d32d3f3a4ab255bad4&amp;width=100%25&amp;height=400&amp;lang=ru_RU&amp;scroll=true"></script> -->
            <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3Aa1c21a22720667468e2e00b1009b667e2403d7dfe330b5d32d3f3a4ab255bad4&amp;source=constructor" width="100%" height="600" frameborder="0"></iframe>
          </div>
        </div>
        <div class="row page-links" v-else >
          <div class="col-12">
            <div v-html="pageData.html"></div>
          </div>
        </div>
      </template>
    </transition>

    <!-- </div> -->
    <!-- <br /> -->
    <!-- {{ nowPage }} -->
  </div>
</template>

<script setup>

import { ref, watchEffect } from 'vue'
import page from './../../use/page.ts'

import { useRoute } from 'vue-router'

import page_about from './about.vue'
// import page_contact from './contact.vue'

const route = useRoute()

const { whatThisPage, pageLoad, pageLoading, pageData, pageError } = page()

const nowPage = ref([])
const nowMod = ref('')

// const stopWatch5 = watchEffect(() => {
//   nowMod.value = markRaw('page_'+route.params.id)
// })

const stopWatch = watchEffect(() => {
  nowPage.value = whatThisPage(route.params.id)
  pageLoad(route.params.id)
})
</script>

<style scoped>
.page-links a{ color: blue; }</style>
