const NumberFormat = (num) => {
    return new Intl.NumberFormat('ru-RU', {
            style: 'currency',
            currency: 'RUB',
            maximumFractionDigits: 0,
        }).format(num)
        // return num + ' 777 ';
}

export default function fn() {
    return {
        NumberFormat,
    }
}

// import {
//     ref,
//     // reactive, toRefs, readonly,
//     // watch,
//     // computed
// } from 'vue'

// // import axios from 'axios'

// const nowOrder = ref({})

// // товары в корзине a_id = quantity
// const cartAr = ref([])
// const cartArBauyed = ref({})

// // инфа по товарам в корзине
// // const cartArGoods = ref({})

// const setStandartGood = (good) => {
//     if (good.OfferName && good.OfferName.length) {
//         good.a_id = good.OfferName
//     }
//     if (good.ProductName && good.ProductName.length) {
//         good.head = good.ProductName
//     }
//     if (good.ManufacturerName && good.ManufacturerName.length) {
//         good.manufacturer = good.ManufacturerName
//     }
//     if (good.Price && (good.Price > 0 || good.Price.length)) {
//         good.a_price = good.Price
//     }
//     return good
// }

// // const howNowId = (good) => {
// //     if (good.a_id && good.a_id.length) {
// //         return good.a_id
// //     } else if (good.OfferName && good.OfferName.length) {
// //         return good.OfferName
// //     }
// // }

// const cartAdd = (good, kolvo = 1) => {
//     // let nom = (good.a_id && good.a_id.length) ? good.a_id : good.Reference
//     // let nom = howNowId(good)

//     good = setStandartGood(good)

//     let findIndex = cartAr.value.findIndex((o) => o.a_id === good.a_id)

//     if (findIndex === -1) {
//         // cartAr.value.findIndex((o) => {
//         //     if (o.a_id === good.a_id) {
//         //         console.log(o)
//         //     }
//         // })

//         good.kolvo = kolvo

//         // good = setStandartGood(good)

//         cartAr.value.push(good)
//         console.log(11, cartAr.value)
//     } else {
//         console.log(22, findIndex)
//         cartAr.value[findIndex]['kolvo'] = cartAr.value[findIndex]['kolvo'] + kolvo
//     }

//     // // if ( good.a_id && cartAr.value[good.a_id] && cartAr.value[good.a_id] > 0 ) {
//     // //   cartAr.value[good.a_id] = cartAr.value[good.a_id] + kolvo
//     // // } else {
//     // //   cartAr.value[good.a_id] = kolvo
//     // // }

//     // cartArGoods.value[good.a_id] = good

//     // console.log(11, cartAr.value, cartArGoods.value )

//     cartCashSave()
// }

// const cartMinus = (good, kolvo = 1) => {
//     // let a = cartAr.value[good.a_id] - kolvo
//     // cartAr.value[good.a_id] = a >= 0 ? a : 0

//     let findIndex = cartAr.value.findIndex((o) => o.a_id === good.a_id)

//     if (findIndex === -1) {
//         // cartAr.value.findIndex((o) => {
//         //     if (o.a_id === good.a_id) {
//         //         console.log(o)
//         //     }
//         // })

//         good.kolvo = kolvo
//         cartAr.value.push(good)
//         console.log(11, cartAr.value)
//     } else {
//         console.log(22, findIndex)
//         cartAr.value[findIndex]['kolvo'] =
//             cartAr.value[findIndex]['kolvo'] > 1 ?
//             cartAr.value[findIndex]['kolvo'] - kolvo :
//             0
//     }

//     cartCashSave()
// }

// const cartRemove = (id) => {
//     if (!confirm('Удалить товар из заказа ?')) {
//         return false
//     }

//     // cartAr.value[good_id]  = -1
//     // var myArray = ['one', 'two', 'three'];
//     // var x = cartAr.value;
//     // var myIndex = x.indexOf(good_id);
//     // if (myIndex !== -1) {
//     //   cartAr.value.splice(myIndex, 1);
//     // }

//     // cartAr.value.forEach(){}
//     // cartAr.value.filter(e => e.population < 1000000)

//     let index = cartAr.value.findIndex((e) => e.a_id === id)
//     if (index !== -1) {
//         // console.log(331, cartAr.value[index])
//         cartAr.value.splice(index, 1)
//     }
//     // else {
//     //     console.log(33, id)
//     // }

//     cartCashSave()
// }

// // пишем корзину в кеш
// const cartCashSave = () => {
//     localStorage.cart = JSON.stringify(cartAr.value)
//         // localStorage.cartGood = JSON.stringify(cartArGoods.value)
// }

