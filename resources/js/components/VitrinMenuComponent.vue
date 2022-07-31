<template>
  <div
    class="leftMenu mb-4 col-xs-6 col-sm-4 col-md-3 col-lg-2"
    v-if="leftMenu && leftMenu.length > 0"
  >
    <!-- vitrin menu
    <br />
    <br /> -->
    <!-- leftMenu : {{ leftMenu }} -->

    <router-link
      v-for="v in leftMenu"
      :key="v.id"
      :to="{ name: 'cat', params: { cat_id: v.a_id } }"
    >
      {{ v.head }}
    </router-link>
  </div>
</template>

<script setup>
import { watchEffect } from 'vue'
import { useRoute } from 'vue-router'
import catalogs from './../use/catalogs.ts'

const route = useRoute()

// catsLevelLower
const { loading, catsLevelLower, leftMenu } = catalogs()

const stopWatch1 = watchEffect(() => {
  // console.log(1)
  if (loading.value == false) {
    // console.log(2 , loading.value)
    if (route.params.cat_id && route.params.cat_id.length) {
      // console.log(3, route.params.cat_id)
      const toLevelCatalogs = catsLevelLower(route.params.cat_id)
      // console.log(31, route.params.cat_idtoLevelCatalogs )
    }
  }
})
</script>

<style scoped>
.leftMenu a {
  display: block;
  padding-left: 6px;
  padding-top: 3px;
  padding-bottom: 3px;
  background-color: rgba(0, 0, 255, 0.1);
  margin-bottom: 1px;
}
.leftMenu a:hover {
  background-color: rgba(0, 0, 255, 0.2);
}
</style>
