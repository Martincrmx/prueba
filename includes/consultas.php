<?php 

if(isset($_POST['action']) && $_POST['action'] == "verDetalles"){
	// VARIABLES INICIALES
	$id = $_POST['id'];
	$consultar_url = "https://reqres.in/api/users/".$id; // ALMACENAMOS LA VARIABLE A CONSULTAR
	$consulta = new Consulta(); 
	// LLAMAMOS A LA FUNCIÓN CONSULTAR USUARIOS
	$usuarios = $consulta->ConsultarUsuarios($consultar_url, $id);
	var_dump($usuarios);
}
if(!$_POST){
	// VARIABLES INICIALES
	$consultar_url = "https://reqres.in/api/users/"; // ALMACENAMOS LA VARIABLE A CONSULTAR

	// INICIAMOS LA LLAMADA A LA CLASE CONSULTA
	$consulta = new Consulta(); 
	// LLAMAMOS A LA FUNCIÓN CONSULTAR USUARIOS
	$usuarios = $consulta->ConsultarUsuarios($consultar_url);
	// INICIAMOS LA LLAMADA A LA CLASE HTML ESTRUCTURA
	$consultaHtml = new HtmlEstructura(); 
	// LLAMAMOS A LA FUNCION ARMAR HTML
	$html = $consultaHtml->armarHtml($usuarios, "asc", $id);
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
					$html .= "<div class='col-md-4 col-xs-12 usuario-box'>
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

			}
		}
	}
?>