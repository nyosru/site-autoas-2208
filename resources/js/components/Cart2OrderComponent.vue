<template>
  <div class="aside-shopping-cart-total">
    <!-- step2Show: {{ step2Show }} <br/> -->
    <!-- orderFormSended: {{orderFormSended}}<br/> -->

    <transition>
      <div class="alert alert-success" v-if="!orderFormSended && showOk">
        <h2>Заказ</h2>
        {{ form_name2 }}
        <br />
        Тел: {{ form_phone2 }}
        <br />
        {{ form_postedAddress2 }}
      </div>

      <div v-else-if="!orderFormSended && !step2Show">
        <form
          action=""
          method="POST"
          @submit.prevent="sendOrder"
          v-if="cartAr.length > 0"
        >
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
      <div v-else-if="orderFormSended === true && cartArBauyed.length > 0">
        <!-- <div v-else-if="route.meta.level == 2 route.name === 'orderOk' && cartArBauyed.length > 0" > -->
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

import { useRouter, useRoute } from 'vue-router'
const router = useRouter()
const route = useRoute()

const {
  phone,
  smsSend,
  smsSendRes,
  smsConfirmSend,
  smsConfirmResult,
  smsConfirmLoading,
} = sms()

const {
  orderFormSended,

  mail_send,

  res2,

  form_name,
  form_name2,
  email,

  form_city,
  form_needHelp,
  form_need_post,
  show_form_postedAddress,
  form_postedAddress,
  form_postedAddress2,
  podZakaz,

  // отправили заказ на сервер
  sendOrderRes,
  errorToHtml,

  // загрузка первой формы
  loadingForm1,

  sendOrder,

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

const { sendToTelegramm, sendTo } = sendTelegramm()

const textSms = ref('')
const showOk = ref(false)

const NumberFormat = (num) => {
  return new Intl.NumberFormat('ru-RU', {
    style: 'currency',
    currency: 'RUB',
    maximumFractionDigits: 0,
  }).format(num)
}

const sendOrder11 = async () => {
  console.log('sendOrder', 77700)
}
</script>

<style scoped>
.v-enter-active,
.v-leave-active {
  transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}
</style>
