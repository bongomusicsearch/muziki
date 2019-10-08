<?php defined('developers') ? : die("akses langsung ke file ini ditangguhkan");

$domain = $_SERVER['HTTP_HOST'];

/*COMMON*/
$config = require BASE .'/config/default/common.php';

/*ROUTES*/
$routes = require 'default/routes.php';

if ( file_exists( BASE . '/config/domain/' . $domain . '/routes.php' ) ) {
  $site_routes = require 'domain/'.$domain.'.routes.php';
  $routes = array_merge( $routes, $site_routes );
}