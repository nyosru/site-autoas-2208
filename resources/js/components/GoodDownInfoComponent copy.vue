<template>
  <div>
    <template v-for="tab1 in tabs" :key="tab1.name">
      <div :id="'tab_' + tab1.mini">
        <!-- <ul class="nav nav-tabs"> -->
        <template v-for="tab in tabs" :key="tab.name">
          <!-- <li
              role="presentation"
              :class="[
                // 'tab-button',
                // { active: currentTab === tab1.component },
                { active: tab.component === tab1.component },
              ]"
              @click.prevent="scrollFix('#tab_' + tab1.mini)"
            > -->
          <div v-if="tab.component === tab1.component">
            <h2>
              <!-- <router-link
              
                :to="'#tab_' + tab1.mini"
                xxsclick.prevent="scrollFix('#tab_' + tab1.mini)"
              > -->
              {{ tab.name }}
              <!-- </router-link> -->
            </h2>
          </div>
          <!-- </li> -->
        </template>

        <!-- <li role="presentation" class="active"><a href="#">Home</a></li> -->
        <!-- <li role="presentation"><a href="#">Profile</a></li> -->
        <!-- <li role="presentation"><a href="#">Messages</a></li> -->
        <!-- </ul> -->

        <!-- {{ good }} -->

        <good-analogi-component
          v-if="tab1.mini == 'analogi0'"
          :analogi="good.analog"
        />
        <!-- <good-down-tab-all-auptoparts-component v-if="tab1.mini == 'allAutoparts'" /> -->
        <!-- GoodDownTabAllAutopartsComponent -->

        <good-down-tab-all-autoparts-component
          :good_articul="good.catnumber_search"
          v-if="tab1.mini == 'allAutoparts'"
        />

        <good-down-tab-analogi-component v-if="tab1.mini == 'analogi'" />
        <good-down-tab-analogi2-component v-if="tab1.mini == 'analogi2'" />
        <good-down-tab-analogi3-component v-if="tab1.mini == 'analogi3'" />

        <br />
        <br />
        <br />
        <br />
        <br />

        <br clear="all" />
      </div>
    </template>
  </div>

  <div v-if="1 == 2">
    <div v-if="2 == 2">
      <br />
      <br />
      <br />

      <div class="row" id="an">
        <div class="col-xs-12">
          <ul class="nav nav-tabs mt-10">
            <template v-for="tab in tabs" :key="tab.name">
              <li
                role="presentation"
                :class="[
                  // 'tab-button',
                  { active: currentTab === tab.component },
                ]"
                @click="currentTabComponent(tab.component)"
              >
                {{ tab.name }}
              </li>
            </template>

            <!-- 
          <li
            role="presentation"
            class="active"
            xv-if="goodData.analog && goodData.analog.length > 0"
          >
            <a href="#" class="active" onclick="return false;">
              Аналоги других производителей
            </a>
          </li> -->

            <!-- <li
            role="presentation"
            xclass="active"
            xv-if="goodData.analog && goodData.analog.length > 0"
          >
            <a href="#" class="active" onclick="return false;">
              Аналоги других производителей 222
            </a>
          </li> -->
          </ul>

          <div
            xv-if="goodData.analog && goodData.analog.length > 0"
            class="product-list grid_full grid_sidebar grid-uniform container-fluid"
            style="margin-top: 30px;"
          >
            <!-- <xxgood-analogi :analogi="goodData.analog" /> -->
          </div>
        </div>
      </div>
    </div>

    <br />
    <br />
    <br />
    <br />

    <div id="dynamic-component-demo" class="demo">
      <template v-for="tab in tabs" :key="tab.name">
        <button
          :class="['tab-button', { active: currentTab === tab.component }]"
          @click="currentTabComponent(tab.component)"
        >
          {{ tab.name }}
        </button>
      </template>

      <br />
      <br />
      currentTab: {{ currentTab }}
      <br />
      <br />

      <good-down-tab-analogi-component
        v-if="currentTab == 'GoodDownTabAnalogiComponent'"
      ></good-down-tab-analogi-component>
      <good-down-tab-analogi-2-component
        v-else-if="currentTab == 'GoodDownTabAnalogi2Component'"
      ></good-down-tab-analogi-2-component>
      <good-down-tab-analogi-3-component
        v-else-if="currentTab == 'GoodDownTabAnalogi3Component'"
      ></good-down-tab-analogi-3-component>

      <!-- Inactive components will be cached! -->
      <component :is="currentTab.value"></component>
      <!-- <keep-alive> -->
      <!-- <component :is="currentTab"></component> -->
      <!-- </keep-alive> -->
    </div>
  </div>
</template>

<script setup>
import { ref } from '@vue/reactivity'

import GoodAnalogiComponent from './GoodDownTabAnalogi0Component.vue'

