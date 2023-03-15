<template>
  <div class="container">
    <div class="row">
      <template v-if="1 == 2">
        <div class="col-12">route: {{ route.params }}</div>
        <div class="col-12">
          route v1: {{ route.params.var1 }}
          <br />
          route v2: {{ route.params.var2 }}
        </div>
      </template>

      <div class="row" v-if="route.params.var1 == 'mailVerify'">
        <div class="col-12 alert alert-success p-5 text-center">
          <h2>
            E-mail:
            <u>{{ route.params.var2 }}</u>
            подтверждён успешно, спасибо
          </h2>
        </div>
      </div>

      <div class="row" v-else-if="route.params.var1 == 'mailStop'">
        <Transition>
        <div
          class="col-12 alert alert-success p-5 text-center"
          v-if="mailStopRes === true"
        >
          <h2>Ок, Спасибо</h2>
        </div>
        <div v-else class="col-12 alert alert-warning p-5 text-center">
          <h2>
            Отписаться от рассылки ?
            <br />
            на E-mail:
            <u>{{ route.params.var2 }}</u>
          </h2>

          <br />

          <a @click.prevent="saveStopMail" href="#" class="btn btn-danger">
            Не хочу больше получать сообщения
          </a>
          &nbsp;
          <a @click.prevent="mailStopRes = true" class="btn btn-success">
            Ладно, Пусть приходят
          </a>
        </div>
      </Transition>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRoute } from 'vue-router'
import mailStop from './../../use/mailStop.js'

const { stopMailLoading, StopMail } = mailStop()

const route = useRoute()
// console.log(222, route.params)

const mailStopRes = ref(false)

const saveStopMail = async () => {
  let rr = await StopMail(route.params.var2, route.params.var2)
  console.log(55, rr ?? 'x')
  // console.log(66, rr.res)
  // return false
  mailStopRes.value = true
}

// const mailV = ref(route.params.)
// const goodQuantity = ref(1)

// const props = defineProps({
//   // показывать или нет заказ с удалённого склада
//   showOrdersOnSklad: Boolean,
// })

// // onMounted(() => {
// //   goodQuantity.value = 1
// // })

// // catsLevelLower
// // const { loading } = catalogs()

// const { goodLoading, goodData, loadGood } = goods()

// // загрузка товара
// const stopWatch3 = watchEffect(() => {
//   if (route.params.good_id && route.params.good_id.length) {
//     loadGood(route.params.good_id)
//     // console.log(880, route.params.good_id)
//   }
// })
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
