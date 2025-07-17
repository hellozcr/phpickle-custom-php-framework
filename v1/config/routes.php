<?php
// config/routes.php

return [
    // Simple GET route
    ['GET', '/', 'HomeController@index'],

    // Route with parameter (e.g., /about/42)
    ['GET', '/about/(:num)', 'HomeController@about'],

    // POST route example
    ['POST', '/contact', 'HomeController@contact'],

    // Route with optional middleware (future use)
    // ['GET', '/dashboard', 'DashboardController@index', ['auth']],

    // RESTful resource example (expand as needed)
    // ['GET', '/api/users', 'Api\\UserController@index'],
    // ['GET', '/api/users/(:num)', 'Api\\UserController@show'],
    // ['POST', '/api/users', 'Api\\UserController@store'],
    // ['PUT', '/api/users/(:num)', 'Api\\UserController@update'],
    // ['DELETE', '/api/users/(:num)', 'Api\\UserController@destroy'],

    // List all users
    ['GET', '/users', 'HomeController@users'],

    // Show user by ID
    ['GET', '/user/(:num)', 'HomeController@user'],
]; 