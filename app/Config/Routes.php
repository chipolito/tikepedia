<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/usuario', 'Usuario::index');

$routes->group('api', ['namespace' => 'App\Controllers\API'], function($routes) {
    $routes->get('usuario', 'Usuario::read');
    $routes->post('usuario/create', 'Usuario::create');
    $routes->put('usuario/update/(:num)', 'Usuario::update/$1');
    $routes->delete('usuario/delete/(:num)', 'Usuario::delete/$1');
});
