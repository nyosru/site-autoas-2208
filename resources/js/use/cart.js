import {
    ref,
} from 'vue'

import sms from './sms.js'

const {
    phone,
    smsSend,
    smsSendRes,
} = sms()

const nowOrder = ref({})

// товары в корзине a_id = quantity
const cartAr = ref([])
const cartArBauyed = ref({})

const setStandartGood = (good) => {
    if (good.OfferName && good.OfferName.length) {
        good.a_id = good.OfferName
    }
    if (good.ProductName && good.ProductName.length) {
        good.head = good.ProductName
    }
    if (good.ManufacturerName && good.ManufacturerName.length) {
        good.manufacturer = good.ManufacturerName
    }
    if (good.Price && (good.Price > 0 || good.Price.length)) {
        good.a_price = good.Price
    }
    return good
}

const cartAdd = (good, kolvo = 1) => {

    good = setStandartGood(good)

    let findIndex = cartAr.value.findIndex((o) => o.a_id === good.a_id)

    if (findIndex === -1) {

        good.kolvo = kolvo

        cartAr.value.push(good)
    } else {
        cartAr.value[findIndex]['kolvo'] = cartAr.value[findIndex]['kolvo'] + kolvo
    }

    cartCashSave()
}

const cartMinus = (good, kolvo = 1) => {
    let findIndex = cartAr.value.findIndex((o) => o.a_id === good.a_id)

    if (findIndex === -1) {
        good.kolvo = kolvo
        cartAr.value.push(good)
    } else {
        cartAr.value[findIndex]['kolvo'] =
            cartAr.value[findIndex]['kolvo'] > 1 ?
            cartAr.value[findIndex]['kolvo'] - kolvo :
            0
    }

    cartCashSave()
}

const cartRemove = (id, conf = true) => {
    if (conf === true) {
        if (!confirm('Удалить товар из заказа ?')) {
            return false
        }
    }

    let index = cartAr.value.findIndex((e) => e.a_id === id)
    if (index !== -1) {
        cartAr.value.splice(index, 1)
        cartCashSave()
    }

}

// пишем корзину в кеш
const cartCashSave = () => {
    localStorage.cart = JSON.stringify(cartAr.value)
        // localStorage.cartGood = JSON.stringify(cartArGoods.value)
}

const noOrder = ref({})

/**
 * оставляем в корзине только товары что не попали в заказ ( кол-во == 0 )
 */
const orderGoodsInOrder = () => {
    let res = []
    let res2 = []

    cartAr.value.forEach(function(v, k) {
        if (v.kolvo > 0) {
            res.push(v)
            cartRemove(v.a_id, false)
        } else {
            res2.push(v)
        }
    })

    cartAr.value = res2

    return res

}

// читаем корзину из кеш
const cartCashRead = () => {
    if (localStorage.cart && localStorage.cart.length) {
        cartAr.value = JSON.parse(localStorage.cart)
    }
}

const goodInCart = (id_str) => {

    if (Object.keys(cartAr.value).length === 0) return false

    let findIndex = cartAr.value.findIndex((o) => o.a_id === id_str)
    return findIndex === -1 ? false : true
}

const orderFormSended = ref(false)

const mail_send = ref(false)

const res2 = ref({})

const form_name = ref('')
const form_name2 = ref('')
    // const email = ref('1@php-cat.com')
const email = ref('')

const form_city = ref('Тюмень')
const form_needHelp = ref(false)
const form_need_post = ref(false)
const show_form_postedAddress = ref(false)
const form_postedAddress = ref('')
const form_postedAddress2 = ref('')
const podZakaz = ref(false)

// отправили заказ на сервер
const sendOrderRes = ref(false)

// показ подтверждения заказа
const step2Show = ref(false)

const errorToHtml = ref([])

// загрузка первой формы
const loadingForm1 = ref(false)

const sendOrder = async() => {
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
            form_postedAddress: show_form_postedAddress.value == true ? form_postedAddress.value : '',
            goods: cartAr.value,
        })
        .then((res) => {
            res2.value = res.data

            if (typeof res.data.send_mail_verified !== undefined) {
                mail_send.value = res.data.send_mail_verified
            } else {
                mail_send.value = false
            }

            nowOrder.value = res.data.user
            sendOrderRes.value = true
            loadingForm1.value = false

            cartArBauyed.value = orderGoodsInOrder()
        })
        .catch((error) => {
            // console.log('error', error)
            // console.log('error response', error.response)
            // console.log('error status', error.status)
            loadingForm1.value = false
        })

    if (sendOrderRes.value == true) {
        if (
            typeof res2.value.phone.phone_confirm !== 'undefined' &&
            res2.value.phone.phone_confirm.length == 0
        ) {
            await smsSend(res2.value.phone.phone)
        }
        step2Show.value = true
        orderFormSended.value = true
    }
}

export default function cart() {
    return {
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

        sendOrderRes,

        errorToHtml,

        loadingForm1,

        sendOrder,

        nowOrder,

        // показ подтверждения заказа
        step2Show,

        // товары в корзине a_id = quantity
        cartAr,
        cartArBauyed,

        // cartArGoods,
        // добавляем
        cartAdd,
        // отнимаем
        cartMinus,

        goodInCart,

        // корзину в кеш
        cartCashSave,
        // корзину из кеш
        cartCashRead,

        cartRemove,

        setStandartGood,
    }
}