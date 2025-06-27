# Chatbot Climático

Este proyecto es un **chatbot inteligente para consultar el clima en tiempo real**, desarrollado como prueba técnica. Combina tecnologías como Laravel, Vue 3, Tailwind CSS, OpenAI y la API de Open-Meteo.

---

## Tecnologías utilizadas

- **Backend:** Laravel 12
- **Frontend:** Vue.js 3 + Vite
- **Estilos:** Tailwind CSS
- **Base de datos:** MySQL
- **IA:** OpenAI (modelo GPT)
- **API de clima:** Open-Meteo

---

## Instalación y configuración

### 1. Clona el repositorio

```bash
git clone https://github.com/julianhidalgo10/chatbot_clima.git
cd chatbot_clima
```

### 2. Instala las dependencias de PHP

```bash
composer install
```

### 3. Instala dependencias de Node (JS/Vue)

```
npm install
```

### 4. Se crea y se configura el archivo .env
Copia el archivo .env.example y renómbralo como .env:

```
cp .env.example .env
```

Edita las siguientes variables en .env:

```
DB_DATABASE=chatbot_clima
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña

OPENAI_API_KEY=sk-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
```

Se puede obtener la API KEY OPENAI desde: https://platform.openai.com/api-keys

### 5. Se genera la clave de aplicación y se ejecutan las migraciones

```
php artisan key:generate
php artisan migrate
```

Asegurarse de tener corriendo el servidor MySQL antes de este paso.

### 6. Se inician los servidores

Backend Laravel:
```php artisan serve```

Frontend (Vite + Vue 3):
```npm run dev```

---

## ¿Cómo se usa?

1. Accede a `http://localhost:8000`

2. Escribe una pregunta como: `¿Cómo está el clima en Medellín?`

3. El chatbot analiza la intención y responde gracias a OpenAI y Open-Meteo.

4. La conversación se guarda en la base de datos.

---

## Estructura resumida del proyecto

├── app/
│   ├── Http/Controllers/ChatController.php
│   ├── Models/Conversation.php
│   └── Models/Message.php
├── database/
│   └── migrations/
├── resources/
│   └── js/  <-- Vue frontend
├── routes/
│   └── api.php
└── .env

---

## Consideraciones

Si OpenAI no responde, revisar la conexión o firewall. El error `cURL error 6` significa que el servidor no pudo llegar a `api.openai.com`.

---

## Autor

Julián Hidalgo
Ingeniero Electrónico | Entusiasta de la IA y desarrollo web fullstack.

---

## Licencia

Uso libre para fines académicos y de evaluación técnica.