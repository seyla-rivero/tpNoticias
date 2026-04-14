<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/noticias', 'Noticias::index');
$routes->get('/noticias/crear', 'Noticias::crear');
$routes->post('/noticias/guardar', 'Noticias::guardar');
