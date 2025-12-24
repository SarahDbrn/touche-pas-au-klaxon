<?php

return [
    // Home
    'GET /' => ['HomeController', 'index'],

    // Auth
    'GET /login' => ['AuthController', 'login'],
    'POST /login' => ['AuthController', 'login'],
    'GET /logout' => ['AuthController', 'logout'],
    'POST /logout' => ['AuthController', 'logout'],

    // Dashboard
    'GET /dashboard' => ['DashboardController', 'index'],

    // Trips
    'GET /trip/create' => ['TripController', 'create'],
    'POST /trip/create' => ['TripController', 'create'],
    'GET /trip/edit' => ['TripController', 'edit'],
    'POST /trip/edit' => ['TripController', 'edit'],
    'POST /trip/delete' => ['TripController', 'delete'],

    // Admin
    'GET /admin' => ['AdminController', 'dashboard'],
    'GET /admin/users' => ['AdminController', 'users'],

    'GET /admin/agencies' => ['AdminController', 'agencies'],
    'POST /admin/agencies/create' => ['AdminController', 'createAgency'],
    'GET /admin/agencies/edit' => ['AdminController', 'editAgency'],
    'POST /admin/agencies/update' => ['AdminController', 'updateAgency'],
    'POST /admin/agencies/delete' => ['AdminController', 'deleteAgency'],

    'GET /admin/trips' => ['AdminController', 'trips'],
    'POST /admin/trips/delete' => ['AdminController', 'deleteTrip'],
];
