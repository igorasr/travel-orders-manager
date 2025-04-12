## 🔐 Endpoints - Autenticação (JWT)


| Método | Endpoint             | Autenticado? | Descrição                              | Payload / Headers                                                                 | Resposta Esperada                               |
|--------|----------------------|--------------|----------------------------------------|------------------------------------------------------------------------------------|-------------------------------------------------|
| POST   | `/api/auth/register` | ❌           | Registra um novo usuário               | **Body (JSON):**<br>`name`, `email`, `password`          | `{ "token": "JWT_TOKEN" }`                      |
| POST   | `/api/auth/login`    | ❌           | Faz login e retorna token JWT          | **Body (JSON):**<br>`email`, `password`                                           | `{ "token": "JWT_TOKEN" }`                      |
| GET    | `/api/auth/me`       | ✅           | Retorna os dados do usuário logado     | **Headers:**<br>`Authorization: Bearer JWT_TOKEN`                                 | `{ "id": 1, "name": "...", "email": "..." }`    |
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