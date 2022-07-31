<template>
  <div>
    <yandex-map :settings="settings" :zoom="10" :coords="coords">
      <!--Markers-->
    </yandex-map>
  </div>
</template>

<script setup>
import { yandexMap, ymapMarker } from 'vue-yandex-maps'
const coords = [54, 39]
const settings = {
  // apiKey: '',
  // lang: 'ru_RU',
  // coordorder: 'latlong',
  // enterprise: false,
  // version: '2.1',
}
</script>

<style scoped></style>
