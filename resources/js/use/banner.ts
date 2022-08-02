import {
  ref,
} from 'vue'

import axios from 'axios'

const items = ref({})
const loading = ref(true)

const load = ( typeRequest = 'banner' ) => {

  items.value = {}
  loading.value = true

  // window.scrollTo(0,0)
  
  axios
    .get( typeRequest == 'adverItems' ? '/api/adverIndex' : '/api/banner' )
    .then((response) => {

      // console.log("get_datar", response.data);
      // items_loading_module.value = items_now_loading.value;

      // data_filtered.value =

      items.value = response.data.data
      // localStorage.cats = JSON.stringify(response.data.data)
      // cfg.value = response.data.cfg;

      loading.value = false
      // return response.data;
      // items_loading.value = dfalse

      // window.scrollTo(0,0)
    })
    .catch((error) => {
      console.log(error)
      loading.value = false
      // this.errored = true;
    })
}

export default function banner() {
  return {
    load,
    items,
    loading,
  }
}
