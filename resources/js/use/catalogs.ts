import {
  ref,
  // reactive, toRefs, readonly,
  // watch,
  // computed
} from 'vue'

import axios from 'axios'


// конфиг загружаемой инфы
// const cfg = ref({})
// данные что загрузил
const data = ref({})
// отфильтрованный список
// const data_filtered = ref({})
// загрузка идёт или нет
const loading = ref(true)
// какой модуль сейчас загружен
// const loading_module_now = ref('')

// тащим все вложенные каталоги в указанный
const catsInner = (parent_id) => {
  return data.value.filter(function (e) {
    return e.a_parentid == parent_id
  })
}

const leftMenu = ref([])

/**
 * тащим все вложенные каталоги в указанный
 */
const catsLevelLower = (id) => {
    // console.log(7701,data);
    
    // return { [1, 2]: }
    //   const c = data.value.find((el) => el.a_id == id)
    leftMenu.value = data.value.filter(function (e){
        // return e.a_parentid == c.a_parentid
        return e.a_parentid == id
    })
    // console.log(7702,ee);
  
    // return ee 
}

// показ или скрыть меню главное
const showMenu = ref(false)

// каталог сейчас (для крошек)
const catNow = ref('')

// const loadData = (module, db_connection = 'out') => {
const loadData = async () => {
  // // console.log('modules items getItemsAll', 1);

  // if (loading_module_now.value != module) {

  //     loading_module_now.value = module;

  //     console.log('mod didrive items datas', 'loadData', 'грузим данные');

  //     // ставим что первая страница
  //     const { setPage } = pages();
  //     setPage(1);

  //     // const {
  //     //     items_data,
  //     //     items_cfg,
  //     //     items_loading
  //     //     // items_loading_module ,
  //     //     // items_now_loading
  //     // } = items();
  //     // const route = useRoute();

  //     // console.log("грузим 2");

  //     data.value = {};
  //     cfg.value = {};
  //     loading.value = true;

  //     //         // console.log( 'new_status' , new_status);

  let d = new Date()
  const now_d = d.getFullYear() + '-' + d.getMonth() + '-' + d.getDate()

  if (
    localStorage.cats &&
    localStorage.cats.length > 0 &&
    localStorage.cats_date &&
    localStorage.cats_date == now_d
  ) {
    data.value = JSON.parse(localStorage.cats)
    loading.value = false
    // console.log('cash 77',localStorage.cats)
    console.log('cat', 'cash 77')
  } else {
    localStorage.cats_date = now_d
    await axios
      .get('/api/catalog')
      .then((response) => {
        // console.log("get_datar", response.data);
        // items_loading_module.value = items_now_loading.value;

        // data_filtered.value =
        data.value = response.data.data
        localStorage.cats = JSON.stringify(response.data.data)
        // cfg.value = response.data.cfg;
        loading.value = false
        // return response.data;
        // items_loading.value = dfalse
      })
      .catch((error) => {
        console.log(error)
        // this.errored = true;
      })
  }
  //         this.itemStatus0 = new_status;

  // } else {
  //     // console.log('modules items getItemsAll', 'не грузим данные, уже есть');
  // }

  // return items_data.value ?? 'x'
}

// const { showStatusDelete } = filterSettings();
// const { now_page } = pages();

// watch([showStatusDelete, now_page, loading], (newValues, prevValues) => {

//     const { now_page, onPage, kolvo } = pages();

//     if (newValues[0] !== prevValues[0])
//         now_page.value = 1;

//     // console.log('watch', newValues, prevValues)
//     // console.log('watch', newValues[0], prevValues[0])
//     //   const { items_data, items_filtered } = items();
//     // console.log("фльтр data", data.value);

//     if (data.value && data.value.length > 0) {

//         // const { showStatusDelete } = filterSettings();
//         // console.log("фльтру delete = ", showStatusDelete.value);

//             const items_filtered = data.value.filter(el => {

//                 if (el.status == "delete" && showStatusDelete.value == false) {
//                     return false;
//                 }

//                 return true;
//             });
//         // console.log("отфильтровали массив по фльтру ", items_filtered);

//         let start = 0;
//         let fin = 0;

//         kolvo.value = items_filtered.length;

//         if (now_page.value == 1) {
//             start = 0;
//             fin = onPage.value - 1;
//         } else {
//             start = (now_page.value - 1) * onPage.value;
//             fin = start + onPage.value - 1;
//         }

//         // console.log("показываем из массива ", start, fin);

//         data_filtered.value = {};

//         // let result = items_data2.slice(start, fin);
//         data_filtered.value = items_filtered.slice(start, fin);

//         // return result;
//     } else {
//         data_filtered.value = {};
//     }

// });

export default function catalogs() {
  return {
    // конфиг загружаемой инфы
    // cfg,
    // данные что загрузил
    data,

    // показываем или нет меню
    showMenu,

    // отфильтрованный список
    // data_filtered,
    // загрузка идёт или нет
    loading,
    // какой модуль сейчас загружен
    // loading_module_now,
    // ф загрузка данных
    //  loadData = (module, db_connection = 'out') => {
    loadData,
    // показ массива с вложенными каталогами, на входе id родителя
    catsInner,
    // тащим все вложенные каталоги в указанный
    // catsLevelLower(id)
    catsLevelLower,
    // левое меню
    leftMenu,
    //
    catNow,
  }
}
