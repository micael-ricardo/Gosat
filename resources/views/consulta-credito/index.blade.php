<!DOCTYPE html>
<html>

<head>
    <title>Consulta de Oferta de Crédito</title>
</head>

<body>
    <h1>Consulta de Crédito</h1>
    <form id="consulta-form">
        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf">
        <button type="submit">Consultar</button>
    </form>

    <div id="resultado"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#consulta-form').submit(function(event) {
                event.preventDefault();

                var cpf = $('#cpf').val();

                if (!cpf) {
                    $('#resultado').html('<p>CPF não fornecido.</p>');
                    return;
                }

                $.ajax({
                    url: '/consulta-oferta-credito',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        cpf: cpf
                    },
                    success: function(response) {
                        if (response.length === 0) {
                            $('#resultado').html(
                            '<p>Nenhuma oferta de crédito disponível.</p>');
                        } else {
                            var html = '<h2>Melhores Ofertas de Crédito</h2>';
                            html += '<ul>';

                            for (var key in response) {
                                if (response.hasOwnProperty(key)) {
                                    var oferta = response[key];
                                    html += '<li>';
                                    html += 'Instituição Financeira: ' + oferta
                                        .instituicaoFinanceira + '<br>';
                                    html += 'Modalidade de Crédito: ' + oferta
                                        .modalidadeCredito + '<br>';
                                    html += 'Valor a Pagar: ' + oferta.valorAPagar + '<br>';
                                    html += 'Valor Solicitado: ' + oferta.valorSolicitado +
                                        '<br>';
                                    html += 'Taxa de Juros: ' + oferta.taxaJuros + '<br>';
                                    html += 'Quantidade de Parcelas: ' + oferta
                                        .quantidadeParcelas + '<br>';
                                    html += '</li>';
                                }
                            }

                            html += '</ul>';

                            $('#resultado').html(html);

                            // Envia os dados das ofertas de crédito para salvar no banco
                            $.ajax({
                                url: '/consulta-credito',
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                    cpf: cpf,
                                    ofertas: Object.values(
                                        response) // Converte o objeto em um array de valores
                                },
                                success: function(response) {
                                    console.log(
                                        'Dados das ofertas de crédito foram salvos com sucesso!'
                                        );
                                },
                                error: function(xhr, status, error) {
                                    console.log(
                                        'Erro ao salvar os dados das ofertas de crédito: ' +
                                        error);
                                }
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        var message = 'Ocorreu um erro na consulta: ' + xhr.responseJSON
                        .message;
                        $('#resultado').html('<p>' + message + '</p>');
                    }
                });
            });
        });
    </script>


</body>

</html>
