<template>
  <div>
    <!-- good_id: {{$route.params.good_id }} -->

    <div class="row">
      <div class="col-12 text-center p-20" v-if="goodLoading">
        .. загрузка ..<br/>
        <img src="/storage/site/img/loader.gif" />
      </div>

      <div class="col-12 col-xs-12 text-center" v-else>
        <div class="container">
          <div class="row">
            <div class="col-xs-12 col-sm-8">
              <img
                v-if="goodData.a_arrayimage == ''"
                src="/storage/photo_no.jpg"
                loading="lazy"
                alt=""
                xclass="img-responsive"
                style="opacity: 0.2;"
              />
              <img
                v-else
                :src="'/storage/photo/' + goodData.a_arrayimage"
                loading="lazy"
                alt=""
                xclass="img-responsive"
              />

              <!-- <img
                xsrc="/di-img/min/800/photo/K0177173.jpg"
                :src="goodData.a_arrayimage"
                alt="Комплект ГРМ"
                class="  "
                style="width: 100%;"
              /> -->
            </div>
            <div
              class="col-xs-12 col-sm-4 xbg-info"
              style="background-color: #d9edf7; border-radius: 3px;"
            >
              <br />
              <br />
              <h3>
                {{ goodData.head }}
                <div class="manufacturer">
                  {{ goodData.manufacturer ?? '' }}
                </div>
              </h3>
              <br />
              <br />
              <p v-if="goodData.a_price == ''">
                Цена:&nbsp;под заказ
              </p>
              <p v-else>Цена:&nbsp;{{ goodData.a_price }}&nbsp;₽</p>
              <br />
              <br />

              <!-- goodInCart: {{ goodInCart($route.params.good_id) }} -->

              <template v-if="goodInCart($route.params.good_id) !== true">
                <br />
                кол-во:
                <button
                  type="button"
                  style="display: inline-block; border-radius: 3px;"
                  class="btn btn-xs btn-danger"
                  xonclick="$ee = $('#quantity7343').val() - 1; $('#quantity7343').val($ee > 0 ? $ee : 0);"
                  @click="
                    goodQuantity = goodQuantity > 1 ? goodQuantity - 1 : 1
                  "
                >
                  <i class="fa fa-minus"></i>
                </button>
                <input
                  type="text"
                  readonly=""
                  style="
                    display: inline-block;
                    width: 40px;
                    text-align: center;
                  "
                  v-model="goodQuantity"
                  min="1"
                  max="999"
                  step="1"
                  size="1"
                  class="form-control kolvo-items"
                />
                <button
                  type="button"
                  style="display: inline-block;"
                  class="btn btn-xs btn-success"
                  xonclick="$ee = +$('#quantity7343').val() + 1; $('#quantity7343').val($ee > 0 ? $ee : 0);"
                  @click="goodQuantity = goodQuantity + 1"
                >
                  <i class="fa fa-plus"></i>
                </button>

                <br />
                <br />

                <div class="button-ver2 text-center">
                  <button class="btn btn-success" @click="goodAdd">
                      Добавить в корзину
                  </button>
                </div>
              </template>

              <template v-else>
                <div class="button-ver2 text-center">
                  В корзине: {{ cartAr[$route.params.good_id] }}
                  <br />
                  <router-link :to="{ name: 'cart' }" class="btn btn-success">
                    Перейти к заказу
                  </router-link>
                </div>
              </template>

              <br />
              <br />
              <br />
            </div>
          </div>
          <br/>
          <br/>
          <br/>
          <div class="row" id="an">
            <div class="col-xs-12">
              <ul class="nav nav-tabs mt-10">
                <li
                  role="presentation"
                  class="active"
                  v-if="goodData.analog && goodData.analog.length > 0"
                >
                  <a href="#" class="active" onclick="return false;">
                    Аналоги других производителей
                  </a>
                </li>
              </ul>

              <div
                v-if="goodData.analog && goodData.analog.length > 0"
                class="product-list grid_full grid_sidebar grid-uniform container-fluid"
                style="margin-top: 30px;"
              >
                <good-analogi :analogi="goodData.analog" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- <div class="row">
      <div class="col-12 col-xs-12 text-center">
        goodLoading: {{ goodLoading }}
        <br />
        goodData : {{ goodData }}
      </div>
    </div> -->
  </div>
</template>

<script setup>
import catalogs from './../use/catalogs.ts'
import goods from './../use/goods.ts'
import cart from './../use/cart.js'

// import VitrinGoodsListItem from './VitrinGoodsListItemComponent.vue'

import {
  ref,
  watchEffect,
  // onMounted
} from 'vue'
import { useRoute } from 'vue-router'

import VitrinGoodsListItem from './VitrinGoodsListItemComponent.vue'
import GoodAnalogi from './GoodAnalogiComponent.vue'

const route = useRoute()

const goodQuantity = ref(1)

// onMounted(() => {
//   goodQuantity.value = 1
// })

// catsLevelLower
// const { loading } = catalogs()

const { goodLoading, goodData, loadGood } = goods()

// загрузка товара
const stopWatch3 = watchEffect(() => {
  if (route.params.good_id && route.params.good_id.length) {
    loadGood(route.params.good_id)
    // console.log(880, route.params.good_id)
  }
})

// показ списка каталогов по загруженному товару
const stopWatch4 = watchEffect(() => {
  if (goodData.value.a_categoryid && goodData.value.a_categoryid.length) {
    const { catNow } = catalogs()
    catNow.value = goodData.value.a_categoryid
    // console.log(882, goodData.value.a_categoryid)
  }
})

const {
  // товары в корзине a_id = quantity
  cartAr,
  // cartArGoods,
  // добавляем
  cartAdd,
  // отнимаем
  cartMinus,
  // поиск есть или нет товар в корзине
  goodInCart,
} = cart()

const goodAdd = () => {
  if (route.params.good_id && route.params.good_id.length) {
    // cartAdd(route.params.good_id, goodQuantity.value)
    cartAdd(goodData.value, goodQuantity.value)
    console.log(route.params.good_id, goodQuantity.value)
  }
}

</script>

<style scoped></style>
