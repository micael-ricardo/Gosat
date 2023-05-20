<?php

namespace App\Http\Controllers;

use App\Services\GosatApi;
use Illuminate\Http\Request;

class CreditoController extends Controller
{
    private $gosatApi;

    public function __construct(GosatApi $gosatApi)
    {
        $this->gosatApi = $gosatApi;
    }

    public function consultaOfertaCredito(Request $request)
    {
        $cpf = $request->input('cpf');
        $result = $this->gosatApi->consultaOfertaCredito($cpf);

        return response()->json($result);
    }

    public function simulacaoOfertaCredito(Request $request)
    {
        $cpf = $request->input('cpf');
        $instituicao_id = $request->input('instituicao_id');
        $codModalidade = $request->input('codModalidade');

        $result = $this->gosatApi->simulacaoOfertaCredito($cpf, $instituicao_id, $codModalidade);

        return response()->json($result);
    }
}
