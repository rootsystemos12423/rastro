<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RastreioController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/rastreio/{id}', [RastreioController::class, 'show'])->name('rastreio.show');


Route::get('/email', function () {
    return view('emails.tracking_code');
});