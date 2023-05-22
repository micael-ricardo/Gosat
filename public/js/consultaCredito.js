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
                            html += '<b>Instituição Financeira:</b> ' + oferta
                                .instituicaoFinanceira + '<br>';
                            html += '<b>Modalidade de Crédito:</b> ' + oferta
                                .modalidadeCredito + '<br>';
                            html += '<b> Valor a Pagar: </b>' + oferta.valorAPagar + '<br>';
                            html += '<b> Valor Solicitado: </b> ' + oferta.valorSolicitado +
                                '<br>';
                            html += '<b> Taxa de Juros: </b>' + oferta.taxaJuros + '<br>';
                            html += '<b> Quantidade de Parcelas: </b>' + oferta
                                .quantidadeParcelas + '<br>';
                            html += '</li><br>';
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