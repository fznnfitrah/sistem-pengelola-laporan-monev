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


// Routes untuk profil user
$routes->group('profile', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Profile::index');
    $routes->get('edit', 'Profile::edit');
    $routes->post('update', 'Profile::update');
});


// ROUTES UNTUK ROLE ADMIN
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


// ROUTES UNTUK ROLE PRODI
$routes->group('prodi', ['namespace' => 'App\Controllers\Prodi'], function ($routes) {
    // ROUTES UNTUK MONEV
    $routes->get('laporan/history', 'Laporan::history');
    $routes->get('laporan/input', 'Laporan::input');
    $routes->post('laporan/save', 'Laporan::save');

    // ROUTES UNTUK KINERJA PRODI
    $routes->get('kinerja/input', 'KinerjaProdiUnit::index');
    $routes->post('kinerja/save', 'KinerjaProdiUnit::save');

    // ROUTES UNTUK AKREDITASI PRODI
    $routes->get('akreditasi/index', 'Akreditasi::index');
    $routes->get('akreditasi/new', 'Akreditasi::new');
    $routes->post('akreditasi/create', 'Akreditasi::create');
});

// ROUTES UNTUK ROLE UNIT
$routes->group('unit', ['namespace' => 'App\Controllers\Unit'], function ($routes) {

    // Laporan Monev
    $routes->get('laporan/input', 'Laporan::input');
    $routes->post('laporan/save', 'Laporan::save');
    $routes->get('laporan/history', 'Laporan::history');

    // Kinerja
    $routes->get('kinerja/input', 'KinerjaProdiUnit::index');
    $routes->post('kinerja/save', 'KinerjaProdiUnit::save');
});



// ROUTES UNTUK ROLE UNIVERSITAS
$routes->group('univ', ['namespace' => 'App\Controllers\Univ'], function ($routes) {
    $routes->get('master', 'Master::index');

    // Fitur Fakultas
    $routes->post('master/simpanFakultas', 'Master::simpanFakultas');
    $routes->post('master/editFakultas', 'Master::editFakultas');
    $routes->get('master/hapusFakultas/(:any)', 'Master::hapusFakultas/$1');

    // Fitur Prodi
    $routes->post('master/simpanProdi', 'Master::simpanProdi');
    $routes->post('master/editProdi', 'Master::editProdi');
    $routes->get('master/hapusProdi/(:any)', 'Master::hapusProdi/$1');

    // Fitur Unit & Lembaga
    $routes->get('unit', 'Unit::index');
    $routes->post('unit/simpan', 'Unit::simpan');
    $routes->post('unit/edit', 'Unit::edit');
    $routes->get('unit/hapus/(:any)', 'Unit::hapus/$1');

    // Fitur Periode
    $routes->get('periode', 'Periode::index');
    $routes->post('periode/simpan', 'Periode::simpan');
    $routes->get('periode/setAktif/(:num)', 'Periode::setAktif/$1');
    $routes->get('periode/hapus/(:num)', 'Periode::hapus/$1');

    // Fitur Master Monev
    $routes->get('monev', 'Monev::index');
    $routes->post('monev/simpan', 'Monev::simpan');
    $routes->post('monev/edit', 'Monev::edit');
    $routes->get('monev/hapus/(:num)', 'Monev::hapus/$1');

    // Fitur Master Kinerja
    $routes->get('kinerja', 'Kinerja::index');
    $routes->post('kinerja/simpan', 'Kinerja::simpan');
    $routes->post('kinerja/edit', 'Kinerja::edit');
    $routes->get('kinerja/hapus/(:num)', 'Kinerja::hapus/$1');

    // Fitur Monitoring Laporan
    $routes->get('monitoring', 'Monitoring::index');

    //Monitoring Akreditasi
    $routes->get('monitoring/akreditasi', 'MonitoringAkreditasi::index');

    // Fitur Jenjang Prodi
    $routes->get('jenjang', 'Jenjang::index');
    $routes->post('jenjang/simpan', 'Jenjang::simpan');
    $routes->post('jenjang/edit', 'Jenjang::edit');
    $routes->get('jenjang/hapus/(:num)', 'Jenjang::hapus/$1');

    // Fitur Lembaga Akreditasi
    $routes->get('lembaga_akreditasi', 'LembagaAkreditasi::index');
    $routes->post('lembaga_akreditasi/simpan', 'LembagaAkreditasi::simpan');
    $routes->post('lembaga_akreditasi/edit', 'LembagaAkreditasi::edit');
    $routes->get('lembaga_akreditasi/hapus/(:num)', 'LembagaAkreditasi::hapus/$1');
});


// ROUTES UNTUK ROLE FAKULTAS
$routes->group('fakultas', function ($routes) {
    $routes->get('dashboard', 'Fakultas\Dashboard::index');
    $routes->get('laporan/input', 'Fakultas\Laporan::input');
    $routes->post('laporan/simpan', 'Fakultas\Laporan::simpan');
    $routes->get('laporan/history', 'Fakultas\Laporan::history');
    $routes->get('monitoring', 'Fakultas\Monitoring::index');
});
