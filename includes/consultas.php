<?php 


if(!$_POST){
	// VARIABLES INICIALES
	$consultar_url = "https://reqres.in/api/users/"; // ALMACENAMOS LA VARIABLE A CONSULTAR

	// INICIAMOS LA LLAMADA A LA CLASE CONSULTA
	$consulta = new Consulta(); 
	// LLAMAMOS A LA FUNCIÓN CONSULTAR USUARIOS
	$usuarios = $consulta->ConsultarUsuarios($consultar_url);
}



	Class Consulta{

		public function ConsultarUsuarios($url){
			
			$resultado = file_get_contents($url); // UTILIZAMOS LA FUNCION FILES GETS CONTENT PARA CONSULTAR LA URL
			$resultadoDecodificado = json_decode($resultado , true); // EL RESULTADO NOS DEVUELVE UN JSON EL CUAL DECODIFICAMOS Y ALMACENAMOS EL RESULTADO
			$usuarios = $resultadoDecodificado['data']; // ALMACENAMOS LA DATA EN UNA VARIABLE PARA RETORNAR LA FUNCION Y MOSTRAR LOS VALORES
			return $usuarios;
		}
	}
?>