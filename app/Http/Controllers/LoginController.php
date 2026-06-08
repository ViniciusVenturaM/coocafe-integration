<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Exibe a tela de login
    public function mostrarLogin()
    {
        return view('auth.login');
    }

    // Processa o clique do botão "Entrar"
    public function autenticar(Request $request)
    {
        // 1. Valida se os campos vieram do formulário Blade
        $credenciais = $request->validate([
            'usuario'  => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // 2. CRUCIAL: Passar a chave 'usuario' explicitamente para o Auth::attempt
        if (Auth::attempt(['usuario' => $credenciais['usuario'], 'password' => $credenciais['password']])) {
            $request->session()->regenerate();

            return redirect()->route('pedidos.index');
        }

        // 3. Se falhar, retorna com erro
        return back()->withErrors([
            'usuario' => 'Usuário ou senha incorretos.',
        ])->onlyInput('usuario');
    }

    // Função de Logout (caso precise colocar um botão de sair na tela de pedidos)
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
