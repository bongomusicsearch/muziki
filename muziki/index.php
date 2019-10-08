<?php 
date_default_timezone_set( 'Asia/Jakarta' );

error_reporting( E_ALL );
define( 'developers', false );
define( 'IDC', dirname( __FILE__ ) );

$base = str_replace( "\\", "/", IDC );
$path = str_replace( rtrim( $_SERVER['DOCUMENT_ROOT'], '/' ), '', $base );
if ( $base == $path ) {
	$base = str_replace( array( "public_html", "\\" ), array( "www", "/" ), IDC );
	$path = str_replace( rtrim( $_SERVER['DOCUMENT_ROOT'], '/' ), '', $base );
}

define( 'BASE', $base, TRUE ); //TRUE = case_insensitive  Base = BASE
define( 'PATH', $path, TRUE );

/*Function*/
require 'core/functions/functions.php';
#require 'core/functions/breadcrumb.php';
#require 'core/functions/google_suggest.php';
/*Function*/

require 'config/init.php';
require 'core/uri.php';
require 'core/router.php';

/*Classes*/
require 'core/classes/ua.class.php';
require 'core/classes/agc.php';
#require 'core/classes/gsm.php';
/*Classes*/

#require 'libraries/lang/lang.php';

// print_r($route);

$theme = '/includes/themes/'.$config['theme'].'/';
if ( $found ) {

  $file = BASE . $theme . $route['file'];
  if ( $route['file'] && file_exists( $file ) ) {
    require $file;
    exit();
  } else {
    print_error( "File <strong>$vars[file]</strong> is not found" );
  }
} else {
  print_error( "Page is not found" );
}
