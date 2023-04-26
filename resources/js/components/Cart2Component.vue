<template>
  <div class="container xcheckout-cart-form">
    <form action="" method="post" @submit.prevent="sendOrder">
      <div class="row">
        <div class="col-md-8 col-sm-12">
          <div v-if="!orderFormSended && cartAr.length == 0" class="text-center">
            <br/>
            <br/>
            <h2>
              В корзине ещё нет покупок, добавляйте товары
            </h2>
              <router-link to="/" class="link7">
                перейти к предложениям
              </router-link>

          </div>
          <div v-else>
            <table class="table">
              <thead>
                <tr
                  style="
                    position: sticky;
                    top: 0;
                    background-color: white;
                    border-bottom: 1px solid gray;
                  "
                >
                  <th class="product-thumbnail hidden-xs">&nbsp;</th>
                  <th class="product-name text-center">Товар</th>
                  <th class="product-price text-center">Цена</th>
                  <th class="quantity text-center">Кол-во</th>
                  <th class="product-subtotal text-center hidden-xs">
                    Сумма
                  </th>
                  <th>&nbsp;</th>
                </tr>
              </thead>

              <tbody v-if="!orderFormSended">
                <template v-for="(v, id_good) in cartAr" :key="id_good">
                  <cart-item-component :v="v" :step-2-show="step2Show" />
                </template>
              </tbody>

              <tbody v-else>
                <template v-for="(v, id_good) in cartArBauyed" :key="id_good">
                  <cart-item-component
                    :v="v"
                    :step2Show="step2Show"
                    type="buyed"
                  />
                </template>
              </tbody>
            </table>
            <br />
            <br />
            <p style="color: gray;">
              * - менеджер свяжется с Вами, согласует цену и срок доставки.
            </p>
          </div>
        </div>

        <div class="col-md-4 col-sm-12">
          <cart-order-component />
        </div>

      </div>
    </form>
  </div>
</template>

<script setup>

import cart from './../use/cart.js'
import sendTelegramm from './../use/sendTelegramm.js'
import { ref, watchEffect, onMounted } from 'vue'

import CartOrderComponent from './Cart2OrderComponent.vue'
import CartItemComponent from './CartItemComponent.vue'

import fn from './../use/fn.js'

const { NumberFormat } = fn()

import {
  // useRouter,
  useRoute,
} from 'vue-router'
// const router = useRouter()
const route = useRoute()

const {

  sendOrder,

  orderFormSended,
  // товары в корзине a_id = quantity
  cartAr,
  cartArBauyed,
  // cartArGoods,
  // добавляем
  cartAdd,
  // отнимаем
  cartMinus,
  // поиск есть или нет товар в корзине
  goodInCart,
  // deleteGoodFromCart,
  cartRemove,
  cartCashSave,
  // показ подтверждения заказа
  step2Show,
  cartCashSaveBeforeOrder,
} = cart()

const sumall = ref(0)
const addPodZakaz = ref(false)

// считаем сумму корзины
const stopWatch7 = watchEffect(() => {
  if (cartAr.value.length > 0) {
    sumall.value = cartAr.value
      .map((item) => (item.a_price > 0 ? item.kolvo * item.a_price : 0))
      .reduce((prev, curr) => prev + curr, 0)

    if (cartAr.value.find((el) => el.a_price == '')) {
      addPodZakaz.value = true
    } else {
      addPodZakaz.value = false
    }
  } else {
    sumall.value = 0
  }
})

const form_name = ref('')
const form_name2 = ref('')

const form_phone = ref('')
const form_phone2 = ref('')

const form_city = ref('Тюмень')
const form_needHelp = ref(false)

const show_form_postedAddress = ref(false)
const form_postedAddress = ref('')

const form_postedAddress2 = ref('')
const podZakaz = ref(false)

const { sendToTelegramm, sendTo } = sendTelegramm()

const textSms = ref('')
const showOk = ref(false)

/**
 * чистим форму отправки
 * @param {*} ro
 */
const clearSendForm = (ro) => {
  // console.log( 3355 , 'cart2' , 'чистим форму отправки' );
  step2Show.value = false
  orderFormSended.value = false
}

watchEffect(() => {
  clearSendForm(route.name)
})
</script>

<style scoped>
.cartItem:hover a.remove {
  color: red;
}
.BtnPlusMinus {
  display: inline-block;
  border-radius: 3px;
}
.nobr {
  white-space: pre;
}
.a-right {
  text-align: right;
}
.m-top {
  padding-top: 18px;
}

.link7{
  text-decoration: underline;
  color: blue;
}
</style>
