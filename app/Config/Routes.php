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

    $routes->group('prioridad', static function ($routes) {
        $routes->get('/', 'Prioridad::read');
        $routes->get('(:num)', 'Prioridad::read/$1');
        $routes->post('create', 'Prioridad::create');
        $routes->put('update/(:num)', 'Prioridad::update/$1');
        $routes->delete('delete/(:num)', 'Prioridad::delete/$1');
    });

    $routes->group('sla', static function ($routes) {
        $routes->get('/', 'Sla::read');
        $routes->get('(:num)', 'Sla::read/$1');
        $routes->post('create', 'Sla::create');
        $routes->put('update/(:num)', 'Sla::update/$1');
        $routes->delete('delete/(:num)', 'Sla::delete/$1');
    });

    $routes->group('tema', static function ($routes) {
        $routes->get('/', 'Temaayuda::read');
        $routes->get('(:num)', 'Temaayuda::read/$1');
        $routes->post('create', 'Temaayuda::create');
        $routes->put('update/(:num)', 'Temaayuda::update/$1');
        $routes->delete('delete/(:num)', 'Temaayuda::delete/$1');
    });

    $routes->group('ticket', static function ($routes) {
        $routes->get('/', 'Ticket::read');
        $routes->get('(:num)', 'Ticket::read/$1');
        $routes->post('create', 'Ticket::create');
        $routes->put('update/(:num)', 'Ticket::update/$1');
        $routes->delete('delete/(:num)', 'Ticket::delete/$1');
        $routes->post('putevidencia', 'Ticket::putEvidencia');
    });

    $routes->group('historia', static function ($routes) {
        $routes->get('(:num)', 'Historia::read/$1');
        $routes->post('create', 'Historia::create');
        $routes->put('update/(:num)', 'Historia::update/$1');
        $routes->delete('delete/(:num)', 'Historia::delete/$1');
        $routes->post('putevidencia', 'Historia::putEvidencia');
    });
});

$routes->get('/', 'Control::login', ["filter" => "noauth"]);
$routes->get('login', 'Control::login', ["filter" => "noauth"]);
$routes->get('logout', 'Control::logout');

$routes->group('agente', ["filter" => "auth"], function ($routes) {
    $routes->get('/', 'Agente::index');
});

$routes->group('cliente', ["filter" => "auth"], function ($routes) {
    $routes->get('/', 'Cliente::index');
    $routes->get('tickets_nuevos', 'Cliente::ticketsNuevos');
    $routes->get('tickets_sin_atencion', 'Cliente::ticketsSinAtencion');
    $routes->get('tickets_en_proceso', 'Cliente::ticketsEnProceso');
    $routes->get('tickets_atrasados', 'Cliente::ticketsAtrasados');
});