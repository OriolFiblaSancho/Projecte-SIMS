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
$router->post('/vehicles/update', 'vehicleController@update');
$router->get('/vehicles/delete/:id', 'vehicleController@delete');
$router->get('/main?admin=ViewVehicle&id=:id', 'vehicleController@view');
$router->get('/api/vehicles/locations', 'vehicleController@getVehiclesWithLocations');

// Users
$router->post('/users/create', 'userController@create');
$router->post('/users/update/:id', 'userController@update');
$router->get('/users/delete/:id', 'userController@delete');

#Menu settings user
$router->post('/settings/save', 'userSettingsController@save');