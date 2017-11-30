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
	<nav class='main' id='n1' role='navigation' style="height: 325px">
		
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
    <section class="main" id="s1" style="height: 325px">
		<?php
		if (isset($_SESSION['EMAIL']) && $_SESSION['ROL']==1){
			$xml = simplexml_load_file("preguntas.xml");
			
			echo '<div id="table-scroll"><table class="scroll" border=1> <thead><tr><th> ID </th><th> Autor </th> <th> Pregunta </th> <th> Respuesta Correcta </th><th> Respuesta Incorrecta 1</th><th> Respuesta Incorrecta 2</th><th> Respuesta Incorrecta 3</th><th> Complejidad </th> <th> Tema </th> </tr></thead><tbody align="center">';
			
			foreach($xml->children() as $child){
				$id = $child['id'];
				$autor = $child['author'];
				$comp = $child['complexity'];
				$tema = $child['subject'];
				$pregunta = $child->itemBody->p;
				$rc = $child->correctResponse->value;
				echo "<tr><td class='nocambiar'>$id</td><td class='nocambiar'> $autor </td> <td> $pregunta </td> <td> $rc </td>";
				foreach($child->incorrectResponses->children() as $ri){
					echo "<td> $ri </td>";
				}
				echo "<td> $comp </td><td> $tema </td></tr>";
			}
			echo '</tbody></table></div>';
		}
		else{
			header("Location: layout.php");
		}
		?>
		<div>
			<font size=4 color=grey>Nota: Haz click sobre una celda para modificarla</font>
		</div>
		<script>
		$('td').mouseover(function(){
			if($(this).hasClass("nocambiar")==false){
				$(this).css('cursor','pointer');
			}
		});
		$('td').click(function(){
			var td = $(this);
			var viejovalor = $(this).html();
			//console.log(viejovalor);
			if($(this).hasClass("nocambiar")==false){
				var answer = prompt("Insertar nuevo valor", '');
				if(answer != null){ 
					$(this).html( answer );
					var $row = $(this).closest("tr");
					$tds = $row.find("td");
					
					var id = parseInt($tds[0].innerHTML);
					var autor = $tds[1].innerHTML.toString();
					var pregunta = $tds[2].innerHTML.toString();
					var rc = $tds[3].innerHTML.toString();
					var ri1 = $tds[4].innerHTML.toString();
					var ri2 = $tds[5].innerHTML.toString();
					var ri3 = $tds[6].innerHTML.toString();
					var comp = parseInt($tds[7].innerHTML);
					var tema = $tds[8].innerHTML.toString();
					
					$.ajax({
						type: "POST",
						cache : false,
						url: 'ModificarPreguntaAJAX.php',
						data: { id: id, autor: autor, pregunta: pregunta, rc: rc, ri1: ri1, ri2: ri2, ri3: ri3, comp: comp, tema: tema },
						success: function(data) {
							if(data.localeCompare("Pregunta modificada correctamente!") != 0){
								td.html( viejovalor );
							}
							alert(data);
						},
					});
				}	
			}
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