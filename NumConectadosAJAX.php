<?php
	header("Cache-Control: no-store, no-cache, must-revalidate");
	
	$xml = simplexml_load_file("contador.xml");

	echo $xml->value;
?>