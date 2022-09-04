<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<title>Ejercicio</title>
	<!-- LLAMADA AL ARCHIVO CONSULTA -->
	<?php require_once('includes/consultas.php'); ?>
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
			$('.btn-detalle').click(function(e){
				e.preventDefault();
				var id = $(this).data('id');
				var action = "verDetalles";
				$.ajax({
	                  url: 'includes/consultas.php',
	                  type: 'post',
	                  dataType: 'json',
	                  cache: false,
	                  data: {action:action, id:id},
	                  success: function(data) {
	                    console.log(data);
	                      if(data.mensaje == 'error')
	                      {
	                          
	                          return false;


	                      }
	                      else if(data.mensaje == 'success'){
	                        
	                     
	                      }
	                  }       
	              }); 
			});
		})
	</script>

</body>
</html>