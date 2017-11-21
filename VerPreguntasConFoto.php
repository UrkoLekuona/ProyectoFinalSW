<!DOCTYPE html>
<html>
	<head>
		<meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
			<title>Preguntas</title>
			<link rel='stylesheet' type='text/css' href='estilos/style.css' />
			<link rel='stylesheet' 
				   type='text/css' 
				   media='only screen and (min-width: 530px) and (min-device-width: 481px)'
				   href='estilos/wide.css' />
			<link rel='stylesheet' 
				   type='text/css' 
				   media='only screen and (max-width: 480px)'
				   href='estilos/smartphone.css' />
			<script src="lib/jquery-3.2.1.min.js"></script>
	</head>
	 <body>
	  <?php
		include 'connectDB.php';

		if (isset($_GET["LOGGED"])){
			$email=$_GET["EMAIL"];
			$logged=$_GET["LOGGED"];
			$imagen=$_GET["IMAGEN"];
			$variables="?LOGGED=$logged&EMAIL=$email&IMAGEN=$imagen";
		}
		else{
			$logged=false;
		}
	?>
	  <div id='page-wrap'>
		<header class='main' id='h1'>
			<?php
			if (strcmp($logged, "True") == 0){
				echo $email;
				echo " ";
				echo "<img src=\"./fotos/fotos_usuario/$imagen\" width=30 height=30 />";
				echo "<span class=\"right\"><a href=\"javascript:alert('Has cerrado sesión');javascript:window.location= 'logout.php'\">Logout</a>";

			}else{
				echo "<span class=\"right\"><a href=\"Registrar.php\">Registrarse</a></span>
				<span class=\"right\"><a href=\"Login.php\">Login</a></span>";
			}
			?>
			<h2>Quiz: el juego de las preguntas</h2>
		</header>
		<nav class='main' id='n1' role='navigation' style="height: 300px">
			<?php
			if (strcmp($logged, "True") == 0){
				echo "<span><a href='layout.php$variables'>Inicio</a></span><span><a href='pregunta.php$variables'>Introducir Preguntas</a></span>
				<span><a href='VerPreguntasConFoto.php$variables'>Ver Preguntas</a></span><span><a href='GestionarPreguntas.php$variables'>Gestionar Preguntas</a></span><span><a href='VerPreguntasSW_Cliente.php$variables'>Ver Preguntas Servicio Web</a></span><span><a href='creditos.php$variables'>Creditos</a></span>";

			}else{
				echo "<span><a href='layout.php'>Inicio</a></span><span><a href='creditos.php'>Creditos</a></span>";
			}
			?>
		</nav>
			<section class="main" id="s1" style="height: 300px">
					<?php
						
						$link = connectDB();
						
						$sql = mysqli_query($link, "select * from preguntas" );
						
						echo '<div id="table-scroll"><table class="scroll" border=1> <thead><tr> <th> ID </th> <th> Autor </th> <th> Pregunta </th> <th> Respuesta Correcta </th> <th> Respuesta Incorrecta 1 </th> <th> Respuesta Incorrecta 2 </th> <th> Respuesta Incorrecta 3 </th> <th> Complejidad </th> <th> Tema </th> <th> Imagen </th> 
						</tr></thead><tbody>';
						while ($row = mysqli_fetch_array( $sql )) {
						echo '<tr><td>' . $row['ID'] . '</td> <td>' . $row['EMAIL'] . '</td> <td>' . $row['PREGUNTA'] . '</td> <td>' . $row['RESPUESTA_C'] . '</td> <td>' . $row['RESPUESTA_I1'] . '</td> <td>' . $row['RESPUESTA_I2'] . '</td> <td>' . $row['RESPUESTA_I3'] . '</td> <td>' . $row['COMP'] . '</td> <td>' . $row['TEMA'] .  
						'</td> <td>';
						$image_name=$row['IMAGEN'];
						echo "<img src=".$folder."fotos_pregunta/".$image_name." width=100 height=100 />";
						echo '</td> </tr>';
						}
						echo '</tbody></table></div>';
						//echo "<br/><br/><a href=\"javascript:history.go(-1)\" style='font-size: 150%;'>VOLVER</a>";
						$sql->close();
						mysqli_close($link);

					?>
			</section>
			<footer class='main' id='f1' >
				<p><a href="http://es.wikipedia.org/wiki/Quiz" target="_blank">Que es un Quiz?</a></p>
				<p><a href='https://github.com'>Link GITHUB</a></p>
			</footer>
		</div>
	</body>
</html>