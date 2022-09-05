<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<title>Ejercicio</title>

	<!-- HOJAS DE ESTILO -->
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/style_gral.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css"/>
</head>
<body>
	<header>
		<div id="header">
			<div class="container">
				<div class="row">
					<div id="logo" class="col-md-3 col-xs-12">
						<img src="img/logo.png">
					</div>
				</div>
			</div>
		</div>
	</header>
	<div class="container">
		<div class="row">
			<div class="col-md-12 ordenar-box">
				<select id="seleccionar">
					<option value="0">Ordenar por</option>
					<option value="asc">Ascendente</option>
					<option value="desc">Descendente</option>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="usuarios-box">
					<?php if(isset($html)) echo $html ?>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="usuarios-detalle">
				</div>
			</div>
		</div>
	</div>
	<!-- INCLUIR SCRIPTS -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.js"></script>
	<script>
		$(document).ready(function(){
			
			mostrarUsuarios(); // INICIAMOS CON LA FUNCIÓN MOTRAR USUARIOS
			$('#seleccionar').change(function(e) {
				e.preventDefault();
				var seleccion = $(this).val(); // OBTENEMOS VALOR DEL SELECTOR
				var action = "ordenar"; // DECLARAMOS VARIABLE ACCIÓN
				if(seleccion != 0){  // SI EL SELECTOR ES DIFERENTE A 0
					$.ajax({ // EJECUTAMOS FUNCIONA AJAX
	                  url: 'includes/consultas.php',
	                  type: 'post',
	                  dataType: 'json',
	                  cache: false,
	                  data: {action:action, ordenar:seleccion}, // ENVIAMOS VARIABLES
	                  success: function(data) { // RETORNO DE AJAX
	                      if(data.mensaje == 'error')
	                      {
	                          return false;

	                      }
	                      else if(data.mensaje == 'success'){ // SI ES SUCCESS LA RESPUESTA 
	                      	$('.usuarios-box').html(data.info); // AGREGAMOS INFO A DIV CON CLASS USUARIOS-BOX
	                      	 $('html, body').stop().animate({ // HACEMOS UN SCROLL HACIA EL DIV
		                        scrollTop: jQuery('.usuarios-box').offset().top
		                    }, 1000);
	                     
	                      }
	                  }       
	              });
				}
				else{
					return false;
				}
			});

			function mostrarUsuarios(){
				var action = "mostrar"; // DECLARAMOS VARIABLE ACCIÓN
				$.ajax({ // EJECUTAMOS FUNCIONA AJAX
	                  url: 'includes/consultas.php',
	                  type: 'post',
	                  dataType: 'json',
	                  cache: false,
	                  data: {action:action}, // ENVIAMOS VARIABLES
	                  success: function(data) {
	                      if(data.mensaje == 'error')
	                      {
	                          
	                          return false;


	                      }
	                      else if(data.mensaje == 'success'){ // SI ES SUCCESS LA RESPUESTA 
	                      	$('.usuarios-box').html(data.info); // AGREGAMOS INFO A DIV CON CLASS USUARIOS-BOX
	                      	 $('html, body').stop().animate({ // HACEMOS UN SCROLL HACIA EL DIV
		                        scrollTop: jQuery('.usuarios-box').offset().top
		                    }, 1000);
	                     
	                      }
	                  }       
	              });
			}
		})
	</script>

</body>
</html>