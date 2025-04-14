# 🛒 API de Produtos (Simples e em PHP)

Esta é uma API REST básica em PHP que permite o gerenciamento de produtos. Os dados são salvos localmente em um arquivo `products.json`.

---

## ▶️ Como rodar

1. Coloque todos os arquivos em uma pasta, por exemplo: `api_rest/`
2. Inicie um servidor local com PHP:
```Seja o XAMPP, Laragon ou afins.
```

---

## 🧪 Testando com Postman ou Insomnia

### 🔹 Listar todos os produtos

- **Método:** GET  
- **URL:** `http://localhost/api_rest/api/api.php`

---

### 🔍 Buscar produto por nome

- **Método:** GET  
- **URL:** `http://localhost/api_rest/api/api.php/products?name=mouse`

---

### 🔹 Obter produto por ID

- **Método:** GET  
- **URL:** `http://localhost/api_rest/api/api.php/products?id=2`

---

### ➕ Adicionar novo produto

- **Método:** POST  
- **URL:** `http://localhost/api_rest/api/api.php/`  
- **Body (JSON):**

```json
{
  "name": "Mouse Gamer",
  "price": 199.99
}
```

---

### ✏️ Atualizar produto

- **Método:** PUT  
- **URL:** `http://localhost/api_rest/api/api.php?id=2`  
- **Body (JSON):**

```json
{
  "name": "Mouse RGB",
  "price": 249.99
}
```

---

### ❌ Deletar produto

- **Método:** DELETE  
- **URL:** `http://localhost/api_rest/api/api.php/?id=1`

---

## 📁 Estrutura de Pastas

```
api_rest/
├── api.php
├── products.json
```

---

## ✅ Extras

- Filtro por nome com `?name=algo`
- Sem banco de dados, 100% em arquivo JSON
- Suporte a GET, POST, PUT, DELETE