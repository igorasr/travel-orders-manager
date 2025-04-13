<template>
  <div class="w-full m-1">
    <label v-if="label" :for="id" class="block text-sm text-gray-700 mb-1">
      {{ label }}
    </label>

    <input
      :id="id"
      :type="type"
      :placeholder="placeholder"
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      :class="[
        'w-full px-4 py-2 border rounded-md shadow-sm focus:outline-none transition text-gray-800',
        error
          ? 'border-red-500 focus:border-red-500 focus:ring-red-200'
          : 'border-gray-300 focus:border-blue-500 focus:ring-blue-200'
      ]"
    />

    <p v-if="error" class="text-sm text-red-500 mt-1">{{ error }}</p>
  </div>
</template>

<script setup>
const props = defineProps({
  modelValue: String,
  label: String,
  type: {
    type: String,
    default: 'text'
  },
  id: {
    type: String,
    default: () => `input-${Math.random().toString(36).substr(2, 9)}`
  },
  placeholder: String,
  error: String
})

const emit = defineEmits(['update:modelValue'])
</script>

<script>
export default {
  emits: ['update:modelValue'],
  watch: {
    modelValue(value) {
      this.$emit('update:modelValue', value)
    }
  }
}
</script>
