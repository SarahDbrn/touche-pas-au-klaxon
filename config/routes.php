<?php
return [
    '/' => ['HomeController', 'index'],
    '/login' => ['AuthController', 'login'],
    '/dashboard' => ['DashboardController', 'index'],
    '/trip/edit' => ['TripController', 'edit'],
    '/trip/delete' => ['TripController', 'delete'],
    '/trip/create' => ['TripController', 'create'],

];

// Admin
$router->get('/admin', 'AdminController@dashboard');
$router->get('/admin/users', 'AdminController@users');

$router->get('/admin/agencies', 'AdminController@agencies');
$router->post('/admin/agencies/create', 'AdminController@createAgency');
$router->get('/admin/agencies/edit', 'AdminController@editAgency');     // ?id=...
$router->post('/admin/agencies/update', 'AdminController@updateAgency'); // POST
$router->post('/admin/agencies/delete', 'AdminController@deleteAgency'); // POST

$router->get('/admin/trips', 'AdminController@trips');
$router->post('/admin/trips/delete', 'AdminController@deleteTrip');     // POST


