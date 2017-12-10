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
			<style> #map {
						height: 40%;
					}
			</style>
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
		<nav class='main' id='n1' role='navigation' style="height: 100%;">
			<?php
			if (isset($_SESSION['EMAIL']) && $_SESSION['ROL']==0){
				echo "<span><a href='layout.php'>Inicio</a></span>
				<span><a href='GestionarPreguntas.php'>Gestionar Preguntas</a></span><span><a href='creditos.php'>Creditos</a></span>";
			}
			elseif(isset($_SESSION['EMAIL']) && $_SESSION['ROL']==1){
				echo "<span><a href='layout.php'>Inicio</a><span><a href='RevisarPreguntas.php'>Revisar Preguntas</a></span><span><a href='EliminarPregunta.php'>Eliminar Preguntas</a></span><span><a href='creditos.php'>Creditos</a></span>";
			}else{
				echo "<span><a href='layout.php'>Inicio</a></span><span><a href='Jugar.php'>¿Cuánto sabes?. Pruébame
				</a></span><span><a href='creditos.php'>Creditos</a></span>";
			}
			?>
		</nav>
			<section class="main" id="s1" style="height: 100%;">
			<img src="fotos/autores.jpg" alt="autores" style="width:290px;height:200px;" align="right">
			<div>
				
				<h3>Aplicación desarrollada por Urko Lekuona e Iñigo Gómez</h3>
				<br/>
				<h3>para Sistemas Web</h3>
				<br/>
				<h3>Alumnos de la Facultad de Informática de la UPV/EHU</h3>
				<br/>
				
			</div>
			<br/>
			<br/>
			<div id="map" style="height: 350px"></div>
			<script>
				function initMap() {
					var map = new google.maps.Map(document.getElementById('map'), {
					  center: {lat: -34.397, lng: 150.644},
					  zoom: 6
					});
					var infoWindow = new google.maps.InfoWindow({map: map});
				}
				
				function updateMap(latitude, longitude){
					var map = new google.maps.Map(document.getElementById('map'), {
					  center: {lat: -34.397, lng: 150.644},
					  zoom: 6
					});
					var infoWindow = new google.maps.InfoWindow({map: map});
					
					var pos = {
					lat: latitude,
					lng: longitude};
					infoWindow.setPosition(pos);
					infoWindow.setContent('Tu ubicación.');
					map.setCenter(pos);
				}
				
			</script>
			<?php $API_key="AIzaSyCxSNonNu3os9th-rmbpfbvNyV9zcPJ-DI";?>
			<script async defer
			src="https://maps.googleapis.com/maps/api/js?key=<?php echo $API_key; ?>&callback=initMap">
			</script>
			<div id="table-scroll" style="wide: 30%;">
				<table id="GeoResults"></table>
			</div>
			<article class="main" id="s2" style="border-style: ridge;border-color: black; border-width:2px;background-color: SandyBrown;">
			<h1>Petición a un servicio web mediante PHP</h1>
			<form id='fpreguntas' name='fpreguntas' action="creditos.php" method="post" enctype="multipart/form-data">
					<input id="ip" name="ip" type="hidden"/>
					<?php
						require_once('./lib/nusoap-0.9.5/src/nusoap.php');
								
						if (isset($_POST["ip"])){
							$soapclient= new nusoap_client('http://www.webservicex.com/geoipservice.asmx?wsdl', true);
							$result= $soapclient->call('GetGeoIP', array('IPAddress'=>$_POST["ip"]));
							
							echo "Tu IP: " . $result["GetGeoIPResult"]["IP"] . "</br>";
							echo "Tu País: " . $result["GetGeoIPResult"]["CountryName"] . "</br>";
						}
						
					?>
				<input type="submit" value="Enviar solicitud" name="submit" id="submit"> 
			</form>
			</article>
			<script>
				$.getJSON("http://ip-api.com/json/?callback=?", function(data) {
					var table_body = "";
					document.getElementById("ip").value=data["query"];
					table_body += "<tr><td>IP: </td><td><b>" + data["query"] + "</b></td></tr>";
					table_body += "<tr><td>Proveedor: </td><td><b>" + data["isp"] + "</b></td></tr>";
					table_body += "<tr><td>Latitud: </td><td><b>" + data["lat"] + "</b></td></tr>";
					table_body += "<tr><td>Longitud: </td><td><b>" + data["lon"] + "</b></td></tr>";
					table_body += "<tr><td>País: </td><td><b>" + data["country"] + "</b></td></tr>";
					table_body += "<tr><td>Ciudad: </td><td><b>" + data["city"] + "</b></td></tr>";
					table_body += "<tr><td>Código Postal: </td><td><b>" + data["zip"] + "</b></td></tr>";
					$("#GeoResults").html(table_body);
					updateMap(data["lat"], data["lon"]);
				});
			</script>
			</section>
			<footer class='main' id='f1'>
				<p><a href="http://es.wikipedia.org/wiki/Quiz" target="_blank">Que es un Quiz?</a></p>
				<p><a href='https://github.com'>Link GITHUB</a></p>
			</footer>
		</div>
	</body>
</html>