<?php 


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
	$html = $consultaHtml->armarHtml($usuarios, "asc");
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

		public function armarHtml($usuarios, $orden){
			var_dump($usuarios);
			$contador = 0;
			$html = "";// DECLARAMOS VARIABLE HTML PARA ALMACENAR ESTRUCTURA

			// VERIFICAMOS EL ORDEN A MOSTRAR
			if($orden == "asc"){ // SI ES ASCENDENTE 
				$usuarios_ordenados = $usuarios;
			}
			else if($orden == "desc"){ // SI ES DESCENDENTE ORDENAMOS
				$usuarios_ordenados = array_reverse($usuarios);
			}
			

			for($i = 0; $i<count($usuarios_ordenados); $i++){
				if($contador == 0){
					$html .= "<div class='row'>";
				}

				$html .= "<div class='col-md-4 col-xs-12 usuario-box'>
							<div class='img-box'>
								<img src='".$usuarios_ordenados[$i]['avatar']."'>
							</div>
							<div class='usuario-info'>
								<h5>".$usuarios_ordenados[$i]['first_name']." ".$usuarios_ordenados[$i]['last_name']."</h5>
								<div class='usuarios-info-texto'>
									'<i class='fa fa-envelope' aria-hidden='true'></i>'
									".$usuarios_ordenados[$i]['email']."
								</div>
							</div>
						</div>
				";
				$contador++;
				if($contador == 3 || $i == count($usuarios)){
					$html .= "</div>";
					$contador = 0;

				}


			}

			return $html;
		}
	}
?>