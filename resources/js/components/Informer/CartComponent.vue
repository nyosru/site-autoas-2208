<template>
 <div class="block block-2">

            <div class="cart" id="cart">
              <router-link
                :to="{ name: 'cart' }"
                role="button"
                xxclick="orderFormSended = false"
              >
                <div class="photo photo-cart">
                  <img
                    src="/storage/site/img/cart.png"
                    alt=""
                    class="img-reponsive"
                  />
                  <span class="lbl number-shopping-cart">{{ sizeA }}</span>
                </div>
                <p class="inform inform-cart">
                  <span class="strong">
                    Корзина
                    <br />
                  </span>
                </p>
              </router-link>
            </div>
          </div>
          <div class="block block-1"></div>
          <div class="clearfix"></div>
</template>

<script setup>

import { ref } from '@vue/reactivity';
import { watchEffect } from '@vue/runtime-core';
import cart from './../../use/cart.js'

const {
  orderFormSended,
  // товары в корзине a_id = quantity
  cartAr,
  // // добавляем
  // cartAdd,
  // // отнимаем
  // cartMinus,
  // // поиск есть или нет товар в корзине
  // goodInCart,
} = cart()

const sizeA = ref(0);

const stopWatch = watchEffect(() => {
sizeA.value = Object.keys(cartAr.value).length;
// console.log(cartAr.value);
})

</script>

<style scoped></style>
