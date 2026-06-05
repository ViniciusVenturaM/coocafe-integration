<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Services\Coocafe;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    public function updateOrderStatus(int $numped, string $bansit, $valorLiberado = 0)
    {
        try {
            $orders = Coocafe::listOrders();
            if (empty($orders)) {
                return response()->json(['message' => 'Nenhum pedido encontrado na API externa Coocafe para busca.'], 404);
            }

            $pedido = null;

            foreach ($orders as $pedidoData) {
                if ($pedidoData['NUMPED'] === $numped) {
                    $pedido = $pedidoData;
                    break;
                }
            }

            if (is_null($pedido)) {
                return response()->json(['message' => "Pedido com NUMPED {$numped} não localizado na lista de pedidos da API externa."], 404);
            }

            $pedido['BANSIT'] = $bansit;

            Pedido::saveOrders([$pedido]);

            $pedido['BANVLR'] = $valorLiberado;
            $params = $this->getParams($pedido, $valorLiberado);

            Coocafe::updateOrder($params);

            return redirect()->route('pedidos.index')->with('success', 'Status atualizado com sucesso!');
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function getParams($pedido, $valorLiberado)
    {
        $paramsArray = [];

        $paramsArray[] = ["key" => "NUMPED", "value" => $pedido['NUMPED']];
        $paramsArray[] = ["key" => "BANSIT", "value" => $pedido['BANSIT']];

        if (isset($pedido['BANOBS'])) {
            $paramsArray[] = ["key" => "BANOBS", "value" => $pedido['BANOBS']];
        }
        if (isset($pedido['COD_FILPED'])) {
            $paramsArray[] = ["key" => "FILPED", "value" => $pedido['COD_FILPED']];
        }
        if (isset($pedido['VLRLIQ'])) {
            $paramsArray[] = ["key" => "BANVLR", "value" => $valorLiberado];
        }

        return [
            'params' => $paramsArray
        ];
    }

    public function prepareBase64String($base64String)
    {
        $padrao = '/<prRetorno>(.*?)<\/prRetorno>/';
        if (preg_match($padrao, $base64String, $matches) == 1) {
            $conteudoBase64 = $matches[1];
            $conteudoBase64 = trim($conteudoBase64, '"');

            return base64_decode($conteudoBase64);
        } else {
            echo "Nenhum conteúdo Base64 encontrado entre as tags <prRetorno>.\n";
        }
    }

    public function getReportPdf(int $numped)
    {
        $data = $this->getParamsForPdf($numped);
        $clientName = $data[1];
        $base64String = Coocafe::getBase64($data[0]);
        $base64Decodificada = $this->prepareBase64String($base64String);

        return $this->generatePdfFromBase64($base64Decodificada, $numped, $clientName);
    }

    public function getParamsForPdf(int $numped)
    {
        $order = Pedido::select('data')->where('numped', '=', $numped)->first();
        $requestBody = [
            'params' => []
        ];
        $pedido = $order->data;
        $requestBody['params'][] = [
            'CNPJ' => env('CNPJ_CRESOL'),
            'FILPED' => (string)$pedido['COD_FILPED'],
            'NUMPED' => (string)$numped,
            'PSWD' => env('API_PASSWORD')
        ];
        $retorno = [$requestBody, $pedido['NOMCLI']];

        return $retorno;
    }

    public function generatePdfFromBase64($base64Decodificada, $numped, $clientName)
    {
        return response($base64Decodificada)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', "inline; filename=\"{$numped}_{$clientName}.pdf\"")
            ->header('Content-Length', strlen($base64Decodificada));
    }

    public function listOrders()
    {
        try {
            $response = Http::post(env('API_BASE_URL') . '/coocafe/v1/listar-pedidos-parceiros', []);
            $response->throw();

            return response()->json($response->json(), $response->status());
        } catch (\Exception $e) {
            Log::error("Erro na rota /coocafe/v1/listar-pedidos-parceiros: " . $e->getMessage());
            $statusCode = isset($response) && $response->status() ? $response->status() : 500;

            return response()->json(['message' => 'Erro ao chamar API externa.', 'error' => $e->getMessage()], $statusCode);
        }
    }
}
