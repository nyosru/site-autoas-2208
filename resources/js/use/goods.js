import {
    ref,
    // reactive, toRefs, readonly,
    // watch,
    // computed
} from 'vue'

import axios from 'axios'

// import Router from '../router';

// конфиг загружаемой инфы
// const cfg = ref({})
// данные что загрузил
const goodsData = ref({})
const goodData = ref({})

// отфильтрованный список
// const data_filtered = ref({})
// загрузка идёт или нет
const goodsLoading = ref(true)
const goodLoading = ref(true)

// какой модуль сейчас загружен
// const loading_module_now = ref('')

const page0 = ref('')
const page01 = ref(0)

// const loadData = (module, db_connection = 'out') => {
const loadGoods = (cat_id, page = 0) => {
    goodsData.value = []
    goodsLoading.value = true

    if (page > 0) {
        page0.value = '?page=' + page
        page01.value = page
    } else {
        page0.value = ''
        page01.value = 0
    }

    // window.scrollTo(0,0)

    axios
        .get('/api/goodscat/' + cat_id + page0.value)
        .then((response) => {
            // console.log("get_datar", response.data);
            // items_loading_module.value = items_now_loading.value;

            // data_filtered.value =
            goodsData.value = response.data
                // localStorage.cats = JSON.stringify(response.data.data)
                // cfg.value = response.data.cfg;
            goodsLoading.value = false
                // return response.data;
                // items_loading.value = dfalse
            window.scrollTo(0, 0)
        })
        .catch((error) => {
            console.log(error)
                // this.errored = true;
        })
}

const searchString = ref('')
const searchStringNow = ref('')



// import { useRouter, useRoute } from 'vue-router'
// const router = useRouter()
// const route = useRoute()


const loadSearchGoods = (search, page = 0) => {
    goodsData.value = []
    goodsLoading.value = true

    if (page > 0) {
        page0.value = '?page=' + page
        page01.value = page
    } else {
        page0.value = ''
        page01.value = 0
    }

    // window.scrollTo(0,0)

    axios
        .post('/api/good' + page0.value, { search })
        .then((response) => {
            searchStringNow.value = search
                // console.log("get_datar", response.data);
                // items_loading_module.value = items_now_loading.value;

            // data_filtered.value =
            goodsData.value = response.data
                // localStorage.cats = JSON.stringify(response.data.data)
                // cfg.value = response.data.cfg;
            goodsLoading.value = false
                // return response.data;
                // items_loading.value = dfalse
            window.scrollTo(0, 0)

            // let itemsCount = Object.keys(response.data.data).length
            // console.log('itemsCount', itemsCount, response.data.data[0]['head'])

            // router.push({
            //   name: 'good',
            //   params: { good_id: response.data.data[0]['a_id'] },
            //   props: { showOrdersOnSklad: true },
            // })
        })
        .catch((error) => {
            console.log(error)
                // this.errored = true;
        })
}

const loadGood = async(good_id) => {
    goodData.value = []
    goodLoading.value = true

    // window.scrollTo(0,0)

    await axios
        .get('/api/good/' + good_id)
        .then((response) => {
            // console.log("get_datar", response.data);
            // items_loading_module.value = items_now_loading.value;

            // data_filtered.value =

            goodData.value = response.data.data[0]
                // localStorage.cats = JSON.stringify(response.data.data)
                // cfg.value = response.data.cfg;

            goodLoading.value = false
                // return response.data;
                // items_loading.value = dfalse

            window.scrollTo(0, 0)
        })
        .catch((error) => {
            console.log(error)
                // this.errored = true;
        })
}

export default function goods() {
    return {
        loadGoods,
        goodsLoading,
        goodsData,

        loadGood,
        goodLoading,
        goodData,

        searchString,
        searchStringNow,
        loadSearchGoods,
    }
}