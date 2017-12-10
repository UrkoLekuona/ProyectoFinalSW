<?php 
		header("Content-type: text/html; charset=utf8");
		
		include 'connectDB.php';
		
		$link = connectDB();
		$sql="DELETE FROM preguntas WHERE ID=$_POST[id]";

		if (!mysqli_query($link ,$sql)){
				echo 'Error: ' . mysqli_error($link);
				die();
		}else{
			error_reporting(0);
			$xml = simplexml_load_file('preguntas.xml');
			if(!$xml){
				echo 'Error: No se puede cargar el fichero preguntas.xml';
				die();
			}
			else{
				foreach ($xml->children() as $pregunta) {
					if ($pregunta['id'] == $_POST['id']) {
						$dom=dom_import_simplexml($pregunta);
						$dom->parentNode->removeChild($dom);
					}
				}
				
				$domxml = new DOMDocument('1.0');
				$domxml->preserveWhiteSpace = false;
				$domxml->formatOutput = true;
				$domxml->loadXML($xml->asXML()); /* $xml es nuestro SimpleXMLElement a guardar*/
				$domxml->save('preguntas.xml');
				$domxml->save('preguntasConTransAut.xml');
				
				echo "Pregunta eliminada correctamente!";
			}
		}
		mysqli_close($link);
?>