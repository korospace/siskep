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

// Dashboard
$routes->get(
    '/', 
    'Dashboard::index', 
    ['filter' => 'DashboardGuard']
);

// Edit profile
$routes->get(
    '/update_profile', 
    'Dashboard::updateProfile', 
    ['filter' => 'DashboardGuard']
);

// Login & Logout
$routes->group("login", function ($routes) {
    $routes->get(
        '/', 
        'Login::index', 
        ['filter' => 'LoggedGuard']
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
        ['filter' => 'AdminApiGuard']
    );
    $routes->post(
        'create', 
        'Bagian::create', 
        ['filter' => 'AdminApiGuard']
    );
    $routes->delete(
        'delete/(:any)', 
        'Bagian::delete/$1', 
        ['filter' => 'AdminApiGuard']
    );
});

// crud Subagian
$routes->group("subagian", function ($routes) {
    $routes->get(
        'show', 
        'Subagian::show', 
        ['filter' => 'NonPegawaiApiGuard']
    );
    $routes->post(
        'create', 
        'Subagian::create', 
        ['filter' => 'NonPegawaiApiGuard']
    );
    $routes->delete(
        'delete/(:any)', 
        'Subagian::delete/$1', 
        ['filter' => 'NonPegawaiApiGuard']
    );
});

// crud user
$routes->group("user", function ($routes) {
    $routes->get(
        'previlege', 
        'Users::getPrevilege', 
        ['filter' => 'AdminKabagApiGuard']
    );
    $routes->get(
        'profile', 
        'Users::getProfile', 
        ['filter' => 'ApiGuard']
    );
    $routes->get(
        'show', 
        'Users::show', 
        ['filter' => 'NonPegawaiApiGuard']
    );
    $routes->get(
        'show/(:any)', 
        'Users::show/$1', 
        ['filter' => 'NonPegawaiApiGuard']
    );
    $routes->post(
        'create', 
        'Users::create', 
        ['filter' => 'NonPegawaiApiGuard']
    );
    $routes->put(
        'update/(:any)', 
        'Users::update/$1', 
        ['filter' => 'NonPegawaiApiGuard']
    );
    $routes->put(
        'update_profile', 
        'Users::updateProfile', 
        ['filter' => 'ApiGuard']
    );
    $routes->delete(
        'delete/(:any)', 
        'Users::delete/$1', 
        ['filter' => 'NonPegawaiApiGuard']
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
