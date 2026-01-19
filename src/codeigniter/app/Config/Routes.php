<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Dashboard::index');
$routes->get('dashboard', 'Dashboard::index');
$routes->get('login', 'Auth::index');
$routes->post('auth/login', 'Auth::login');
$routes->get('auth/logout', 'Auth::logout');
$routes->get('auth/switch/(:num)', 'Auth::switch/$1');

// app/admin/roles
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('roles', 'Roles::index');     // Menampilkan tabel ini
    $routes->get('roles/add', 'Roles::add');   // Menampilkan form tambah
    $routes->post('roles/save', 'Roles::save'); // Proses simpan
    $routes->delete('roles/(:num)', 'Roles::delete/$1'); // Proses hapus
    $routes->get('roles/edit/(:num)', 'Roles::edit/$1'); // Menampilkan form edit
    $routes->put('roles/(:num)', 'Roles::update/$1'); //
});
