<?php

class controllerSalon{

	function estadoMesa(){
			$respuesta = modelSalon::estadoMesa();
		  return $respuesta;
	}
	function ListadoMeseros(){
		  $respuesta = modelSalon::ListadoMeseros();
		  return $respuesta;
 	}
  function Mesero($idMesero){
      $respuesta = modelSalon::Mesero($idMesero);
      return $respuesta;
  }
	function Usuario($idUsuario){
			$respuesta = modelSalon::Usuario($idUsuario);
			return $respuesta;
	}
  function ListadoCategorias(){
      $respuesta = modelSalon::ListadoCategorias();
      return $respuesta;
  }
  function ListadoPlatos($idCategoria){
      $respuesta = modelSalon::ListadoPlatos($idCategoria);
      return $respuesta;
  }
 	function listarComprasDia($x){
			$respuesta = modelInicio::listarComprasDia($x);
			return $respuesta;
	}
	function listarPagosDia($x){
	    $respuesta = modelInicio::listarPagosDia($x);
	    return $respuesta;
  }
	function cambioEstadoMesa($mesa,$estado){
		$datosController = array("NroMesa"=>$mesa,
														 "Estado"=>$estado);
			$respuesta = modelSalon::cambioEstadoMesa($datosController);
	}
	  // MANEJO DE IDPEDIDO
	function crearPedido($idPersonal,$NroMesa){
			modelSalon::crearPedido($idPersonal);
			$ultimoPedido = modelSalon::ultimoIdPedido();

			$respuesta = modelSalon::crearDetalleMesa($NroMesa,$ultimoPedido['idPedido']);
	}
	function idPedido($NroMesa){
			$respuesta = modelSalon::idPedido($NroMesa);
			return $respuesta;
	}
	function idPersonal($idPedido){
			$respuesta = modelSalon::idPersonal($idPedido);
			return $respuesta;
	}
	function idDetallePedido($idPedido){
			$respuesta = modelSalon::idDetallePedido($idPedido);
			return $respuesta;
	}
	function descripcionItem($IdItems){
			$respuesta = modelSalon::descripcionItem($IdItems);
			return $respuesta;
	}
	function pagoPedido($x){
			$respuesta = modelSalon::pagoPedido($x);
			return $respuesta;
	}


	//Cambio de mesa
	public function cambioMesa(){

		if(isset($_POST["mesa1"]) && isset($_POST["mesa2"])){
			$datosController = array("mesa1"=>$_POST["mesa1"],
															 "mesa2"=>$_POST["mesa2"]);
			$estadoMesaMesa1 = modelSalon::verificarEstadoMesa($_POST["mesa1"]);
			$estadoMesaMesa2 = modelSalon::verificarEstadoMesa($_POST["mesa2"]);
			if ($estadoMesaMesa1['Estado'] == 'O' && $estadoMesaMesa2['Estado'] == "L" )
			{
			$IdDetalleMesa = modelSalon::idDetalleMesa($datosController);
			$success = 0; 
			foreach ($IdDetalleMesa as $key => $value) {
				$idDetalleMesaModificar = $value["IdDetalleMesa"];
				$cambioMesaIdDetalleMesa = array("mesa"=>$_POST["mesa2"], "IdDetalleMesa"=>$idDetalleMesaModificar);
				$cambioDeIdMesaDetalle = modelSalon::cambioMesaIdDetalleMesa($cambioMesaIdDetalleMesa);
				if ($cambioDeIdMesaDetalle != 'success') {
					$success++;
				}
			}

				$cambioestadoMesa1 = array("NroMesa" => $_POST["mesa1"], "Estado" => "L");
			    $respuesta1 = modelSalon::cambioEstadoMesa($cambioestadoMesa1);
				$cambioestadoMesa2 = array("NroMesa"=>$_POST["mesa2"], "Estado"=>"O");
				$respuesta2 = modelSalon::cambioEstadoMesa($cambioestadoMesa2);

			if($success == "0"){
				echo '<script>
				swal({
					title: "Cambio",
					text: "Se cambio exitosamente",
					type: "success",
					showCancelButton: false,
					confirmButtonColor: "#3085d6",
					cancelButtonColor: "#d33",
						confirmButtonText: "Ok"
				}).then(function () {
				location = location;
				});
		</script>';
			}
			else{
				echo '<script>
				swal({
					title: "ERROR",
					text: "No se cambio la mesa",
					type: "success",
					showCancelButton: false,
					confirmButtonColor: "#3085d6",
					cancelButtonColor: "#d33",
						confirmButtonText: "Ok"
				}).then(function () {
				location = location;
				});
			</script>';
			}
		}
		else
		{
			echo '<script>
			swal({
				title: "ERROR",
				text: "Se verifique el estado de la mesa",
				type: "error",
				showCancelButton: false,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
					confirmButtonText: "Ok"
			}).then(function () {
			location = location;
			});
		</script>';
		}
	}
		}

