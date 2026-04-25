<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Noticias::index');
$routes->get('/noticias', 'Noticias::index');
$routes->get('/noticias/mis', 'Noticias::misNoticias');
$routes->get('/noticias/crear', 'Noticias::crear');
$routes->post('/noticias/guardar', 'Noticias::guardar');
$routes->post('/registro', 'Autenticacion::guardar');
$routes->post('/login', 'Autenticacion::validar');
$routes->get('/logout', 'Autenticacion::logout');
$routes->get('reset_password/(:any)', 'Autenticacion::formReset/$1');
$routes->post('reset_password', 'Autenticacion::resetPassword');
$routes->get('recuperar_password', 'Autenticacion::formRecuperar');
$routes->post('recuperar_password', 'Autenticacion::recuperarPassword');
$routes->get('noticias/pendientes', 'Noticias::pendientes');
$routes->get('noticias/detalle/(:num)', 'Noticias::detalle/$1');
$routes->post('noticias/cambiarEstado/(:num)', 'Noticias::cambiarEstado/$1');
$routes->post('noticias/detalle/(:num)', 'Noticias::detalle/$1');
$routes->get('noticias/editar/(:num)', 'Noticias::editar/$1');
$routes->post('noticias/editar/(:num)', 'Noticias::editar/$1');
$routes->post('noticias/guardar/(:num)', 'Noticias::guardar/$1');
$routes->get('/noticias/historial/(:num)', 'Noticias::historial/$1');
$routes->get('noticias/configuracion', 'Noticias::configuracion');
$routes->post('noticias/configuracion/guardar', 'Noticias::guardarConfiguracion');