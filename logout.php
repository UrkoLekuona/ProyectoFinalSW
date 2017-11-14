<?php
	header("Cache-Control: no-store, no-cache, must-revalidate");
	
	$xml = simplexml_load_file("contador.xml");

	$xml->value=$xml->value-1;

	$xml->asXML('contador.xml');

	header("Location:layout.php");
?>