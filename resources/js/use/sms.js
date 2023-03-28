import { ref } from 'vue'

import axios from 'axios'

// const phone = ref('79000000001')
const phone = ref('')
    // const phone = ref('89222622289')
const smsConfirmResult = ref(false)
const smsConfirmLoading = ref(false)

const smsSendRes = ref({})
const smsSendResCode = ref('')

const smsConfirmSend = async(code) => {
    smsConfirmLoading.value = true
    let ress = false

    await axios

        .post('/api/smsConfirmSend/' + phone.value + '/' + code)
        //
        .then((response) => {
            ress = response.data.result
        })
        .finally(() => {
            smsConfirmLoading.value = false
        })

    return ress
}

const smsSend = async(phone) => {
    smsSendRes.value = {}
        // phone = '79000000001'

    await axios
        .post('/api/smsConfirm/' + phone)
        //
        .then((response) => {
            const re = JSON.parse(response.data)
            smsSendRes.value = re
            smsSendResCode.value = re.code
        })
}

const smsSend22 = async(inCode) => {
    if (inCode == smsSendResCode.value) {
        smsSendRes.value = {}

        await axios
            .post('/api/smsSendConfirm/' + phone)
            //
            .then((response) => {
                const re = JSON.parse(response.data)
                smsSendRes.value = re
                smsSendResCode.value = re.code
            })
    } else {
        return false
    }
}

export default function sms() {
    return {
        phone,
        smsSend,
        smsSendRes,
        smsSendResCode,
        smsConfirmSend,
        smsConfirmResult,
        smsConfirmLoading,
    }
}