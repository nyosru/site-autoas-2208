import { ref } from 'vue'

import axios from 'axios'

import use_var from './var.js'
const{ findedOnPartner , findedOnPartnerLoading } = use_var()

const items = ref({})
const itemsCount = ref(0)
const loading = ref(true)

const sortByField = (field) => {
  return (a, b) => (a[field] > b[field] ? 1 : -1)
}

const load = async (searchString = '') => {

  items.value = {}
  loading.value = true
  findedOnPartnerLoading.value = true

  await axios
    .get('/api/allautoparts/' + searchString.replaceAll(' ', ''))
    .then((response) => {

      if (
        response.data[0]['AnalogueCode']
      ) {
        findedOnPartner.value =
        itemsCount.value = Object.keys(response.data).length
        items.value = response.data
        items.value.sort(sortByField('Price'))
      }

      loading.value = false
      findedOnPartnerLoading.value = false
    })
    .catch((error) => {
      findedOnPartnerLoading.value = false
      console.log('error', error)
      loading.value = false
    })
}

export default function goodsAllautoparts() {
  return {
    load,
    items,
    itemsCount,
    loading,
  }
}
