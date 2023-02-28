import {
    ref,
    // reactive, toRefs, readonly,
    // watch,
    // computed
} from 'vue'

import axios from 'axios'

const phone = ref('79000000001')
const smsConfirmResult = ref(false)
const smsConfirmLoading = ref(false)

const smsSendRes = ref({})
const smsSendResCode = ref('')








// const smsConfirmSend = async(code) => {
const smsConfirmSend = async(code) => {

    // if (smsSendResCode.value != code) {
    //     return false
    // }

    //   goodData.value = []
    smsConfirmLoading.value = true
        //   // window.scrollTo(0,0)

    await axios
        .post('/api/smsConfirmSend/' + phone.value + '/' + code)
        //
        .then((response) => {
            console.log('smsConfirmSend', phone.value, code, response.data)
                //       // items_loading_module.value = items_now_loading.value;
                //       // data_filtered.value =
                //       goodData.value = response.data.data[0]
                //       // localStorage.cats = JSON.stringify(response.data.data)
                //       // cfg.value = response.data.cfg;
                //       goodLoading.value = false
                //       // return response.data;
                //       // items_loading.value = dfalse
                //       window.scrollTo(0,0)
        })
        //     .catch((error) => {
        //       console.log(error)
        //       // this.errored = true;
        //     })
        .finally(() => {
            smsConfirmLoading.value = false
        })
}









const smsSend = async(phone) => {
    //   goodData.value = []
    smsSendRes.value = {}

    //   // window.scrollTo(0,0)

    await axios
        .post('/api/smsConfirm/' + phone)
        //
        .then((response) => {

            const re = JSON.parse(response.data)
                // console.log('smsConfirmSend', phone, code, response.data)
            smsSendRes.value = re
                // console.log(6611, re, re.code, typeof(re));
                // console.log(6611, response.data, typeof(response.data));
                // console.log(661133, response.data['code']);
            smsSendResCode.value = re.code
                // console.log(7711, response.data.code);
                //       // items_loading_module.value = items_now_loading.value;
                //       // data_filtered.value =
                //       goodData.value = response.data.data[0]
                //       // localStorage.cats = JSON.stringify(response.data.data)
                //       // cfg.value = response.data.cfg;
                //       goodLoading.value = false
                //       // return response.data;
                //       // items_loading.value = dfalse
                //       window.scrollTo(0,0)
        })
        //     .catch((error) => {
        //       console.log(error)
        //       // this.errored = true;
        //     })
        // .finally(() => {
        //     smsConfirmLoading.value = false
        // })
}

const smsSend22 = async(inCode) => {

    if (inCode == smsSendResCode.value) {

        //   goodData.value = []
        smsSendRes.value = {}
            //   // window.scrollTo(0,0)

        await axios
            .post('/api/smsSendConfirm/' + phone)
            //
            .then((response) => {

                const re = JSON.parse(response.data)
                    // console.log('smsConfirmSend', phone, code, response.data)
                smsSendRes.value = re
                    // console.log(6611, re, re.code, typeof(re));
                    // console.log(6611, response.data, typeof(response.data));
                    // console.log(661133, response.data['code']);
                smsSendResCode.value = re.code
                    // console.log(7711, response.data.code);
                    //       // items_loading_module.value = items_now_loading.value;
                    //       // data_filtered.value =
                    //       goodData.value = response.data.data[0]
                    //       // localStorage.cats = JSON.stringify(response.data.data)
                    //       // cfg.value = response.data.cfg;
                    //       goodLoading.value = false
                    //       // return response.data;
                    //       // items_loading.value = dfalse
                    //       window.scrollTo(0,0)
            })
            //     .catch((error) => {
            //       console.log(error)
            //       // this.errored = true;
            //     })
            // .finally(() => {
            //     smsConfirmLoading.value = false
            // })
    } else {
        return false
    }
}

// показ подтверждения заказа
// const step2Show = ref(false)

export default function sms() {
    return {
        phone,
        smsSend,
        smsSendRes,
        smsSendResCode,
        smsConfirmSend,
        smsConfirmResult,
        smsConfirmLoading,
        // // показ подтверждения заказа
        // step2Show,
        // // товары в корзине a_id = quantity
        // cartAr,
        // // cartArGoods,
        // // добавляем
        // cartAdd,
        // // отнимаем
        // cartMinus,

        // goodInCart,

        // // корзину в кеш
        // cartCashSave,
        // // корзину из кеш
        // cartCashRead,

        // cartRemove,

        // setStandartGood,

        // // loadGoods,
        // // goodsLoading,
        // // goodsData,
        // // loadGood,
        // // goodLoading,
        // // goodData,

    }
}