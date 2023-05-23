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
                            html += '<p class="card-text"><b>Valor a Pagar:</b> ' + oferta.valorAPagar.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }) + '</p>';
                            html += '<p class="card-text"><b>Valor Solicitado:</b> ' + oferta.valorSolicitado.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }) + '</p>';
                            html += '<p class="card-text"><b>Taxa de Juros:</b> ' + oferta.taxaJuros + '</p>';
                            html += '<p class="card-text"><b>Quantidade de Parcelas:</b> ' + oferta.quantidadeParcelas + '</p>';
                            html += '<div class="card-info" style="display: none;">';
                            html += '<b>Clique para mais detalhes!</b> ';
                            html += '</div>';
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

                                $('#modal-detalhamento-oferta-credito .valor-min').text(response.valorMin.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }));
                                $('#modal-detalhamento-oferta-credito .valor-max').text(response.valorMax.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }));
                                $('#modal-detalhamento-oferta-credito .juros-mes').text(response.jurosMes);
                                $('#modal-detalhamento-oferta-credito .qnt-parcela-min').text(response.qntParcelaMin);
                                $('#modal-detalhamento-oferta-credito .qnt-parcela-max').text(response.qntParcelaMax);
                                $('#modal-detalhamento-oferta-credito').modal('show');

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
                        $(this).find('.card-info').show();
                        $(this).css('background-color', 'lightgray');
                    });
                    $('.card').mouseout(function () {
                        $(this).find('.card-info').hide();
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
            // Caso digite cpf faltando digito entra nesse erro
            error: function (xhr, status, error) {
                var message = 'Ocorreu um erro na consulta: ' + xhr.responseJSON
                    .message;
                $('#resultado').html('<p>' + message + '</p>');
            }            
        });
    });
});

// Extrai os dados necessários para o gráfico do HTML
var ofertas = [];
$('.card').each(function() {
  var oferta = {
    instituicao: $(this).find('.card-title').text(),
    valorAPagar: parseFloat($(this).find('.card-text:eq(2)').text().replace('Valor a Pagar: ', '').replace(',', '').replace('R$', '')),
    taxaJuros: parseFloat($(this).find('.card-text:eq(3)').text().replace('Taxa de Juros: ', '').replace('%', ''))
  };
  ofertas.push(oferta);
});

// Ordena as ofertas com base no valor a pagar (do menor para o maior)
ofertas.sort(function(a, b) {
  return a.valorAPagar - b.valorAPagar;
});

// Prepara os dados para o gráfico
var instituicoes = ofertas.map(function(oferta) {
  return oferta.instituicao;
});
var valoresAPagar = ofertas.map(function(oferta) {
  return oferta.valorAPagar;
});
var taxasJuros = ofertas.map(function(oferta) {
  return oferta.taxaJuros;
});

// Cria o gráfico usando o Chart.js
// var ctx = document.getElementById('myChart').getContext('2d');
// var myChart = new Chart(ctx, {
//   type: 'bar',
//   data: {
//     labels: instituicoes,
//     datasets: [{
//       label: 'Valor a Pagar',
//       data: valoresAPagar,
//       backgroundColor: 'rgba(75, 192, 192, 0.2)',
//       borderColor: 'rgba(75, 192, 192, 1)',
//       borderWidth: 1
//     }, {
//       label: 'Taxa de Juros',
//       data: taxasJuros,
//       backgroundColor: 'rgba(255, 99, 132, 0.2)',
//       borderColor: 'rgba(255, 99, 132, 1)',
//       borderWidth: 1
//     }]
//   },
//   options: {
//     scales: {
//       y: {
//         beginAtZero: true,
//         ticks: {
//           callback: function(value) {
//             if (this.label.includes('Valor a Pagar')) {
//               return 'R$' + value.toLocaleString('pt-BR');
//             } else if (this.label.includes('Taxa de Juros')) {
//               return value + '%';
//             }
//             return value;
//           }
//         }
//       }
//     }
//   }
// });


// Mascara para o campo Input cpf
$('#cpf').inputmask('999.999.999-99');

