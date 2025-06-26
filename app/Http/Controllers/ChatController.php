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
        $userMessage = Message::create([
            'conversation_id' => $conversation->id,
            'sender' => 'user',
            'content' => $question,
        ]);

        // Generar respuesta con IA (la veremos en el siguiente paso)
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
        // Aquí va la lógica real con OpenAI y Open-Meteo en próximos commits.
        return "Respuesta simulada: aún sin integrar OpenAI";
    }
}