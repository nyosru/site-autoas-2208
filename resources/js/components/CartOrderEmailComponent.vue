<template>
  <div class="pt-2 pb-2">
    <div class="text-center mb-1">
      Указан E-mail:
      <br />
      <b>{{ email }}</b>
    </div>
    <!-- mail_send: {{ mail_send }} -->
    <div v-if="mail_send">
      Для подтверждения, перейдите по ссылке, которую Вам послали
    </div>
    <!-- <br />
    <br />
    mail_verify_ranee: {{ mail_verify_ranee }}
    <br />
    mail_in_stop_list: {{ mail_in_stop_list }} -->
  </div>
</template>

<script setup>
const props = defineProps({
  email: '',
  mail_send: false,
})
</script>

<style scoped></style>
