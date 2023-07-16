<template>
    <!-- <div>{{ tab }}</div> -->

    <div class="row" v-if="goodAnalogsLoading">
        <div class="col-12 text-center">
            ...
        </div>
    </div>
    <div class="row" v-else>
        <div class="col-12 text-center" v-if="typeof(goodAnalogsData.data) != 'undefined' && goodAnalogsData.data.length > 0" >
            <h2>
                Аналоги
                <!--        +{{ good_id ?? 'x' }}        <br/>-->
                <!--        goodAnalogsLoading: {{ goodAnalogsLoading ?? 'xx' }}        <br/>-->
                <!--        goodAnalogsData: {{ goodAnalogsData ?? 'y' }}-->
            </h2>

            <div
                v-for="a in goodAnalogsData.data"
                :key="a.id"
                class="col-xs-12 col-sm-6 col-md-4 col-xl-3 col-lg-2 xproduct-list-item"
                style="margin-bottom: 3vh; margin-top: 5vh;"
            >
                <!--        a: {{ a }}-->
                <vitrin-goods-list-item :i="a"/>
            </div>

        </div>
    </div>
</template>

<script setup>

import VitrinGoodsListItem from './VitrinGoodsListItemComponent.vue'
import {useRoute} from "vue-router";

// const props = defineProps({
//   tab: Object,
//     // goodId: Number
//   // analogi: Object,
// })

const route = useRoute()
const good_id = route.params.good_id;


import good from './../use/goods'
import {onMounted, ref, watchEffect} from 'vue'

const {goodsAnalogsLoad, goodAnalogsData, goodAnalogsLoading} = good()

watchEffect(() => {
    goodsAnalogsLoad(route.params.good_id)
})

</script>

<style scoped>
h2 {
    margin-top: 3vh;
    margin-bottom: 3vh;
}
</style>
