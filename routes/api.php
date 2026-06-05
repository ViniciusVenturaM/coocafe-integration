<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Services\Coocafe;

Route::get('/teste-api-loader', function () {
    return 'API Loader Working!';
});


Route::post('/login', [Coocafe::class, 'getAuthToken']);
Route::get('/atualiza-status-pedido/{numped}/{bansit}/{valorLiberado?}', [ApiController::class, 'updateOrderStatus']);
Route::get('/gera-pdf/{numped}', [ApiController::class, 'getReportPdf']);
Route::post('/listar-pedidos', [Coocafe::class, 'listOrders']);
