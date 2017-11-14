<?php
	header("Cache-Control: no-store, no-cache, must-revalidate");
	
	$xml = simplexml_load_file("preguntas.xml");
	$cont = 0;
	$a = 'author';
	foreach ($xml->children() as $child){
		if($_POST['email']===(string)$child['author']){
			$cont++;
		}
	}
	echo $cont . "/" . $xml->count();
?>