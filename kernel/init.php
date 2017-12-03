<?php
if ( !defined( "FILE_INDEX" ) ) { die( "Hacking..." ); exit(); }

$global['microtime'] = microtime();
$global['url'] = explode( "/", @$_GET['url']);
$global['time'] = time () + ( $config['tz'] * 60 * 60 );
$config['charset'] = ( $config['charset'] ) ? strtolower( $config['charset'] ) : "UTF-8";
$config['debug'] = "yes";

require_once DIR_ROOT . "/kernel/classes/mysqli.class.php";
$db = new db( "localhost", "cms", "", "test" );



?>