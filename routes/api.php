<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;

Route::middleware('api')->group(function () {

    // Endpoint del chatbot
    Route::post('/chat', [ChatController::class, 'ask']);

});