<template>
  <div class="container xcheckout-cart-form">
    <form action="" method="post" @submit.prevent="sendOrder">
      <Div style="max-height: 200px; overflow-x: auto;">
        route:
        <br />
        {{ route }}
        <br />
        router:
        <br />
        {{ router }}
      </Div>

      <br />

      route.name: {{ route.name }}
      <br />
      cartAr.length: {{ cartAr.length }}
      <br />
      showOk: {{ showOk }}
      <br />

      <div v-if="route.name == 'cart' && cartAr.length == 0 && !showOk">
        <br />
        <br />
        <br />
        <br />

        <h2 class="alert alert-success text-center">
          Выберите нужные товары и&nbsp;закажите,
          <br />
          доставим в&nbsp;лучшем виде в&nbsp;кратчайшие сроки
        </h2>
      </div>

      <div class="row" v-else-if="route.name == 'orderOk'">
        23
      </div>

      <!-- <div class="row" v-else-if=" true " >
        12
      </div> -->

      <!-- <div class="row" v-else-if="1 == 1 || route.name == 'orderOk'"> -->

      <div class="row" v-else-if="true || route.name == 'orderOk'">
        <div class="col-md-8 col-sm-12">
          <!-- cartAr: {{ cartAr }} -->
          <!-- <br /> -->
          <!-- <br /> -->
          <!-- cartArGoods:              {{cartArGoods}} -->

          <h2 class="alert alert-success text-center" v-if="showOk">
            Заказ отправлен, в&nbsp;ближайшее рабочее время позвоним уточнить
            и&nbsp;подтвердить детали заказа
          </h2>

          <template v-else>
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

              <!-- <tbody v-if="route.name === 'orderOk' && cartArBauyed.length > 0" > -->
              <tbody v-if="route.name === 'orderOk'">
                <template v-for="(v, id_good) in cartArBauyed" :key="id_good">
                  <tr><td colspan="3">orderOk</td></tr>
                  <cart-item-component
                    :v="v"
                    :step2Show="step2Show"
                    type="buyed"
                  />
                </template>
              </tbody>

              <tbody v-else>
                <!-- cartAr, -->
                <!-- cartArGoods, -->
                <template v-for="(v, id_good) in cartAr" :key="id_good">
                  <cart-item-component :v="v" :step-2-show="step2Show" />

                  <template v-if="1 == 2">
                    <tr v-if="v.kolvo >= 0" class="cartItem">
                      <td>
                        <a
                          v-if="!step2Show"
                          href="#"
                          @click.prevent="cartRemove(v.a_id)"
                          class="remove"
                        >
                          <i class="ion-close" aria-hidden="true"></i>
                        </a>

                        <!-- <br /> -->
                        <!-- {{ v.a_id }} -->
                      </td>
                      <td>
                        <!-- ++ {{ v.OfferName ?? '' }} -->
                        <!-- ++ {{ v.a_id ?? '' }} -->
                        <!-- <Br/> -->
                        <span
                          v-if="v.id && v.id > 0 && v.a_id && v.a_id.length"
                        >
                          <router-link
                            :to="{
                              name: 'good',
                              params: { good_id: v.a_id },
                            }"
                          >
                            {{ v.head ?? '' }}
                          </router-link>
                        </span>
                        <span v-else>
                          <!-- <small>заказ с удалённого склада</small><br /> -->
                          <!-- {{ v.head ?? '' }} -->
                          <span v-html="v.head"></span>
                        </span>
                        <!-- {{ cartArGoods[id_good] ? ( cartArGoods[id_good]['head'] ?? '' ) : '' }} -->
                        <div class="text-muted text-red-hover">
                          {{ v.manufacturer ?? '' }}
                          <!-- {{ cartArGoods[id_good] ? ( cartArGoods[id_good]['manufacturer'] ?? '' ) : '' }} -->
                        </div>
                        <!-- <div @click="s1 = !s1">-- разработка ( показать инфу ) --</div> -->
                        <!-- <div v-if="s1">                        {{ v }}                      </div> -->
                      </td>
                      <td class="a-right m-top">
                        {{
                          v.a_price && v.a_price > 0
                            ? NumberFormat(v.a_price)
                            : 'под&nbsp;заказ*'
                        }}
                      </td>

                      <td v-if="step2Show" class="text-center m-top">
                        {{ v.kolvo }}
                      </td>

                      <!-- <td>{{ v.kolvo }}</td> -->
                      <td v-else class="text-center">
                        <div class="nobr">
                          <button
                            type="button"
                            class="btn btn-xs btn-danger BtnPlusMinus"
                            @click="cartMinus(v, 1)"
                          >
                            <i class="fa fa-minus"></i>
                          </button>
                          <input
                            type="text"
                            readonly=""
                            style="
                              display: inline-block;
                              width: 40px;
                              text-align: center;
                            "
                            :value="v.kolvo"
                            class="form-control kolvo-items"
                          />
                          <button
                            type="button"
                            class="btn btn-xs btn-success BtnPlusMinus"
                            @click="cartAdd(v, 1)"
                          >
                            <i class="fa fa-plus"></i>
                          </button>
                        </div>
                      </td>

                      <td class="a-right m-top">
                        {{
                          v.a_price && v.a_price > 0 && v.kolvo && v.kolvo > 0
                            ? NumberFormat(v.kolvo * v.a_price)
                            : '-'
                        }}
                      </td>
                    </tr>
                    <tr>
                      <td colspan="3">v {{ v }}</td>
                    </tr>
                  </template>
                </template>
              </tbody>
            </table>

            <!-- <br />
            <br />

            cartArBauyed: {{ cartArBauyed }} -->

            <br />
            <br />
            <p style="color: gray;">
              * - менеджер свяжется с Вами, согласует цену и срок доставки.
            </p>
          </template>
        </div>
        <div class="col-md-4 col-sm-12">
          <cart-order-component />
          <div v-if="1 == 2" class="aside-shopping-cart-total">
            <div class="alert alert-success" v-if="showOk">
              <h2>Заказ</h2>
              {{ form_name2 }}
              <br />
              Тел: {{ form_phone2 }}
              <br />
              {{ form_postedAddress2 }}
            </div>
            <template v-else>
              <div v-if="cartAr.length == 0"></div>
              <div v-else>
                <h2>Заказ</h2>

                <ul>
                  <li>
                    <span class="text">
                      Итого:
                      <span class="xcart-number" id="summa_all_show">
                        {{ NumberFormat(sumall) }}
                        <sup>{{ addPodZakaz ? ' + под заказ' : '' }}</sup>
                      </span>
                    </span>
                  </li>
                  <li>
                    <br />
                    <br />
                    <span class="text xcalculate">Контактные данные</span>
                  </li>
                  <li>
                    <label>
                      Как Вас зовут:
                      <br />
                      <input
                        type="text"
                        class="form-contol"
                        style="max-width: 100%;"
                        v-model="form_name"
                        required=""
                      />
                    </label>
                  </li>
                  <li>
                    <label>
                      Телефон:
                      <br />
                      <input
                        type="text"
                        class="form-contol"
                        style="max-width: 100%;"
                        v-model="form_phone"
                        required=""
                      />
                    </label>
                  </li>
                  <li>
                    <label>
                      Ваш город:
                      <br />
                      <input
                        type="text"
                        class="form-contol"
                        style="max-width: 100%;"
                        v-model="form_city"
                        required=""
                      />
                    </label>
                  </li>
                  <li>
                    <label>
                      <input
                        type="checkbox"
                        style="max-width: 100%;"
                        v-model="form_needHelp"
                      />
                      Нужна помощь специалиста
                    </label>
                  </li>
                  <li id="help_text" style="display: none;">
                    <div style="padding: 10px;">
                      <p style="color: red;">
                        <b>
                          Кроссы и замены на сайте Avto-AS являются справочной
                          информацией и нуждаются в дополнительной проверке.
                          Ответственность за корректный подбор запасных частей
                          лежит на Покупателе. В случае неверного
                          самостоятельного подбора возврат деталей не возможен.
                          <!-- Если требуется помощь - необходимо обратиться к специалисту магазина. -->
                        </b>
                      </p>
                    </div>
                  </li>

                  <li xid="dost1">
                    Нужна доставка ?
                    <span
                      class="btn btn-sm btn-primary"
                      @click="
                        show_form_postedAddress = !show_form_postedAddress
                      "
                    >
                      Да
                    </span>
                  </li>
                  <li xid="dost2" v-if="show_form_postedAddress">
                    <label>
                      Адрес доставки
                      <br />
                      <input
                        type="text"
                        class="form-contol"
                        style="max-width: 100%;"
                        v-model="form_postedAddress"
                      />
                      <br />
                    </label>
                  </li>
                </ul>
                <div class="process">
                  <button class="btn-checkout" type="submit">
                    Отправить заказ
                  </button>
                </div>
              </div>
            </template>
          </div>
        </div>
      </div>
    </form>
    <div class="shopping-cart-option"></div>
  </div>
