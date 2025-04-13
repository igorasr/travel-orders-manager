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
    localStorage.setItem('user', JSON.stringify(data.user))
  }

  function getUser()
  {
    const userData = localStorage.getItem('user');
    if (userData) {
      user.value = JSON.parse(userData);
    }
    return user.value;
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

  async function logout() {
    await HttpClient.get('/auth/logout');
    localStorage.removeItem('token')
    localStorage.removeItem('user')
    user.value = null
    token.value = null
  }

  return {
    token,
    user,
    isAuthenticated,
    setToken,
    setUser,
    logout,
    getUser
  }
}
)
