<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RastreioController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/rastreio', [RastreioController::class, 'reciveOrder']);

Route::get('/rastreio', function (Request $request) {
    return response()->noContent(200);  // Sem corpo e status 200
});
