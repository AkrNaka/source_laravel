<?php

use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;

Route::get('/todos', [TodoController::class, 'index']);
Route::post('/todos', [TodoController::class, 'store']);
Route::get('todos/{id}', [TodoController::class, 'show']);
Route::put('todos/{id}', [TodoController::class, 'update']);

Route::get('/users', [UserController::class, 'index']);
