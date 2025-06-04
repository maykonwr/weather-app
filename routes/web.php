<?php

use App\Http\Controllers\WeatherController;

Route::get('/', [WeatherController::class, 'index']);
Route::post('/search', [WeatherController::class, 'search']);