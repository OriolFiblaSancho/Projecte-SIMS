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
$router->get('/vehicles/delete/:id', 'vehicleController@delete');
$router->get('/main?admin=ViewVehicle&id=:id', 'vehicleController@view');

// Geofencing CRUD
$router->get('/geofencing', 'geofencingController@getAll');
$router->get('/geofencing/create', 'geofencingController@create');
$router->post('/geofencing/store', 'geofencingController@store');
$router->get('/geofencing/view/:id', 'geofencingController@view');
$router->get('/geofencing/edit/:id', 'geofencingController@edit');
$router->post('/geofencing/update', 'geofencingController@update');
$router->get('/geofencing/delete/:id', 'geofencingController@delete');