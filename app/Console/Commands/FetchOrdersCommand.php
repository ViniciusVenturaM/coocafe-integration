<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pedido;
use App\Services\Coocafe;
use Illuminate\Support\Facades\Log;

class FetchOrdersCommand extends Command
{
    protected $signature = 'fetch:orders';
    protected $description = 'Fetches orders from partner API and stores them in DB.';

    public $authToken = null;
    
    public function handle()
    {
        $this->info('Iniciando busca de pedidos da API externa...');

        try {
            $orders = Coocafe::listOrders();

            if (!$orders) {
                $this->info('Nenhum pedido novo para processar.');
                return Command::SUCCESS;
            }
            foreach ($orders as $pedidoInfo) {
                $pedido = Pedido::where('numped', $pedidoInfo['NUMPED'])->firstOrNew();
                $pedido->data = $pedidoInfo;
                $isNew = !$pedido->exist; 
                $pedido->save();

                if($isNew){
                    // enviar para algum lugar (sheets e afins, se tiver como)
                }
            }
            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error("Erro ao buscar e armazenar pedidos: " . $e->getMessage());
            Log::error("Erro no comando 'fetch:orders': " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
