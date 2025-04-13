<template>
  <div class="w-full m-1">
    <label v-if="label" :for="id" class="block text-sm text-gray-700 mb-1">
      {{ label + (required ? ' *' : '') }}
    </label>

    <select
      :id="id"
      :value="modelValue"
      @change="$emit('update:modelValue', $event.target.value)"
      :required="required"
      :class="[
        'w-full px-4 py-2 border rounded-md shadow-sm focus:outline-none transition text-gray-800 bg-white',
        error
          ? 'border-red-500 focus:border-red-500 focus:ring-red-200'
          : 'border-gray-300 focus:border-blue-500 focus:ring-blue-200'
      ]"
    >
      <option
        v-for="(option, index) in options"
        :key="index"
        :value="option.value"
      >
        {{ option.label }}
      </option>
    </select>

    <p v-if="error" class="text-sm text-red-500 mt-1">{{ error }}</p>
  </div>
</template>

<script setup>
defineProps({
  id: String,
  label: String,
  modelValue: [String, Number],
  options: {
    type: Array,
    default: () => [],
  },
  error: String,
  placeholder: {
    type: String,
    default: 'Selecione uma opção',
  },
  required: {
    type: Boolean,
    default: false,
  },
})
defineEmits(['update:modelValue'])
</script>
