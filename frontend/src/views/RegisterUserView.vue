<template>
  <FormCard
    title="Registre-se"
    description="Crie uma conta para acessar o sistema"
  >
  
  <form @submit.prevent="register">
    <BaseInput
    label="Nome"
    type="text"
    placeholder="Digite seu nome"
    v-model="user.name"
    required
    />

  <BaseInput
    label="Email"
    type="email"
    placeholder="Digite seu email"
    v-model="user.email"
    required
  />

  <BaseInput
    label="Senha"
    type="password"
    placeholder="Digite sua senha"
    v-model="user.password"
    required
  />
  <BaseInput
    label="Confirmação de Senha"
    type="password"
    placeholder="Digite sua senha novamente"
    :error="erroConfirmacao"
    v-model="user.password_confirmation"
    required
  />

  <BaseButton
    type="submit"
    variant="primary"
    size="lg"
    class="w-full mt-4"
    :loading="loading.loading"
  >
    Registre-se
  </BaseButton>

  </form>
  </FormCard>
</template>

<script setup>
import FormCard from '@/components/FormCard.vue';
import BaseInput from '@/components/BaseInput.vue';
import BaseButton from '@/components/BaseButton.vue';
import HttpClient from '@/services/HttpClient';
import {reactive, ref} from 'vue';
import { useAuthStore } from '@/stores/auth'
import { useRouter } from 'vue-router'
import { useToast } from "vue-toastification";

const router = useRouter()
const toast = useToast();

const loading = reactive({
  loading: false
});

const user = reactive({
  name: '',
  email: '',
  password: '',
  password_confirmation: ''
})

const erroConfirmacao = ref('')

function validarSenhasIguais(senha, confirmacao) {
  return senha === confirmacao
}

async function register(){
  if (!validarSenhasIguais(user.password, user.password_confirmation)) {
    erroConfirmacao.value = 'As senhas não coincidem.'
    return
  }

  loading.loading = true;
  const authStore = useAuthStore();

  const payload = {
    name: user.name,
    email: user.email,
    password: user.password
  };

  try {
    let response = await HttpClient.post('/auth/register', payload);

    if(!response.success){
      toast.error(response.error.message);
      return;
    }

    const token = response.data.token;

    authStore.setToken({
      token
    });

    if(token){
      let {data} = await HttpClient.get('/auth/me');

      const user = data;
      authStore.setUser({
        user
      });

      router.replace('/dashboard');
    }
  } catch (error) {
    toast.error(error.message);
  }
  finally {
    loading.loading = false;
  }
}

</script>

<style lang="scss" scoped>

</style>