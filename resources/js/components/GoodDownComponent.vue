<template>
    <div>
        <good-analogi-component :tab="tabs[0]" :analogi="good.good_analog"/>
        <br clear="all"/>
        <good-down-tab-all-autoparts-component
            v-if="showOrdersOnSklad"
            :tab="tabs[1]"
            :good_articul="good.catnumber_search"
        />
    </div>
</template>

<script setup>

import {ref} from '@vue/reactivity'
import GoodAnalogiComponent from './GoodDownTabAnalogi0Component.vue'
// import GoodDownTabAnalogiComponent from './GoodDownTabAnalogiComponent.vue'
import GoodDownTabAllAutopartsComponent from './GoodDownTabSellAuptopartsComponent.vue'

const props = defineProps({
    good: Object,
    // показывать или нет заказ с удалённого склада
    showOrdersOnSklad: Boolean,
})
// const currentTab = ref('GoodDownTabAnalogiComponent')
const currentTab = ref('')
const tabs = ref([
    {name: 'Аналоги', mini: 'analogi0', component: 'GoodAnalogiComponent'},
    {name: 'Заказать с удалённых складов', mini: 'allAutoparts', component: ''},
])

const currentTabComponent = (name) => {
    currentTab.value = name
    console.log(name)
}
</script>

<style scoped>
h2 {
    color: rgb(40, 57, 118);
    text-decoration: underline;
    margin-top: 3vh;
    margin-bottom: 3vh;
}

.demo {
    font-family: sans-serif;
    border: 1px solid #eee;
    border-radius: 2px;
    padding: 20px 30px;
    margin-top: 1em;
    margin-bottom: 40px;
    user-select: none;
    overflow-x: auto;
}

.tab-button {
    padding: 6px 10px;
    border-top-left-radius: 3px;
    border-top-right-radius: 3px;
    border: 1px solid #ccc;
    cursor: pointer;
    background: #f0f0f0;
    margin-bottom: -1px;
    margin-right: -1px;
}

.tab-button:hover {
    background: #e0e0e0;
}

.tab-button.active {
    background: #e0e0e0;
}

.demo-tab {
    border: 1px solid #ccc;
    padding: 10px;
}
</style>
