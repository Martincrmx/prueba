<?php 

if(isset($_POST['action']) && $_POST['action'] == "verDetalles"){
	// VARIABLES INICIALES
	$id = $_POST['id'];
	$consultar_url = "https://reqres.in/api/users/".$id; // ALMACENAMOS LA VARIABLE A CONSULTAR
	$consulta = new Consulta(); 
	// LLAMAMOS A LA FUNCIÓN CONSULTAR USUARIOS
	$usuarios = $consulta->ConsultarUsuarios($consultar_url, $id);
	// INICIAMOS LA LLAMADA A LA CLASE HTML ESTRUCTURA
	$consultaHtml = new HtmlEstructura(); 
	// LLAMAMOS A LA FUNCION ARMAR HTML
	$html = $consultaHtml->armarHtml($usuarios, NULL, $id);

	if($html != NULL){ // SI VARIABLE HTML ES DIFERENTE A NULL
		$data['info'] = $html;
		$data['mensaje'] = "success";  // ENVIAMOS UN MENSAJE DE SUCESS
	}
	else{
		$data['info'] = "";
		$data['mensaje'] = "error"; // ENVIAMOS UN MENSAJE DE ERROR

	}

	echo json_encode($data);
}
else if(isset($_POST['action']) && $_POST['action'] == "ordenar"){
	// VARIABLES INICIALES
	$ordenar = $_POST['ordenar'];
	$consultar_url = "https://reqres.in/api/users/"; // ALMACENAMOS LA VARIABLE A CONSULTAR
	$consultar = new Consulta(); 
	// LLAMAMOS A LA FUNCIÓN CONSULTAR USUARIOS
	$usuarios = $consultar->ConsultarUsuarios($consultar_url);
	// INICIAMOS LA LLAMADA A LA CLASE HTML ESTRUCTURA
	$consultaHtml = new HtmlEstructura(); 
	// LLAMAMOS A LA FUNCION ARMAR HTML
	$html = $consultaHtml->armarHtml($usuarios, $ordenar, NULL);

	if($html != NULL){
		$data['info'] = $html;
		$data['mensaje'] = "success"; // ENVIAMOS MENSAJE DE SUCCESS
	}
	else{
		$data['info'] = "";
		$data['mensaje'] = "error"; // ENVIAMOS UN MENSAJE DE ERROR

	}

	echo json_encode($data);
	
}
else if(isset($_POST['action']) && $_POST['action'] == "mostrar"){
	// VARIABLES INICIALES
	$consultar_url = "https://reqres.in/api/users/"; // ALMACENAMOS LA VARIABLE A CONSULTAR

	// INICIAMOS LA LLAMADA A LA CLASE CONSULTA
	$consulta = new Consulta(); 
	// LLAMAMOS A LA FUNCIÓN CONSULTAR USUARIOS
	$usuarios = $consulta->ConsultarUsuarios($consultar_url);
	// INICIAMOS LA LLAMADA A LA CLASE HTML ESTRUCTURA
	$consultaHtml = new HtmlEstructura(); 
	// LLAMAMOS A LA FUNCION ARMAR HTML
	$html = $consultaHtml->armarHtml($usuarios, "asc");

	if($html != NULL){ // SI LA VARIABLE ES DIFERENTE A NULL
		$data['info'] = $html;
		$data['mensaje'] = "success"; // ENVIAMOS MENSAJE DE SUCCESS
	}
	else{ // SI ES NULL
		$data['info'] = "";
		$data['mensaje'] = "error"; // ENVIAMOS UN MENSAJE DE ERROR

	}

	echo json_encode($data);
}



	Class Consulta{

		public function ConsultarUsuarios($url){
			
			$resultado = file_get_contents($url); // UTILIZAMOS LA FUNCION FILES GETS CONTENT PARA CONSULTAR LA URL
			$resultadoDecodificado = json_decode($resultado , true); // EL RESULTADO NOS DEVUELVE UN JSON EL CUAL DECODIFICAMOS Y ALMACENAMOS EL RESULTADO
			$usuarios = $resultadoDecodificado['data']; // ALMACENAMOS LA DATA EN UNA VARIABLE PARA RETORNAR LA FUNCION Y MOSTRAR LOS VALORES
			return $usuarios;
		}
	}

	Class HtmlEstructura{

		public function armarHtml($usuarios, $orden = NULL, $id = NULL){
			if($id == NULL){
				$contador = 0;
				$html = "";// DECLARAMOS VARIABLE HTML PARA ALMACENAR ESTRUCTURA

				// VERIFICAMOS EL ORDEN A MOSTRAR
				if($orden == "asc" || $orden == NULL){ // SI ES ASCENDENTE 
					$usuarios_ordenados = $usuarios;
				}
				else if($orden == "desc"){ // SI ES DESCENDENTE ORDENAMOS
					$usuarios_ordenados = array_reverse($usuarios); // FUNCION PARA ORDENAR DE FORMA DESCENDENTE ARREGLO
				}
				

				for($i = 0; $i<count($usuarios_ordenados); $i++){ // RECORREMOS EL ARRAY PARA IMPRIMIR
					if($contador == 0){// SI EL CONTADOR ES IGUAL A 0 ABRIMOS DIV CON CLASE ROW
						$html .= "<div class='row row-usuario'>"; // INICIAMOS ESTRUCTURA HTML 
					}

					// INICIAMOS EL ARMADO DEL HTML A MOSTRAR
					$html .= "<div class='col-md-4 col-xs-12 usuario-col'>
								<div class='usuario-box'>
									<div class='img-box'>
										<img src='".$usuarios_ordenados[$i]['avatar']."'>
									</div>
									<div class='usuario-info'>
										<h5>".$usuarios_ordenados[$i]['first_name']." ".$usuarios_ordenados[$i]['last_name']."</h5>
										<div class='usuarios-info-texto'>
											<p><i class='fa fa-envelope' aria-hidden='true'></i>
											".$usuarios_ordenados[$i]['email']."</p>
											<div class='usuarios-btn'>
												<a href='#' class='btn btn-primary btn-detalle' data-id='".$usuarios_ordenados[$i]['id']."'>Ver detalle</a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<script>
								$('body').on('click', '.btn-detalle',  function(e){
									e.preventDefault();
									var id = $(this).data('id');
									var action = 'verDetalles';
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
					                      	$('.usuarios-detalle').html(data.info);
					                      	 $('html, body').stop().animate({
						                        scrollTop: jQuery('.usuarios-detalle').offset().top
						                    }, 1000);
					                     
					                      }
					                  }       
					              });
								});
							</script>
					";
					$contador++;
					if($contador == 3 || $i == count($usuarios_ordenados)){ // SI EL CONTADOR ES IGUAL A 3 O LA VARIABLE I ES IGUAL A EL TOTAL DEL ARRAY USUARIOS CERRAMOS EL DIV CON LA CLASE ROW
						$html .= "</div>";
						$contador = 0; // CUANDO SE CUMPLE LA CONDICION PONEMOS LA VARIABLE A 0

					}


				}

				return $html; // RETORNAMOS VARIABLE
			}
			else{
				$html = "";// DECLARAMOS VARIABLE HTML PARA ALMACENAR ESTRUCTURA
				$html .= "<div class='row'><div class='col-md-12'><h2>Detalles de Usuario</div></div>";
				$html .= "<div class='row'>
					<div class='col-md-12 detalle-bg'>
						<div class='row'>
							<div class='col-md-3 col-xs-12 img-detalle'>
								<img src='".$usuarios['avatar']."'>
							</div>
							<div class='col-md-9 col-xs-12 info-detalle'>
								<h4>ID: ".$usuarios['id']."</h4>
								<h3>".$usuarios['first_name']." ".$usuarios['last_name']."</h3>
								<div class='info-detalle-texto'><i class='fa fa-envelope' aria-hidden='true'></i> Email: <a href='mailto:".$usuarios['email']."'>".$usuarios['email']."</a></div>
							</div>
						</div>
					</div>
				</div>
				";

				return $html;
			}
		}
	}
?>