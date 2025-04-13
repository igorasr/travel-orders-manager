import { defineStore } from 'pinia'
import { ref } from 'vue'
import HttpClient from '@/services/HttpClient.js'

export const useAuthStore = defineStore('auth', () => {
  // Estado
  const token = ref(null)
  const user = ref(null)

  // Computado opcional

  // Ações
  function setToken(data) {
    token.value = data.token
    localStorage.setItem('token', data.token)
  }

  function setUser(data) {
    user.value = data.user
    localStorage.setItem('user', data.user)
  }

  async function isAuthenticated() {
    try{
      let {data} = await HttpClient.get('/auth/me');
      const userData = data;
      return !!userData;

    } catch (error) {
      return false
    }

  }

  function logout() {
    user.value = null
    token.value = null
  }

  return {
    token,
    user,
    isAuthenticated,
    setToken,
    setUser,
    logout
  }
})
