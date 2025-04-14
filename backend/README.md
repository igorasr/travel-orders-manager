# 📘 TravelOrderManager API

API para gerenciamento de pedidos de viagem e autenticação de usuários.

> **Base URL:** `http://127.0.0.1/api`

---

## 🔐 Autenticação

A maioria dos endpoints exige autenticação via token JWT.

**Cabeçalho:**
```
Authorization: Bearer {jwt_token}
Accept: application/json
```

---

## 🧍 Usuários

### 🔹 Registrar Usuário

**POST** `/auth/register`

Cria um novo usuário.

**Body (JSON):**
```json
{
  "name": "John Doe",
  "email": "johndoe@fake.com",
  "password": "senha123"
}
```

---

### 🔹 Login

**POST** `/auth/login`

Realiza o login do usuário e retorna o token JWT.

**Body (JSON):**
```json
{
  "email": "johndoe@teste.com",
  "password": "senha123"
}
```

---

### 🔹 Logout

**POST** `/auth/logout`

Realiza logout e invalida o token.

**Body (JSON):**
```json
{
  "email": "johndoe@fake.com",
  "password": "senha123"
}
```

---

### 🔹 Informações do Usuário Autenticado

**GET** `/auth/me`

Retorna os dados do usuário logado.

---

## 🧾 Pedidos de Viagem

### 🔹 Listar todos os pedidos

**GET** `/travel-orders`

Retorna a lista de todos os pedidos de viagem.

---

### 🔹 Detalhar pedido por ID

**GET** `/travel-orders/{id}`

Exemplo:
```
/travel-orders/99
```

---

### 🔹 Criar novo pedido

**POST** `/travel-orders`

**Body (JSON):**
```json
{
  "user_id": 1,
  "destino": {
    "city": "Rio de Janeiro",
    "state": "RJ",
    "country": "Brasil"
  },
  "status": "solicitado",
  "data_ida": "2025-06-25",
  "data_volta": "2025-07-05"
}
```

---

### 🔹 Atualizar status do pedido

**PATCH** `/travel-orders/{id}/status`

Exemplo:
```
/travel-orders/3/status
```

**Body (JSON):**
```json
{
  "status": "aprovado"
}
```

---

### 🔹 Cancelar pedido

**PATCH** `/travel-orders/{id}/cancel`

Exemplo:
```
/travel-orders/3/cancel
```

---

## 👥 Usuários

### 🔹 Listar todos os usuários

**GET** `/users`

Retorna a lista de usuários cadastrados.

---
