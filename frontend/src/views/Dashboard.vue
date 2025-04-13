<template>
  <div class="p-6 max-w-7xl mx-auto">
    <!-- Filtros -->
    <FormCard
      title="Filtros"
      description="Filtre os pedidos de acordo com suas preferências."
      class="mb-8"
    >
      <form @submit.prevent="buscarPedidos" class="grid gap-4 md:grid-cols-3">
      <BaseInput v-model="filtros.status" label="Status" placeholder="Ex: solicitado" />
      <BaseInput v-model="filtros.cidade" label="Cidade" placeholder="Ex: Belo Horizonte" />
      <BaseInput v-model="filtros.estado" label="Estado" placeholder="Ex: BH" />
      <BaseInput v-model="filtros.pais" label="País" placeholder="Ex: Brasil" />
      <BaseInput v-model="filtros.data_ida" label="Data de ida" type="date" />
      <BaseInput v-model="filtros.data_volta" label="Data de volta" type="date" />

      <div class="md:col-span-3">
        <BaseButton class="w-full md:w-auto" type="submit">Filtrar</BaseButton>
      </div>
    </form>
    </FormCard>

    <!-- Lista de pedidos -->
    <div class="mt-8 grid gap-4">
      <div
        v-for="travelOrder in travelOrders"
        :key="travelOrder.id"
        class="p-4 rounded-xl shadow bg-white border border-gray-100 flex flex-col md:flex-row justify-between gap-4 transform transition hover:-translate-y-1 hover:shadow-md items-center"
      >
        <div >
          <h3 class="text-lg font-semibold text-gray-800">
            {{ travelOrder.destino.city }}, {{ travelOrder.destino.state }} - {{ travelOrder.destino.country }}
          </h3>
          <span
            class="inline-block text-sm font-medium px-2 py-1 rounded mt-1"
            :class="statusClass(travelOrder.status) + ' text-white'"
          >
          {{ travelOrder.status }}
        </span>
        </div>
        <div class="text-sm text-gray-700 text-right md:text-left">
          <p>Ida: {{ formatarData(travelOrder.data_ida) }}</p>
          <p>Volta: {{ formatarData(travelOrder.data_volta) }}</p>
        </div>

        <!-- Ações -->
        <div class="flex flex-col gap-1 mt-3">
            <BaseButton
              :disabled="canApprove(travelOrder)"
              @click="store.aprovarPedido(travelOrder.id)"
              class="text-green-600 hover:text-green-800 transition"
              title="Aprovar"
              variant="transparent"
            >
              <CheckCircle class="w-5 h-5" />
            </BaseButton>
    
            <BaseButton
              :disabled="canCancel(travelOrder)"
              @click="store.cancelarPedido(travelOrder.id)"
              class="text-red-500 hover:text-red-700 transition"
              title="Cancelar"
              variant="transparent"
            >
              <XCircle class="w-5 h-5" />
            </BaseButton>
          </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import HttpClient from '@/services/HttpClient'
import BaseInput from '@/components/BaseInput.vue'
import BaseButton from '@/components/BaseButton.vue'
import FormCard from '@/components/FormCard.vue'
import { CheckCircle, XCircle } from 'lucide-vue-next'
import { useTravelOrdersStore } from '@/stores/TravelOrderStore'
import { storeToRefs } from 'pinia'

const store = useTravelOrdersStore()
const { travelOrders, loading } = storeToRefs(store)

// Estado dos filtros
const filtros = ref({
  status: '',
  cidade: '',
  estado: '',
  pais: '',
  data_ida: '',
  data_volta: ''
})

store.loadTravelOrders()


// Formatar datas
function formatarData(data) {
  return new Date(data).toLocaleDateString('pt-BR')
}

function statusClass(status) {
  switch (status) {
    case 'solicitado':
      return 'bg-sky-950'
    case 'aprovado':
      return 'bg-emerald-500'
    case 'cancelado':
      return 'bg-red-800'
  }
}

function canApprove(pedido) {
  return pedido.status === 'solicitado'
}

function canCancel(pedido) {
  return pedido.status === 'solicitado' || pedido.status === 'aprovado'
}
</script>
