<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Services\Coocafe;
use Illuminate\Support\Facades\Log;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = [];

        try {
            $pedidos = Coocafe::listOrders();

            if ($pedidos === false) {
                $pedidos = [];
                Log::error("Falha ao listar pedidos da API Coocafe para a view.");
            }
        } catch (\Exception $e) {
            Log::error("Erro ao carregar lista de pedidos para a view: " . $e->getMessage());
            $pedidos = [];
        }
        // $pedidos = Pedido::orderBy('numped', 'desc')->get();
        $pedidos = collect($pedidos);
        return view('pedidos', compact('pedidos'));
    }
}
