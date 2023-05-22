$(document).ready(function () {
    $('#consulta-form').submit(function (event) {
        event.preventDefault();

        var cpf = $('#cpf').val();
        if (!cpf) {
            $('#resultado').html('<p>CPF não fornecido.</p>');
            return;
        }
        // Html tela Consultar Credito
        $.ajax({
            url: '/consulta-oferta-credito',
            type: 'POST',
            dataType: 'json',
            data: {
                cpf: cpf
            },
            success: function (response) {
                if (response.length === 0) {
                    $('#resultado').html(
                        '<p>Nenhuma oferta de crédito disponível.</p>');
                } else {
                    var html = '<div class="text-center mt-4 mb-4"><h4>Melhores Ofertas de Crédito</h4></div>';
                    html += '<div class="row">';

                    for (var key in response) {
                        if (response.hasOwnProperty(key)) {
                            var oferta = response[key];
                            html += '<div class="col-md-4">';
                            html += '<div class="card" data-index="' + key + '" data-instituicao-id="' + oferta.Id[0] + '" data-modalidade-id="' + oferta.Id[1] + '">';
                            html += '<div class="card-body">';
                            html += '<h5 class="card-title">' + oferta.instituicaoFinanceira + '</h5>';
                            html += '<p class="card-text"><b>Modalidade de Crédito:</b> ' + oferta.modalidadeCredito + '</p>';
                            html += '<p class="card-text"><b>Valor a Pagar:</b> ' + oferta.valorAPagar.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }) + '</>';
                            html += '<p class="card-text"><b>Valor Solicitado:</b> ' + oferta.valorSolicitado.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }) + '</p>';
                            html += '<p class="card-text"><b>Taxa de Juros:</b> ' + oferta.taxaJuros + '</p>';
                            html += '<p class="card-text"><b>Quantidade de Parcelas:</b> ' + oferta.quantidadeParcelas + '</p>';
                            html += '</div>';
                            html += '</div>';
                            html += '</div>';
                        }
                    }
                    html += '</div>';

                    $('#resultado').html(html);

                    // Insere os dados de detalhamento da oferts de credito apos o click
                    $('.card').click(function () {
                        var instituicaoId = $(this).data('instituicao-id');
                        var modalidadeId = $(this).data('modalidade-id');
                        $.ajax({
                            url: '/detalhamento-oferta-credito',
                            type: 'POST',
                            data: {
                                cpf: cpf,
                                instituicaoId: instituicaoId,
                                modalidadeCod: modalidadeId
                            },
                            success: function (response) {
                                // Abre o modal com os dados detalhados
                                console.log(response);
                                // Exibe os detalhes da oferta de crédito na página
                                // $('#detalhes-oferta-credito').html(response);
                            },
                            error: function () {
                                alert('Erro ao obter detalhes da oferta de crédito.');
                            }
                        });
                    });
                    // Cor de fundo para quando passar o mouse por cima
                    $('.card').mouseover(function () {
                        $(this).css('background-color', 'lightgray');
                    });
                    $('.card').mouseout(function () {
                        $(this).css('background-color', 'white');
                    });

                    // Envia os dados das ofertas de crédito para salvar no banco
                    $.ajax({
                        url: '/consulta-credito',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            cpf: cpf,
                            ofertas: Object.values(response) // Converte o objeto em um array de valores
                        },
                        success: function (response) {
                            console.log(
                                'Dados das ofertas de crédito foram salvos com sucesso!'
                            );
                        },
                        error: function (xhr, status, error) {
                            console.log(
                                'Erro ao salvar os dados das ofertas de crédito: ' +
                                error);
                        }
                    });
                }
            },
            // Caso digite cpf errado ou faltando digito entra nesse erro
            error: function (xhr, status, error) {
                var message = 'Ocorreu um erro na consulta: ' + xhr.responseJSON
                    .message;
                $('#resultado').html('<p>' + message + '</p>');
            }
        });
    });
});
// Mascara para o campo Input cpf
$('#cpf').inputmask('999.999.999-99');