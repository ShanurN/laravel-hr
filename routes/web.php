<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/widget', [\App\Http\Controllers\WidgetController::class, 'index']);

Route::group(['prefix' => 'admin'], function () {
    Route::get('/tickets', [\App\Http\Controllers\Admin\TicketController::class, 'index'])->name('admin.tickets.index');
    Route::get('/tickets/{id}', [\App\Http\Controllers\Admin\TicketController::class, 'show'])->name('admin.tickets.show');
    Route::patch('/tickets/{id}/status', [\App\Http\Controllers\Admin\TicketController::class, 'updateStatus'])->name('admin.tickets.updateStatus');
});