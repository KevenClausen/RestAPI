<?php

$routes = array (
  0 => 
  array (
    'route' => '/^\\/ilias\\/repository\\/(?P<ref_id>[^\\/]+)$/',
    'http_method' => 'GET',
    'method' => 'objectInformation',
  ),
  1 => 
  array (
    'route' => '/^\\/ilias\\/repository\\/(?P<ref_id>[^\\/]+)$/',
    'http_method' => 'DELETE',
    'method' => 'deleteObject',
  ),
  2 => 
  array (
    'route' => '/^\\/ilias\\/repository\\/(?P<ref_id>[^\\/]+)\\/exists$/',
    'http_method' => 'GET',
    'method' => 'objectExists',
  ),
  3 => 
  array (
    'route' => '/^\\/ilias\\/repository\\/(?P<ref_id>[^\\/]+)\\/type$/',
    'http_method' => 'GET',
    'method' => 'getObjectType',
  ),
  4 => 
  array (
    'route' => '/^\\/ilias\\/repository\\/(?P<ref_id>[^\\/]+)\\/parent$/',
    'http_method' => 'GET',
    'method' => 'getParent',
  ),
  5 => 
  array (
    'route' => '/^\\/ilias\\/repository\\/(?P<ref_id>[^\\/]+)\\/childrens$/',
    'http_method' => 'GET',
    'method' => 'getChildren',
  ),
  6 => 
  array (
    'route' => '/^\\/ilias\\/repository\\/(?P<ref_id>[^\\/]+)\\/copy\\/(?P<target_ref_id>[^\\/]+)$/',
    'http_method' => 'PUT',
    'method' => 'copyObject',
  ),
  7 => 
  array (
    'route' => '/^\\/ilias\\/repository\\/(?P<ref_id>[^\\/]+)\\/advancedmetadata$/',
    'http_method' => 'GET',
    'method' => 'getAdvancedMetaData',
  ),
  8 => 
  array (
    'route' => '/^\\/ilias\\/repository\\/(?P<ref_id>[^\\/]+)\\/learninghistory\\/users$/',
    'http_method' => 'GET',
    'method' => 'getLearningHistoryUsers',
  ),
  9 => 
  array (
    'route' => '/^\\/ilias\\/repository\\/(?P<ref_id>[^\\/]+)\\/learninghistory\\/users\\/(?P<user_id>[^\\/]+)$/',
    'http_method' => 'GET',
    'method' => 'getLearningHistoryByUserID',
  ),
);

return [
    'routes' => $routes,
];
