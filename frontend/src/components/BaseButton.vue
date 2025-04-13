<template>
  <button
    :type="type"
    :disabled="disabled || loading"
    :class="[
      'inline-flex items-center justify-center rounded-md font-medium transition px-4 py-2',
      sizeClasses,
      variantClasses,
      loading || disabled ? 'opacity-50 cursor-not-allowed' : ''
    ]"
  >
    <span v-if="loading" class="animate-spin mr-2 h-4 w-4 border-2 border-t-transparent border-white rounded-full"></span>
    <slot />
  </button>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  type: {
    type: String,
    default: 'button'
  },
  variant: {
    type: String,
    default: 'primary' // 'secondary', 'danger', etc.
  },
  size: {
    type: String,
    default: 'md' // 'sm', 'lg'
  },
  loading: {
    type: Boolean,
    default: false
  },
  disabled: {
    type: Boolean,
    default: false
  }
})

const variantClasses = computed(() => {
  switch (props.variant) {
    case 'secondary':
      return 'bg-gray-200 text-gray-800 hover:bg-gray-300'
    case 'danger':
      return 'bg-red-600 text-white hover:bg-red-700'
    default:
      return 'bg-blue-600 text-white hover:bg-blue-700'
  }
})

const sizeClasses = computed(() => {
  switch (props.size) {
    case 'sm':
      return 'text-sm px-3 py-1.5'
    case 'lg':
      return 'text-lg px-6 py-3'
    default:
      return 'text-base'
  }
})
</script>
