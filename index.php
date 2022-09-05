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
			
			mostrarUsuarios();
			$('#seleccionar').change(function(e) {
				e.preventDefault();
				var seleccion = $(this).val();
				var action = "ordenar";
				if(seleccion != 0){ 
					$.ajax({
	                  url: 'includes/consultas.php',
	                  type: 'post',
	                  dataType: 'json',
	                  cache: false,
	                  data: {action:action, ordenar:seleccion},
	                  success: function(data) {
	                      if(data.mensaje == 'error')
	                      {
	                          
	                          return false;


	                      }
	                      else if(data.mensaje == 'success'){
	                      	$('.usuarios-box').html(data.info);
	                      	 $('html, body').stop().animate({
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
				var action = "mostrar";
				$.ajax({
	                  url: 'includes/consultas.php',
	                  type: 'post',
	                  dataType: 'json',
	                  cache: false,
	                  data: {action:action},
	                  success: function(data) {
	                      if(data.mensaje == 'error')
	                      {
	                          
	                          return false;


	                      }
	                      else if(data.mensaje == 'success'){
	                      	$('.usuarios-box').html(data.info);
	                      	 $('html, body').stop().animate({
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