<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/consulta-oferta-credito', 'CreditoController@consultaOfertaCredito');

$router->post('/consulta-instituicao-credito', 'CreditoController@consultaInstituicaoCredito');

$router->post('/detalhamento-oferta-credito', 'CreditoController@detalhamentoOfertaCredito');

$router->post('/ofertas-credito', 'CreditoController@ofertasCredito');
