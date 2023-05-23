@extends('template/layout')
@section('title', 'Consulta de Crédito')
@section('conteudo')
    <h2 class="display-4">Consulta de Crédito</h2>
    <div class="row col-md-6 mb-2">
        <form id="consulta-form">
            <div class="input-group  ml-3">
                <input type="text" id="cpf" name="cpf" class="form-control  col-sm-4" placeholder="Digite o CPF">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Consultar
                </button>
            </div>
        </form>
    </div>
    <div id="resultado"></div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modal-detalhamento-oferta-credito" tabindex="-1" role="dialog"
        aria-labelledby="modalLabel" aria-hidden="true" role="dialog" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Detalhes da oferta de crédito</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><b>Valor mínimo:</b> <span class="valor-min"></span></p>
                    <p><b>Valor máximo: </b><span class="valor-max"></span></p>
                    <p><b>Juros ao mês: </b><span class="juros-mes"></span></p>
                    <p><b>Quantidade mínima de parcelas:</b> <span class="qnt-parcela-min"></span></p>
                    <p><b>Quantidade máxima de parcelas:</b> <span class="qnt-parcela-max"></span></p>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-md-12">
            <canvas id="myChart"></canvas>
        </div>
    </div> --}}
    <script src="js/consultaCredito.js"></script>
@endsection
