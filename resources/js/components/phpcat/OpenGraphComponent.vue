<template>
  <meta
    property="og:title"
    content="Скрипт колесо фортуны - виджет, повышающий конверсию сайта"
  />
  <meta property="og:site_name" content="Smartlanding.biz" />
  <meta
    property="og:url"
    content="https://smartlanding.biz/smartroulette-lp/"
  />
  <meta
    property="og:description"
    content="SmartRoulette - скрипт (виджет) для сайта, который в игровой форме повышает конверсию и собирает в 2 раза больше заявок. В простонародье - «Колесо фортуны»"
  />
  <meta
    property="og:image"
    content="https://smartlanding.biz/smartroulette-lp/img/preview-koleso-fortuny.png"
  />
  <meta property="og:image:width" content="968" />
  <meta property="og:image:height" content="504" />
</template>

<script setup>
// import cart from './../use/cart.js'
// import sendTelegramm from './../use/sendTelegramm.ts'
// import { ref, watchEffect, onMounted } from 'vue'

// // import { useRoute } from 'vue-router'
// // const router = useRoute()

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

// const {
//   // товары в корзине a_id = quantity
//   cartAr,
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
// } = cart()

// const s1 = ref(false)
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
//   sumall.value = cartAr.value
//     .map((item) => (item.a_price > 0 ? item.kolvo * item.a_price : 0))
//     .reduce((prev, curr) => prev + curr, 0)
//   // console.log(sumall);

//   if (cartAr.value.find((el) => el.a_price == '')) {
//     addPodZakaz.value = true
//   } else {
//     addPodZakaz.value = false
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

// const NumberFormat = (num) => {
//   return new Intl.NumberFormat('ru-RU', {
//     style: 'currency',
//     currency: 'RUB',
//   }).format(num)
//   // return num + ' 777 ';
// }
// const sendOrder = async (good_id) => {
//   console.log(77700)

//   // добавляем серхио тест
//   // sendTo.value.push(5152088168)
//   // first_name: Авто-АС
//   sendTo.value.push(1022228978)
//   // Денис Авто-СА
//   sendTo.value.push(663501687)

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

<style scoped></style>
