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


// Routes untuk role UNIVERSITAS
$routes->group('univ', function($routes) {
    $routes->get('master', 'Univ\Master::index');
    
    // Fitur Fakultas
    $routes->post('master/simpanFakultas', 'Univ\Master::simpanFakultas');
    $routes->post('master/editFakultas', 'Univ\Master::editFakultas'); 
    $routes->get('master/hapusFakultas/(:any)', 'Univ\Master::hapusFakultas/$1');

    // Fitur Prodi
    $routes->post('master/simpanProdi', 'Univ\Master::simpanProdi');
    $routes->post('master/editProdi', 'Univ\Master::editProdi');
    $routes->get('master/hapusProdi/(:any)', 'Univ\Master::hapusProdi/$1');

    // Fitur Unit & Lembaga
    $routes->get('unit', 'Univ\Unit::index');
    $routes->post('unit/simpan', 'Univ\Unit::simpan');
    $routes->post('unit/edit', 'Univ\Unit::edit');
    $routes->get('unit/hapus/(:any)', 'Univ\Unit::hapus/$1');

    // Fitur Periode
    $routes->get('periode', 'Univ\Periode::index');
    $routes->post('periode/simpan', 'Univ\Periode::simpan');
    $routes->get('periode/setAktif/(:num)', 'Univ\Periode::setAktif/$1');
    $routes->get('periode/hapus/(:num)', 'Univ\Periode::hapus/$1');

    // Fitur Master Monev
    $routes->get('monev', 'Univ\Monev::index');
    $routes->post('monev/simpan', 'Univ\Monev::simpan');
    $routes->post('monev/edit', 'Univ\Monev::edit');
    $routes->get('monev/hapus/(:num)', 'Univ\Monev::hapus/$1');

    // Fitur Master Kinerja
    $routes->get('kinerja', 'Univ\Kinerja::index');
    $routes->post('kinerja/simpan', 'Univ\Kinerja::simpan');
    $routes->post('kinerja/edit', 'Univ\Kinerja::edit');
    $routes->get('kinerja/hapus/(:num)', 'Univ\Kinerja::hapus/$1');
});
