<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');

//aut login//
$routes->get('/', 'Auth::login');
$routes->post('/login/process', 'Auth::process');
$routes->get('/logout', 'Auth::logout');

$routes->get('/admin/dashboard', 'Admin\AdminController::dashboard');
$routes->get('/kasir/dashboard', 'Kasir\KasirController::dashboard');
$routes->get('/owner/dashboard', 'Owner\OwnerController::dashboard');

//users
$routes->get('/admin/user', 'Admin\UserController::index');

$routes->get('/admin/user/create', 'Admin\UserController::create');

$routes->post('/admin/user/store', 'Admin\UserController::store');

$routes->get('/admin/user/delete/(:num)', 'Admin\UserController::delete/$1');

//admin

$routes->get('/admin/user', 'Admin\UserController::index');

$routes->get('/admin/user/create', 'Admin\UserController::create');

$routes->post('/admin/user/store', 'Admin\UserController::store');

$routes->get('/admin/user/edit/(:num)', 'Admin\UserController::edit/$1');

$routes->post('/admin/user/update/(:num)', 'Admin\UserController::update/$1');

$routes->get('/admin/user/delete/(:num)', 'Admin\UserController::delete/$1');
//kamar//
$routes->group('admin', function($routes) {
    $routes->get('kamar', 'Admin\KamarController::index');
    $routes->get('kamar/create', 'Admin\KamarController::create');
    $routes->post('kamar/store', 'Admin\KamarController::store');
    $routes->get('kamar/edit/(:num)', 'Admin\KamarController::edit/$1');
    $routes->post('kamar/update/(:num)', 'Admin\KamarController::update/$1');
    $routes->get('kamar/delete/(:num)', 'Admin\KamarController::delete/$1');
});


//tipe
$routes->group('admin', function($routes) {
    $routes->get('tipe', 'Admin\TipeController::index');
    $routes->get('tipe/create', 'Admin\TipeController::create');
    $routes->post('tipe/store', 'Admin\TipeController::store');
    $routes->get('tipe/edit/(:num)', 'Admin\TipeController::edit/$1');
    $routes->post('tipe/update/(:num)', 'Admin\TipeController::update/$1');
    $routes->get('tipe/delete/(:num)', 'Admin\TipeController::delete/$1');
});