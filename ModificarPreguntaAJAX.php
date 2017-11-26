<?php 
		header("Content-type: text/html; charset=utf8");

		if (strlen($_POST["pregunta"])< 10){
			echo "El campo de pregunta debe tener mas de 10 caracteres";
			die();
		}
		if (strlen($_POST["rc"]) == 0){
			echo "El campo de respuesta correcta está vacío";
			die();
		}
		if (strlen($_POST["ri1"]) == 0){
			echo "El campo de la respuesta incorrecta 1 está vacío";
			die();
		}
		if (strlen($_POST["ri2"]) == 0){
			echo "El campo de la respuesta incorrecta 2 está vacío";
			die();
		}
		if (strlen($_POST["ri3"]) == 0){
			echo "El campo de la respuesta incorrecta 3 está vacío";
			die();
		}
		if (strlen($_POST["comp"])== 0){
			echo "El campo de complejidad está vacío";
			die();
		}
		$pattern='/^[1-5]$/';
		if (preg_match($pattern, $_POST["comp"]) === 0){
			echo "La complejidad debe ser un número entero y estar entre 1 y 5";
			die();
		}
		if (strlen($_POST["tema"])== 0){
			echo "El campo de tema está vacío";
			die();
		}
		
		include 'connectDB.php';
		
		$link = connectDB();
		$sql="UPDATE PREGUNTAS SET PREGUNTA='$_POST[pregunta]', RESPUESTA_C='$_POST[rc]', RESPUESTA_I1='$_POST[ri1]', RESPUESTA_I2='$_POST[ri2]', RESPUESTA_I3='$_POST[ri3]', COMP=$_POST[comp], TEMA='$_POST[tema]' WHERE ID=$_POST[id];";

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
						$pregunta['complexity']=$_POST['comp'];
						$pregunta['subject']=trim($_POST['tema']);
						$pregunta->itemBody->p=trim($_POST['pregunta']);
						$pregunta->correctResponse->value=trim($_POST['rc']);
						unset($pregunta->incorrectResponses);
						$ri = $pregunta->addChild('incorrectResponses');
						$val1 = $ri->addChild('value', trim($_POST['ri1']));
						$val2 = $ri->addChild('value', trim($_POST['ri2']));
						$val3 = $ri->addChild('value', trim($_POST['ri3']));
					}
				}
				
				$domxml = new DOMDocument('1.0');
				$domxml->preserveWhiteSpace = false;
				$domxml->formatOutput = true;
				$domxml->loadXML($xml->asXML()); /* $xml es nuestro SimpleXMLElement a guardar*/
				$domxml->save('preguntas.xml');
				$domxml->save('preguntasConTransAut.xml');
				
				echo "Pregunta modificada correctamente!";
			}
		}
		mysqli_close($link);
?>