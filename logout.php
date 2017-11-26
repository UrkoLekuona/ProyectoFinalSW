<?php
	header("Cache-Control: no-store, no-cache, must-revalidate");
	
	session_start ();
	
	$xml = simplexml_load_file("contador.xml");

	$xml->value=$xml->value-1;

	$xml->asXML('contador.xml');

	session_destroy();
	
	header("Location:layout.php");
?>