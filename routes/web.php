<?php

/** @var \Laravel\Lumen\Routing\Router $router */


$router->get('/', function () {
    return view('consulta-credito.index');
});
// Tratar API
$router->post('/consulta-oferta-credito', 'CreditoController@consultaOfertaCredito');
$router->post('/consulta-instituicao-credito', 'CreditoController@consultaInstituicaoCredito');
$router->post('/detalhamento-oferta-credito', 'CreditoController@detalhamentoOfertaCredito');
$router->post('/ofertas-credito', 'CreditoController@ofertasCredito');

// Rota para salvar os dados das ofertas de crédito
$router->post('/consulta-credito',['as' => 'consulta-credito.store', 'uses' => 'ConsultaCreditoController@store']);