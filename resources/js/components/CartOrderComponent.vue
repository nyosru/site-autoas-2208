<template>
  <div class="aside-shopping-cart-total">
    step2Show: {{ step2Show }}

    <transition>
      <div class="alert alert-success" v-if="showOk">
        <h2>Заказ</h2>
        {{ form_name2 }}
        <br />
        Тел: {{ form_phone2 }}
        <br />
        {{ form_postedAddress2 }}
      </div>

      <div v-else-if="!step2Show">
        <div v-if="cartAr.length == 0"></div>

        <form action="" method="POST" @submit.prevent="sendOrder" v-else>
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
              <cart-order-show-error-component
                v-if="
                  errorToHtml && errorToHtml.name && errorToHtml.name.length > 0
                "
                :errors="errorToHtml.name"
              />
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
              <cart-order-show-error-component
                v-if="errorToHtml.city && errorToHtml.city.length > 0"
                :errors="errorToHtml.city"
              />
            </li>

            <li>
              <label>
                Телефон:
                <br />
                <input
                  type="text"
                  class="form-contol"
                  style="max-width: 100%;"
                  v-model="phone"
                  required=""
                />
              </label>
              <cart-order-show-error-component
                v-if="errorToHtml.phone && errorToHtml.phone.length > 0"
                :errors="errorToHtml.phone"
              />
            </li>

            <li>
              <label>
                E-mail:
                <br />
                <input
                  type="email"
                  class="form-contol"
                  style="max-width: 100%;"
                  v-model="email"
                  required=""
                />
              </label>
              <cart-order-show-error-component
                v-if="errorToHtml.email && errorToHtml.email.length > 0"
                :errors="errorToHtml.email"
              />
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

            <li v-if="1 == 2" id="help_text">
              <div style="padding: 10px;">
                <p style="color: red;">
                  <b>
                    Кроссы и замены на сайте Avto-AS являются справочной
                    информацией и нуждаются в дополнительной проверке.
                    Ответственность за корректный подбор запасных частей лежит
                    на Покупателе. В случае неверного самостоятельного подбора
                    возврат деталей не возможен.
                    <!-- Если требуется помощь - необходимо обратиться к специалисту магазина. -->
                  </b>
                </p>
              </div>
            </li>

            <li xid="dost1">
              <label>
                <input
                  type="checkbox"
                  style="max-width: 30px;"
                  v-model="show_form_postedAddress"
                />
                Нужна доставка
              </label>
              <!-- <span
              class="btn btn-sm btn-primary"
              @click="show_form_postedAddress = !show_form_postedAddress"
            >
              Да
            </span> -->
            </li>

            <transition>
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
            </transition>
          </ul>

          <!-- errorToHtml: {{ errorToHtml }} -->
          <!-- loadingForm1: {{ loadingForm1 }} -->

          <div class="process">
            <div class="text-xs">
              Перейти к&nbsp;завершающему этапу
              <br />
              оформления заказа
            </div>

            <div v-if="loadingForm1 == true" class="text-center">
              <img src="/storage/img/admin-loader.gif" />
            </div>

            <div v-else>
              <button class="btn-checkout" type="submit">
                Отправить
              </button>
            </div>
          </div>
        </form>
      </div>

      <!-- <div v-else> -->
      <div v-else-if="route.name === 'orderOk' && cartArBauyed.length > 0">
        <div>
          <br />
          <br />
          <h2>Заказ принят</h2>
          <br />
          <br />

          <!-- res2: {{ res2 }} -->

          <!-- На e-mail
      <u>{{ email }}</u><br/>
      отправили ссылку подтверждения -->

          <cart-order-email-component
            :email="email"
            :mail_send="mail_send ?? false"
          />
          <br />
          <br />
          <cart-order-sms-component
            :phone="phone"
            :phone_veritify="res2.phone.phone_confirm ?? ''"
          />
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup>
import cart from './../use/cart.js'
import sendTelegramm from './../use/sendTelegramm.js'
import { ref, watchEffect, onMounted } from 'vue'

import CartOrderShowErrorComponent from './CartOrderShowErrorComponent.vue'
import CartOrderSmsComponent from './CartOrderSmsComponent.vue'
import CartOrderEmailComponent from './CartOrderEmailComponent.vue'

import sms from './../use/sms.js'

// import { useRouter } from 'vue-router'
// const router = useRouter()

import { useRouter, useRoute } from 'vue-router'
const router = useRouter()
const route = useRoute()

const res2 = ref({})
const mail_send = ref(false)

