<?php

use App\Http\Controllers\ChatHistoryController;
use Illuminate\Support\Facades\Route;

Route::post('/wa/webhook', [ChatHistoryController::class, 'webhook']);
