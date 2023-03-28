<template>
  <div class="container xcheckout-cart-form">

    <div style="max-height: 200px; overflow-x: auto;">
      route:
      <br />
      {{ route }}
      <br />
      router:
      <br />
      {{ router }}
    </div>

    <br />

    route.name: {{ route.name }}
    <br />
    cartAr.length: {{ cartAr.length }}
    <br />
    showOk: {{ showOk }}
    <br />

    <div class="row">
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
      </div>
    </div>
    <div class="shopping-cart-option"></div>
  </div>
</template>

<script setup>

import cart from './../use/cart.js'
// import sendTelegramm from './../use/sendTelegramm.js'
import { ref, watchEffect, onMounted } from 'vue'

import CartOrderComponent from './CartOrderComponentOrderOk.vue'
import CartItemComponent from './CartItemComponent.vue'

// import fn from './../use/fn.js'

// const { NumberFormat } = fn()

// // import { useRoute } from 'vue-router'
// // const router = useRoute()

import { useRouter, useRoute } from 'vue-router'
const router = useRouter()
const route = useRoute()

// // const props = defineProps({
// //   orderGood: false,
// // })
// // alert(props.orderGood ?? 'x')

// // // показ списка каталогов по загруженному товару
// // const stopWatch4 = watchEffect(() => {
// //   if (goodData.value.a_categoryid && goodData.value.a_categoryid.length) {
// //     const { catNow } = catalogs()
// //     catNow.value = goodData.value.a_categoryid
// //     // console.log(882, goodData.value.a_categoryid)
// //   }
// // })

const {
//   // товары в корзине a_id = quantity
  cartAr,
  cartArBauyed,
//   // cartArGoods,
//   // добавляем
//   cartAdd,
//   // отнимаем
//   cartMinus,
//   // поиск есть или нет товар в корзине
//   goodInCart,
//   // deleteGoodFromCart,
//   cartRemove,
//   cartCashSave,
//   // показ подтверждения заказа
//   step2Show,
//   cartCashSaveBeforeOrder,
} = cart()

// // const s1 = ref(false)
// // deleteGoodFromCart

// // const itemRemove = (good_id) => {
// //   // cartAr.value[good_id]  = -1

// //   // var myArray = ['one', 'two', 'three'];
// //   // var x = cartAr.value;
// //   // var myIndex = x.indexOf(good_id);
// //   // if (myIndex !== -1) {
// //   //   cartAr.value.splice(myIndex, 1);
// //   // }
// //   // console.log(33,cartAr.value)
// //   cartCashSave()
// // }

// const sumall = ref(0)
// const addPodZakaz = ref(false)

// // считаем сумму корзины
// const stopWatch7 = watchEffect(() => {
//   // if (goodData.value.a_categoryid && goodData.value.a_categoryid.length) {
//   //   const { catNow } = catalogs()
//   //   catNow.value = goodData.value.a_categoryid
//   //   // console.log(882, goodData.value.a_categoryid)
//   // }
//   if (cartAr.value.length > 0) {
//     sumall.value = cartAr.value
//       .map((item) => (item.a_price > 0 ? item.kolvo * item.a_price : 0))
//       .reduce((prev, curr) => prev + curr, 0)
//     // console.log(sumall);

//     if (cartAr.value.find((el) => el.a_price == '')) {
//       addPodZakaz.value = true
//     } else {
//       addPodZakaz.value = false
//     }
//   } else {
//     sumall.value = 0
//   }
// })

// const form_name = ref('')
// const form_name2 = ref('')

// const form_phone = ref('')
// const form_phone2 = ref('')

// const form_city = ref('Тюмень')
// const form_needHelp = ref(false)

// const show_form_postedAddress = ref(false)
// const form_postedAddress = ref('')

// const form_postedAddress2 = ref('')
// const podZakaz = ref(false)

// const { sendToTelegramm, sendTo } = sendTelegramm()

// const textSms = ref('')
// const showOk = ref(false)

// // onMounted(() => {
// //   showOk.value = false
// // })

// const sendOrder = async (good_id) => {
//   console.log(77700)

//   // добавляем серхио тест
//   // sendTo.value.push(5152088168)

//   // // first_name: Авто-АС
//   // sendTo.value.push(1022228978)
//   // // Денис Авто-СА
//   // sendTo.value.push(663501687)

//   podZakaz.value = false

//   textSms.value =
//     'новый заказ:' +
//     '\n' +
//     form_name.value +
//     ' (' +
//     form_city.value +
//     ')' +
//     '\n' +
//     'Тел: ' +
//     form_phone.value +
//     '\n' +
//     'Нужна помощь:' +
//     (form_needHelp.value ? 'ДА' : 'НЕТ') +
//     '\n' +
//     'Доставка:' +
//     (show_form_postedAddress.value
//       ? 'нужна > Адрес: ' + (form_postedAddress.value ?? '-')
//       : 'НЕ нужна') +
//     '\n'

//   cartAr.value.forEach((e) => {
//     textSms.value +=
//       '\n' +
//       e.head +
//       '\n' +
//       (e.id && e.id > 0 && e.a_id && e.a_id.length ? '' : '(заказ) ') +
//       e.a_id +
//       ' // ' +
//       (e.a_price != ''
//         ? e.a_price +
//           ' р * ' +
//           e.kolvo +
//           ' ед.' +
//           ' = ' +
//           e.a_price * e.kolvo +
//           'р'
//         : 'под заказ ' + e.kolvo + ' ед.') +
//       '\n'
//     if (e.a_price != '') {
//       podZakaz.value = true
//     }
//   })

//   textSms.value +=
//     '\n Итого: ' +
//     sumall.value +
//     ' р. ' +
//     (podZakaz.value ? ' + под заказ ' : '')

//   let ww = await sendToTelegramm(textSms.value)

//   console.log(77711, ww)

//   if (ww == 'sended') {
//     // alert('Заказ отправлен, позвоним в рабочее время')
//     // router.push({ name: 'orderOk' })

//     form_name2.value = form_name.value
//     form_phone2.value = form_phone.value
//     form_postedAddress2.value = form_postedAddress.value
//     showOk.value = true
//     cartAr.value = []
//     cartCashSave()

//     cartCashSaveBeforeOrder()
//     $router.push({ name: 'orderOk' })
//   }
// }

// //  async formSend() {
// //       //   console.log(2222, this.formName, this.formPhone, this.formMsg);
// //       //   console.log(2222, this.formPhone, this.titleFrom);

// //       this.loading = true;

// //       const { sendToTelegramm } = sendTelegramm();
// //       let ww = await sendToTelegramm(
// //         "Где: " +
// //           this.titleFrom +
// //           "<br>" +
// //           "Как зовут: " +
// //           this.formName +
// //           "<br>" +
// //           "Телефон: " +
// //           this.formPhone +
// //           "<br>" +
// //           "Сообщение: " +
// //           this.formMsg
// //       );
// //       //   console.log('ww',ww);
// //       this.result = ww;
// //     },
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
