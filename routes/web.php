<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\LoginController;


Route::get('/login', [LoginController::class, 'mostrarLogin'])->name('login');
Route::post('/login', [LoginController::class, 'autenticar'])->name('login.autenticar');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware('auth')->group(function () {

    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::get('/pedidos/{numped}/pdf', [ApiController::class, 'getReportPdf'])->name('pedidos.pdf');

});