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
      :disabled="loading"
      :class="[
        'w-full px-4 py-2 border rounded-md shadow-sm focus:outline-none transition text-gray-800 bg-white',
        error
          ? 'border-red-500 focus:border-red-500 focus:ring-red-200'
          : 'border-gray-300 focus:border-blue-500 focus:ring-blue-200'
      ]"
    >
      <option disabled value="">
        {{ loading ? 'Carregando...' : placeholder }}
      </option>
      <option
        v-for="user in options"
        :key="user.id"
        :value="user.id"
      >
        {{ loggedUser.id == user.id ? 'Eu' : user.name }}
      </option>
    </select>

    <p v-if="error" class="text-sm text-red-500 mt-1">{{ error }}</p>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import HttpClient from '@/services/HttpClient'
import { useAuthStore } from '@/stores/auth'


const props = defineProps({
  id: String,
  modelValue: [String, Number],
  label: {
    type: String,
    default: 'Usuário'
  },
  placeholder: {
    type: String,
    default: 'Selecione um usuário'
  },
  required: {
    type: Boolean,
    default: false
  },
  error: String
})

defineEmits(['update:modelValue'])

const options = ref([])
const loading = ref(false)

const auth = useAuthStore()

const loggedUser = auth.getUser()

onMounted(async () => {
  try {
    loading.value = true
    const { data } = await HttpClient.get('/users')
    options.value = data
  } catch (error) {
    console.error('Erro ao carregar usuários:', error)
  } finally {
    loading.value = false
  }
})
</script>
