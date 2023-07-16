<template>
    <div>
        <!-- good_id: {{$route.params.good_id }} -->

        <!-- <open-graph-component /> -->

        <!--        <div class="row">-->
        <!--            <div class="col-12">-->
        <!--                goodLoading: {{ goodLoading }}-->
        <!--                <br/>-->
        <!--                goodData: {{ goodData }}-->
        <!--            </div>-->
        <!--        </div>-->


        <div class="row" v-if="goodLoading">
            <div class="col-12 text-center p-20">
                .. загрузка ..
                <br/>
                <img src="/storage/site/img/loader.gif"/>
            </div>
        </div>

        <div class="row" v-else>
            <div class="col-12 col-xs-12 text-center">
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
                            <br/>
                            <br/>
                            <h3>
                                {{ goodData.head }}
                                <div class="manufacturer">
                                    {{ goodData.manufacturer ?? '' }}
                                </div>
                            </h3>
                            <br/>
                            <br/>
                            <p v-if="goodData.a_price == ''">
                                Цена:&nbsp;под заказ
                            </p>
                            <p v-else>Цена:&nbsp;{{ NumberFormat(goodData.a_price) }}</p>
                            <br/>
                            <br/>

                            <!-- goodInCart: {{ goodInCart($route.params.good_id) }} -->

                            <template v-if="goodInCart($route.params.good_id) !== true">
                                <br/>
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

                                <br/>
                                <br/>

                                <div class="button-ver2 text-center">
                                    <button class="btn btn-success" @click="goodAdd">
                                        Добавить в корзину
                                    </button>
                                </div>
                            </template>

                            <template v-else>
                                <div class="button-ver2 text-center">
                                    В корзине: {{ cartAr[$route.params.good_id] }}
                                    <br/>
                                    <router-link :to="{ name: 'cart' }" class="btn btn-success"
                                                 xxclick="orderFormSended = false"
                                    >
                                        Перейти к заказу
                                    </router-link>
                                </div>
                            </template>

                            <br/>
                            <br/>
                            <br/>
                        </div>
                    </div>

                    <!--                    аналоги-->
                    <!--                    <good-down-component :good="goodData"-->
                    <!--                                         :showOrdersOnSklad=" $route.params.dop == 'showOrdersOnSklad'"/>-->

                    <good-down-analogi-component/>


                </div>

            </div>

        </div>

    </div>
</template>

<script setup>

import catalogs from './../use/catalogs.ts'
import goods from './../use/goods.js'
import cart from './../use/cart.js'


import {
    ref,
    watchEffect,
    // onMounted
} from 'vue'
import {useRoute} from 'vue-router'

import VitrinGoodsListItem from './VitrinGoodsListItemComponent.vue'
// import GoodAnalogi from './GoodDownTabAnalogi0Component.vue'
// import GoodSellAuptoparts from './GoodSellAuptopartsComponent.vue'
import GoodDownComponent from './GoodDownComponent.vue'
import GoodDownAnalogiComponent from "./GoodDownAnalogiComponent";

const route = useRoute()
const goodQuantity = ref(1)

const props = defineProps({
    // показывать или нет заказ с удалённого склада
    showOrdersOnSklad: Boolean,
})

const {goodLoading, goodData, loadGood} = goods()

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
        const {catNow} = catalogs()
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

const NumberFormat = (num) => {
    return new Intl.NumberFormat('ru-RU', {
        style: 'currency',
        currency: 'RUB',
        maximumFractionDigits: 0,
    }).format(num)
    // return num + ' 777 ';
}

</script>

<style scoped>
.manufacturer {
    color: rgb(41, 59, 119)
}
</style>
