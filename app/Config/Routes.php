<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/tareas', 'Tareas::index');
$routes->get('/tareas/crear', 'Tareas::crear');
$routes->post('/tareas/guardar', 'Tareas::guardar');
