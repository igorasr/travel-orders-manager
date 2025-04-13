<template>
  <FormCard
    title="Login"
  >
  
  <form @submit.prevent="login">
    <BaseInput
    label="Email"
    type="email"
    placeholder="Digite seu email"
    v-model="user.email"
  />

  <BaseInput
    label="Senha"
    type="password"
    placeholder="Digite sua senha"
    v-model="user.password"
  />

  <BaseButton
    type="submit"
    variant="primary"
    size="lg"
    class="w-full mt-4"
    :loading="loading.loading"
  >
    Login
  </BaseButton>

  </form>
  
  <p class="text-center text-sm text-gray-500 mt-4">
    Não tem uma conta? 
    <router-link to="/register" class="text-blue-600 hover:underline">
      Registre-se
    </router-link>
  </p>
  </FormCard>
</template>

<script setup>
import FormCard from '@/components/FormCard.vue';
import BaseInput from '@/components/BaseInput.vue';
import BaseButton from '@/components/BaseButton.vue';
import HttpClient from '@/services/HttpClient';
import {reactive} from 'vue';
import { useAuthStore } from '@/stores/auth'


const loading = reactive({
  loading: false
});

const user = reactive({
  email: '',
  password: ''
})

async function login(){
  loading.loading = true;
  const authStore = useAuthStore();

  const payload = {
    email: user.email,
    password: user.password
  };

  try {
    let {data} = await HttpClient.post('/auth/login', payload);
    const token = data.token;

    authStore.setToken({
      token
    });

    if(token){
      let {data} = await HttpClient.get('/auth/me');

      const user = data;
      authStore.setUser({
        user
      });
    }
  } catch (error) {
    alert(error.message);
  }
  finally {
    loading.loading = false;
  }
}

</script>

<style lang="scss" scoped>

</style>