// // читаем корзину из кеш
// const cartCashRead = () => {
//     // localStorage.cats = JSON.stringify(cartAr.value)
//     if (localStorage.cart && localStorage.cart.length) {
//         cartAr.value = JSON.parse(localStorage.cart)
//             // cartArGoods.value = JSON.parse(localStorage.cartGood)
//     }
// }

// const goodInCart = (id_str) => {
//     // return cartAr.value[id_str] && cartAr.value[id_str] > 0
//     let findIndex = cartAr.value.findIndex((o) => o.a_id === id_str)
//         // let findIndex2 = cartAr.value.findIndex((o) => o.Reference === id_str)
//         // return findIndex === -1 ? (findIndex2 === -1 ? false : true) : true
//     return findIndex === -1 ? false : true
// }

// // const deleteGoodFromCart = (id_str) => {

// //   console.log(cartAr.value, id_str);
// //   cartMinus(id_str,0)
// //   // if( cartAr.value[id_str] ){
// //   //   cartAr.value[id_str] = 0
// //   // }

// //   // let r = cartAr.value
// //   // r.forEach(function callback(v, i, obj) {
// //   //   // if (v == id_str) {
// //   //   console.log(99, v, i)
// //   //   // }
// //   // })

// //   // cartAr.value = cartAr.value.filter( b => b != id_str )
// //   // console.log(99,cartAr.value);

// //   // return cartAr.value[id_str] && cartAr.value[id_str] > 0
// // }

// // const goodData = ref({})

// // // отфильтрованный список
// // // const data_filtered = ref({})
// // // загрузка идёт или нет
// // const goodsLoading = ref(true)
// // const goodLoading = ref(true)

// // // какой модуль сейчас загружен
// // // const loading_module_now = ref('')

// // const page0 = ref('')
// // const page01 = ref(0)

// // // const loadData = (module, db_connection = 'out') => {
// //   /**
// //    * загрузка данных по товарам что в корзине
// //    */
// // const loadGoodsInCart = () => {
// // //   goodsData.value = []
// // //   goodsLoading.value = true

// // //   if (page > 0) {
// // //     page0.value = '?page=' + page
// // //     page01.value = page
// // //   } else {
// // //     page0.value = ''
// // //     page01.value = 0
// // //   }

// // //   // window.scrollTo(0,0)

// //   axios
// //     .get('/api/goodscat/' + cat_id + page0.value)
// //     .then((response) => {
// //       // console.log("get_datar", response.data);
// //       // items_loading_module.value = items_now_loading.value;

// //       // data_filtered.value =
// //       goodsData.value = response.data
// //       // localStorage.cats = JSON.stringify(response.data.data)
// //       // cfg.value = response.data.cfg;
// //       goodsLoading.value = false
// //       // return response.data;
// //       // items_loading.value = dfalse
// //       window.scrollTo(0,0)
// //     })
// //     .catch((error) => {
// //       console.log(error)
// //       // this.errored = true;
// //     })
// // }

// // const loadGood = ( good_id ) => {

// //   goodData.value = []
// //   goodLoading.value = true

// //   // window.scrollTo(0,0)

// //   axios
// //     .get('/api/good/' + good_id )
// //     .then((response) => {

// //       // console.log("get_datar", response.data);
// //       // items_loading_module.value = items_now_loading.value;

// //       // data_filtered.value =

// //       goodData.value = response.data.data[0]
// //       // localStorage.cats = JSON.stringify(response.data.data)
// //       // cfg.value = response.data.cfg;

// //       goodLoading.value = false
// //       // return response.data;
// //       // items_loading.value = dfalse

// //       window.scrollTo(0,0)
// //     })
// //     .catch((error) => {
// //       console.log(error)
// //       // this.errored = true;
// //     })
// // }

// // показ подтверждения заказа
// const step2Show = ref(false)

// export default function cart() {
//     return {
//         nowOrder,
//         // показ подтверждения заказа
//         step2Show,
//         // товары в корзине a_id = quantity
//         cartAr,
//         cartArBauyed,

//         // cartArGoods,
//         // добавляем
//         cartAdd,
//         // отнимаем
//         cartMinus,

//         goodInCart,

//         // корзину в кеш
//         cartCashSave,
//         // корзину из кеш
//         cartCashRead,

//         cartRemove,

//         setStandartGood,

//         // loadGoods,
//         // goodsLoading,
//         // goodsData,
//         // loadGood,
//         // goodLoading,
//         // goodData,
//     }
// }