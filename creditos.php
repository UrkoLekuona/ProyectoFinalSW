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
	</head>
	 <body>
	  <?php
		
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
				echo "<span class=\"right\"><a href=\"javascript:alert('Has cerrado sesión');javascript:window.location= 'layout.php'\">Logout</a>";

			}else{
				echo "<span class=\"right\"><a href=\"Registrar.php\">Registrarse</a></span>
				<span class=\"right\"><a href=\"Login.php\">Login</a></span>";
			}
			?>
		
			<h2>Quiz: el juego de las preguntas</h2>
		</header>
		<nav class='main' id='n1' role='navigation'>
			<?php
			if (strcmp($logged, "True") == 0){
				echo "<span><a href='layout.php$variables'>Inicio</a></span><span><a href='pregunta.php$variables'>Introducir Preguntas</a></span>
				<span><a href='VerPreguntasConFoto.php$variables'>Ver Preguntas</a></span><span><a href='creditos.php$variables'>Creditos</a></span>";

			}else{
				echo "<span><a href='layout.php'>Inicio</a></span><span><a href='creditos.php'>Creditos</a></span>";
			}
			?>
		</nav>
			<section class="main" id="s1">
			<img src="fotos/autores.jpg" alt="autores" style="width:290px;height:200px;" align="right">
			<div>
				
				<h3>Aplicación desarrollada por Urko Lekuona e Iñigo Gómez</h3>
				<br/>
				<h3>para Sistemas Web</h3>
				<br/>
				<h3>Alumnos de la Facultad de Informática de la UPV/EHU</h3>
				<br/>
				
			</div>
			</section>
			<footer class='main' id='f1'>
				<p><a href="http://es.wikipedia.org/wiki/Quiz" target="_blank">Que es un Quiz?</a></p>
				<p><a href='https://github.com'>Link GITHUB</a></p>
			</footer>
		</div>
	</body>
</html>