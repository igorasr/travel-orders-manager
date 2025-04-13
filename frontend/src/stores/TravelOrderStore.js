// stores/travelOrders.js
import { defineStore } from 'pinia'
import HttpClient from '@/services/HttpClient'
import { useToast } from 'vue-toastification'

const toast = useToast()

export const useTravelOrdersStore = defineStore('travelOrders', {
  state: () => ({
    travelOrders: [],
    loading: false
  }),

  actions: {
    async loadTravelOrders(filtros = {}) {
      this.loading = true
      const { data, success } = await HttpClient.get('/travel-orders', filtros)
      if (success) this.travelOrders = data
      this.loading = false
    },

    atualizarPedido(pedidoAtualizado) {
      const index = this.travelOrders.findIndex(p => p.id === pedidoAtualizado.id)
      if (index !== -1) this.travelOrders[index] = pedidoAtualizado
    },

    async aprovarPedido(id) {
      const payload = { status: 'aprovado' }
      const response= await HttpClient.patch(`/travel-orders/${id}/status`, payload)
      if(!response.success) {
        toast.error(response.error.message || 'Erro ao aprovar o pedido')
        return
      }
      this.atualizarPedido(response.data)
    },

    async cancelarPedido(id) {
      const response = await HttpClient.patch(`/travel-orders/${id}/cancel`)
      if(!response.success) {
        toast.error(response.error.message || 'Erro ao cancelar o pedido')
        return
      }
      this.atualizarPedido(response.data)
    }
  }
})
