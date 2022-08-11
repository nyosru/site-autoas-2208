<template>
  <div class="item0" >
    <div class="product-item-img">
      <!-- <a href="/show/i/9415/podkryilok_plastikovyiy_peredniy_levyiy/"> -->
      <router-link :to="{ name: 'good', params: { good_id: i.a_id } }">
        <img
          v-if="i.a_arrayimage == ''"
          src="/storage/photo_no.jpg"
          loading="lazy"
          alt=""
          class="img-responsive"
          style="opacity: 0.4;"
        />
        <img
          v-else
          :src="'/storage/photo/' + i.a_arrayimage"
          loading="lazy"
          alt=""
          class="img-responsive"
        />
        <!-- </a> -->
      </router-link>
    </div>
    <div class="product-item-info">
      <div class="item_name_vitrin_resize">
        <h3 xclass="item_name_vitrin">
          <router-link :to="{ name: 'good', params: { good_id: i.a_id } }">
            <!-- <a
            href="/show/i/9415/podkryilok_plastikovyiy_peredniy_levyiy/"
            title=""
            xclass="black"
          > -->
            {{ i.head }}
            <span class="manufacturer">{{ i.manufacturer ?? '' }}</span>
            <!-- </a> -->
          </router-link>
        </h3>
      </div>
      <div class="prod-price" @click="showAr = !showAr">
        <span v-if="i.a_price.length" class="price color-green">
          {{ i.a_price }} ₽
        </span>
        <span v-else class="price color-gray">
          под заказ
        </span>
      </div>
      <div class="button-ver2 text-center">
        <template v-if="goodInCart(i.a_id) !== true">
          <button class="btn btn-info" @click="goodAdd(i.a_id)">
            Добавить в корзину
          </button>
        </template>
        <template v-else>
          <router-link
            :to="{ name: 'cart' }"
            class="addcart-ver2 ok btn btn-success"
          >
            В&nbsp;корзине
          </router-link>
        </template>

        <small v-if="showAr">
          {{ i }}
        </small>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, watchEffect } from 'vue'

import cart from './../use/cart.js'
import { useRoute } from 'vue-router'

const route = useRoute()

const props = defineProps({
  i: Object,
})

const showAr = ref(false)

const {
  // // товары в корзине a_id = quantity
  // cartAr,
  // добавляем
  cartAdd,
  // // отнимаем
  // cartMinus,
  // поиск есть или нет товар в корзине
  goodInCart,
} = cart()

const goodAdd = () => {
  if (props.i.a_id && props.i.a_id.length) {
    cartAdd(props.i)
    // console.log( 778 , props.i.a_id)
  }
}

// watch: { '$route': function (value) { } } 
// watchEffect()

</script>

<style scoped>
h3 {
  font-size: 1.2em;
}
.item0{
  margin-top: 1vh;
  margin-bottom: 1vh;
}
.manufacturer{ color: rgb(41,59,119) }
</style>