const {
  phone,
  smsSend,
  smsSendRes,
  /* smsSendResCode, */
  smsConfirmSend,
  smsConfirmResult,
  smsConfirmLoading,
} = sms()

// import { useRoute } from 'vue-router'
// const router = useRoute()

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
  nowOrder,
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
// const email = ref('11@11')
// const email = ref('')
const email = ref('1@php-cat.com')
// const phone = ref('79000000001')
// const phone = ref('89222622289')
// const form_phone2 = ref('79000000001')
// const form_phone2 = ref('')
// const form_phone2 = ref('89222622289')

const form_city = ref('Тюмень')
const form_needHelp = ref(false)
const form_need_post = ref(false)
const show_form_postedAddress = ref(false)
const form_postedAddress = ref('')
const form_postedAddress2 = ref('')
const podZakaz = ref(false)

// // показ подтверждения заказа
// const step2Show = ref(false)

const { sendToTelegramm, sendTo } = sendTelegramm()

// загрузка первой формы
const loadingForm1 = ref(false)

const textSms = ref('')
const showOk = ref(false)

const errorToHtml = ref([])

// отправили заказ на сервер
const sendOrderRes = ref(false)

// onMounted(() => {
//   showOk.value = false
// })

const NumberFormat = (num) => {
  return new Intl.NumberFormat('ru-RU', {
    style: 'currency',
    currency: 'RUB',
    maximumFractionDigits: 0,
  }).format(num)
  // return num + ' 777 ';
}

const sendOrder11 = async () => {
  console.log('sendOrder', 77700)
}

const sendOrder = async () => {
  // console.log(77700)

  if (loadingForm1.value == true) {
    return false
  }

  loadingForm1.value = true

  step2Show.value = false
  errorToHtml.value = []
  sendOrderRes.value = false

  await axios
    .post('/api/order', {
      name: form_name.value,
      city: form_city.value,
      phone: phone.value,
      email: email.value,

      form_needHelp: form_needHelp.value,
      form_postedAddress:
        show_form_postedAddress.value == true ? form_postedAddress.value : '',

      goods: cartAr.value,

      // domain: window.location.hostname,
      // // show_datain: 1,
      // answer: 'json',

      // // s: md5('1'),
      // // s: md5(window.location.hostname),

      // // id: 1,
      // id: sendTo.value,
    })
    .then((res) => {
      res2.value = res.data

      //+
      mail_send.value = res.data.send_mail_verified ?? false

      console.log('res.status', res.status)
      console.log('res', res)

      console.log('res d user', res.data.user.id)
      nowOrder.value = res.data.user

      sendOrderRes.value = true
      loadingForm1.value = false

      console.log(55, 11)

      cartArBauyed.value = cartAr.value
      cartAr.value = []
    })
    .catch((error) => {
      console.log('error', error)
      console.log('error response', error.response)
      console.log('error status', error.status)

      // errorToHtml.value = error.response.data.errors

      // console.log('error status', error.status)
      // console.log('error status', error.errors)
      // console.log('error', error.data)
      // console.log('error', error)
      // return 'errored'
      loadingForm1.value = false

      console.log(55, 22)
    })

  if (sendOrderRes.value == true) {
    console.log('res2 1 ', res2.value ?? 'x')
    // console.log('res2', 333)

    // console.log('111',res2.value.phone.phone_confirm);

    // console.log(77 , 33 , 'res2.value', res2.value )
    // console.log(77 , 33 , 'res2.value.phone', res2.value.phone )
    // console.log(77 , 33 , 'res2.value.phone.phone_confirm', res2.value.phone.phone_confirm )
    // console.log(77 , 33 , 'res2.value.phone.phone_confirm.length', res2.value.phone.phone_confirm.length ?? 'x' )

    console.log(77, 11, 22)

    if (res2.value && !res2.value.phone.phone_confirm) {
      //   console.log(77 , 11, 33, 55);
      // }
      // if ( res2.value.phone.phone_confirm ) {

      // console.log(77, 11, 33)
      // console.log(77, 11, res2.value.phone.phone_confirm)
      // console.log(77, res2.value.phone.phone)
      await smsSend(res2.value.phone.phone)
      console.log(77, smsSendRes.value)
    }

    console.log(77, 11, 44)
    step2Show.value = true

    // cartCashSaveBeforeOrder()
    // router.push('/cart_ok')
    // router.push({ name: 'orderOk' })
  }
}
</script>

<style scoped>
/* we will explain what these classes do next! */
.v-enter-active,
.v-leave-active {
  transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}
</style>
