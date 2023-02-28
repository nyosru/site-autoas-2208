<template>
  <form action="" method="post" @submit.prevent="ConfirmSendForm()">
    <div class="mb-1 text-center">
      Указан телефон:
      <br />
      <b>{{ phoneNom }}</b>
    </div>
    <br />
    <div v-if="smsSendResCode == ''" class="text-center">
      Загружаем возможность подтверждения
      <br />
      <img src="/storage/img/admin-loader.gif" />
    </div>
    <div v-else>
      <span v-if="!smsConfirmResult">
        Подтвердите сотовый телефон, сейчас вам позвонит автономер, введите 4
        последних цифры этого номера
        <br />
        smsSendResCode: {{ smsSendResCode }}
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
        <br />
        smsConfirmResult: {{ smsConfirmResult }}
        <br />
        smsConfirmResult.result: {{ smsConfirmResult.result }}
        <br />
        smsConfirmLoading: {{ smsConfirmLoading }}
      </div>
    </div>
  </form>
</template>

<script setup>
import { ref } from 'vue'
import sms from './../use/sms.js'

const props = defineProps({
  phoneNom: '',
  // code: '',
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

const ConfirmSendForm = async () => {
  console.log('phone', props.phoneNom, smsText.value, smsSendResCode.value)

  if (smsText.value == smsSendResCode.value) {
    // console.log(33, nowOrder.id)
    // smsConfirmResult.value = await smsConfirmSend(smsText.value)
    smsConfirmResult.value = true
    console.log('res 1', smsConfirmResult.value)
    smsTextError.value = ''
  } else {
    smsTextError.value = 'Введён не верный код подтверждения'
    console.log('res 2')
  }
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
