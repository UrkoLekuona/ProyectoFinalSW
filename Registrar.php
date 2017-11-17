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
		<nav class='main' id='n1' role='navigation' style="height: 300px">
			<span><a href='layout.php'>Inicio</a></span>
			<span><a href='creditos.php'>Creditos</a></span>
		</nav>
			<section class="main" id="s1" style="height: 300px">
				<h4>REGISTRO</h4>
				<article class="main" id="s2" style="border-style: ridge;border-color: black; border-width:2px;background-color: SandyBrown;height: 275px;">
					<form id='fpreguntas' name='fpreguntas' action="Registrar.php" method="post" enctype="multipart/form-data">
						<br/>
						Email*: <input id="email" name="email"/>
						<br/>
						Nombre*: <input id="nombre" name="nombre" type="text"/>
						<br/>
						Apellidos*: <input id="apellidos" name="apellidos" type="text"/>
						<br/>
						Nickname*: <input id="nick" name="nick" type="text"/>
						<br/>
						Contraseña*: <input id="pass" name="pass" type="password"/>
						<br/>
						Repetir contraseña*: <input id="pass2" name="pass2" type="password"/>
						<br/>
						<input type="file" id="imagen" name="imagen" accept="image/*" onchange="cargarFoto(this)" onload="this.value=null">
						<br/>
						<p> <img id = "foto" name="foto"> </p>
						<input type="submit" value="Enviar solicitud" name="submit" id="submit"> 
						<input type="reset" value="Borrar" name="reset" onclick="borrarFoto()">
						<br/>
						<?php
						require_once('/lib/nusoap.php');
						require_once('/lib/class.wsdlcache.php');
						
						if (isset($_POST["email"])){
							if (strlen($_POST["email"]) == 0){
								echo "<script type='text/javascript'>alert('El campo del email está vacío');</script>";
								die();
							}
							/*$pattern='/^[a-z]{2,}[0-9]{3}@ikasle\.ehu\.(eus|es)$/';
							if (preg_match($pattern, $_POST["email"]) === 0){
								echo "<script type='text/javascript'>alert('El email no es válido, tiene que acabar en @ikasle.ehu.eus o @ikasle.ehu.es');</script>";
								die();
							}*/
							$soapclient= new nusoap_client('http://ehusw.es/jav/ServiciosWeb/comprobarmatricula.php?wsdl', true);
							$result= $soapclient->call('comprobar', array('x'=>$_POST["email"]));
							if('NO'===trim($result)){
								echo "<script type='text/javascript'>alert('El email introducido no es VIP');</script>";
								die();
							}
							if (strlen($_POST["nombre"]) == 0){
								echo "<script type='text/javascript'>alert('El campo del nombre está vacío');</script>";
								die();
							}
							if (strlen($_POST["apellidos"]) == 0){
								echo "<script type='text/javascript'>alert('El campo del apellido está vacío');</script>";
								die();
							}
							if (strlen($_POST["nick"]) == 0){
								echo "<script type='text/javascript'>alert('El campo del nickname está vacío');</script>";
								die();
							}
							if (strlen($_POST["pass"]) == 0){
								echo "<script type='text/javascript'>alert('El campo de la contraseña no puede tener 0 caracteres');</script>";
								die();
							}
							if (strcmp($_POST["pass"], $_POST["pass2"]) != 0){
								echo "<script type='text/javascript'>alert('Las contraseñas no pueden ser diferentes');</script>";
								die();
							}
							$soapclient2 = new nusoap_client('http://localhost/Lab5/WebServices/samples/comprobarPass.php?wsdl', true);
							$result= $soapclient->call('comprobarPass', array('x'=>$_POST["pass"]));
							if('INVALIDA'===trim($result)){
								echo "<script type='text/javascript'>alert('La contraseña introducida es vulnerable');</script>";
								die();
							}
							
							include 'connectDB.php';
							
							$link = connectDB();
							$nombreC = $_POST["nombre"] . " " . $_POST["apellidos"];
							$sql="INSERT INTO user(EMAIL, NOMBRE, NICK, PASS) VALUES ('$_POST[email]', '$nombreC', '$_POST[nick]', '$_POST[pass]')";

							if (!mysqli_query($link ,$sql)){
									$error = mysqli_error($link);
									echo "Error: $error";
							}
							else{
								$emailquery = mysqli_query($link, "SELECT EMAIL FROM user WHERE EMAIL='$_POST[email]'" );
								$email=mysqli_fetch_array( $emailquery );
								if (isset($_FILES["imagen"]) && ( $_FILES["imagen"]["type"]=="image/jpeg" || $_FILES["imagen"]["type"]=="image/png" || $_FILES["imagen"]["type"]=="image/jpg")){
									$origen=$_FILES["imagen"]["tmp_name"]; 
									$imagen="Imagen_".$email[0].select_type($_FILES["imagen"]["type"]);
									move_uploaded_file($origen, $folder."fotos_usuario/".$imagen);
								}
								else{
									$origen="$folder"."fotos_usuario/"."usuario_def.jpg"; 
									$imagen="Imagen_".$email[0].".jpg";
									copy($origen, $folder."fotos_usuario/".$imagen);
								}
								$update="UPDATE user SET IMAGEN='$imagen' WHERE EMAIL='$email[0]'";
								if (!mysqli_query($link ,$update)){
									echo 'Error: ' . mysqli_error($link);
									die();
								}else{
									echo "<script type='text/javascript'>alert('Usuario registrado correctamene!');</script>";
								}
							}
							mysqli_close($link);
						}
						
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
					</form>
				</article>
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
					document.getElementById("n1").style="height: 400px;";
					document.getElementById("s1").style="height: 400px;";
					document.getElementById("foto").width=150;
					document.getElementById("foto").height=150;
					document.getElementById("foto").style.display="initial";
					document.getElementById("s2").style="border-style: ridge;border-color: black; border-width:2px;background-color: SandyBrown;height: 380px;";
					reader.readAsDataURL(im.files[0]);
				}
			}
			
			function borrarFoto(){
				document.getElementById("n1").style="height: 300px;";
				document.getElementById("s1").style="height: 300px;";
				document.getElementById("foto").style.display = "none";
				document.getElementById("s2").style="border-style: ridge;border-color: black; border-width:2px;background-color: SandyBrown;height: 275px;";
			}
		</script>
	</body>
</html>