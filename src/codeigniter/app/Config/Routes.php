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

$routes->group('univ', function($routes) {
    $routes->get('master', 'Univ\Master::index');
    
    // Fitur Fakultas
    $routes->post('master/simpanFakultas', 'Univ\Master::simpanFakultas');
    $routes->post('master/editFakultas', 'Univ\Master::editFakultas'); // Tambahkan ini
    $routes->get('master/hapusFakultas/(:any)', 'Univ\Master::hapusFakultas/$1'); // Tambahkan ini

    // Fitur Prodi
    $routes->post('master/simpanProdi', 'Univ\Master::simpanProdi');
    $routes->post('master/editProdi', 'Univ\Master::editProdi'); // Tambahkan ini
    $routes->get('master/hapusProdi/(:any)', 'Univ\Master::hapusProdi/$1'); // Tambahkan ini
});
