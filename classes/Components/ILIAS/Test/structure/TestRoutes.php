<?php

$routes = array (
  0 => 
  array (
    'route' => '/^\\/ilias\\/test$/',
    'http_method' => 'GET',
    'method' => 'getAllTests',
  ),
  1 => 
  array (
    'route' => '/^\\/ilias\\/test\\/(?P<ref_id>[^\\/]+)$/',
    'http_method' => 'GET',
    'method' => 'getTestById',
  ),
  2 => 
  array (
    'route' => '/^\\/ilias\\/test\\/(?P<ref_id>[^\\/]+)\\/info$/',
    'http_method' => 'GET',
    'method' => 'getTestInfoById',
  ),
  3 => 
  array (
    'route' => '/^\\/ilias\\/test\\/(?P<ref_id>[^\\/]+)\\/settings\\/general$/',
    'http_method' => 'GET',
    'method' => 'getTestSettingsGeneralById',
  ),
  4 => 
  array (
    'route' => '/^\\/ilias\\/test\\/(?P<ref_id>[^\\/]+)\\/settings\\/general$/',
    'http_method' => 'PATCH',
    'method' => 'updateTestSettingsGeneralById',
  ),
  5 => 
  array (
    'route' => '/^\\/ilias\\/test\\/(?P<ref_id>[^\\/]+)\\/settings\\/grading-system$/',
    'http_method' => 'GET',
    'method' => 'getAllGradingByRefid',
  ),
  6 => 
  array (
    'route' => '/^\\/ilias\\/test\\/(?P<ref_id>[^\\/]+)\\/settings\\/grading-system$/',
    'http_method' => 'PATCH',
    'method' => 'patchGrading',
  ),
  7 => 
  array (
    'route' => '/^\\/ilias\\/test\\/(?P<ref_id>[^\\/]+)\\/settings\\/grading-system\\/(?P<short_name>[^\\/]+)$/',
    'http_method' => 'DELETE',
    'method' => 'deleteGrading',
  ),
  8 => 
  array (
    'route' => '/^\\/ilias\\/test\\/(?P<ref_id>[^\\/]+)\\/settings\\/grading-system\\/reset$/',
    'http_method' => 'PATCH',
    'method' => 'resetGrading',
  ),
  9 => 
  array (
    'route' => '/^\\/ilias\\/test\\/(?P<ref_id>[^\\/]+)\\/participants$/',
    'http_method' => 'GET',
    'method' => 'getParticipants',
  ),
  10 => 
  array (
    'route' => '/^\\/ilias\\/test\\/(?P<ref_id>[^\\/]+)\\/results$/',
    'http_method' => 'GET',
    'method' => 'getResults',
  ),
  11 => 
  array (
    'route' => '/^\\/ilias\\/test\\/(?P<ref_id>[^\\/]+)\\/results\\/(?P<user_id>[^\\/]+)$/',
    'http_method' => 'GET',
    'method' => 'getResultsByUser',
  ),
);

return [
    'routes' => $routes,
];
