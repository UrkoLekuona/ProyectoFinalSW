<?php
	header("Content-type: text/html; charset=utf8");
	
	include 'connectDB.php';
		
	$link = connectDB();
	$sql="SELECT NICK FROM USER WHERE EMAIL='$_POST[email]'";

	$result=mysqli_query($link ,$sql);
	if (!$result){
			echo 'Error: ' . mysqli_error($link);
			die();
	}
	else{
		if(mysqli_num_rows($result)!=1){
			echo 'El email introducido no está registrado';
		}else{
			$emailcifrado = crypt($_POST['email'], 'usesomesillystringforsalt$');
			$emailcifrado = str_replace('$', '', $emailcifrado);
			$enlace = "http://localhost/LabSeguridad/CambiarContrasena.php?email=".$emailcifrado;
			$mensaje = "Has solicitado cambiar la contrasena en tu cuenta de https://urkolekuona.000webhostapp.com/ . Haz click en el siguiente enlace para introducir una contrasena nueva: \r\n $enlace \r\n Si no has solicitado el cambio de contrasena, por favor ignora este mensaje.";
			#$mensaje = wordwrap($mensaje, 70, "\r\n");
			mail($_POST['email'], 'Recuperación de contraseña', $mensaje);
			echo 'Email enviado, por favor revisa tu bandeja de entrada';
		}
	}
	mysqli_close($link);
?>