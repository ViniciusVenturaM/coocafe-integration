<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\LoginController;


Route::get('/teste-autenticacao-secreta', function () {
    $tentativa = \Illuminate\Support\Facades\Auth::attempt([
        'usuario' => 'vinicius.ventura', 
        'password' => 'coocafe2026'
    ]);
    
    return $tentativa ? 'SENHA E USUÁRIO CORRETOS NO BANCO!' : 'FALHOU: O BANCO NÃO ACEITOU.';
});



Route::get('/login', [LoginController::class, 'mostrarLogin'])->name('login');
Route::post('/login', [LoginController::class, 'autenticar'])->name('login.autenticar');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware('auth')->group(function () {

    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::get('/pedidos/{numped}/pdf', [ApiController::class, 'getReportPdf'])->name('pedidos.pdf');

});