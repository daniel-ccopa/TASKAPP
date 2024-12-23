<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('AuthController');
$routes->setDefaultMethod('login');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// Authentication routes
$routes->get('/login', 'AuthController::login'); // Show login form
$routes->post('/login', 'AuthController::authenticate'); // Handle login form submission
$routes->get('/logout', 'AuthController::logout'); // Handle logout
$routes->get('/register', 'AuthController::register'); // Show register form
$routes->post('/register', 'AuthController::store'); // Handle register form submission

// Task management routes (protected by 'auth' filter)
$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/dashboard', 'TaskController::index'); // Show task list (dashboard)
    $routes->get('/tasks/create', 'TaskController::create'); // Show task creation form
    $routes->post('/tasks/store', 'TaskController::store'); // Handle task creation
    $routes->get('/tasks/edit/(:num)', 'TaskController::edit/$1'); // Show task editing form
    $routes->post('/tasks/update/(:num)', 'TaskController::update/$1'); // Handle task update
    $routes->get('/tasks/delete/(:num)', 'TaskController::delete/$1'); // Handle task deletion

    // Chat integration
    $routes->post('/chat/sendMessage', 'ChatController::sendMessage'); // Send message to ChatGPT

    $routes->get('/api/dni/(:num)', 'DniController::lookup/$1');
});

// Admin routes (protected by 'admin' filter)
$routes->group('admin', ['filter' => 'admin'], function ($routes) {
    $routes->get('', 'AdminController::index'); // Página principal del panel del administrador
    $routes->get('/users', 'AdminController::index'); // Lista todos los usuarios
    $routes->get('/users/edit/(:num)', 'AdminController::edit/$1'); // Mostrar formulario para editar un usuario
    $routes->post('/users/update/(:num)', 'AdminController::update/$1'); // Manejar actualización de un usuario
    $routes->get('/users/delete/(:num)', 'AdminController::delete/$1'); // Manejar eliminación de un usuario
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * Environment-based routing can be loaded here. You have access to the
 * $routes object within that file without needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
