<template>
  <tr v-if="v.kolvo >= 0" class="cartItem">
    <td>
      <!-- type: {{ type }} -->
      <!-- <br /> -->
      <!-- step2Show: {{ step2Show }} -->
      <a
        v-if="!step2Show"
        href="#"
        @click.prevent="cartRemove(v.a_id)"
        class="remove"
      >
        <i class="ion-close" aria-hidden="true"></i>
      </a>

      <!-- <br /> -->
      <!-- {{ v.a_id }} -->
    </td>
    <td>
      <!-- ++ {{ v.OfferName ?? '' }} -->
      <!-- ++ {{ v.a_id ?? '' }} -->
      <!-- <Br/> -->
      <span v-if="v.id && v.id > 0 && v.a_id && v.a_id.length">
        <router-link
          :to="{
            name: 'good',
            params: { good_id: v.a_id },
          }"
        >
          {{ v.head ?? '' }}
        </router-link>
      </span>
      <span v-else>
        <!-- <small>заказ с удалённого склада</small><br /> -->
        <!-- {{ v.head ?? '' }} -->
        <span v-html="v.head"></span>
      </span>
      <!-- {{ cartArGoods[id_good] ? ( cartArGoods[id_good]['head'] ?? '' ) : '' }} -->
      <div class="text-muted text-red-hover">
        {{ v.manufacturer ?? '' }}
        <!-- {{ cartArGoods[id_good] ? ( cartArGoods[id_good]['manufacturer'] ?? '' ) : '' }} -->
      </div>
      <!-- <div @click="s1 = !s1">-- разработка ( показать инфу ) --</div> -->
      <!-- <div v-if="s1">                        {{ v }}                      </div> -->
    </td>
    <td class="a-right m-top">
      {{
        v.a_price && v.a_price > 0 ? NumberFormat(v.a_price) : 'под&nbsp;заказ*'
      }}
    </td>

    <td v-if="step2Show" class="text-center m-top">
      {{ v.kolvo }}
    </td>

    <!-- <td>{{ v.kolvo }}</td> -->
    <td v-else class="text-center">
      <div class="nobr">
        <button
          type="button"
          class="btn btn-xs btn-danger BtnPlusMinus"
          @click="cartMinus(v, 1)"
        >
          <i class="fa fa-minus"></i>
        </button>
        <input
          type="text"
          readonly=""
          style="display: inline-block; width: 40px; text-align: center;"
          :value="v.kolvo"
          class="form-control kolvo-items"
        />
        <button
          type="button"
          class="btn btn-xs btn-success BtnPlusMinus"
          @click="cartAdd(v, 1)"
        >
          <i class="fa fa-plus"></i>
        </button>
      </div>
    </td>

    <td class="a-right m-top">
      {{
        v.a_price && v.a_price > 0 && v.kolvo && v.kolvo > 0
          ? NumberFormat(v.kolvo * v.a_price)
          : '-'
      }}
    </td>
  </tr>
  <!-- <tr>
    <td colspan="5">v {{ v }}</td>
  </tr> -->
</template>

<script setup>
const props = defineProps({
  v: {},
  type: 'new',
  step2Show: false,
})

import fn from './../use/fn.js'

const { NumberFormat } = fn()

import cart from './../use/cart.js'

const {
  cartRemove,
  // отнимаем
  cartMinus,
  // добавляем
  cartAdd,
} = cart()
</script>

<style scoped></style>
