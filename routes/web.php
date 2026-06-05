<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ApiController;

Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
Route::get('/pedidos/{numped}/pdf', [ApiController::class, 'getReportPdf'])->name('pedidos.pdf');