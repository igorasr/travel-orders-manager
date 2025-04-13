import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import piniaPersistedstate from 'pinia-plugin-persistedstate'


import App from './App.vue'
import router from './router'

import Toast from 'vue-toastification'
import "vue-toastification/dist/index.css";

const app = createApp(App)
const pinia = createPinia()
app.use(Toast, {
  position: 'top-center',
  timeout: 3000,
  closeOnClick: true,
  pauseOnHover: true,
  draggable: true,
})

app.use(pinia)
pinia.use(piniaPersistedstate)
app.use(router)

app.mount('#app')