		// public function registroMensaje(){
		// 	if(isset($_POST["idDetalle"])){
		// 		$datosController = array(
		// 										"idDetalle"=>$_POST["idDetalle"],
		// 										"mensaje"=>$_POST["mensaje"]);
		// 		$respuesta = modelSalon::registroMensaje($datosController);
		// 		if($respuesta == "success"){
		// 			echo '<script>
		// 			swal({
		// 				title: "Registrado",
		// 				text: "Se registro exitosamente",
		// 				type: "success",
		// 				showCancelButton: false,
		// 				confirmButtonColor: "#3085d6",
		// 				cancelButtonColor: "#d33",
		// 					confirmButtonText: "Ok"
		// 			}).then(function () {
		// 			location = location;
		// 			});
		// 	</script>';
		// 		}
		// 		else{
		// 			echo $respuesta;
		// 		// header("location:index.php");
		// 		}
		// 	}
		// }
		public function reApertura(){
			if(isset($_POST["mesaReapertura"])){
				$idPedidoF = "";
				$res = modelSalon::idPedidoReapertura1($_POST["mesaReapertura"]);
				foreach ($res as $row => $value) {
					# code...
				
				if ($_POST["idA"] == "CAJA") {
					$idPedidoF = $_POST["idPedidoRE"];
				}else{
					$idPedido = modelSalon::idPedidoReapertura($_POST["mesaReapertura"]);
					$idPedidoF = $idPedido['Pedido'];
				}
				$respuesta = modelSalon::reApertura($idPedidoF);
				$datosController = array("Estado"=>'O',
					 "NroMesa"=>$_POST["mesaReapertura"]);
				}
				modelSalon::cambioEstadoMesa($datosController);
				if($respuesta == "success"){
					echo '<script>
					swal({
						title: "ReAperturado",
						text: "La orden se reaperturo exitosamente",
						type: "success",
						showCancelButton: false,
						confirmButtonColor: "#3085d6",
						cancelButtonColor: "#d33",
							confirmButtonText: "Ok"
					}).then(function () {
					location = location;
					});
			</script>';
				}
				else{
					echo $respuesta;
				// header("location:index.php");
				}
			}
		}

		function pedidosPorMesa($mesa){
				$respuesta = modelSalon::pedidosPorMesa($mesa);
				return $respuesta;
		}
		function crearPedidoConNombre(){
		if(isset($_POST["idPersonalNuevaCuenta"])){
		$datosController = array("IdPersonal"=>$_POST["idPersonalNuevaCuenta"],
		                         "NroMesa"=>$_POST["nroMesaNuevaCuenta"],
													 	 "NombreCliente"=>$_POST["clienteNuevaOrden"]);
														 modelSalon::actualizarCombinarPedido($_POST["idPedidoCambiarCompartir"]);
		                         modelSalon::crearPedidoConNombre($datosController);
		                         $ultimoPedido = modelSalon::ultimoIdPedido();
		                   			 $respuesta = modelSalon::crearDetalleMesa($_POST["nroMesaNuevaCuenta"],$ultimoPedido['idPedido']);
														 echo '<script>
														 					location = location;
												 	 				 </script>';
		}
	}

	function cliente($idPedido){
			$respuesta = modelSalon::cliente($idPedido);
			return $respuesta;
	}

	function cambiarNombreCliente(){
		if(isset($_POST["idPedidoCambiarNombre"])){
		$datosController = array("IdPedido"=>$_POST["idPedidoCambiarNombre"],
														 "NombreCliente"=>$_POST["cliente"]);
			$respuesta = modelSalon::cambiarNombreCliente($datosController);
			echo '<script>
							 location = location;
						</script>';
		}
	}

	public function anularTodosLosPedidos(){
		if(isset($_POST["Usuario"])){
			 $verificar = array("Usuario"=>$_POST['Usuario'],
			 										"Clave"=>$_POST['Clave']);
			$IdUsuario = modelSalon::verificarAutorizacion($verificar);
			if(isset($IdUsuario["IdUsuario"])){
			$datosController = array("idPedido"=>$_POST["idPedido"]);
			$respuesta =	modelSalon::anularTodosLosPedidos($datosController);
			$suceso = array("suceso"=>"Se a anulado todos los pedidos de la mesa ".$_POST["NroMesa"],
											"IdPersonal"=>$_POST["idPersonal"],
											"IdUsuario"=>$IdUsuario["IdUsuario"]);
											modelSucesos::registroAnularTodosLosPedidos($suceso);
			if($respuesta == "success"){
				echo '<script>
				swal({
					title: "Anulados",
					text: "Se anularon todos los pedidos exitosamente",
					type: "success",
					showCancelButton: false,
					confirmButtonColor: "#3085d6",
					cancelButtonColor: "#d33",
						confirmButtonText: "Ok"
				}).then(function () {
				location = location;
				});
		</script>';
			}
			else{
				echo $respuesta;
			}
		}
		else {
			echo "<script>
			swal(
			'Error',
			'El usuario o clave son incorrectos',
			'error'
			) </script>";
		}
	}
}



		}
