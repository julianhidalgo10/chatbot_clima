<template>
  <div class="min-h-screen bg-gray-100 p-8">
    <div class="max-w-xl mx-auto bg-white shadow p-6 rounded">
      <h1 class="text-2xl font-bold mb-4 text-blue-600">Chatbot climático</h1>

      <form @submit.prevent="sendMessage">
        <input
          type="text"
          v-model="question"
          class="w-full border border-gray-300 rounded p-2 mb-4"
          placeholder="Escribe tu pregunta..."
        />

        <button
          type="submit"
          class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
          :disabled="loading"
        >
          {{ loading ? 'Consultando...' : 'Enviar' }}
        </button>
      </form>

      <div v-if="response" class="mt-6 bg-green-100 p-4 rounded text-green-800">
        <strong>Respuesta del bot:</strong>
        <p>{{ response }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

const question = ref('')
const response = ref('')
const loading = ref(false)

const sendMessage = async () => {
  if (!question.value.trim()) return
  loading.value = true

  try {
    const res = await axios.post('/api/chat', {
      question: question.value
    })
    response.value = res.data.response
  } catch (err) {
    response.value = 'Ocurrió un error al comunicarse con el chatbot.'
    console.error(err)
  } finally {
    loading.value = false
  }
}
</script>

<!-- # cGFuZ29saW4= -->