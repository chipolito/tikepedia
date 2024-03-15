<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('api', ['namespace' => 'App\Controllers\API'], function($routes) {
    $routes->get('usuario', 'Usuario::read');
    $routes->get('usuario/(:num)', 'Usuario::read/$1');
    $routes->post('usuario/create', 'Usuario::create');
    $routes->put('usuario/update/(:num)', 'Usuario::update/$1');
    $routes->delete('usuario/delete/(:num)', 'Usuario::delete/$1');
    $routes->post('usuario/dologin', 'Usuario::do_login');
});
