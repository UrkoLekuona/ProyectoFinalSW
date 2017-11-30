<?PHP
session_start ();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
			<title>Registro</title>
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
			<span class="right"><a href="Registrar.php">Registrarse</a></span>
				<span class="right"><a href="Login.php">Login</a></span>
				<span class="right" style="display:none;"><a href="/logout">Logout</a></span>
			<h2>Quiz: el juego de las preguntas</h2>
		</header>
		<nav class='main' id='n1' role='navigation' style="height: 160px">
			<span><a href='layout.php'>Inicio</a></span>
			<span><a href='creditos.php'>Creditos</a></span>
		</nav>
			<section class="main" id="s1" style="height: 160px">
				<h4>LOGIN</h4>
				<article class="main" id="s2" style="border-style: ridge;border-color: black; border-width:2px;background-color: SandyBrown;height: 120px;">
					<form id='fpreguntas' name='fpreguntas' method="post" enctype="multipart/form-data">
						<br/>
						Email: <input id="email" name="nick" type="text"/>
						<br/>
						Contraseña: <input id="pass" name="pass" type="password"/>
						<br/>
						<input type="submit" value="Enviar solicitud" name="submit" id="submit"> 
						<br/> 
						<?php 
						if(isset($_SESSION['EMAIL'])){
							header("Location:layout.php");
						}
						else{
							if (isset($_POST["nick"])){
								if (!isset($_SESSION["intentos"])){
									$_SESSION["intentos"]=0;
								}
								if ($_SESSION["intentos"]<3){
									include 'connectDB.php';
									
									$enc_password = crypt($_POST["pass"], '$5$rounds=5000$usesomesillystringforsalt$');
									
									$link = connectDB();
									$sql = mysqli_query($link ,"SELECT EMAIL, ROL, IMAGEN FROM user WHERE EMAIL='$_POST[nick]' AND PASS='$enc_password'");
									$cont= mysqli_num_rows($sql);
									mysqli_close($link);
									
									if($cont==1){
										$row = mysqli_fetch_array( $sql );
										$_SESSION['EMAIL'] = $row['EMAIL'];
										$_SESSION['IMAGEN'] = $row['IMAGEN'];
										$_SESSION['ROL'] = $row['ROL'];
										$xml = simplexml_load_file("contador.xml");

										$xml->value=$xml->value+1;

										$xml->asXML('contador.xml');
										echo "<script>alert('Bienvenido, $_SESSION[EMAIL]!');window.location= 'layout.php'</script>";
									}
									else {
										$_SESSION["intentos"]++;
										echo ("Parámetros de login incorrectos</br>");
										echo ($_SESSION["intentos"]."/3 intentos");
									}
								}
								else{
									echo ("Has superado el número máximo de intentos para iniciar sesión.");
								}
							}
						}
						?> 
					</form>
				</article>
				<a href="RecuperarContrasena.php">¿Has olvidado la contraseña?</a>
			</section>
			<footer class='main' id='f1' >
				<p><a href="http://es.wikipedia.org/wiki/Quiz" target="_blank">Que es un Quiz?</a></p>
				<p><a href='https://github.com'>Link GITHUB</a></p>
			</footer>
		</div> 
	</body>
</html>