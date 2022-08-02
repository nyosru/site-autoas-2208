import {
  ref,
} from 'vue'

import axios from 'axios'

const items = ref({})
const loading = ref(true)

const load = async ( ) => {

  items.value = {}
  loading.value = true

  // window.scrollTo(0,0)
  
  await axios
    .get( '/api/banner' )
    .then((response) => {
      items.value = response.data.data
      loading.value = false
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
