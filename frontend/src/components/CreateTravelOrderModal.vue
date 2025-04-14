<template>

  <TransitionRoot appear :show="modelValue" as="template">
    <Dialog as="div" :open="modelValue" @close="$emit('update:modelValue', false)" class="relative z-10">
      <TransitionChild
        as="template"
        enter="duration-300 ease-out"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="duration-200 ease-in"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div class="fixed inset-0 bg-black/25" />
      </TransitionChild>

      <div class="fixed inset-0 overflow-y-auto">
        <div
          class="flex min-h-full items-center justify-center p-4 text-center"
        >
          <TransitionChild
            as="template"
            enter="duration-300 ease-out"
            enter-from="opacity-0 scale-95"
            enter-to="opacity-100 scale-100"
            leave="duration-200 ease-in"
            leave-from="opacity-100 scale-100"
            leave-to="opacity-0 scale-95"
          >
            <DialogPanel
              class="w-full max-w-2xl transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
            >
              <DialogTitle
                as="h3"
                class="text-lg font-medium leading-6 text-gray-900 flex justify-between items-center"
              >
              Novo Pedido de Viagem
                <button @click="$emit('update:modelValue', false)">
                  <X class="w-5 h-5 text-gray-500 hover:text-red-500" />
                </button>
              </DialogTitle>
              <hr class="my-4" />
              <form @submit.prevent="submitForm">
                <SelectUsuarios
                  id="usuario_id"
                  label="Usuário"
                  v-model="form.usuario_id"
                  required
                />
                <div class="flex">
                  <BaseInput required label="Cidade" v-model="form.city" placeholder="Digite a cidade de destino" />
                  <BaseInput required label="Estado" v-model="form.state" placeholder="Digite o estado de destino" />
                </div>
                <div class="flex">
                  <BaseInput required label="Pais" v-model="form.country" placeholder="Digite o pais de destino" />
                  <BaseSelect required label="Status" v-model="form.status" :options="statusOptions" />
                </div>
                <div class="flex">
                  <BaseInput required label="Data de Ida" type="date" v-model="form.data_ida" />
                  <BaseInput required label="Data de Volta" type="date" v-model="form.data_volta" />
                </div>
                <div class="mt-4 flex justify-end">
                  <BaseButton type="submit">Salvar</BaseButton>
                </div>
              </form>

            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogPanel,
  DialogTitle,
} from '@headlessui/vue'
import { X } from 'lucide-vue-next'
import { reactive, watch } from 'vue'
import BaseInput from '@/components/BaseInput.vue'
import BaseSelect from '@/components/BaseSelect.vue'
import BaseButton from '@/components/BaseButton.vue'
import HttpClient from '@/services/HttpClient'
import { useToast } from 'vue-toastification'
import SelectUsuarios from './SelectUsuarios.vue'

const props = defineProps({
  modelValue: Boolean,
})

const emit = defineEmits(['update:modelValue', 'saved'])
const toast = useToast()

const form = reactive({
  usuario_id: '',
  city: '',
  state: '',
  country: '',
  data_ida: '',
  data_volta: '',
  status: '',
})

watch(() => props.modelValue, (open) => {
  if (!open) {
    Object.assign(form, {
      city: '',
      state: '',
      country: '',
      data_ida: '',
      data_volta: '',
      status: '',
    })
  }
})

const statusOptions = [
  { label: 'Solicitado', value: 'solicitado' },
  { label: 'Aprovado', value: 'aprovado' },
  { label: 'Cancelado', value: 'cancelado' },
]

async function submitForm() {
  try {
    const payload = {
      user_id: form.usuario_id,
      destino: {
        city: form.city,
        state: form.state,
        country: form.country,
      },
      data_ida: form.data_ida,
      data_volta: form.data_volta,
      status: form.status,
    }

    await HttpClient.post('/travel-orders', payload)
    toast.success('Pedido criado com sucesso!')
    emit('update:modelValue', false)
    emit('saved') // notifica para recarregar a lista
  } catch (error) {
    toast.error('Erro ao criar pedido')
  }
}
</script>
