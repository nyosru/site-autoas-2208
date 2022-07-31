<template>
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <ul class="other-link-sub xpull-right">
          <li>
            <router-link
              :to="{ name: 'index' }"
              title="Запчасти для автомобилей Авто-АС"
            >
              Авто-АС
            </router-link>
          </li>

          <!-- <li><a href="#home">Home</a></li> -->
          <!-- <li><a class="active" href="#shop">Shop</a></li> -->

          <!-- <li>{{ stepCrumb }}</li> -->
          <!-- <li>{{ stepCrumb[0] }}</li> -->
          <template v-for="n in stepCrumb">
            <li :key="n.a_id" v-if="n.head">
              <span v-if="n.type == 'page'">{{ n.head }}</span>
              <router-link
                v-else
                :to="{
                  name: n.type ?? 'cat',
                  params: { cat_id: n.a_id },
                }"
              >
                {{ n.head }}
              </router-link>
            </li>
          </template>

          <!-- <li v-if="c1.head"><a class="active" href="#shop">{{ c1.head }}</a></li> -->
          <!-- <li>{{ stepCrumb[5] && stepCrumb[5][head] }}</li> -->
          <!-- <li>{{ stepCrumb[4][head] ?? 'x4' }}</li> -->
          <!-- <li>{{ stepCrumb[3][head] ?? 'x3' }}</li> -->
          <!-- <li>{{ stepCrumb[2][head] ?? 'x2' }}</li> -->
          <!-- <li>{{ stepCrumb[1][head] ?? 'x1' }}</li> -->
          <!-- <li>{{ stepCrumb[0][head] ?? 'x0' }}</li> -->
        </ul>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useRoute } from 'vue-router'
import { ref, watchEffect } from 'vue'
import catalogs from './../use/catalogs.ts'

const route = useRoute()
const stepCrumb = ref([])

// тащим инфу по каталогам что выше текущего
function getStepCats(cat_id) {
  const { loading, data } = catalogs()

  if (route.name == 'page') {
    // return [['name' > 'ppage'], []]
  } else {
    if (loading.value == false) {
      const c1 = data.value.find((el) => el.a_id == cat_id)
      let c2 = []
      let c3 = []
      let c4 = []
      let c5 = []

      // console.log( 11 , c1.a_parentid );
      // console.log( 11 , c1 , c1.value );

      if (
        c1.a_parentid &&
        c1.a_parentid.length &&
        c1.a_parentid != '00000126'
      ) {
        c2 = data.value.find((el) => el.a_id == c1.a_parentid)
      }

      if (
        c2.a_parentid &&
        c2.a_parentid.length &&
        c2.a_parentid != '00000126'
      ) {
        c3 = data.value.find((el) => el.a_id == c2.a_parentid)
      }

      if (
        c3.a_parentid &&
        c3.a_parentid.length &&
        c3.a_parentid != '00000126'
      ) {
        c4 = data.value.find((el) => el.a_id == c3.a_parentid)
      }

      if (
        c4.a_parentid &&
        c4.a_parentid.length &&
        c4.a_parentid != '00000126'
      ) {
        c5 = data.value.find((el) => el.a_id == c4.a_parentid)
      }

      // console.log(
      //   // alert(
      //   '2222',
      //   1,
      //   c1 ?? 'x1',
      //   2,
      //   c2 ?? 'x2',
      //   3,
      //   c3 ?? 'x3',
      //   4,
      //   c4 ?? 'x4',
      //   5,
      //   c5 ?? 'x5',
      //   // data,
      //   stepCrumb.value,
      // )

      return [c5 ?? [], c4 ?? [], c3 ?? [], c2 ?? [], c1 ?? []]
    }
  }
  // return []
}

const { catNow } = catalogs()

const nowPage = ref([])

import page from './../use/page.ts'
const { whatThisPage } = page()


const stopWatch = watchEffect(() => {
  // const { loading, data } = catalogs()
  // route.params.cat_id
  // console.log(77, data, route.params.cat_id)

  // if( route.params.cat_id && route.params.cat_id.length ){
  // stepCrumb.value = getStepCats(route.params.cat_id)
  // }

  // console.log(
  //   'route',
  //   11,
  //   // route,
  //   route.name,
  //   route.params,
  //   route.params.good_id,
  //   route.params.cat_id,
  //   route.params.page,
  // )

  stepCrumb.value = []

  if (route.name == 'page') {

  nowPage.value = whatThisPage(route.params.id)

    // console.log({ type: 'page', head: route.params.id, a_id: route.params.id })
    stepCrumb.value.push({
      type: 'page',
      head: nowPage.value.head,
      a_id: nowPage.value.a_id,
    })
    // console.log(stepCrumb.value)
    window.scrollTo(0,0)
  }else if (route.name == 'cart') {

  nowPage.value = whatThisPage(route.params.id)

    // console.log({ type: 'page', head: route.params.id, a_id: route.params.id })
    stepCrumb.value.push({
      type: 'cart',
      head: 'Корзина покупок',
      a_id: 'x',
    })
    // console.log(stepCrumb.value)
    window.scrollTo(0,0)
  } else if (catNow.value && catNow.value.length) {
    stepCrumb.value = getStepCats(catNow.value)
  }

  // console.log(77, stepCrumb ?? 'xx' )
  // async newId => {
  //   userData.value = await fetchUser(newId)
  // }
})
</script>

<style scoped></style>
