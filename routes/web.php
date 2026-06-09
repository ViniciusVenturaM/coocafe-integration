<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\LoginController;


// Route::get('/teste-autenticacao-secreta', function () {
//     // 1. Busca o seu usuário no banco da Railway
//     $user = \App\Models\User::where('usuario', 'vinicius.ventura')->first();
    
//     if (!$user) {
//         return 'ERRO: Usuário vinicius.ventura não foi encontrado no banco da Railway. Certifique-se de que rodou o INSERT lá primeiro!';
//     }
    
//     // 2. Atualiza a senha forçando a criptografia nativa do ambiente atual
//     $user->password = 'coocafe2026'; // O Cast 'hashed' do Model faz o trabalho sozinho
//     $user->save();
    
//     return 'SUCESSO! A senha foi recriptografada e salva direto pelo Laravel na Railway. Agora remova esse código e tente logar na tela normal!';
// });



Route::get('/login', [LoginController::class, 'mostrarLogin'])->name('login');
Route::post('/login', [LoginController::class, 'autenticar'])->name('login.autenticar');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware('auth')->group(function () {

    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::get('/pedidos/{numped}/pdf', [ApiController::class, 'getReportPdf'])->name('pedidos.pdf');

});