<?php
require_once('../lib/nusoap-0.9.5/src/nusoap.php');

$ns="http://schemas.xmlsoap.org/soap/envelope/";
$server = new soap_server;
$server->configureWSDL('comprobarPass',$ns);
$server->wsdl->schemaTargetNamespace=$ns;

$server->register('comprobarPass', array('x'=>'xsd:string'), array('z'=>'xsd:string'), $ns);
function comprobarPass ($x){
	$handle = fopen('toppasswords.txt', 'r');
	$valid = false; // init as false
	while (($buffer = fgets($handle)) !== false) {
		if (strcmp(trim($buffer), $x) == 0) {
			$valid = TRUE;
			break; // Once you find the string, you should break out the loop.
		}      
	}
	fclose($handle);
	
	if($valid==TRUE){
		return 'INVALIDA';
	}
	else{
		return 'VALIDA';
	}
}

if ( !isset( $HTTP_RAW_POST_DATA ) ) $HTTP_RAW_POST_DATA =file_get_contents( 'php://input' );
$server->service($HTTP_RAW_POST_DATA);
?>