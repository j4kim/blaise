<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\VisitController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/authenticate', [LoginController::class, 'authenticate']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn(Request $request) => $request->user());
    Route::post('/logout', [LoginController::class, 'logout']);
    Route::get('/clients/{client}', [ClientController::class, 'show'])->name('clients.show');
    Route::get('/clients/search/{query}', [ClientController::class, 'search'])->name('clients.search');
    Route::post('/visits/{client}', [VisitController::class, 'store'])->name('visits.store');
    Route::post('/visits/{visit}/validate', [VisitController::class, 'validate'])->name('visits.validate');
    Route::delete('/visits/{visit}', [VisitController::class, 'destroy'])->name('visits.destroy');
    Route::post('visits/{visit}/services/{service}', [VisitController::class, 'addService'])->name('visits.addService');
    Route::post('visits/{visit}/article/{article}', [VisitController::class, 'addArticle'])->name('visits.addArticle');
    Route::put('visits/{visit}/sale/{sale}', [VisitController::class, 'updateSale'])->name('visits.updateSale');
    Route::delete('visits/{visit}/sale/{sale}', [VisitController::class, 'deleteSale'])->name('visits.deleteSale');
    Route::post('visits/{visit}/sale', [VisitController::class, 'addSale'])->name('visits.addSale');
    Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
});
