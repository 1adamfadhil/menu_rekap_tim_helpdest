<?php

use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLogin']);

Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth')->group(function () {

    Route::get("/tickets", [TicketController::class, 'index']);

    Route::get('/tickets/create', [TicketController::class, 'create']);

    Route::post('/tickets', [TicketController::class, 'store']);

    Route::get('/tickets/{id}/edit', [TicketController::class, 'edit']);

    Route::put('/tickets/{id}', [TicketController::class, 'update']);

    Route::put('/tickets/{id}/status', [TicketController::class, 'updateStatus'])
        ->middleware('role:admin,agent');

    Route::delete('/tickets/{id}', [TicketController::class, 'destroy']);

    Route::post('/tickets/{id}/comments', [TicketController::class, 'storeComment']);

    Route::put('/tickets/{id}/agent', [TicketController::class, 'assignAgent'])
        ->middleware('role:admin');

    Route::get('/tickets/{id}', [TicketController::class, 'show']);
});
