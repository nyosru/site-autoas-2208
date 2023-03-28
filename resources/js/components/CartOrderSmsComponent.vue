<template>
  <form action="" method="post" @submit.prevent="ConfirmSendForm()">
    <div class="mb-1 text-center">
      Указан телефон:
      <br />
      <b>{{ phone }}</b>
    </div>
    <br />

    <!-- nowOrder: {{ nowOrder }} -->
    <!-- phone_veritify: {{ phone_veritify ?? 'x' }} / {{ phone_veritify ? phone_veritify.length : 'x' }} -->

    <div v-if="phone_veritify.length == 0">
      <div
        v-if="nowOrder.phone_confirm && nowOrder.phone_confirm.length > 0"
      ></div>
      <div v-else>
        <div v-if="smsSendResCode == ''" class="text-center">
          Загружаем возможность подтверждения
          <br />
          <img src="/storage/img/admin-loader.gif" width="32" />
        </div>
        <div v-else>
          <div v-if="smsResLoading">
            ... загружаю ...
          </div>
          <div v-else>
            <span v-if="!smsConfirmResult">
              Подтвердите сотовый телефон, сейчас вам позвонит автономер,
              введите 4 последних цифры этого номера
              <!-- <br />
          smsSendResCode: {{ smsSendResCode }} -->
              <br />
              <br />
            </span>
            <div class="text-center">
              <span v-if="!smsConfirmResult">
                <input type="text" v-model="smsText" class="sms-input" />

                <!-- <cart-order-show-error-component
              v-if="errorToHtmlSms && errorToHtmlSms.length > 0"
              :errors="errorToHtmlSms"
            /> -->

                <br />
                <div v-if="smsTextError != ''" class="mb-5 alert alert-danger">
                  {{ smsTextError }}
                </div>
              </span>
              <button
                v-if="smsConfirmResult"
                class="btn-success"
                type="button"
                style="border-radius: 5px; padding: 5px 10px 5px 10px;"
              >
                Подтверждено!
              </button>
              <button
                v-else
                class="btn-checkout"
                type="submit"
                style="border-radius: 5px; padding: 5px 10px 5px 10px;"
              >
                Подтвердить
              </button>
              <br />
              <br />
              <!-- <br />
          nowOrder: {{ nowOrder }} -->
              <!-- <br />
          smsConfirmResult: {{ smsConfirmResult }} -->
              <!-- <br />
          smsConfirmResult.result: {{ smsConfirmResult.result }} -->
              <!-- <br />
          smsConfirmLoading: {{ smsConfirmLoading }} -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</template>

<script setup>
import { ref } from 'vue'
import sms from './../use/sms.js'

const props = defineProps({
  phone: '',
  phone_veritify: '',
})

const smsText = ref('')
const smsTextError = ref('')
const {
  smsConfirmSend,
  smsSendResCode,
  smsConfirmResult,
  smsConfirmLoading,
} = sms()

import cart from './../use/cart.js'
const { nowOrder } = cart()

const smsResLoading = ref(false)

const ConfirmSendForm = async () => {
  smsResLoading.value = true
  console.log('phone', props.phone, smsText.value, smsSendResCode.value)

  if (smsText.value == smsSendResCode.value) {
    let rr = await smsConfirmSend(smsText.value)
    // console.log(['7722', rr])
    console.log(['ConfirmSendForm res smsConfirmSend', rr])
    // console.log(33, nowOrder.id)
    // smsConfirmResult.value = await smsConfirmSend(smsText.value)
    smsConfirmResult.value = true
    console.log('ConfirmSendForm res 1', smsConfirmResult.value)
    smsTextError.value = ''
  } else {
    smsTextError.value = 'Введён не верный код подтверждения'
    console.log('ConfirmSendForm res 2')
  }
  smsResLoading.value = false
}
</script>

<style scoped>
.sms-input {
  padding-bottom: 3px;
  padding-top: 3px;
  font-size: 1.5rem;
  text-align: center;
  width: 80px;
}
</style>
