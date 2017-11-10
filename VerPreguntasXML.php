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
				echo "<a href=\"javascript:alert('Has cerrado sesión');javascript:window.location= 'layout.php'\">Logout</a>";

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
				<span><a href='VerPreguntasConFoto.php$variables'>Ver Preguntas</a></span><span><a href='creditos.php$variables'>Creditos</a></span>";

			}else{
				echo "<span><a href='layout.php'>Inicio</a></span><span><a href='creditos.php'>Creditos</a></span>";
			}
			?>
			
	</nav>
    <section class="main" id="s1" style="height: 300px">
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
    </section>
	<footer class='main' id='f1'>
		<p><a href="http://es.wikipedia.org/wiki/Quiz" target="_blank">Que es un Quiz?</a></p>
		<p><a href='https://github.com'>Link GITHUB</a></p>
	</footer>
</div>
</body>
</html>
