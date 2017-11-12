<?php
	header("Cache-Control: no-store, no-cache, must-revalidate");
	
	$xml = simplexml_load_file("preguntas.xml");
	$c = 'complexity';
	$t = 'subject'; 
	$a = 'author';
	
	foreach($xml->children() as $child){
		$rif = '';
		$comp = $child->attributes()->$c;
		$tema = $child->attributes()->$t;
		$pregunta = $child->itemBody->p;
		$rc = $child->correctResponse->value;
		foreach($child->incorrectResponses->children() as $ri){
			$rif = $rif . $ri . '</br>';
		}
		$autor = $child->attributes()->$a;
		echo "<tr><td> $pregunta </td> <td> $rc </td> <td> $rif </td> <td> $comp </td> <td> $tema </td> <td> $autor </td></tr>";
	}
?>