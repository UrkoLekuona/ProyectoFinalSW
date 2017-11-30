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
	<nav class='main' id='n1' role='navigation' style="height:100px;">
		
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
    <section class="main" id="s1" style="height:100px;">
		<h4>Recuperar Contraseña</h4>
			<article class="main" id="s2" style="border-style: ridge;border-color: black; border-width:2px;background-color: SandyBrown;height: 80px;">
				<form id='fpreguntas' name='fpreguntas' method="post" enctype="multipart/form-data">
					<br/>
					Email: <input id="email" name="nick" type="text"/>
					<br/>
					<input id="button1" type="button" value="Recuperar Contraseña"/>
				</form>
				<script>
					$("#button1").click(function(){
						var miemail = $("#email").val();
						$.post('RecuperarContrasenaAJAX.php', {email : miemail}, function(data) {alert(data);});
					});
				</script>
			</article>
    </section>
	<footer class='main' id='f1'>
		<p><a href="http://es.wikipedia.org/wiki/Quiz" target="_blank">Que es un Quiz?</a></p>
		<p><a href='https://github.com'>Link GITHUB</a></p>
	</footer>
</div>
</body>
</html>
