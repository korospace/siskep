<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Dashboard');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// Main Dashboard Page
$routes->get(
    '/', 
    'Dashboard::index', 
    ['filter' => 'Dashboard']
);

// Penempatan
$routes->get(
    '/penempatan', 
    'Dashboard::penempatan', 
    ['filter' => 'Dashboard']
);

// List User Page
$routes->get(
    '/pegawai', 
    'Dashboard::listUsers', 
    ['filter' => 'DashboardAsn']
);

// Surat keputusan Page
$routes->get(
    '/sk', 
    'Dashboard::suratKeputusan', 
    ['filter' => 'Dashboard']
);

// Surat keputusan Page
$routes->get(
    '/tugas', 
    'Dashboard::tugas', 
    ['filter' => 'Dashboard']
);

// Edit profile Page
$routes->get(
    '/update_profile', 
    'Dashboard::updateProfile', 
    ['filter' => 'DashboardNonAsn']
);

// Login & Logout
$routes->group("login", function ($routes) {
    $routes->get(
        '/', 
        'Login::index', 
        ['filter' => 'DashboardLogged']
    );
    $routes->get('show',      'Login::show');  
    $routes->post('create',   'Login::create');
    $routes->delete('delete', 'Login::delete');
});

// crud bagian
$routes->group("bagian", function ($routes) {
    $routes->get(
        'show', 
        'Bagian::show', 
        ['filter' => 'ApiGuardAdmin']
    );
    $routes->get(
        'detail/(:any)', 
        'Bagian::detail/$1', 
        ['filter' => 'ApiGuard']
    );
    $routes->post(
        'create', 
        'Bagian::create', 
        ['filter' => 'ApiGuardAdmin']
    );
    $routes->put(
        'update', 
        'Bagian::update', 
        ['filter' => 'ApiGuardAdmin']
    );
    $routes->delete(
        'delete/(:any)', 
        'Bagian::delete/$1', 
        ['filter' => 'ApiGuardAdmin']
    );
});

// crud Subagian
$routes->group("subagian", function ($routes) {
    $routes->get(
        'show', 
        'Subagian::show', 
        ['filter' => 'ApiGuardAdminKabag']
    );
    $routes->get(
        'detail/(:any)', 
        'Subagian::detail/$1', 
        ['filter' => 'ApiGuard']
    );
    $routes->post(
        'create', 
        'Subagian::create', 
        ['filter' => 'ApiGuardAdmin']
    );
    $routes->put(
        'update', 
        'Subagian::update', 
        ['filter' => 'ApiGuardAdmin']
    );
    $routes->delete(
        'delete/(:any)', 
        'Subagian::delete/$1', 
        ['filter' => 'ApiGuardAdmin']
    );
});

// crud kedudukan
$routes->group("kedudukan", function ($routes) {
    $routes->get(
        'show', 
        'Kedudukan::show', 
        ['filter' => 'ApiGuard']
    );
    $routes->post(
        'create', 
        'Kedudukan::create', 
        ['filter' => 'ApiGuardAdmin']
    );
    $routes->put(
        'update', 
        'Kedudukan::update', 
        ['filter' => 'ApiGuardAdmin']
    );
    $routes->delete(
        'delete/(:any)', 
        'Kedudukan::delete/$1', 
        ['filter' => 'ApiGuardAdmin']
    );
});

// crud user
$routes->group("user", function ($routes) {
    $routes->get(
        'previlege', 
        'Users::getPrevilege', 
        ['filter' => 'ApiGuardAsn']
    );
    $routes->get(
        'profile', 
        'Users::getProfile', 
        ['filter' => 'ApiGuard']
    );
    $routes->get(
        'show', 
        'Users::show', 
        ['filter' => 'ApiGuardAsn']
    );
    $routes->get(
        'xlsx', 
        'Users::xlsxUsers', 
        ['filter' => 'ApiGuardAsn']
    );
    $routes->post(
        'create', 
        'Users::create', 
        ['filter' => 'ApiGuardAsn']
    );
    $routes->put(
        'update/(:any)', 
        'Users::update/$1', 
        ['filter' => 'ApiGuardAsn']
    );
    $routes->put(
        'update_profile', 
        'Users::updateProfile', 
        ['filter' => 'ApiGuard']
    );
    $routes->delete(
        'delete/(:any)', 
        'Users::delete/$1', 
        ['filter' => 'ApiGuardAsn']
    );
});

// crud Surat Keputusan
$routes->group("sk", function ($routes) {
    $routes->get(
        'show', 
        'SuratKeputusan::show',
        ['filter' => 'ApiGuard']
    );
    $routes->post(
        'create', 
        'SuratKeputusan::create', 
        ['filter' => 'ApiGuardAsn']
    );
    $routes->delete(
        'delete/(:any)', 
        'SuratKeputusan::delete/$1', 
        ['filter' => 'ApiGuardAsn']
    );
});

// crud Tugas
$routes->group("tugas", function ($routes) {
    $routes->get(
        'show', 
        'Tugas::show',
        ['filter' => 'ApiGuard']
    );
    $routes->get(
        'show/(:any)', 
        'Tugas::show/$1', 
        ['filter' => 'ApiGuard']
    );
    $routes->post(
        'create', 
        'Tugas::create', 
        ['filter' => 'ApiGuard']
    );
    $routes->put(
        'update/(:any)', 
        'Tugas::update/$1', 
        ['filter' => 'ApiGuard']
    );
    $routes->delete(
        'delete_file/(:any)', 
        'Tugas::deleteFile/$1', 
        ['filter' => 'ApiGuard']
    );
    $routes->delete(
        'delete/(:any)', 
        'Tugas::delete/$1', 
        ['filter' => 'ApiGuard']
    );
});

// crud Information
$routes->group("information", function ($routes) {
    $routes->get(
        'show', 
        'Information::show'
    );
    $routes->put(
        'update', 
        'Information::update', 
        ['filter' => 'ApiGuardAdmin']
    );
});

// not found
$routes->add('(:any)', function () {
    return view("errors/html/error_404.php");
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
