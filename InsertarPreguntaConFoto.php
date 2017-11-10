
<?php 
		header("Content-type: text/html; charset=utf8");
		
		$email=$_GET["EMAIL"];
		$logged=$_GET["LOGGED"];
		$imagen=$_GET["IMAGEN"];
		$variables="?LOGGED=$logged&EMAIL=$email&IMAGEN=$imagen";
			
		/*if (strlen($_POST["email"]) == 0){
			echo "<script>alert('El campo del email está vacío');window.location= 'pregunta.php$variables'</script>";
			die();
		}
		$pattern='/^[a-z]{2,}[0-9]{3}@ikasle\.ehu\.(eus|es)$/';
		if (preg_match($pattern, $_POST["email"]) === 0){
			echo "<script>window.location= 'pregunta.php$variables'</script>";
			echo "<script type='text/javascript'>alert('El email no es válido, tiene que acabar en @ikasle.ehu.eus o @ikasle.ehu.es');</script>";
			die();
		}*/
		if (strlen($_POST["pregunta"])< 10){
			echo "<script>alert('El campo de pregunta debe tener mas de 10 caracteres');window.location= 'pregunta.php$variables'</script>";
			die();
		}
		if (strlen($_POST["rc"]) == 0){
			echo "<script>alert('El campo de respuesta correcta está vacío');window.location= 'pregunta.php$variables'</script>";
			die();
		}
		if (strlen($_POST["ri1"]) == 0){
			echo "<script>alert('El campo de la respuesta incorrecta 1 está vacío');window.location= 'pregunta.php$variables'</script>";
			die();
		}
		if (strlen($_POST["ri2"]) == 0){
			echo "<script>alert('El campo de la respuesta incorrecta 2 está vacío');window.location= 'pregunta.php$variables'</script>";
			die();
		}
		if (strlen($_POST["ri3"]) == 0){
			echo "<script>alert('El campo de la respuesta incorrecta 3 está vacío');window.location= 'pregunta.php$variables'</script>";
			die();
		}
		if (strlen($_POST["comp"])== 0){
			echo "<script>alert('El campo de complejidad está vacío');window.location= 'pregunta.php$variables'</script>";
			die();
		}
		$pattern='/^[1-5]$/';
		if (preg_match($pattern, $_POST["comp"]) === 0){
			echo "<script>alert('La complejidad debe ser un número entero y estar entre 1 y 5');window.location= 'pregunta.php$variables'</script>";
			die();
		}
		if (strlen($_POST["tema"])== 0){
			echo "<script>alert('El campo de tema está vacío');window.location= 'pregunta.php$variables'</script>";
			die();
		}
			
		include 'connectDB.php';
		
		$link = connectDB();
		$sql="INSERT INTO preguntas(EMAIL, PREGUNTA, RESPUESTA_C, RESPUESTA_I1, RESPUESTA_I2, RESPUESTA_I3, COMP, TEMA) VALUES ('$_POST[email]', '$_POST[pregunta]', '$_POST[rc]', '$_POST[ri1]', '$_POST[ri2]', '$_POST[ri3]', '$_POST[comp]', '$_POST[tema]')";

		if (!mysqli_query($link ,$sql)){
				echo 'Error: ' . mysqli_error($link);
				echo "<br/><br/><a href=\"javascript:history.go(-1)\" style='font-size: 150%;'>VOLVER</a>";
				die();
		}
		else{
			$idquery = mysqli_query($link, "SELECT MAX(ID) FROM preguntas" );
			$id=mysqli_fetch_array( $idquery );
			if (isset($_FILES["imagen"]) && ( $_FILES["imagen"]["type"]=="image/jpeg" || $_FILES["imagen"]["type"]=="image/png" || $_FILES["imagen"]["type"]=="image/jpg")){
				$origen=$_FILES["imagen"]["tmp_name"]; 
				$imagen="Imagen_".$id[0].select_type($_FILES["imagen"]["type"]);
				move_uploaded_file($origen, $folder."fotos_pregunta/".$imagen);
			}
			else{
				$origen="$folder"."fotos_pregunta/"."pregunta_def.jpg"; 
				$imagen="Imagen_".$id[0].".jpg";
				copy($origen, $folder."fotos_pregunta/".$imagen);
			}
			$update="UPDATE preguntas SET IMAGEN='$imagen' WHERE ID='$id[0]'";
			if (!mysqli_query($link ,$update)){
				echo 'Error: ' . mysqli_error($link);
				echo "<br/><br/><a href=\"javascript:history.go(-1)\" style='font-size: 150%;'>VOLVER</a>";
				die();
			}else{
				error_reporting(0);
				$xml = simplexml_load_file('preguntas.xml');
				if(!$xml){
					echo 'Error: No se puede cargar el fichero preguntas.xml';
					echo "<br/><br/><a href=\"javascript:history.go(-1)\" style='font-size: 150%;'>VOLVER</a>";
					die();
				}
				else{
					$pregunta = $xml->addChild('assessmentItem');
					
					$pregunta->addAttribute('complexity', trim($_POST['comp']));
					$pregunta->addAttribute('subject', trim($_POST['tema']));
					$pregunta->addAttribute('author', trim($_POST['email']));
					
					$enunciado = $pregunta->addChild('itemBody');
					$p = $enunciado->addChild('p', trim($_POST['pregunta']));
					
					$rc = $pregunta->addChild('correctResponse');
					$val = $rc->addChild('value', trim($_POST['rc']));
					
					$ri = $pregunta->addChild('incorrectResponses');
					$val1 = $ri->addChild('value', trim($_POST['ri1']));
					$val2 = $ri->addChild('value', trim($_POST['ri2']));
					$val3 = $ri->addChild('value', trim($_POST['ri3']));
					
					$domxml = new DOMDocument('1.0');
					$domxml->preserveWhiteSpace = false;
					$domxml->formatOutput = true;
					$domxml->loadXML($xml->asXML()); /* $xml es nuestro SimpleXMLElement a guardar*/
					$domxml->save('preguntas.xml');
					$domxml->save('preguntasConTransAut.xml');

					echo "<script>alert('Pregunta guardada correctamene!');window.location= 'VerPreguntasXML.php$variables'</script>";
				}
			}
		}
		mysqli_close($link);
		
		function select_type ( $data ) {
			$output = $data;
			if ($data == "image/jpeg"){
				$output = ".jpeg";
			}
			elseif ($data == "image/jpg"){
				$output = ".jpg";
			}
			elseif ($data == "image/png"){
				$output = ".png";
			}
			
			return $output;
		}
?>   
 