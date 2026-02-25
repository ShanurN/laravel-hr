<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/widget', [\App\Http\Controllers\WidgetController::class, 'index']);