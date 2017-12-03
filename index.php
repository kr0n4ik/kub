<?php
@session_start();
@ob_start();
@ob_implicit_flush(0);

//Отладка
@ini_set ( 'display_errors', true );
@ini_set ( 'html_errors', true );
@error_reporting ( E_ERROR  );
@ini_set ( 'error_reporting', E_ERROR  );

define( "FILE_INDEX", true );
define( "DIR_ROOT", dirname( __FILE__ ) );

require_once DIR_ROOT . "/kernel/init.php";

header( "Content-type: text/html; charset={$config['charset']}" );


?>
<!DOCTYPE html>
<head>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

  <!-- jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  
  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>
<body>
<?php 
	if (file_exists( DIR_ROOT . "/modules/" . $global['url'][0] . "/content.php")) {
		include_once DIR_ROOT . "/modules/" . $global['url'][0] . "/content.php";
	} else {
		echo DIR_ROOT . "/modules/" . $global['url'][0] . "/content.php";
	}
?>
</body>
</html>
<?php
$global['microtime'] = ( microtime() - $global['microtime'] );
echo "\n<!-- Time:" . $global['microtime'] . " -->\n";
unset( $global );
?>