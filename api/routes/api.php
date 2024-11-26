<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\NotificationPreferenceController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(EventController::class)->group(function () {
    Route::get('/events', 'index');
    Route::post('/event', 'store');
    Route::delete('/event/{id}', 'destroy');
    Route::get('/event/{id}', 'show');
    Route::put('/event/{id}', 'update');
});

Route::controller(TenantController::class)->group(function () {
    Route::get('/tenants', 'index');
    Route::get('/tenant/{id}', 'show');
    Route::delete('/tenant/{id}', 'destroy');
    Route::post('/tenant', 'store');
    Route::put('/tenant/{id}', 'update');
});

Route::controller(ClientController::class)->group(function () {
    Route::get('/clients', 'index');
    Route::get('/client/{id}', 'show');
    Route::delete('/client/{id}', 'destroy');
    Route::post('/client', 'store');
    Route::put('/client/{id}', 'update');
});

Route::controller(TicketController::class)->group(function () {
    Route::get('/tickets', 'index');
    Route::get('/ticket/{id}', 'show');
    Route::delete('/ticket/{id}', 'destroy');
    Route::post('/ticket', 'store');
    Route::put('/ticket/{id}', 'update');
});

Route::controller(TransactionController::class)->group(function () {
    Route::get('/transactions', 'index');
    Route::get('/transaction/{id}', 'show');
    Route::delete('/transaction/{id}', 'destroy');
    Route::post('/transaction', 'store');
    Route::put('/transaction/{id}', 'update');
});

Route::controller(NotificationPreferenceController::class)->group(function () {
    Route::get('/notifications', 'index');
    Route::get('/notification/{id}', 'show');
    Route::delete('/notification/{id}', 'destroy');
    Route::post('/notification', 'store');
    Route::put('/notification/{id}', 'update');
});