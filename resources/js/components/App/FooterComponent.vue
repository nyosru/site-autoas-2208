<template>
  <div class="top-footer">
    <div class="container">
      <div class="row">
        <div class="col-md-3 col-xs-12 text-center">
          <div class="photo" xstyle="padding-top: 3rem;">
            <router-link :to="{ name: 'index' }">
              <img
                src="/storage/site/img/logo2.png"
                alt="Авто-АС"
                class="img-responsive"
                style="max-height: 100px;"
              />
            </router-link>
          </div>
        </div>
        <div class="col-md-3 xhidden-xs xhidden-sm  xtext-center">
          <div class="widget-info">
            <ul>
              <li>
                <p class="title-contain">
                  <i class="ion-ios-location fa-4" aria-hidden="true"></i>
                  <router-link
                    :to="{ name: 'page', params: { id: 'contact' } }"
                  >
                    г.Тюмень, ул.Пархоменко, 54
                  </router-link>
                </p>
              </li>
              <li class="clearfix"></li>
              <li>
                <p class="title-contain">
                  <i class="ion-ios-telephone fa-4" aria-hidden="true"></i>
                  <a href="tel://+73452560333">
                    8(3452)560-333
                  </a>
                </p>
              </li>
              <li class="clearfix"></li>
            </ul>
          </div>
        </div>
        <div class="col-md-4 pd-left xhidden-xs xhidden-sm  text-center">
          <span class="link_footer">
            <router-link
              v-for="u in link_footer"
              :key="u.name"
              :to="{ name: 'page', params: { id: u.id } }"
            >
              {{ u.head }}
            </router-link>
          </span>
        </div>
        <div
          v-if="1 == 2"
          class="col-xs-12 col-sm-12 hidden-md hidden-lg nidden-xl text-center"
        >
          <p class="title-contain">
            <a href="#">г.Тюмень, ул.Пархоменко, 54</a>
            <br />
            <a href="tel://+73452560333">
              8(3452)560-333
            </a>
          </p>
          <br />

          <span class="link_footer">
            <router-link
              v-for="u in link_footer"
              :key="u.name"
              :to="{ name: 'page', params: { id: u.id } }"
            >
              {{ u.head }}
            </router-link>
          </span>
          <br />
          <br />
        </div>

        <div class="col-md-2 col-xs-12 text-center">
          <ul class="social">
            <a href="https://vk.com/avto_as" target="_blank" title="VK">
              <img
                src="/storage/site/img/icon/vk04.png"
                style="width: 46px; margin-right: 7px;"
              />
            </a>
            <a
              href=" https://www.instagram.com/avto.as.shop/"
              target="_blank"
              title="insta"
            >
              <img
                src="/storage/site/img/icon/instagram.png"
                style="width: 40px; margin-right: 5px;"
              />
            </a>
            <a
              href="https://wa.me/79292696191"
              target="_blank"
              title="WhatsApp"
            >
              <img
                src="/storage/site/img/icon/wa.png"
                style="width: 42px; margin-right: 5px;"
              />
            </a>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="copyright">
    <div class="container-fluid">
      <div class="row">
        <div class="col-xs-12 col-sm-3 col-lg-4 text-center">
          <span>
            <a href="/" title="" style="color: #6c6c6c;">
              Авто-АС © 2008 - 2022
              <br />
              Внимательность к деталям!
            </a>
          </span>
        </div>
        <div class="col-xs-12 col-sm-3 col-lg-4 text-center">
          <img
            src="/storage/site/img/visa.png"
            alt="images"
            xclass="img-responsive"
            style="margin-right: 10px;"
          />
          <img
            src="/storage/site/img/mastercard.png"
            alt="images"
            xclass="img-responsive"
          />
        </div>
        <div class="col-xs-12 col-sm-3 col-lg-4 text-center">
          <span>
            <a
              href="//php-cat.com"
              target="_blank"
              title="Создание сайта"
              style="color: #6c6c6c;"
            >
              PHP-CAT.com
              <br />
              создание сайтов для работы с данными
            </a>
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const link_footer = [
  { id: 'about', head: 'О компании' },
  { id: 'posted', head: 'Доставка' },
  { id: 'contact', head: 'Контакты' },
  { id: 'politika', head: 'Политика конфеденциальности' },
  { id: 'oferta', head: 'Оферта' },
  { id: 'return', head: 'Возврат' },
]
</script>

<style scoped>
.link_footer a {
  display: block;
  margin-bottom: 5px;
}
</style>
