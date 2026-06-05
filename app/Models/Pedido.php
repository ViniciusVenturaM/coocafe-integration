<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'numped',
        'data'
    ];

    protected $casts = [
        'data'   => 'array'
    ];


    public static function saveOrders($orders)
    {
        foreach ($orders as $pedidoInfo) {
            $dados = [
                'numped' => $pedidoInfo['NUMPED'],
                'data' => $pedidoInfo
            ];

            $pedido = Pedido::where('numped', '=', $dados['numped'])->firstOrNew();

            $pedido->fill($dados);
            $pedido->save();
        }

        return $orders;
    }
}
