<template>
  <header class="w-full bg-white shadow p-4 flex justify-between items-center">
    <!-- Logo ou nome do sistema -->
    <h1 class="text-xl font-bold text-gray-800">Dashboard</h1>

    <!-- Usuário + Logout -->
    <div class="flex items-center gap-4">
      <span class="text-sm text-gray-600">Olá, {{ user.name }}</span>
      <button
        @click="logout"
        class="text-red-600 hover:text-red-700 transition flex items-center gap-1 text-sm font-medium"
      >
        <LogOut class="w-4 h-4" />
        Sair
      </button>
    </div>
  </header>
</template>

<script setup>
import { LogOut } from 'lucide-vue-next'
import { useAuthStore } from '@/stores/auth'
import { useRouter } from 'vue-router'

const auth = useAuthStore()
const router = useRouter()

const user = auth.getUser()

function logout() {
  auth.logout()
  router.push('/')
}
</script>
