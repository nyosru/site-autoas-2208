<template>
  <div class="aside-shopping-cart-total">
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
              v-if="errorToHtml.name && errorToHtml.name.length > 0"
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
                  Ответственность за корректный подбор запасных частей лежит на
                  Покупателе. В случае неверного самостоятельного подбора
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

        errorToHtml: {{ errorToHtml }}

        <div class="process">
          <div class="text-xs">
            Перейти к&nbsp;завершающему шагу
            <br />
            оформления заказа
          </div>
          <button class="btn-checkout" type="submit">
            Отправить
          </button>
        </div>
      </form>
    </template>
  </div>
</template>

<script setup>
import cart from './../use/cart.js'
import sendTelegramm from './../use/sendTelegramm.ts'
import { ref, watchEffect, onMounted } from 'vue'

import CartOrderShowErrorComponent from './CartOrderShowErrorComponent.vue'

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
  // товары в корзине a_id = quantity
  cartAr,
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
  sumall.value = cartAr.value
    .map((item) => (item.a_price > 0 ? item.kolvo * item.a_price : 0))
    .reduce((prev, curr) => prev + curr, 0)
  // console.log(sumall);

  if (cartAr.value.find((el) => el.a_price == '')) {
    addPodZakaz.value = true
  } else {
    addPodZakaz.value = false
  }
})

const form_name = ref('')
const form_name2 = ref('')
const email = ref('')
const phone = ref('')
const form_phone2 = ref('')
const form_city = ref('Тюмень')
const form_needHelp = ref(false)
const form_need_post = ref(false)
const show_form_postedAddress = ref(false)
const form_postedAddress = ref('')
const form_postedAddress2 = ref('')
const podZakaz = ref(false)

const { sendToTelegramm, sendTo } = sendTelegramm()

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

const sendOrder = async () => {
  console.log(77700)

  errorToHtml.value = []

  sendOrderRes.value = false
  let res2 = await axios
    .post('/api/orger', {

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
      console.log('res.status', res.status)
      console.log('res', res)
      sendOrderRes.value = true
    })
    .catch((error) => {
      // console.log('error response', error.response)
      errorToHtml.value = error.response.data.errors
      // console.log('error status', error.status)
      // console.log('error status', error.errors)
      // console.log('error', error.data)
      // console.log('error', error)
      // return 'errored'
    })

  console.log('sendOrderRes.value', sendOrderRes.value)

  if (sendOrderRes.value == true) {
    // console.log('res2', res2)
    console.log('res2', 333)
    return false

    // добавляем серхио тест
    // sendTo.value.push(5152088168)
    // first_name: Авто-АС
    // sendTo.value.push(1022228978)
    // Денис Авто-СА
    // sendTo.value.push(663501687)

    podZakaz.value = false

    textSms.value =
      'новый заказ:' +
      '\n' +
      form_name.value +
      ' (' +
      form_city.value +
      ')' +
      '\n' +
      'Тел: ' +
      phone.value +
      '\n' +
      'Email: ' +
      email.value +
      '\n' +
      'Нужна помощь:' +
      (form_needHelp.value ? 'ДА' : 'НЕТ') +
      '\n' +
      'Доставка:' +
      (show_form_postedAddress.value
        ? 'нужна > Адрес: ' + (form_postedAddress.value ?? '-')
        : 'НЕ нужна') +
      '\n'

    cartAr.value.forEach((e) => {
      textSms.value +=
        '\n' +
        e.head +
        '\n' +
        (e.id && e.id > 0 && e.a_id && e.a_id.length ? '' : '(заказ) ') +
        e.a_id +
        ' // ' +
        (e.a_price != ''
          ? e.a_price +
            ' р * ' +
            e.kolvo +
            ' ед.' +
            ' = ' +
            e.a_price * e.kolvo +
            'р'
          : 'под заказ ' + e.kolvo + ' ед.') +
        '\n'
      if (e.a_price != '') {
        podZakaz.value = true
      }
    })

    textSms.value +=
      '\n Итого: ' +
      sumall.value +
      ' р. ' +
      (podZakaz.value ? ' + под заказ ' : '')

    let ww = await sendToTelegramm(textSms.value)

    console.log(77711, ww)

    if (ww == 'sended') {
      // alert('Заказ отправлен, позвоним в рабочее время')
      // router.push({ name: 'orderOk' })

      form_name2.value = form_name.value
      form_phone2.value = phone.value
      form_postedAddress2.value = form_postedAddress.value
      showOk.value = true
      cartAr.value = []
      cartCashSave()
    }
  }
}

//  async formSend() {
//       //   console.log(2222, this.formName, this.formPhone, this.formMsg);
//       //   console.log(2222, this.formPhone, this.titleFrom);

//       this.loading = true;

//       const { sendToTelegramm } = sendTelegramm();
//       let ww = await sendToTelegramm(
//         "Где: " +
//           this.titleFrom +
//           "<br>" +
//           "Как зовут: " +
//           this.formName +
//           "<br>" +
//           "Телефон: " +
//           this.formPhone +
//           "<br>" +
//           "Сообщение: " +
//           this.formMsg
//       );
//       //   console.log('ww',ww);
//       this.result = ww;
//     },
</script>

<style scoped></style>
