<template>
  <tr :class="{ n2: ind % 2 }">
    <td class="text-left">

      <!-- a.OfferName: {{ a.OfferName ?? 'x' }}      <br/> -->
      <!-- ++      <br/> -->

      <!-- <span xxclick="show = !show"> -->
        <!-- {{ ind }} /  -->
        <!-- {{ a.AnalogueCode }} /  -->
        <!-- {{ a.ProductName }} -->
        <span v-html="a.ProductName"></span>
        <!-- <div class="text-gray" >{{ a.ManufacturerName }}</div> -->
      <!-- </span> -->

      <!-- <div v-if="show">
        <br />
        <br />
        a: {{ a }}
      </div> -->

    </td>
    <td>{{ a.Quantity }}</td>
    <td>{{ a.PeriodMax }}</td>
    <td class="text-right" >{{ NumberFormat(a.Price) }}</td>
    <td>
    <template v-if="goodInCart(a.OfferName) === true"></template>
      <div v-else class="nobr">
        <button class="minus" @click="kolvo = kolvo > 2 ? kolvo - 1 : 1">
          -
        </button>
        <input
          type="text"
          size="2"
          min="1"
          step="1"
          v-model.number="kolvo"
          class="ta-c xform-control"
        />
        <button class="plus" @click="kolvo = kolvo + 1">+</button>
      </div>
    </td>
    <td>
      <!-- <button>Заказать</button> -->
      <!-- goodInCart({{ a.Reference }}) : {{ goodInCart(a.Reference) }} -->
      <!-- <br /> -->
      <template v-if="goodInCart(a.OfferName) !== true">
        <button class="btn btn-info" @click="goodAdd(a, kolvo)">
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
    </td>
  </tr>
</template>

<script setup>
// // import VitrinGoodsListItem from './VitrinGoodsListItemComponent.vue'

import { ref } from '@vue/reactivity'

// import { onMounted } from '@vue/runtime-core'

// // import goodsAllautoparts from './../use/goodsAllautoparts.ts'
// import goodsAllautoparts from './../use/goodsAllautoparts.ts'
// const { load, items, loading } = goodsAllautoparts()

import cart from './../use/cart.js'
// import { useRoute } from 'vue-router'
// const route = useRoute()
// const props = defineProps({   i: Object, })
// const showAr = ref(false)

const {
  // // товары в корзине a_id = quantity
  // cartAr,
  // добавляем
  cartAdd,
  // // отнимаем
  // cartMinus,
  // поиск есть или нет товар в корзине
  goodInCart,
} = cart()

const goodAdd = (good, kolvo = 1) => {
  // if (props.i.a_id && props.i.a_id.length) {
  if (good.OfferName && good.OfferName.length) {
    good.a_id = good.OfferName
  }
  cartAdd(good, kolvo)
  // console.log( 778 , props.i.a_id)
  // }
}

const props = defineProps({
  a: Object,
  ind: Number,
})

const kolvo = ref(1)
const show = ref(false)

// onMounted(() => {
//   load(props.good_articul)
//   console.log(77)
// })


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
button.minus,
button.plus {
  border-radius: 10%;
  border: none;
}

button.minus {
  background-color: rgb(255, 150, 150);
}
button.plus {
  background-color: rgb(150, 255, 150);
}

.ta-c {
  text-align: center;
}
td {
  padding: 4px 10px;
}
.n2 td {
  background-color: rgb(240, 240, 240);
}
.nobr {
  white-space: pre;
}
</style>
