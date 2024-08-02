<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('admin', static function ($routes) {
    $routes->group('', ['filter' => 'cifilter:auth'], static function ($routes) {
        //$routes->view('example-page','example-page');
        $routes->get('home', 'AdminController::index', ['as' => 'admin.home']);
       
        

    });


    $routes->group('roles', ['filter' => 'cifilter:auth'], function ($routes) {
        $routes->get('/', 'RolesController::index');
        $routes->post('create', 'RolesController::create');
        $routes->get('edit/(:num)', 'RolesController::edit/$1');
        $routes->post('update/(:num)', 'RolesController::update/$1');
        $routes->get('delete/(:num)', 'RolesController::delete/$1');
    });
    
  
    $routes->group('', ['filter' => 'cifilter:guest'], static function ($routes) {
        //$routes->view('example-auth','example-auth');
        $routes->get('login', 'AuthController::loginForm', ['as' => 'admin.login.form']);
        $routes->post('login', 'AuthController::loginHandler', ['as' => 'admin.login.handler']);
        $routes->get('forgot', 'AuthController::forgotPassword', ['as' => 'admin.forgot.form']);
        //$routes->get('forgot-password', 'AuthController::forgotPassword', ['as' => 'admin.forgot.form']);
        $routes->post('forgot-password', 'AuthController::sendResetLink', ['as' => 'send_password_reset_link']);
        //$routes->post('send-password-reset-link','AuthController::sendPasswordResetLink',['as'=>'send_password_reset_link']);
        $routes->get('password/reset/(:any)', 'AuthController::resetPassword/$1', ['as' => 'admin.reset_password']);
    });

});
