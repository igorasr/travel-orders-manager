import axios from 'axios';

const baseURL = 'http://localhost/api';

/**
 * Este servico é utilizado para fazer requisições HTTP para a API.
 * 
 * Centraliza a instancia do Axios com as configurações padrão e os interceptors.
 */
const axiosInstance = axios.create({
  baseURL,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
});


// Adiciona um interceptor de requisição para adicionar o token de autenticação
axiosInstance.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token');
    if (token) {
      config.headers['Authorization'] = `Bearer ${token}`;
    }
    return config;
  }
);

/**
 * Trata qualquer chamada da API, capturando o erro e retornando uma resposta segura
 */
async function request(method, url, data = null, config = {}) {
  try {
    const response = await axiosInstance({ method, url, data, ...config })
    return {
      success: true,
      data: response.data.data || response.data,
      error: null
    }
  } catch (err) {
    let message = 'Erro inesperado.'
    if (err.response?.data?.message) {
      message = err.response.data.message
    } else if (err.message) {
      message = err.message
    }

    return {
      success: false,
      data: null,
      error: {
        status: err.response?.status || null,
        message
      }
    }
  }
}

const HttpClient = {
  get: (url, params = {}) =>
    request('get', url, null, { params }),

  post: (url, data = {}) =>
    request('post', url, data),

  patch: (url, data = {}) =>
    request('patch', url, data),

  delete: (url) =>
    request('delete', url)
}

export default HttpClient;