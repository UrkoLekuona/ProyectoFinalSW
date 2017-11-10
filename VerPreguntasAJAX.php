<?php
		if (strcmp($logged, "True") == 0){
			$xml = simplexml_load_file("preguntas.xml");
			$c = 'complexity';
			$t = 'subject'; 
			
			echo '<div id="table-scroll"><table class="scroll" border=1> <thead><tr> <th> Pregunta </th> <th> Complejidad </th> <th> Tema </th> </tr></thead><tbody>';
			
			foreach($xml->children() as $child){
				$comp = $child->attributes()->$c;
				$tema = $child->attributes()->$t;
				$pregunta = $child->itemBody->p;
				echo "<tr><td> $pregunta </td> <td> $comp </td> <td> $tema </td></tr>";
			}
			echo '</tbody></table></div>';
		}
		else{
			echo 'Este contenido solo está disponible para usuarios registrados.';
		}
?>