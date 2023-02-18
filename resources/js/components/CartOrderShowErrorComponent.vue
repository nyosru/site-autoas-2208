<template>
  <div class="alert alert-danger">
    <div v-for="i in errors" :key="i">
      {{ i }}
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  errors: {},
})
</script>

<style scoped></style>
