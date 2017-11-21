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
		<nav class='main' id='n1' role='navigation' style="height: 250px">
			<?php
			if (strcmp($logged, "True") == 0){
				echo "<span><a href='layout.php$variables'>Inicio</a></span><span><a href='pregunta.php$variables'>Introducir Preguntas</a></span>
				<span><a href='VerPreguntasConFoto.php$variables'>Ver Preguntas</a></span><span><a href='GestionarPreguntas.php$variables'>Gestionar Preguntas</a></span><span><a href='VerPreguntasSW_Cliente.php$variables'>Ver Preguntas Servicio Web</a></span><span><a href='creditos.php$variables'>Creditos</a></span>";

			}else{
				echo "<span><a href='layout.php'>Inicio</a></span><span><a href='creditos.php'>Creditos</a></span>";
			}
			?>
		</nav>
			<section class="main" id="s1" style="height: 250px">
				<article class="main" id="s2" style="border-style: ridge;border-color: black; border-width:2px;background-color: SandyBrown;height: 225px;">
					<form id='fpreguntas' name='fpreguntas' action="VerPreguntasSW_Cliente.php<?php echo $variables;?>" method="post" enctype="multipart/form-data">
						<br/>
						ID de la pregunta *: <input id="pregunta" name="pregunta"/>
						<br/>
						<input type="submit" value="Enviar solicitud" name="submit" id="submit"> 
						<input type="reset" value="Borrar" name="reset">
						<br/>
						<br/>
					<?php
						require_once('./lib/nusoap-0.9.5/src/nusoap.php');
						
						if (isset($_POST["pregunta"])){
							$soapclient= new nusoap_client('http://localhost/Lab5/WebServices/ObtenerPreguntaSW.php?wsdl', true);
							$result= $soapclient->call('ObtenerPregunta', array('x'=>$_POST["pregunta"]));
							
							if($result["comp"]==0){
								echo "No existe una pregunta con el ID introducido o se ha producido un error.";
							}
							else{
								echo '<div id="table-scroll"><table class="scroll" border=1> <thead><th> Pregunta </th> <th> Respuesta Correcta </th><th> Complejidad </th></tr></thead>
								<tbody><tr><td>' . $result["pregunta"] . '</td> <td>' . $result["respuesta"] . '</td> <td>' . $result["comp"] . '</td></tr></tbody></table></div>';
							}
						}
					?>
					</form>
				</article>
			</section>
			<footer class='main' id='f1' >
				<p><a href="http://es.wikipedia.org/wiki/Quiz" target="_blank">Que es un Quiz?</a></p>
				<p><a href='https://github.com'>Link GITHUB</a></p>
			</footer>
		</div>
	</body>
</html>