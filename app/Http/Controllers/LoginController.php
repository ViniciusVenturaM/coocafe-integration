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

    
    public function autenticar(Request $request)
    {
        $credenciais = $request->validate([
            'usuario'  => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        
        if (Auth::attempt(['usuario' => $credenciais['usuario'], 'password' => $credenciais['password']])) {
            $request->session()->regenerate();

            return redirect()->route('pedidos.index');
        }

        
        return back()->withErrors([
            'usuario' => 'Usuário ou senha incorretos.',
        ])->onlyInput('usuario');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
