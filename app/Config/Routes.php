<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

$routes->get('/', 'Home::index');

$routes->get(
    'apply',
    'Home::index'
);

$routes->post(
    'apply',
    'Home::apply'
);

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

$routes->post(
    'admin/login',
    'Admin::login'
);

$routes->get(
    'admin/logout',
    'Admin::logout'
);

$routes->get(
    'admin',
    'Home::loginPage'
);

$routes->get(
    'admin/login',
    'Home::loginPage'
);

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

$routes->get(
    'admin/dashboard',
    'Admin::dashboard'
);

$routes->get(
    'admin/analytics',
    'Admin::analytics'
);

$routes->get(
    'admin/applicationsPage',
    'Admin::applicationsPage'
);

$routes->get(
    'admin/usersPage',
    'Admin::usersPage'
);

$routes->get(
    'admin/rolesPage',
    'Admin::rolesPage'
);

// Friendly aliases
$routes->get(
    'admin/applications',
    'Admin::applicationsPage'
);

$routes->get(
    'admin/users',
    'Admin::usersPage'
);

$routes->get(
    'admin/roles',
    'Admin::rolesPage'
);

$routes->post(
    'admin/update-status/(:num)',
    'Admin::updateStatus/$1'
);

/*
|--------------------------------------------------------------------------
| JOB ROLES
|--------------------------------------------------------------------------
*/

$routes->post(
    'admin/add-role',
    'Admin::addRole'
);

$routes->post(
    'admin/update-role/(:num)',
    'Admin::updateRole/$1'
);

$routes->get(
    'admin/delete-role/(:num)',
    'Admin::deleteRole/$1'
);

/*
|--------------------------------------------------------------------------
| APPLICATION ASSIGNMENT
|--------------------------------------------------------------------------
*/

$routes->post(
    'admin/assign-application',
    'Admin::assignApplication'
);

$routes->get(
    'admin/get-assignable-users',
    'Admin::getAssignableUsers'
);

/*
|--------------------------------------------------------------------------
| APPLICATION LOGS
|--------------------------------------------------------------------------
*/

$routes->get(
    'admin/application-logs/(:num)',
    'Admin::applicationLogs/$1'
);

/*
|--------------------------------------------------------------------------
| USER MANAGEMENT
|--------------------------------------------------------------------------
*/

$routes->get(
    'admin/users-data',
    'Admin::users'
);

$routes->post(
    'admin/create-user',
    'Admin::createUser'
);


/*
|--------------------------------------------------------------------------
| APPLICANT DETAILS
|--------------------------------------------------------------------------
*/

$routes->get(
    'admin/applicant/(:num)',
    'Admin::applicantDetails/$1'
);

$routes->post(
    'admin/add-skill',
    'Admin::addSkill'
);

$routes->get(
    'admin/delete-skill/(:num)',
    'Admin::deleteSkill/$1'
);

$routes->post(
    'admin/update-access/(:num)',
    'Admin::updateAccess/$1'
);

$routes->post(
    'admin/update-settings',
    'Admin::updateSettings'
);
