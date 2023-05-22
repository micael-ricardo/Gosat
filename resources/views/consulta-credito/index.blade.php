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
    <script src="js/consultaCredito.js"></script>
@endsection
