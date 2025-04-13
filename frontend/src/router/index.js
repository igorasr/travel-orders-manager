import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/LoginView.vue'
import { useAuthStore } from '@/stores/auth'
import RegisterUserView from '@/views/RegisterUserView.vue'


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'login',
      component: LoginView,
    },
    {
      path: '/register',
      name: 'register',
      component: RegisterUserView,
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      meta: {
        requiresAuth: true,
      },
      component: () => import('../views/Dashboard.vue'),
    },
  ],
})

router.beforeEach(async (to, from, next) => {
  const auth = useAuthStore();
  const isAuthenticated = await auth.isAuthenticated();

  // Se a rota exige autenticação e o usuário não está logado
  if (to.meta.requiresAuth && !isAuthenticated) {
    return next({ name: 'login' })
  }

  // Se já está logado e tenta acessar /login, redireciona pra /dashboard
  if (to.name === 'login' && await isAuthenticated) {
    return next({ name: 'dashboard' })
  }

  next()
})

export default router
