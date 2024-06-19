<?php

use App\Http\Controllers\API\V1\AuthorController;
use App\Http\Controllers\API\V1\AuthorTicketsController;
use App\Http\Controllers\API\V1\TicketController;
use App\Http\Controllers\API\V1\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('tickets', TicketController::class)->except(['update']);
    Route::put('tickets/{ticket}', [TicketController::class, 'replace']);
    Route::patch('tickets/{ticket}', [TicketController::class, 'update']);

    Route::apiResource('users', UserController::class)->except(['update']);
    Route::put('users/{user}', [UserController::class, 'replace']);
    Route::patch('users/{user}', [UserController::class, 'update']);

    Route::apiResource('authors', AuthorController::class);

    Route::apiResource('author.tickets', AuthorTicketsController::class)->except(['store', 'update', 'delete']);
    Route::put('author/{author}/tickets/{ticket}', [AuthorTicketsController::class, 'replace']);
    Route::patch('author/{author}/tickets/{ticket}', [AuthorTicketsController::class, 'update']);
});
