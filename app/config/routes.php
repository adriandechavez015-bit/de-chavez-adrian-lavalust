<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/** @var object $router **/

$router->get('/', 'Welcome::index');

// Preserved Lab Routes
$router->get('/student', 'StudentController::index');
$router->get('/student/profile', 'StudentController::profile', ['middleware' => ['student']]);
$router->get('/student/clear', 'StudentController::clear');
$router->get('/users', 'UsersController::index');

// Lab Exercise No. 5: Auth Routes
$router->get('/login', 'AuthController::login');
$router->post('/login/submit', 'AuthController::login_submit');
$router->get('/logout', 'AuthController::logout');

// Lab Exercise No. 5: Product CRUD Routes
$router->get('/products', 'ProductController::index');
$router->get('/products/create', 'ProductController::create');
$router->post('/products/store', 'ProductController::store');
$router->get('/products/edit/(:num)', 'ProductController::edit/$1');
$router->post('/products/update/(:num)', 'ProductController::update/$1');
$router->get('/products/delete/(:num)', 'ProductController::delete/$1');