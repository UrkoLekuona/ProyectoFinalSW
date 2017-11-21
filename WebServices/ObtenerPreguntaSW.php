<?php
require_once('../lib/nusoap-0.9.5/src/nusoap.php');
include '../connectDB.php';

$ns="http://schemas.xmlsoap.org/soap/envelope/";
$server = new soap_server;
$server->configureWSDL('ObtenerPregunta',$ns);
$server->wsdl->schemaTargetNamespace=$ns;
$server->wsdl->addComplexType(
    'Pregunta',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'pregunta' => array('name' => 'pregunta', 'type' => 'xsd:string'),
        'respuesta' => array('name' => 'respuesta', 'type' => 'xsd:string'),
        'comp' => array('name' => 'comp', 'type' => 'xsd:int')
    )
);

$server->register('ObtenerPregunta', array('x'=>'xsd:int'), array('return' => 'tns:Pregunta'), $ns);
function ObtenerPregunta ($x){
	
	$link = connectDB();

	$sql = mysqli_query($link, "select PREGUNTA, RESPUESTA_C, COMP from preguntas where ID=$x" );
	
	if(!$sql || mysqli_num_rows($sql)!=1){
		return array(
		'pregunta'=>"",
		'respuesta'=>"",
		'comp'=>0
		);
	}
	
	$row = mysqli_fetch_array( $sql );
	
	return array(
		'pregunta'=>$row['PREGUNTA'],
		'respuesta'=>$row['RESPUESTA_C'],
		'comp'=>$row['COMP']
	);
}

if ( !isset( $HTTP_RAW_POST_DATA ) ) $HTTP_RAW_POST_DATA =file_get_contents( 'php://input' );
$server->service($HTTP_RAW_POST_DATA);
?>