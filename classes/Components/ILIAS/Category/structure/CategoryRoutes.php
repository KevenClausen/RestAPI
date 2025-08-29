<?php

$routes = array(
  0 =>
  array(
    'route' => '/^\\/ilias\\/category$/',
    'http_method' => 'GET',
    'method' => 'getCategorys',
  ),
  1 =>
  array(
    'route' => '/^\\/ilias\\/category\\/(?P<ref_id>[^\\/]+)$/',
    'http_method' => 'GET',
    'method' => 'getCategoryById',
  ),
);

return [
    'routes' => $routes,
];
