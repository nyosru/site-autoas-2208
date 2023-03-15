import {
    createRouter,
    // createWebHashHistory
    createWebHistory,
} from 'vue-router'

import BreadcrumbsComponent from './components/BreadcrumbsComponent.vue'
import UpBannerComponent from './components/IndexUpBannersComponent.vue'
import StarterComponent from './components/StarterComponent.vue'
import VitrinComponent from './components/VitrinComponent.vue'
import SearchComponent from './components/SearchComponent.vue'
import PageComponent from './components/page/PageComponent.vue'
import CartComponent from './components/CartComponent.vue'
import GoodComponent from './components/GoodComponent.vue'

import IndexLineAdver from './components/IndexLineAdverComponent.vue'

const routes = [

    // {
    //     path: '/',
    //     component: () =>
    //         import ('./components/App/AppComponent.vue')
    // },

    {
        path: '/',
        name: 'index',
        components: {
            // BreadcrumbsComponent
            // adver: UpBannerComponent,
            adverList: IndexLineAdver,
            // starter: StarterComponent,
            // page: null,
            // cart: null,
            // vitrin: null,
        },
    },

    {
        path: '/dop/:var1?/:var2?',
        name: 'index2',
        components: {
            // BreadcrumbsComponent
            // adver: UpBannerComponent,
            adverList: IndexLineAdver,
            // starter: StarterComponent,
            // page: null,
            // cart: null,
            // vitrin: null,
        },
    },

    // текстовая страница
    {
        path: '/page/:id',
        name: 'page',
        components: {
            BreadcrumbsComponent,
            page: PageComponent,
        },
    },

    // товар 1 показ
    {
        path: '/good/:good_id/:dop?',
        name: 'good',
        components: {
            BreadcrumbsComponent,
            vitrin: GoodComponent,
        },
    },
    {
        path: '/show/i/:good_id/:dop?',
        name: 'good2',
        components: {
            BreadcrumbsComponent,
            vitrin: GoodComponent,
        },
    },



    // search товаров
    {
        path: '/search/:search/:page?',
        name: 'search',
        components: {
            BreadcrumbsComponent,
            vitrin: SearchComponent,
        },
    },



    // каталог товаров
    {
        path: '/cat/:cat_id/:page?',
        name: 'cat',
        components: {
            BreadcrumbsComponent,
            vitrin: VitrinComponent,
        },
    },
    {
        path: '/show/:cat_id/:page?',
        name: 'cat2',
        components: {
            BreadcrumbsComponent,
            vitrin: VitrinComponent,
        },
    },


    // корзина товаров
    {
        path: '/cart',
        name: 'cart',
        components: {
            BreadcrumbsComponent,
            vitrin: CartComponent,
        },
    },
    // orderOk
    {
        path: '/cart',
        name: 'orderOk',
        components: {
            BreadcrumbsComponent,
            vitrin: CartComponent,
        },
        props: {
            orderGood: true
        }
    },
    // если не сработал ни один роут, показываем первую страничку
    {
        path: '/:catchAll(.*)*',
        name: 'NotFound',
        components: {
            adver: UpBannerComponent,
            // starter: StarterComponent,
            adverList: IndexLineAdver,
        },
    },
]

const router = new createRouter({
    // history: createWebHashHistory('/vue/'),
    history: createWebHistory(),
    routes: routes,
    // scrollBehavior(to, from, savedPosition) {
    //     // always scroll to top
    //     return { top: 0 }
    //   },
    scrollBehavior(to, from, savedPosition) {
        if (to.hash) {
            return {
                el: to.hash,
                behavior: 'smooth',
            }
        } else {
            return { top: 0, behavior: 'smooth', }
        }
    }
})

// скрываем меню при любом переходе по ссылке
import catalogs from './use/catalogs.ts'
const { showMenu } = catalogs()
router.afterEach((to, from) => {
    showMenu.value = false
})

export default router