</template>

<script setup>
import cart from './../use/cart.js'
import sendTelegramm from './../use/sendTelegramm.js'
import { ref, watchEffect, onMounted } from 'vue'

import CartOrderComponent from './CartOrderComponent.vue'
import CartItemComponent from './CartItemComponent.vue'

import fn from './../use/fn.js'

const { NumberFormat } = fn()

// import { useRoute } from 'vue-router'
// const router = useRoute()

import { useRouter, useRoute } from 'vue-router'
const router = useRouter()
const route = useRoute()

// const props = defineProps({
//   orderGood: false,
// })
// alert(props.orderGood ?? 'x')

// // показ списка каталогов по загруженному товару
// const stopWatch4 = watchEffect(() => {
//   if (goodData.value.a_categoryid && goodData.value.a_categoryid.length) {
//     const { catNow } = catalogs()
//     catNow.value = goodData.value.a_categoryid
//     // console.log(882, goodData.value.a_categoryid)
//   }
// })

const {
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

// const s1 = ref(false)
// deleteGoodFromCart

// const itemRemove = (good_id) => {
//   // cartAr.value[good_id]  = -1

//   // var myArray = ['one', 'two', 'three'];
//   // var x = cartAr.value;
//   // var myIndex = x.indexOf(good_id);
//   // if (myIndex !== -1) {
//   //   cartAr.value.splice(myIndex, 1);
//   // }
//   // console.log(33,cartAr.value)
//   cartCashSave()
// }

const sumall = ref(0)
const addPodZakaz = ref(false)

// считаем сумму корзины
const stopWatch7 = watchEffect(() => {
  // if (goodData.value.a_categoryid && goodData.value.a_categoryid.length) {
  //   const { catNow } = catalogs()
  //   catNow.value = goodData.value.a_categoryid
  //   // console.log(882, goodData.value.a_categoryid)
  // }
  if (cartAr.value.length > 0) {
    sumall.value = cartAr.value
      .map((item) => (item.a_price > 0 ? item.kolvo * item.a_price : 0))
      .reduce((prev, curr) => prev + curr, 0)
    // console.log(sumall);

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
</style>
