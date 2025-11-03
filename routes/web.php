<?php
/**
 * ROUTES - Definició de totes les rutes de l'aplicació
 * 
 * Format: $router->METHOD('url', 'Controller@method');
 */

// Pàgines
$router->get('/', 'PageController@landing');
$router->get('/main', 'PageController@main');

// Vehicles
$router->post('/vehicles/create', 'vehicleController@create');
