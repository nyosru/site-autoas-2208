import {
  ref,
  //   // reactive, toRefs, readonly,
  //   // watch,
  //   // computed
} from 'vue'

import axios from 'axios'

const pageData = ref({})
const pageLoading = ref(true)
const pageError = ref(false)

const pageList = [
  { id: 'about', head: 'О компании', footer: true },
  { id: 'posted', head: 'Доставка', footer: true },
  { id: 'contact', head: 'Контакты', footer: true },
  { id: 'politika', head: 'Политика конфеденциальности', footer: true },
  { id: 'oferta', head: 'Оферта', footer: true },
  { id: 'return', head: 'Возврат', footer: true },
]

function whatThisPage(page_id) {
  const ww = pageList.find(function (e) {
    // return e.a_parentid == c.a_parentid
    return e.id == page_id
  })
  return ww
}

const pageLoad = async (page_id) => {
  pageData.value = {}
  pageLoading.value = true
  pageError.value = false

  await axios
    .get('/api/page/' + page_id)
    .then((response) => {
      // console.log("get_datar", response.data);
      // items_loading_module.value = items_now_loading.value;

      // data_filtered.value =
      // data.value = response.data.data
      pageData.value = response.data.data
      // localStorage.cats = JSON.stringify(response.data.data)
      // cfg.value = response.data.cfg;
      pageLoading.value = false
      // return response.data;
      // items_loading.value = dfalse
    })
    // .catch((error) => {
    //   console.log( 11 , error.status , error)
    //   // this.errored = true;
    // })
    .catch((error) => {
      // if (error.response.status == 404) {
        pageError.value = true
        pageLoading.value = false
      // } else {
        console.log(
          // 11,
          error.response,
          // error.response.status,
          // error.status,
          // error,
        )
      // }
      // this.errored = true;
    })
}

export default function page() {
  return {
    pageList,
    whatThisPage,
    pageData,
    pageLoad,
    pageLoading,
    pageError,
  }
}
