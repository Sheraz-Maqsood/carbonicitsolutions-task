<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WeatherController;
use App\Http\Controllers\OrderController;


Route::get('/', [WeatherController::class, 'showWeather']);

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::post('/orders/sync/{order}', [OrderController::class, 'syncOrderWithApi'])->name('orders.sync');
