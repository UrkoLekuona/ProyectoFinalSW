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
		<nav class='main' id='n1' role='navigation' style="height: 800px">
			<?php
			if (strcmp($logged, "True") == 0){
				echo "<span><a href='layout.php$variables'>Inicio</a></span><span><a href='pregunta.php$variables'>Introducir Preguntas</a></span>
				<span><a href='VerPreguntasConFoto.php$variables'>Ver Preguntas</a></span><span><a href='creditos.php$variables'>Creditos</a></span>";

			}else{
				echo "<span><a href='layout.php'>Inicio</a></span><span><a href='creditos.php'>Creditos</a></span>";
			}
			?>
		</nav>
			<section class="main" id="s1" style="height: 800px">
				<div>
					<h4>DATOS DE LA PREGUNTA</h4>
					<article class="main" id="s2" style="border-style: ridge;border-color: black; border-width:2px;background-color: SandyBrown;height: 275px;">
						<form id='fpreguntas' name='fpreguntas' action="InsertarPreguntaConFoto.php<?php echo $variables;?>" method="post" enctype="multipart/form-data">
							<input type="hidden" id="email" name="email" value="<?php echo $email; ?>" />
							<br/>
							Enunciado de la pregunta*: <input id="pregunta" name="pregunta" type="text"/>
							<br/>
							Respuesta Correcta*: <input id="rc" name="rc" type="text"/>
							<br/>
							Respuesta Incorrecta*: <input id="ri1" name="ri1" type="text"/>
							<br/>
							Respuesta Incorrecta*: <input id="ri2" name="ri2" type="text"/>
							<br/>
							Respuesta Incorrecta*: <input id="ri3" name="ri3" type="text"/>
							<br/>
							Complejidad (1..5)*: <input id="comp" name="comp" type="text"/>
							<br/>
							Tema (subject)*: <input id="tema" name="tema" type="text"/>
							<br/>
							<input type="file" id="imagen" name="imagen" accept="image/*" onchange="cargarFoto(this)" onload="this.value=null">
							<br/>
							<p> <img id = "foto" name="foto"> </p>
		<!--PONER BUTTON! --><input type="submit" value="Enviar solicitud" name="submit" id="submit"> 
							<input type="reset" value="Borrar" name="reset" onclick="borrarFoto()">
						</form>
					</article>
				</div>
				<div>
					<h4>VER PREGUNTAS</h4>
					</br>
					<input type="button" value="Ver preguntas" name="verP" id="verP" onClick="cargarTabla()"> 
					</br>
					<div id="table-scroll"><table id="tabla" class="scroll" border=1 style="display: none;"> <thead><tr><th> Pregunta </th> <th> Respuesta Correcta </th> <th> Respuestas Incorrectas </th> <th> Complejidad </th> <th> Tema </th> <th> Autor </th> 
						</tr></thead><tbody>
					</tbody></table></div>
				</div>
			</section>
			<footer class='main' id='f1' >
				<p><a href="http://es.wikipedia.org/wiki/Quiz" target="_blank">Que es un Quiz?</a></p>
				<p><a href='https://github.com'>Link GITHUB</a></p>
			</footer>
		</div>
		<script>
			function cargarFoto(im){
				if (im.files && im.files[0]){
					var reader = new FileReader();
					reader.onload = function(){
							var output = document.getElementById("foto");
							output.src = reader.result;
					};
					document.getElementById("n1").style="height: 900px;";
					document.getElementById("s1").style="height: 900px;";
					document.getElementById("foto").width=150;
					document.getElementById("foto").height=150;
					document.getElementById("foto").style.display="initial";
					document.getElementById("s2").style="border-style: ridge;border-color: black; border-width:2px;background-color: SandyBrown;height: 380px;";
					reader.readAsDataURL(im.files[0]);
				}
			}
			
			function borrarFoto(){
				document.getElementById("n1").style="height: 800px;";
				document.getElementById("s1").style="height: 800px;";
				document.getElementById("foto").style.display = "none";
				document.getElementById("s2").style="border-style: ridge;border-color: black; border-width:2px;background-color: SandyBrown;height: 275px;";
			}
			
			function cargarTabla(){
				xmlhttp = new XMLHttpRequest();
				
				xmlhttp.onreadystatechange = function (){
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
						document.getElementById("tabla").style="display: inline-block;";
					}
				}
				xmlhttp.open("GET", "VerPreguntasAJAX.php", true);
				xmlhttp.send();
			}
		</script>
	</body>
</html>