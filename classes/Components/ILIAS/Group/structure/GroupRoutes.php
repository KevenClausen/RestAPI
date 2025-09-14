<?php

$routes = array(
  0 =>
  array(
    'route' => '/^\\/ilias\\/group$/',
    'http_method' => 'GET',
    'method' => 'getAllGroups',
  ),
  1 =>
  array(
    'route' => '/^\\/ilias\\/group\\/(?P<ref_id>[^\\/]+)$/',
    'http_method' => 'GET',
    'method' => 'getGroupByRefID',
  ),
  2 =>
  array(
    'route' => '/^\\/ilias\\/group\\/(?P<ref_id>[^\\/]+)$/',
    'http_method' => 'PATCH',
    'method' => 'updateGroupByRefId',
  ),
  3 =>
  array(
    'route' => '/^\\/ilias\\/group\\/(?P<ref_id>[^\\/]+)\\/property\\/(?P<property>[^\\/]+)$/',
    'http_method' => 'GET',
    'method' => 'getGroupInformation',
  ),
  4 =>
  array(
    'route' => '/^\\/ilias\\/group\\/(?P<ref_id>[^\\/]+)\\/users\\/(?P<user_id>[^\\/]+)\\/(?P<default_role>[^\\/]+)$/',
    'http_method' => 'PUT',
    'method' => 'addUser',
  ),
  5 =>
  array(
    'route' => '/^\\/ilias\\/group\\/(?P<ref_id>[^\\/]+)\\/users\\/(?P<user_id>[^\\/]+)$/',
    'http_method' => 'DELETE',
    'method' => 'deleteUser',
  ),
  6 =>
  array(
    'route' => '/^\\/ilias\\/group\\/(?P<ref_id>[^\\/]+)\\/users$/',
    'http_method' => 'GET',
    'method' => 'getAllUsers',
  ),
  7 =>
  array(
    'route' => '/^\\/ilias\\/group\\/(?P<ref_id>[^\\/]+)\\/admins$/',
    'http_method' => 'GET',
    'method' => 'getAllAdmins',
  ),
  8 =>
  array(
    'route' => '/^\\/ilias\\/group\\/(?P<ref_id>[^\\/]+)\\/members$/',
    'http_method' => 'GET',
    'method' => 'getAllMembers',
  ),
  9 =>
  array(
    'route' => '/^\\/ilias\\/group\\/(?P<ref_id>[^\\/]+)\\/roles$/',
    'http_method' => 'GET',
    'method' => 'getGroupRoles',
  ),
);

return [
    'routes' => $routes,
];
