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
        $routes->post('get-users', 'AdminController::getUser', ['as' => 'admin.users.get']);
        $routes->get('get-users', 'AdminController::getUsers', ['as' => 'get-users']);
        $routes->get('user/edit', 'AdminController::edit', ['as' => 'user.edit']);
        $routes->post('user/update', 'AdminController::update', ['as' => 'user.update']);
        $routes->post('user/delete', 'AdminController::delete', ['as' => 'user.delete']);
        $routes->get('profile', 'AdminController::profile', ['as' => 'profile']);
        $routes->get('logs', 'LogsController::index');
         $routes->get('change-password', 'AdminController::changePassword', ['as' => 'change_password']);
        $routes->post('change-password', 'AdminController::updatePassword');  
        $routes->get('new-user', 'AdminController::addUser', ['as' => 'new-user']);
        $routes->post('create-user', 'AdminController::createUser', ['as' => 'create-user']);
    });
    $routes->group('students', ['filter' => 'cifilter:auth'], static function ($routes) {
        $routes->get('attachment/create', 'StudentsController::create', ['as' => 'attachment.create']);
        $routes->post('attachment/store', 'StudentsController::store', ['as' => 'attachment.store']);
         $routes->get('get', 'StudentController::index');
        // $routes->get('assign-supervisor/(:num)', 'StudentController::assignSupervisor/$1');
        // $routes->post('assign-supervisor/save', 'StudentController::saveAssignment');
        $routes->get('confirm-assessment/(:num)', 'StudentsController::confirmAssessmentByStudent/$1');
        $routes->post('create-student', 'AdminController::createStudent');
        $routes->get('edit', 'AdminController::editStudent');
        $routes->post('delete', 'AdminController::deleteStudent');
        $routes->post('update-student', 'AdminController::updateStudent');

    });

    $routes->group('attachment', ['filter' => 'cifilter:auth'], static function ($routes) {
        $routes->get('get', 'AttachmentController::index');
       $routes->get('assign-supervisor/(:num)', 'AttachmentController::assignSupervisor/$1');
       $routes->post('assign-supervisor/save', 'AttachmentController::saveAssignment');
        $routes->get('change-supervisor/(:num)', 'AttachmentController::changeSupervisor/$1');
        $routes->post('save-supervisor-change', 'AttachmentController::saveSupervisorChange');
        $routes->get('attachment-details', 'AttachmentController::viewAttachmentDetails');
        $routes->get('my-students', 'AttachmentController::students');
        $routes->get('assessment-form/(:num)', 'AttachmentController::assessmentForm/$1');
        $routes->post('confirm-assessment', 'AttachmentController::confirmAssessment');

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
