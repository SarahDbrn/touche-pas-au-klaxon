<?php
return [
    '/' => ['HomeController', 'index'],
    '/login' => ['AuthController', 'login'],
    '/dashboard' => ['DashboardController', 'index'],
    '/trip/edit' => ['TripController', 'edit'],
    '/trip/delete' => ['TripController', 'delete'],
    '/trip/create' => ['TripController', 'create'],

];

