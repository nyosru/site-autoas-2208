<template>
  <div class="pt-2 pb-2">
    <div class="text-center mb-1">
      Указан E-mail:
      <br />
      <b>{{ email }}</b>
    </div>
    Для подтверждения, перейдите по ссылке, которую Вам послали
  </div>
</template>

<script setup>
const props = defineProps({
  email: '',
})
</script>

<style scoped></style>
