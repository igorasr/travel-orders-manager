// stores/travelOrders.js
import { defineStore } from 'pinia'
import HttpClient from '@/services/HttpClient'

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
      const { success, data } = await HttpClient.patch(`/travel-orders/${id}`, payload)
      if (success) this.atualizarPedido(data)
    },

    async cancelarPedido(id) {
      const { success, data } = await HttpClient.patch(`/travel-orders/${id}/cancel`)
      if (success) this.atualizarPedido(data)
    }
  }
})
