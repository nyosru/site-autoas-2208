<template>
    <div class="item0">
        <div class="product-item-img">
            <router-link :to="{ name: 'good', params: { good_id: i.a_id } }">
                <img
                    :src="'/storage/photo/mini/' + (i.a_arrayimage ?? 'x')"
                    loading="lazy"
                    onerror="if(this.src.includes('/mini/')){this.src=this.src.replace('/mini/','')}else if(!this.src.includes('photo_no')){this.src='/storage/photo_no.jpg'}"
                    alt=""
                    class="img-responsive"
                />
            </router-link>
        </div>
        <div class="product-item-info">
            <div class="item_name_vitrin_resize">
                <h3 xclass="item_name_vitrin">
                    <router-link :to="{ name: 'good', params: { good_id: i.a_id } }">
                        {{ i.head }}
                        <span class="manufacturer">{{ i.manufacturer ?? '' }}</span>
                    </router-link>
                </h3>
            </div>
            <div class="prod-price" @click="showAr = !showAr">
        <span v-if="i.a_price.length" class="price color-green">
          {{ i.a_price }} ₽
        </span>
                <span v-else class="price color-gray">
          под заказ
        </span>
            </div>
            <div class="button-ver2 text-center">
                <template v-if="goodInCart(i.a_id) !== true">
                    <button class="btn btn-info" @click="goodAdd(i.a_id)">
                        Добавить в корзину
                    </button>
                </template>
                <template v-else>
                    <router-link
                        :to="{ name: 'cart' }"
                        class="addcart-ver2 ok btn btn-success"
                    >
                        В&nbsp;корзине
                    </router-link>
                </template>

                <small v-if="showAr">
                    {{ i }}
                </small>
            </div>
        </div>
    </div>
</template>

<script setup>
import {ref, watch, watchEffect} from 'vue'

import cart from './../use/cart.js'
import {useRoute} from 'vue-router'

const route = useRoute()

const props = defineProps({
    i: Object,
})

const showAr = ref(false)

const {
    cartAdd,
    goodInCart,
} = cart()

const goodAdd = () => {
    if (props.i.a_id && props.i.a_id.length) {
        cartAdd(props.i)
    }
}
</script>

<style scoped>
h3 {
    font-size: 1.2em;
}

.item0 {
    margin-top: 1vh;
    margin-bottom: 1vh;
}

.manufacturer {
    color: rgb(41, 59, 119)
}
</style>
