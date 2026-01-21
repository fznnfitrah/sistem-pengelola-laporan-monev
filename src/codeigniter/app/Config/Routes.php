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



$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
    // ROUTES UNTUK ROLES
    $routes->get('roles', 'Roles::index');
    $routes->get('roles/add', 'Roles::add');
    $routes->post('roles/save', 'Roles::save');
    $routes->delete('roles/(:num)', 'Roles::delete/$1');
    $routes->get('roles/edit/(:num)', 'Roles::edit/$1');
    $routes->put('roles/(:num)', 'Roles::update/$1');

    // ROUTES UNTUK USERS
    $routes->get('users', 'Users::index');
    $routes->get('users/add', 'Users::add');
    $routes->post('users/save', 'Users::save');
    $routes->delete('users/(:num)', 'Users::delete/$1');
    $routes->get('users/edit/(:num)', 'Users::edit/$1');
    $routes->put('users/(:num)', 'Users::update/$1');
});




// Routes untuk role prodi
$routes->group('prodi', ['namespace' => 'App\Controllers\Prodi'], function ($routes) {
    // ROUTES UNTUK MONEV
    $routes->get('laporan/history', 'Laporan::history');
    $routes->get('laporan/input', 'Laporan::input');
    $routes->post('laporan/save', 'Laporan::save');
    $routes->get('laporan/detail/(:num)', 'Laporan::detail/$1');
});



// Routes untuk role universitas
$routes->group('univ', function ($routes) {
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


// Routes untuk role fakultas
$routes->group('fakultas', function($routes) {
    $routes->get('dashboard', 'Fakultas\Dashboard::index');
    $routes->get('laporan/input', 'Fakultas\Laporan::input');
    $routes->post('laporan/simpan', 'Fakultas\Laporan::simpan');
    $routes->get('laporan/history', 'Fakultas\Laporan::history');
});
