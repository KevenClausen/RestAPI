<?php

$routes = array (
  0 => 
  array (
    'route' => '/^\\/ilias\\/user$/',
    'http_method' => 'GET',
    'method' => 'getAllUsers',
  ),
  1 => 
  array (
    'route' => '/^\\/ilias\\/user\\/(?P<user_id>[^\\/]+)$/',
    'http_method' => 'GET',
    'method' => 'getUserInformation',
  ),
  2 => 
  array (
    'route' => '/^\\/ilias\\/user\\/(?P<user_id>[^\\/]+)$/',
    'http_method' => 'DELETE',
    'method' => 'deleteUser',
  ),
  3 => 
  array (
    'route' => '/^\\/ilias\\/user\\/(?P<user_id>[^\\/]+)$/',
    'http_method' => 'PATCH',
    'method' => 'updateUser',
  ),
  4 => 
  array (
    'route' => '/^\\/ilias\\/user\\/(?P<user_id>[^\\/]+)\\/course$/',
    'http_method' => 'GET',
    'method' => 'getUserCourses',
  ),
  5 => 
  array (
    'route' => '/^\\/ilias\\/user\\/(?P<user_id>[^\\/]+)\\/group$/',
    'http_method' => 'GET',
    'method' => 'getUserGroups',
  ),
  6 => 
  array (
    'route' => '/^\\/ilias\\/user\\/(?P<user_id>[^\\/]+)\\/role$/',
    'http_method' => 'GET',
    'method' => 'getUserRoles',
  ),
  7 => 
  array (
    'route' => '/^\\/ilias\\/user\\/(?P<user_id>[^\\/]+)\\/role\\/(?P<role_id>[^\\/]+)$/',
    'http_method' => 'PUT',
    'method' => 'addUserRoleEntry',
  ),
  8 => 
  array (
    'route' => '/^\\/ilias\\/user\\/(?P<user_id>[^\\/]+)\\/role\\/(?P<role_id>[^\\/]+)$/',
    'http_method' => 'DELETE',
    'method' => 'deleteUserRoleEntry',
  ),
  9 => 
  array (
    'route' => '/^\\/ilias\\/user\\/(?P<user_id>[^\\/]+)\\/customfield$/',
    'http_method' => 'GET',
    'method' => 'getUserCustomFields',
  ),
  10 => 
  array (
    'route' => '/^\\/ilias\\/user\\/(?P<user_id>[^\\/]+)\\/customfield$/',
    'http_method' => 'PATCH',
    'method' => 'setUserCustomFields',
  ),
  11 => 
  array (
    'route' => '/^\\/ilias\\/user\\/(?P<user_id>[^\\/]+)\\/customfield\\/(?P<customfield>[^\\/]+)$/',
    'http_method' => 'GET',
    'method' => 'getUserCustomFieldsByCustomFieldName',
  ),
  12 => 
  array (
    'route' => '/^\\/ilias\\/user\\/(?P<user_id>[^\\/]+)\\/exists$/',
    'http_method' => 'GET',
    'method' => 'userExists',
  ),
  13 => 
  array (
    'route' => '/^\\/ilias\\/user\\/(?P<user_id>[^\\/]+)\\/export$/',
    'http_method' => 'GET',
    'method' => 'userExport',
  ),
);

return [
    'routes' => $routes,
];
