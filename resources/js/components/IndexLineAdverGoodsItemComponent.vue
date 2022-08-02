<template>
  <div>
    <router-link :to="{ name: 'good', params: { good_id: i.a_id } }">
      <!-- i: {{ i }} -->
      <img :src="'/storage/photo/' + i.a_arrayimage" loading="lazy" alt="" />
      <br />
      <strong>{{ i.head }}</strong>
      <br />
      {{ i.a_price }}р
    </router-link>
  </div>
</template>

<script setup>
const props = defineProps({
  i: Object,
})
</script>

<style scoped>
img {
  width: 220px;
}
</style>
