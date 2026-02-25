<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/tickets', [\App\Http\Controllers\Api\TicketController::class, 'store']);
Route::get('/tickets/statistics', [\App\Http\Controllers\Api\TicketController::class, 'statistics']);
