<template>
  <div class="top-nav hidden-xs hidden-sm">
    <div class="container">
      <div class="row">
        <div class="col-md-5 col-sm-5 col-xs-12">
          <div class="left-nav">
            <div class="location dropdown">
              <span class="icon">
                <i class="ion-ios-location" aria-hidden="true"></i>
              </span>
              <span>Тюмень</span>
            </div>
            <div class="language dropdown">
              <span class="icon">
                <i class="ion-ios-world-outline" aria-hidden="true"></i>
              </span>
              <span>Русский</span>
            </div>
          </div>
        </div>
        <div class="col-md-7 col-sm-7 col-xs-12">
          <div class="right-nav">
            <ul>
              <li>
                <i class="ion-log-in fa-1a" aria-hidden="true"></i>
                г.Тюмень, ул.Пархоменко, 54
              </li>
            </ul>
            <a href="tel://+73452560333">
              <span class="phone">
                8(3452)560-333
              </span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="bottom">
    <div class="container">
      <div class="row">
        <div class="col-md-3 col-sm-8 col-xs-7 logo text-center">
          <a href="/show/" title="Авто-АС">
            <!-- <img src="/sites/kl2009asavto/download/logo_new.svg" alt="Авто-АС" style="max-width:100%; max-height: 200px; margin: 0 auto;" > -->
            <!-- <img src="/sites/kl2009asavto/download/img/logo7.jpg" alt="Авто-АС" style="max-width:100%; max-height: 100px; margin: 0 auto;" > -->
            <img
              src="/storage/site/img/logo2112.png"
              alt="Авто-АС"
              style="max-width: 100%; max-height: 100px; margin: 0 auto;"
            />
          </a>
        </div>
        <div
          class="col-md-6 hidden-sm col-xs-5 hidden-xs nextlogo text-center"
          xstyle="border: 1px solid gray;"
        >
          <br />
          <center>
            <form action="/index.php" class="search-form" method="GET">
              <input
                type="text"
                name="search"
                class="text-center form-control"
                placeholder="поиск по названию или артикулу детали"
              />
              <input type="hidden" name="level" value="show" />
              <button type="submit" class="search-icon"></button>
            </form>
          </center>
        </div>
        <div class="col-md-3 col-sm-4 col-xs-5 nextlogo">
          <cart-informer />
        </div>
      </div>
    </div>
  </div>

  <div class="menu">
    <div class="container">
      <div class="row">
        <div class="col-md-3 col-sm-4 col-xs-6 column-left">
          <!-- 111 -->
          <header-menu-component></header-menu-component>
        </div>
        <div class="col-md-9 col-sm-6 col-xs-6 column-right">
          <aside id="column-right">
            <div class="collapse navbar-collapse v2 show" id="myNavbar">
              <ul class="menubar v2">
                <!-- <li class=""><a href="/10.about/">О компании</a></li> -->
                <!-- <li class=""><a href="/50.posted/">Доставка</a></li> -->
                <!-- <li class=""><a href="/contacts/">Контакты</a></li> -->
                <li class="">
                  <router-link :to="{ name: 'page', params: { id: 'about' } }">
                    О компании
                  </router-link>
                </li>
                <li class="">
                  <router-link :to="{ name: 'page', params: { id: 'posted' } }">
                    Доставка
                  </router-link>
                </li>
                <li class="">
                  <router-link
                    :to="{ name: 'page', params: { id: 'contact' } }"
                  >
                    Контакты
                  </router-link>
                </li>
              </ul>
            </div>
          </aside>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import HeaderMenuComponent from './HeaderMenuComponent.vue'
import CartInformer from './../Informer/CartComponent.vue'
</script>

<style scoped></style>
