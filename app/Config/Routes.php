<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Noticias::index');
$routes->get('/noticias', 'Noticias::index');
$routes->get('/noticias/crear', 'Noticias::crear');
$routes->post('/noticias/guardar', 'Noticias::guardar');
$routes->get('/registro', 'Autenticacion::registro');
$routes->post('/registro', 'Autenticacion::guardar');
$routes->get('/login', 'Autenticacion::login');
$routes->post('/login', 'Autenticacion::validar');
$routes->get('/logout', 'Autenticacion::logout');
