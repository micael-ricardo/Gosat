<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GosatApi
{
    private $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('GOSAT_API_BASE_URL');
    }

    public function consultaOfertaCredito($cpf)
    {
        $response = Http::post("{$this->baseUrl}/simulacao/credito", [
            'cpf' => $cpf,
        ]);

        return $response->json();
    }

    public function simulacaoOfertaCredito($cpf, $instituicao_id, $codModalidade)
    {
        $response = Http::post("{$this->baseUrl}/simulacao/oferta", [
            'cpf' => $cpf,
            'instituicao_id' => $instituicao_id,
            'codModalidade' => $codModalidade,
        ]);

        return $response->json();
    }
}
