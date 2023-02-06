<template>
  <aside id="column-left">
    <div v-if="1 == 2" style="max-height: 100px; overflow: auto;">
      {{ loading ?? 'xx' }}
      <br />
      <br />
      <!-- {{ data ?? 'x' }} -->
      catOne: {{ catOne ?? 'x' }}
    </div>

    <!-- catOne: {{ catOne }} -->

    <div
      v-if="!catOne"
      class="menu-heading js-nav-menu"
    >
      &nbsp;
    </div>
    <nav v-else class="navbar-default">
      <div
        class="menu-heading js-nav-menu"
        :class="{ show: showMenu }"
        @click="showMenu = !showMenu"
      >
        Каталог 
      </div>
      <div class="vertical-wrapper v3" :class="{ active: showMenu }">
        <ul class="level0">
          <li v-for="v in catOne" :key="v.id" style="text-align: left;">
            <router-link
              :to="{ name: 'cat', params: { cat_id: v.a_id } }"
              style="xborder: 1px solid green; text-align: left;"
              xclick="showMenu = false"
            >
              <table style="width: 100%;">
                <tbody>
                  <tr>
                    <td>
                      <img
                        :src="( v.icon && v.icon.icon && v.icon.icon.length > 0 ? '/storage/site/module_items_image/' + v.icon.icon : '/storage/site/img/icon/vk04.png' )"
                        style="
                          float: left;
                          max-width: 60px;
                          max-height: 50px;
                          margin-right: 3px;
                        "
                      />
                    </td>
                    <td>
                      <span
                        class="fa fa-chevron-right"
                        style="padding-top: 4px; float: right;"
                      ></span>
                      {{ v.head }}
                    </td>
                  </tr>
                </tbody>
              </table>
            </router-link>

            <span class="icon"></span>
            <div class="dropdown-content">
              <ul class="level1">
                <li class="sub-menu xcol-3">
                  <ul xclass="level2">
                    <div
                      v-for="v1 in catsInner(v.a_id)"
                      :key="v1.id"
                      class="link_block"
                    >
                      <router-link
                        :to="{ name: 'cat', params: { cat_id: v1.a_id } }"
                        class="link1"
                        xclick="showMenu = false"
                      >
                        <b>{{ v1.head }}</b>
                      </router-link>

                      <router-link
                        v-for="v2 in catsInner(v1.a_id)"
                        :key="v2.id"
                        :to="{ name: 'cat', params: { cat_id: v2.a_id } }"
                        class="link2 xbtn xbtn-light"
                        xclick="showMenu = false"
                      >
                        {{ v2.head }}
                      </router-link>
                    </div>
                  </ul>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
          </li>
        </ul>
      </div>
    </nav>
  </aside>
</template>

<script setup>

import { ref, computed, onMounted, watchEffect } from 'vue'

/**
 * загрузка и подготовка катологов
 */

import catalogs from './../../use/catalogs.ts'
const { showMenu, data, loading, loadData, catsInner } = catalogs()

onMounted(() => {
  // el.value // <div>
  loadData()
})

const catOne = ref([])
// const catOne = computed(() =>
//   data.value && data.value.length > 0
//     ? data.value.filter(function (e) {
//         if (e.a_parentid != '00000126') {
//           return false
//         }
//         return true
//       })
//     : [],
// )

watchEffect(() => {

  // console.log('watchEffect', 22)
  // catOne.value = catOneCreate(data.value)

  if (data.value && data.value.length > 0) {
    // console.log(77)
    const a0 = data.value.filter(function (e) {
      return e.a_parentid == '00000126' && e.head.indexOf('втомобили') > 0
    })
    const a1 = data.value.filter(function (e) {
      if (e.a_parentid == '00000126' ){
        if( e.head.indexOf('втомобили') < 0 )  {
        return true
      } }
        return false
      
      // return e.a_parentid == '00000126' && !e.head.indexOf('втомобили')
    })
    // const a2 = a0.concat(a1)
    catOne.value = a0.concat(a1)
    // console.log(a0, a1)
    // catOne.value = a2

  }
})

// // функция
// function catOneCreate(data) {

//   console.log( 'catOneCreate',data)

//   if( data && data.length > 0 ){
//     console.log( 77 )
//     catOne.value = data.filter(function (e) {
//         return e.a_parentid == '00000126'
//         // if (e.a_parentid == '00000126' ) {
//         //   return false
//         // }
//         // return true
//       })
//   }

// }
</script>

<style scoped></style>
