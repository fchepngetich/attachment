<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('admin', static function ($routes) {
    $routes->group('', ['filter' => 'cifilter:auth'], static function ($routes) {
        $routes->get('home', 'StudentsController::index', ['as' => 'admin.home']);
        $routes->get('logout', 'AdminController::logoutHandler');

       
    });
    $routes->group('students', ['filter' => 'cifilter:auth'], static function ($routes) {
        $routes->get('attachment/create', 'StudentsController::create', ['as' => 'attachment.create']);
        $routes->post('attachment/store', 'StudentsController::store', ['as' => 'attachment.store']);
         $routes->get('get', 'StudentController::index');
        $routes->get('assign-supervisor/(:num)', 'StudentController::assignSupervisor/$1');
        $routes->post('assign-supervisor/save', 'StudentController::saveAssignment');
      
    });

    $routes->group('attachment', ['filter' => 'cifilter:auth'], static function ($routes) {
        $routes->get('get', 'AttachmentController::index');
       $routes->get('assign-supervisor/(:num)', 'AttachmentController::assignSupervisor/$1');
       $routes->post('assign-supervisor/save', 'AttachmentController::saveAssignment');

        $routes->get('change-supervisor/(:num)', 'AttachmentController::changeSupervisor/$1');

        $routes->post('save-supervisor-change', 'AttachmentController::saveSupervisorChange');

     
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
