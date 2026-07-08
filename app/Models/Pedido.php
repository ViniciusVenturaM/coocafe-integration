<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'numped',
        'data',
        'num_processo',
        'chamado_finalizado'
    ];

    protected $casts = [
        'data'   => 'array'
    ];


    public static function saveOrders($pedidos)
    {
        foreach ($pedidos as $pedidoInfo) {
            $dados = [
                'numped' => $pedidoInfo['NUMPED'],
                'data' => $pedidoInfo
            ];

            Pedido::updateOrCreate(
                ['numped' => $dados['numped']],
                $dados
            );
        }

        return $pedidos;
    }
}
