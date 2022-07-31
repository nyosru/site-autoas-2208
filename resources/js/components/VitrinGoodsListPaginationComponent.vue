<template>
  <div class="container-fluid text-center" v-if="inf && inf.links">
    <!-- pagination
    <Br />
    <Br /> -->

    <!-- <div class="product-pagination"> -->
    <ul class="pagination">
      <!-- <li><a href="#" >Страницы:</a></li> -->
      <!-- <li>
          <a href="#"><i class="ion-chevron-left"></i></a>
        </li>
        <li class="active"><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">...</a></li>
        <li><a href="#">5</a></li>
        <li>
          <a href="#"><i class="ion-chevron-right"></i></a>
        </li> -->

      <template v-for="li in inf.links" :key="li.label">
        <li
          v-if="(li.label > 0 && li.label < 999) || li.label == '...'"
          :class="{ active: li.active === true }"
        >
          <a v-if="li.label === '...'">...</a>
          <router-link
            v-else-if="li.label > 0 && li.label < 999"
            :to="{
              name: 'cat',
              params: {
                cat_id: cat_id_now,
                page: li.label != 1 ? li.label : '',
              },
            }"
          >
            {{ li.label }}
          </router-link>
        </li>
      </template>
    </ul>
    <!-- </div>

    <Br />
    <Br /> -->

    <!-- <router-link v-for="li in inf.links" :key="li.label" >{{ li.label }}</router-link> -->

    <!-- <Br />
    <Br />
    inf.links {{ inf.links }} -->
  </div>
  <!-- <div class="ff" v-else>
    111
  </div> -->
  <!-- <div>inf {{ inf }}</div> -->
</template>

<script setup>
import { useRoute } from 'vue-router'
const route = useRoute()

const cat_id_now = route.params.cat_id ?? ''

const props = defineProps({
  inf: Object,
})

// console.log(223, props , props.inf)
</script>

<style scoped></style>
