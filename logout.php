<?php
session_start ();

if(isset($_SESSION['EMAIL'])){
	header("Cache-Control: no-store, no-cache, must-revalidate");
	
	$xml = simplexml_load_file("contador.xml");

	$xml->value=$xml->value-1;

	$xml->asXML('contador.xml');

	session_destroy();
	
	header("Location:layout.php");
}
else{
	header("Location:layout.php");
}
?>