import GoodDownTabAnalogiComponent from './GoodDownTabAnalogiComponent.vue'
import GoodDownTabAnalogi2Component from './GoodDownTabAnalogi2Component.vue'
import GoodDownTabAnalogi3Component from './GoodDownTabAnalogi3Component.vue'

import GoodDownTabAllAutopartsComponent from './GoodDownTabSellAuptopartsComponent.vue'

const props = defineProps({
  good: Object,
})

// const app = Vue.createApp({
//   data() {
//     return {
const currentTab = ref('GoodDownTabAnalogiComponent')
const tabs = ref([
  { name: 'Аналоги', mini: 'analogi0', component: 'GoodAnalogiComponent' },
  { name: 'Заказ с удалённого склада', mini: 'allAutoparts', component: '' },
  // { name: 'Home', mini: 'analogi', component: 'GoodDownTabAnalogiComponent' },
  // {
  //   name: 'Home1',
  //   mini: 'analogi2',
  //   component: 'GoodDownTabAnalogi2Component',
  // },
  // {
  //   name: 'Home2',
  //   mini: 'analogi3',
  //   component: 'GoodDownTabAnalogi3Component',
  // },
  // 'GoodAnalogiComponent', 'Posts', 'Archive'
])

const currentTabComponent = (name) => {
  currentTab.value = name
  console.log(name)
  // return 'tab-' + name
}

// const scrollFix = (hash) => {
//   setTimeout(
//     () =>
//       $('html, body').animate(
//         {
//           scrollTop: $(hash).offset().top,
//         },
//         1000,
//       ),
//     1,
//   )
// }

//     }
//   },
//   computed: {
//     currentTabComponent() {
//       return 'tab-' + this.currentTab.toLowerCase()
//     }
//   }
// })

// app.component('tab-home', {
//   template: `<div class="demo-tab">Home component</div>`
// })
// app.component('tab-posts', {
//   template: `<div class="dynamic-component-demo-posts-tab">
//     <ul class="dynamic-component-demo-posts-sidebar">
//       <li
//         v-for="post in posts"
//         :key="post.id"
//         :class="{
//           'dynamic-component-demo-active': post === selectedPost
//         }"
//         @click="selectedPost = post"
//       >
//         {{ post.title }}
//       </li>
//     </ul>
//     <div class="dynamic-component-demo-post-container">
//       <div v-if="selectedPost" class="dynamic-component-demo-post">
//         <h3>{{ selectedPost.title }}</h3>
//         <div v-html="selectedPost.content"></div>
//       </div>
//       <strong v-else>
//         Click on a blog title to the left to view it.
//       </strong>
//     </div>
//   </div>`,
//     data() {
//     return {
//       posts: [
//         {
//           id: 1,
//           title: 'Cat Ipsum',
//           content:
//             '<p>Dont wait for the storm to pass, dance in the rain kick up litter decide to want nothing to do with my owner today demand to be let outside at once, and expect owner to wait for me as i think about it cat cat moo moo lick ears lick paws so make meme, make cute face but lick the other cats. Kitty poochy chase imaginary bugs, but stand in front of the computer screen. Sweet beast cat dog hate mouse eat string barf pillow no baths hate everything stare at guinea pigs. My left donut is missing, as is my right loved it, hated it, loved it, hated it scoot butt on the rug cat not kitten around</p>'
//         },
//         {
//           id: 2,
//           title: 'Hipster Ipsum',
//           content:
//             '<p>Bushwick blue bottle scenester helvetica ugh, meh four loko. Put a bird on it lumbersexual franzen shabby chic, street art knausgaard trust fund shaman scenester live-edge mixtape taxidermy viral yuccie succulents. Keytar poke bicycle rights, crucifix street art neutra air plant PBR&B hoodie plaid venmo. Tilde swag art party fanny pack vinyl letterpress venmo jean shorts offal mumblecore. Vice blog gentrify mlkshk tattooed occupy snackwave, hoodie craft beer next level migas 8-bit chartreuse. Trust fund food truck drinking vinegar gochujang.</p>'
//         },
//         {
//           id: 3,
//           title: 'Cupcake Ipsum',
//           content:
//             '<p>Icing dessert soufflé lollipop chocolate bar sweet tart cake chupa chups. Soufflé marzipan jelly beans croissant toffee marzipan cupcake icing fruitcake. Muffin cake pudding soufflé wafer jelly bear claw sesame snaps marshmallow. Marzipan soufflé croissant lemon drops gingerbread sugar plum lemon drops apple pie gummies. Sweet roll donut oat cake toffee cake. Liquorice candy macaroon toffee cookie marzipan.</p>'
//         }
//       ],
//       selectedPost: null
//     }
//   }
// })
// app.component('tab-archive', {
//   template: `<div class="demo-tab">Archive component</div>`
// })

// app.mount('#dynamic-component-demo')
</script>

<style scoped>
h2{
  color: rgb(40,57,118);
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
