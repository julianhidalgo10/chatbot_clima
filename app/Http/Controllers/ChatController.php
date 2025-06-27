<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    public function ask(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'conversation_id' => 'nullable|exists:conversations,id',
        ]);

        $question = $request->input('question');
        $conversationId = $request->input('conversation_id');

        // Crear conversación si no existe
        $conversation = $conversationId
            ? Conversation::find($conversationId)
            : Conversation::create(['user_identifier' => 'anonymous']);

        // Guardar mensaje del usuario
        Message::create([
            'conversation_id' => $conversation->id,
            'sender' => 'user',
            'content' => $question,
        ]);

        // Generar respuesta con IA (OpenAI)
        $response = $this->generateSmartResponse($question);

        // Guardar respuesta del bot
        Message::create([
            'conversation_id' => $conversation->id,
            'sender' => 'bot',
            'content' => $response,
        ]);

        return response()->json([
            'conversation_id' => $conversation->id,
            'question' => $question,
            'response' => $response,
        ]);
    }

    private function generateSmartResponse($question)
{
    try {
        $prompt = <<<EOT
Eres un asistente meteorológico experto que responde en español con información clara y útil.
Si la pregunta del usuario menciona una ciudad o clima, responde usando datos de la API de Open-Meteo.
Si no tienes suficiente información para responder, indícalo educadamente.

Pregunta: "{$question}"
EOT;

        $openaiKey = config('services.openai.key');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $openaiKey,
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'Responde como un experto en clima en español.'],
                ['role' => 'user', 'content' => $prompt],
            ],
            'temperature' => 0.7,
        ]);

        if ($response->failed()) {
            \Log::error('Error al consultar OpenAI', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return "Ocurrió un problema al consultar a la IA (OpenAI).";
        }

        return $response->json()['choices'][0]['message']['content'] ?? "No se pudo obtener respuesta de la IA.";
    } catch (\Exception $e) {
        \Log::error('Excepción al consultar OpenAI', [
            'message' => $e->getMessage(),
        ]);
        return "Error inesperado al generar respuesta: " . $e->getMessage();
    }
}