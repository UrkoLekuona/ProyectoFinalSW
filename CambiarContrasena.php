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
	<nav class='main' id='n1' role='navigation' style="height:140px;">
		
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
    <section class="main" id="s1" style="height:140px;">
			<?php
			require_once('./lib/nusoap-0.9.5/src/nusoap.php');
			
			if(isset($_POST["email"])){
				$encontrado=true;
				$emailencontrado=$_POST["email"];
				
				$soapclient2 = new nusoap_client('http://localhost/LabSeguridad/WebServices/comprobarPass.php?wsdl', true);
				$result2= $soapclient2->call('comprobarPass', array('x'=>$_POST["pass"]));
				$final=trim($result2);
				
				if (strlen($_POST["pass"]) == 0){
					echo '<font color="red">El campo de la contraseña no puede tener 0 caracteres</font>';
				
				}elseif(strcmp($_POST["pass"],$_POST["pass2"])!=0){
					echo '<font color="red">Las contraseñas no coinciden</font>';
				}elseif('INVALIDA'===trim($result2)){
					echo '<font color="red">La contraseña introducida es vulnerable</font>';
				}else{
					$pass=crypt($_POST["pass"], '$5$rounds=5000$usesomesillystringforsalt$');
					include 'connectDB.php';
					$link = connectDB();
					$sql = mysqli_query($link ,"UPDATE USER SET PASS='$pass' WHERE EMAIL='$_POST[email]'");
					echo "<script>alert('La contraseña se ha modificado correctamente');window.location= 'Login.php'</script>";
				}
				
			}else{
				include 'connectDB.php';
				$link = connectDB();
				$sql = mysqli_query($link ,"SELECT EMAIL FROM USER");
				
				$encontrado=false;
				
				while ($row = mysqli_fetch_array( $sql )) {
					if(strcmp(str_replace('$', '', crypt($row['EMAIL'], 'usesomesillystringforsalt$')), $_GET['email']) == 0){
						$encontrado=true;
						$emailencontrado=$row['EMAIL'];
					}
				}
				mysqli_close($link);
			}
			if($encontrado){
				echo '<h4>Recuperar Contraseña</h4><article class="main" id="s2" style="border-style: ridge;border-color: black; border-width:2px;background-color: SandyBrown;height: 100px;">
			<form id="fpreguntas" name="fpreguntas" method="post" enctype="multipart/form-data" action="CambiarContrasena.php">
				Email: <input id="email" name="email" type="text" readonly="readonly" value=\''.$emailencontrado.'\'/>
				<br/>
				Nueva contraseña: <input id="pass" name="pass" type="password"/>
				<br/>
				Repetir contraseña: <input id="pass2" name="pass2" type="password"/>
				</br>
				<input id="button1" type="submit" value="Guardar contraseña"/>
			</form>
			';
				
			echo '</article>';
			}else{
				echo '</br><h3>Este enlace es inválido</h3>';
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
