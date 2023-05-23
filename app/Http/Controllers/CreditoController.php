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

        if (empty($cpf)) {
            return response()->json(['message' => 'CPF não fornecido.'], 422);
        }
        // Consulte as ofertas de crédito para o CPF informado
        $ofertas = $this->gosatApi->consultaOfertaCredito($cpf);
        // dd($ofertas);
        // Verifique se há ofertas disponíveis
        if (empty($ofertas['instituicoes'])) {
            return response()->json(['message' => 'Nenhuma oferta de crédito disponível.'], 422);
        }
        $melhoresOfertas = [];
        // Para cada instituição financeira, consulte o detalhamento da oferta de crédito
        foreach ($ofertas['instituicoes'] as $instituicao) {
            foreach ($instituicao['modalidades'] as $modalidade) {
                $Id = [$instituicao['id'], $modalidade['cod']];
                $detalhesOferta = $this->gosatApi->simulacaoOfertaCredito($cpf, $instituicao['id'], $modalidade['cod']);

                // Selecione as melhores ofertas com base nos detalhes da oferta
                $melhoresOfertas = $this->selecionaMelhoresOfertas($detalhesOferta, $instituicao, $modalidade, $melhoresOfertas, $Id);
                // Adicione o valor do atributo "data-instituicao-id" objeto de resposta
            }
        }
        // Ordene as ofertas com relação ao melhor para o cliente
        usort($melhoresOfertas, function ($a, $b) {
            if ($a['taxaJuros'] == $b['taxaJuros']) {
                if ($a['quantidadeParcelas'] == $b['quantidadeParcelas']) {
                    return $b['valorAPagar'] <=> $a['valorAPagar'];
                }
                return $a['quantidadeParcelas'] <=> $b['quantidadeParcelas'];
            }
            return $a['taxaJuros'] <=> $b['taxaJuros'];
        });
        // Selecione até 3 ofertas de crédito
        $melhoresOfertas = array_slice($melhoresOfertas, 0, 3);
        return response()->json($melhoresOfertas);
    }
    public function consultaInstituicaoCredito(Request $request)
    {
        $cpf = $request->input('cpf');

        if (empty($cpf)) {
            return response()->json(['message' => 'CPF não fornecido.'], 422);
        }
        // Consulte as ofertas de crédito para o CPF informado
        $ofertas = $this->gosatApi->consultaOfertaCredito($cpf);

        // Verifique se há ofertas disponíveis
        if (empty($ofertas['instituicoes'])) {
            return response()->json(['message' => 'Nenhuma oferta de crédito disponível.'], 422);
        }

        $instituicoes = [];

        // Para cada instituição financeira, adicione à lista de instituições
        foreach ($ofertas['instituicoes'] as $instituicao) {
            $instituicoes[] = [
                'id' => $instituicao['id'],
                'nome' => $instituicao['nome']
            ];
        }

        return response()->json($instituicoes);
    }

    public function detalhamentoOfertaCredito(Request $request)
    {
        $cpf = $request->input('cpf');
        $instituicaoId = $request->input('instituicaoId');
        $codModalidade = $request->input('modalidadeCod');

        // dd($cpf)
        if (empty($cpf) || empty($instituicaoId) || empty($codModalidade)) {
            return response()->json(['message' => 'CPF, ID da instituição financeira e código da modalidade de crédito são obrigatórios.'], 422);
        }

        // Consulte o detalhamento da oferta de crédito
        $detalhesOferta = $this->gosatApi->simulacaoOfertaCredito($cpf, $instituicaoId, $codModalidade);

        // dd($detalhesOferta);
        // Verifique se as informações gerais das ofertas estão presentes
        if (
            !isset($detalhesOferta['QntParcelaMin']) ||
            !isset($detalhesOferta['QntParcelaMax']) ||
            !isset($detalhesOferta['valorMin']) ||
            !isset($detalhesOferta['valorMax']) ||
            !isset($detalhesOferta['jurosMes'])
        ) {
            return response()->json(['message' => 'Detalhamento da oferta de crédito não encontrado.'], 422);
        }

        $detalhesOfertaFormatado = [
            'valorMin' => $detalhesOferta['valorMin'],
            'valorMax' => $detalhesOferta['valorMax'],
            'jurosMes' => $detalhesOferta['jurosMes'],
            'qntParcelaMin' => $detalhesOferta['QntParcelaMin'],
            'qntParcelaMax' => $detalhesOferta['QntParcelaMax']
        ];

        return response()->json($detalhesOfertaFormatado);
    }
    public function ofertasCredito(Request $request)
    {
        $cpf = $request->input('cpf');

        if (empty($cpf)) {
            return response()->json(['message' => 'CPF não fornecido.'], 422);
        }

        // Consulte as ofertas de crédito para o CPF informado
        $ofertas = $this->gosatApi->consultaOfertaCredito($cpf);

        // Verifique se há ofertas disponíveis
        if (empty($ofertas['instituicoes'])) {
            return response()->json(['message' => 'Nenhuma oferta de crédito disponível.'], 422);
        }

        $todasOfertas = [];

        // Para cada instituição financeira, consulte o detalhamento da oferta de crédito
        foreach ($ofertas['instituicoes'] as $instituicao) {
            foreach ($instituicao['modalidades'] as $modalidade) {
                $detalhesOferta = $this->gosatApi->simulacaoOfertaCredito($cpf, $instituicao['id'], $modalidade['cod']);

                // Adicione a oferta à lista de todas as ofertas
                $todasOfertas[] = [
                    'instituicaoFinanceira' => $instituicao['nome'],
                    'modalidadeCredito' => $modalidade['nome'],
                    'valorMin' => $detalhesOferta['valorMin'],
                    'valorMax' => $detalhesOferta['valorMax'],
                    'jurosMes' => $detalhesOferta['jurosMes'],
                    'qntParcelaMin' => $detalhesOferta['QntParcelaMin'],
                    'qntParcelaMax' => $detalhesOferta['QntParcelaMax']
                ];
            }
        }

        return response()->json($todasOfertas);
    }

    private function selecionaMelhoresOfertas($detalhesOferta, $instituicao, $modalidade, $melhoresOfertas, $Id)
    {

        // Verifique se as informações gerais das ofertas estão presentes
        if (
            !isset($detalhesOferta['QntParcelaMin']) ||
            !isset($detalhesOferta['QntParcelaMax']) ||
            !isset($detalhesOferta['valorMin']) ||
            !isset($detalhesOferta['valorMax']) ||
            !isset($detalhesOferta['jurosMes'])
        ) {
            return $melhoresOfertas;
        }

        // Calcule o valor a pagar com base nas informações gerais das ofertas
        $valorSolicitado = $detalhesOferta['valorMin'];
        $valorAPagar = $valorSolicitado + ($valorSolicitado * $detalhesOferta['jurosMes']);

        $ofertaFormatada = [
            'instituicaoFinanceira' => $instituicao['nome'],
            'modalidadeCredito' => $modalidade['nome'],
            'valorAPagar' => $valorAPagar,
            'valorSolicitado' => $valorSolicitado,
            'taxaJuros' => $detalhesOferta['jurosMes'],
            'quantidadeParcelas' => $detalhesOferta['QntParcelaMax'],
            'Id' => $Id
        ];

        // Adicione a oferta à lista de melhores ofertas
        $melhoresOfertas[] = $ofertaFormatada;

        // dd( $ofertaFormatada);
        return $melhoresOfertas;
    }
}