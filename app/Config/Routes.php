<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('api', ['namespace' => 'App\Controllers\API'], function($routes) {
    $routes->group('usuario', static function ($routes) {
        $routes->get('/', 'Usuario::read');
        $routes->get('(:num)', 'Usuario::read/$1');
        $routes->post('create', 'Usuario::create');
        $routes->put('update/(:num)', 'Usuario::update/$1');
        $routes->delete('delete/(:num)', 'Usuario::delete/$1');
        $routes->post('dologin', 'Usuario::doLogin');
        $routes->post('putavatar', 'Usuario::putAvatar');
    });

    $routes->group('departamento', static function ($routes) {
        $routes->get('/', 'Departamento::read');
        $routes->get('(:num)', 'Departamento::read/$1');
        $routes->post('create', 'Departamento::create');
        $routes->put('update/(:num)', 'Departamento::update/$1');
        $routes->delete('delete/(:num)', 'Departamento::delete/$1');
    });

    $routes->group('organizacion', static function ($routes) {
        $routes->get('/', 'Organizacion::read');
        $routes->get('(:num)', 'Organizacion::read/$1');
        $routes->post('create', 'Organizacion::create');
        $routes->put('update/(:num)', 'Organizacion::update/$1');
        $routes->delete('delete/(:num)', 'Organizacion::delete/$1');
        $routes->post('putlogo', 'Organizacion::putLogo');
    });

    $routes->group('configuracion', static function ($routes) {
        $routes->get('(:any)', 'Configuracion::read/$1');
        $routes->put('update/(:any)', 'Configuracion::update/$1');
    });

    $routes->group('permiso', static function ($routes) {
        $routes->get('/', 'Permiso::read');
        $routes->post('hasPermission', 'Permiso::hasPermission');
        $routes->put('putpermission', 'Permiso::putPermission');
    });
});
