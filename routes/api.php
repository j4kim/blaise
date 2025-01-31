<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/authenticate', [LoginController::class, 'authenticate']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/clients/{client}', [ClientController::class, 'show'])->name('clients.show');
Route::get('/clients/search/{query}', [ClientController::class, 'search'])->name('clients.search');
