<template>
  <div class="w-full max-w-3xl mx-auto p-4">
    <div class="bg-white shadow-md rounded-2xl p-6 sm:p-8">
      <h2 class="text-xl sm:text-2xl font-semibold text-gray-800">
        {{ title }}
      </h2>
      <small class="text-gray-600">
        {{ description }}
      </small>
      <hr class="m-2">
      <slot />
    </div>
  </div>
</template>

<script setup>
defineProps({
  title: {
    type: String,
    default: 'Formulário'
  },
  description: {
    type: String,
    default: ''
  }
})
</script>

<style scoped>
/* Se quiser estilos adicionais */
</style>
