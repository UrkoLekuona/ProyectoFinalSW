<?PHP
session_start ();
?>
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
	  <div id='page-wrap'>
		<header class='main' id='h1'>
			<?php
			if (isset($_SESSION['EMAIL'])){
				echo $_SESSION["EMAIL"];
				echo " ";
				echo "<img src=\"./fotos/fotos_usuario/$_SESSION[IMAGEN]\" width=30 height=30 />";
				echo "<a href=\"javascript:alert('Has cerrado sesión');javascript:window.location= 'logout.php'\">Logout</a>";

			}else{
				echo "<span class=\"right\"><a href=\"Registrar.php\">Registrarse</a></span>
				<span class=\"right\"><a href=\"Login.php\">Login</a></span>";
			}
			?>
			<h2>Quiz: el juego de las preguntas</h2>
		</header>
		<nav class='main' id='n1' role='navigation' style="height: 800px">
			<?php
			if (isset($_SESSION['EMAIL']) && $_SESSION['ROL']==0){
				echo "<span><a href='layout.php'>Inicio</a></span>
				<span><a href='GestionarPreguntas.php'>Gestionar Preguntas</a></span><span><a href='creditos.php'>Creditos</a></span>";
			}
			elseif(isset($_SESSION['EMAIL']) && $_SESSION['ROL']==1){
				echo "<span><a href='layout.php'>Inicio</a><span><a href='RevisarPreguntas.php'>Revisar Preguntas</a></span><span><a href='creditos.php'>Creditos</a></span>";
			}else{
				echo "<span><a href='layout.php'>Inicio</a></span><span><a href='creditos.php'>Creditos</a></span>";
			}
			?>
		</nav>
			<section class="main" id="s1" style="height: 800px">
				<?php
					if(isset($_SESSION['EMAIL']) && $_SESSION['ROL']==0){
						echo '<div>
					<label>Usuarios conectados : </label>
					<label type="text" id="conectados"></label>
				</div>
				<div>
					<label>Número de preguntas tuyas / totales : </label>
					<label type="text" id="numPreguntas"></label>
				</div>
				<div>
					<h4>INTRODUCIR PREGUNTA</h4>
					<article class="main" id="s2" style="border-style: ridge;border-color: black; border-width:2px;background-color: SandyBrown;height: 180px;">
						<form id=\'fpreguntas\' name=\'fpreguntas\' method=\'post\'>
							<input type="hidden" id="email" name="email" value="';
							echo $_SESSION["EMAIL"];
							echo '" />
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
							<input type="button" value="Enviar solicitud" name="submit" id="submit"> 
							<input type="reset" value="Borrar" name="reset">
						</form>
					</article>
				</div>
				<div>
					<h4>VER PREGUNTAS</h4>
					</br>
					<input type="button" value="Ver preguntas" name="verP" id="verP" onClick="cargarTabla()"> 
					</br>
					</br>
					<div id="table-scroll" style="height: 350px;"><table id="tabla" class="scroll" border=1 style="display: none;"> <thead><tr><th> Pregunta </th> <th> Respuesta Correcta </th> <th> Respuestas Incorrectas </th> <th> Complejidad </th> <th> Tema </th> <th> Autor </th> 
						</tr></thead><tbody>
					</tbody></table></div>
				</div>';
					}
					else{
						header("Location: layout.php");
					}
				?>
			</section>
			<footer class='main' id='f1' >
				<p><a href="http://es.wikipedia.org/wiki/Quiz" target="_blank">Que es un Quiz?</a></p>
				<p><a href='https://github.com'>Link GITHUB</a></p>
			</footer>
		</div>
		<script>
			function cargarTabla(){
				xmlhttp = new XMLHttpRequest();
				
				xmlhttp.onreadystatechange = function (){
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
						$("#tabla").find('tbody').empty();
						document.getElementById("tabla").style="display: inline-table;";
						$("#tabla").find('tbody').append( xmlhttp.responseText );
						
					}
				}
				xmlhttp.open("GET", "VerPreguntasAJAX.php", true);
				xmlhttp.send();
			}
			
			$('#submit').click(function(){
				$.ajax({
					type: "POST",
					cache : false,
					url: 'InsertarPreguntaAJAX.php',
					data: $('#fpreguntas').serialize(),
					success: function(data) {
						alert(data);
					},
				});
			});

			function mispreguntas(){
				var miemail = $('#emaillog').text();
				$.post('PreguntasUsuarioAJAX.php', {email : miemail}, function(data) {$("#numPreguntas").text(data);});
			}

			function usuariosConectados(){
				$.post('NumConectadosAJAX.php', 
					function(data) {$("#conectados").text(data);});
			}

			var tmp = setInterval(function(){ mispreguntas() }, 5000);
			var tmp2 = setInterval(function(){ usuariosConectados() }, 5000);
		</script>
	</body>
</html>