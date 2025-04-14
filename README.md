# 📦 Projeto Fullstack - Laravel + Vue.js

Este é um projeto fullstack desenvolvido como parte do teste técnico. Ele combina **Laravel** no backend com **Vue.js** no frontend, ambos hospedados no mesmo diretório.

## 🛠️ Tecnologias Utilizadas

- **Laravel** (Backend - PHP)
- **Laravel Sail** (Ambiente de desenvolvimento com Docker)
- **MySQL** (Banco de dados)
- **Vue.js** (Frontend - JavaScript)
- **Docker & Docker Compose**

---

## 🚀 Como Executar o Projeto

### ✅ Pré-requisitos

Antes de começar, você precisará ter os seguintes itens instalados na sua máquina:

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/)
- [Git](https://git-scm.com/)

---

### 📥 Clonando o Repositório

```bash
git clone https://github.com/igorasr/travel-orders-manager.git
cd travel-orders-manager
```

### ⚙️ Rodando Backend

Acesse o diretorio
```bash
cd backend
```

1. Copie o arquivo .env.example e crie seu .env:
```bash
cp .env.example .env
```

2. Instale as dependências PHP com o Composer:
```bash
composer install
```

3. Inicie os containers com o Laravel Sail:
```bash
./vendor/bin/sail up -d
```
4. Gere a chave da aplicação:
```bash
./vendor/bin/sail artisan key:generate
```
5. Rode as migrations e (se necessário) os seeders:
```bash
./vendor/bin/sail artisan migrate
```

### 🖥️ Rodando o Frontend (Vue.js)
> O frontend está integrado ao Laravel e localizado em resources/js (estrutura padrão com Vite).

Acesse o diretorio do frontend
```bash
cd frontend
```

1. Instale as dependências com o npm:

```bash
npm install
```
2. Inicie o servidor Vite para desenvolvimento:
```bash
npm run dev
```

### 🌐 Acessando a Aplicação
Após iniciar os containers e servidores, acesse:

Frontend: http://localhost

Backend (API): http://localhost/api

MySQL: Acessível pela porta 3306 (confira o docker-compose.yml)

## 🔐 Endpoints - Autenticação (JWT)


| Método | Endpoint             | Autenticado? | Descrição                              | Payload / Headers                                                                 | Resposta Esperada                               |
|--------|----------------------|--------------|----------------------------------------|------------------------------------------------------------------------------------|-------------------------------------------------|
| POST   | `/api/auth/register` | ❌           | Registra um novo usuário               | **Body (JSON):**<br>`name: "John Doe", email: "john@example.com", password: "secret"` | `{ "token": "JWT_TOKEN" }`                      |
| POST   | `/api/auth/login`    | ❌           | Faz login e retorna token JWT          | **Body (JSON):**<br>`email: "john@example.com", password: "secret"`               | `{ "token": "JWT_TOKEN" }`                      |
| GET    | `/api/auth/me`       | ✅           | Retorna os dados do usuário logado     | **Headers:**<br>`Authorization: Bearer JWT_TOKEN`                                 | `{ "id": 1, "name": "John Doe", "email": "john@example.com" }` |                             | `{ "message": "Desconectado com sucesso" }`     |
| POST   | `/api/auth/logout`   | ✅           | Invalida o token atual (logout)        | **Headers:**<br>`Authorization: Bearer JWT_TOKEN`                                 | `{ "message": "Desconectado com sucesso" }`     |

---

## 📦 Endpoints - Sistema de Pedidos de Viagem

| Método  | Endpoint                                 | Descrição                                                                 |
|---------|------------------------------------------|---------------------------------------------------------------------------|
| POST    | /api/travel-orders                       | Cria um novo pedido de viagem com id do usuario (solicitante), destino, datas e status inicial. |
| GET     | /api/travel-orders/{id}                  | Retorna os detalhes completos de um pedido de viagem pelo ID.            |
| GET     | /api/travel-orders                       | Lista todos os pedidos de viagem, com suporte a filtros por status, destino e período. |
| PATCH   | /api/travel-orders/{id}/status           | Atualiza o status do pedido para "aprovado" ou "cancelado". |
| PATCH   | /api/travel-orders/{id}/cancel           | Cancela um pedido aprovado .         |
| GET     | /api/travel-orders?status=...&cidade=...&estado=...&pais=...&data_ida_inicio=...&data_ida_fim=... | Lista pedidos filtrando por status, destino ou período. (mesmo endpoint do GET geral) |

## 📦 Como Rodar os Testes

### Executando Testes

Para rodar os testes do projeto, você pode usar o PHPUnit. O ambiente de testes está configurado para usar um banco de dados **SQLite** em memória.

1. Navegue até o diretório do backend:
    ```bash
    cd backend
    ```
2. Execute os testes com o seguinte comando:
    ```bash
    php artisan test --env=testing
    ```
3. Para rodar testes de integração específicos, você pode usar o PHPUnit diretamente:
    ```bash
    vendor/bin/phpunit --filter NomeDoTeste
    ```

### Testando a API
Os testes estão configurados para validar a criação de pedidos de viagem, autenticação de usuários, e filtros de pesquisa. Para mais detalhes sobre as APIs, confira a coleção Postman incluída.

[Collection para testes da API](./TravelOrderManager.postman_collection.json)