<?php

namespace App\Services;

use App\Models\Pedido;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Coocafe
{
    public static function getAuthToken()
    {
        $token = Cache::get('access_token');
        if (!$token) {
            $token = self::loginApi();
            if ($token) {
                Cache::put('access_token', $token, 600);
            }
        }

        return $token;
    }

    public static function loginApi()
    {
        try {
            $response = Http::cresol()->post('/auth/login-api', [
                'username' => env('API_USERNAME'),
                'password' => env('API_PASSWORD'),
            ]);

            return $response->json('access_token');
        } catch (\Exception $e) {
            Log::error($e);

            return false;
        }
    }

    public static function listOrders()
    {
        try {
            $response = Http::cresol()
                ->withToken(self::getAuthToken())
                ->post('/coocafe/v1/listar-pedidos-parceiros?disablePagination=true', []);

            $orders = $response->json();
            Pedido::saveOrders($orders);

            $numpeds = array_column($orders, 'NUMPED');
            $pedidosLocais = Pedido::whereIn('numped', $numpeds, 'and', false)->get()->keyBy('numped');

            foreach ($orders as &$pedido) {
                $numped = $pedido['NUMPED'];

                if ($pedidosLocais->has($numped)) {
                    $pedido['num_processo']   = $pedidosLocais[$numped]->num_processo;
                    $pedido['chamado_finalizado'] = $pedidosLocais[$numped]->chamado_finalizado;
                } else {
                    $pedido['num_processo']   = null;
                    $pedido['chamado_finalizado'] = false;
                }
            }
            
            return $orders;
        } catch (\Exception $e) {
            Log::error($e);

            return false;
        }
    }

    public static function updateOrder($params)
    {
        $token = self::getAuthToken();
        try {
            $response = Http::cresol()
                ->withToken($token)
                ->post('/coocafe/v1/atualizar-pedidos-parceiro-status?disablePagination=true&page=1&limit=10', $params);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error($e);

            return false;
        }
    }

    public static function getBase64($params)
    {
        try {
            $response = Http::cresol()
                ->withToken(self::getAuthToken())
                ->post('/coocafe/v1/relatorio-pdf', $params);
            return $response->body();
        } catch (\Exception $e) {
            Log::error($e);

            return false;
        }
    }
}
