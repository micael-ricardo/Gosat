<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConsultaCredito;
use App\Models\OfertaCredito;

class ConsultaCreditoController extends Controller
{
    public function store(Request $request)
    {
        // Salvar dados na tabela consulta_credito
        $consultaCredito = ConsultaCredito::create([
            'cpf' => $request->input('cpf')
        ]);

        // Obter o ID da consulta de crédito
        $consultaCreditoId = $consultaCredito->id;
        $ofertas = $request->input('ofertas');
        foreach ($ofertas as $oferta) {
            OfertaCredito::create([
                'consulta_credito_id' => $consultaCreditoId,
                'instituicao_financeira' => $oferta['instituicaoFinanceira'],
                'modalidade_credito' => $oferta['modalidadeCredito'],
                'valor_solicitado' => $oferta['valorSolicitado'],
                'valor_pagar' => $oferta['valorAPagar'],
                'taxa_juros' => $oferta['taxaJuros'],
                'quantidade_parcelas' => $oferta['quantidadeParcelas'],
            ]);
        }

        return response()->json(['message' => 'Ofertas de crédito salvas com sucesso']);
    }
}