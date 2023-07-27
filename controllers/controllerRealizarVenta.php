<?php
	// require __DIR__ . '../../views/autoload.php';
	// use Mike42\Escpos\Printer;
	// use Mike42\Escpos\EscposImage;
	// use Mike42\Escpos\PrintConnectors\FilePrintConnector;
	// use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

 	function truncateFloat($number, $digitos){
		$raiz = 10;
		$multiplicador = pow ($raiz,$digitos);
		$resultado = ((int)($number * $multiplicador)) / $multiplicador;
		return number_format($resultado, $digitos);
	}

	class controllerRealizarVenta {

		public function registroPagoC(){
    		if(isset($_POST["idPedido"])){
				if($_POST["comprobante"] == "T"){
      				$evitarDuplicacion = 0;
    				$Duplicacion =  modelRealizarVenta::evitarDuplicacionC();
    				if($Duplicacion['evitarDuplicacion'] == "" ){
      					$evitarDuplicacion = 1;
    				}else{
      					$evitarDuplicacion = $Duplicacion['evitarDuplicacion'];
      				}
      				$NRC = "";
      				if (isset($_POST["Buscar"])) {
        				$NRC = $_POST["Buscar"];
      				}
					$total = ROUND($_POST["total"], 2);
					$propina = ROUND($_POST["Propina"], 2);
					$totalpagar = ROUND($_POST["TotalPagar"], 2);
					
					$DtsPedido = modelRealizarVenta::getPedido($_POST['idPedido']);
				// 	var_dump($DtsPedido);
					
					$datosController = array(
						"idpedido"=>$_POST["idPedido"],
                        "nrocomprobante"=>$_POST["nrocomprobanteC"],
						"total"=>$total,
						"formapago"=>$_POST["formaPago"],
						"comprobante"=>$_POST["comprobante"],
						"propina"=>$propina,
						"totalpagar"=>$totalpagar,
						"evitarDuplicacion"=>$evitarDuplicacion,
						"cliente"=>$_POST["Cliente"],
						"nrc" => $NRC,
						"Fecha" => $DtsPedido['FechaPedido']
					);
					$Existe = modelRealizarVenta::ComprobanteC($datosController['idpedido']);
					$respuesta = '';
					if ($Existe) {
						$respuesta =  modelRealizarVenta::UPregistroCompra($datosController, $Existe['IdcomprobanteC']);
					}else{
						$respuesta = modelRealizarVenta::registroCompra($datosController);
					}
					if($respuesta == "success"){}else{}
				}
   			}
		}
  		public function registroCompraOriginal(){
			if(isset($_POST["idPedido"])){

      			$datosControllerCajero = array(
					"idpedido"=>$_POST["idPedido"],
					"IdUsuario"=>$_SESSION["idusuario"]
				);
      			modelRealizarVenta::cajeroQueRealizoVenta($datosControllerCajero);

      			$nroMesa = modelRealizarVenta::nroMesa($_POST["idPedido"]);
      			$datosMesaActualizar = array("id"=>$nroMesa["NroMesa"]);

				if($_POST["mesa"]=="Llevar"){
  					$R = modelRealizarVenta::actualizarEstadoMesa($datosMesaActualizar);
				}else{
      				$cantidadCuentas = 0;
            		$respuesta = modelRealizarVenta::pedidosPorMesaCaja($_POST["mesa"]);
               		foreach($respuesta as $row => $item){
                    	$cantidadCuentas++;
                   	}
        
      				if($cantidadCuentas == 1){
        				$R = modelRealizarVenta::actualizarEstadoMesa($datosMesaActualizar);
      				}
                }
				
				$numeroComprobante;
                if($_POST["comprobante"] == 'FCF' || $_POST["comprobante"] == 'CCF'){
                	$numeroComprobante=$_POST["nrocomprobanteC"];
                } else {
                	$numeroComprobante=$_POST["nrocomprobante"];
                }
				
				$evitarDuplicacion = 0;
                $Duplicacion =  modelRealizarVenta::evitarDuplicacion();
                if($Duplicacion['evitarDuplicacion'] == "" ){
                    $evitarDuplicacion = 1;
                }else{
                    $evitarDuplicacion = $Duplicacion['evitarDuplicacion'];
                    $NRC = "";
                    if (isset($_POST["Buscar"])) {
                    	$NRC = $_POST["Buscar"];
                    }                                              
					$total = ROUND($_POST["total"], 2);
					$propina = ROUND($_POST["Propina"], 2);
					$totalpagar = ROUND($_POST["TotalPagar"], 2);
					$datosController = array(
						"idpedido"=>$_POST["idPedido"],
						"nrocomprobante"=>$numeroComprobante,
						"total"=>$total,
						"formapago"=>$_POST["formaPago"],
						"comprobante"=>$_POST["comprobante"],
						"propina"=>$propina,
						"totalpagar"=>$totalpagar,
						"evitarDuplicacion"=>$evitarDuplicacion,
						"cliente"=>$_POST["Cliente"],
						"nrc" => $NRC
					);
								
					$Existe = modelRealizarVenta::Comprobante($datosController['idpedido']);
					$respuesta = '';
					if ($Existe) {
						$respuesta =  modelRealizarVenta::UPregistroCompraOriginal($datosController, $Existe['IdComprobante']);
					}else{
						$respuesta = modelRealizarVenta::registroCompraOriginal($datosController);
					}

					$datosPedidoActualizar = array("id"=>$_POST["idPedido"]);
					modelRealizarVenta::actualizarEstadoPedido($datosPedidoActualizar);
					if($respuesta == "success"){
        				echo '<script>
							swal({
								title: "Registrado",
								text: "Se registro exitosamente",
								type: "success",
								showCancelButton: false,
								confirmButtonColor: "#3085d6",
								cancelButtonColor: "#d33",
								confirmButtonText: "Ok"
							}).then(function () {
								location = location;
							});
						</script>
						';
					}
				}
			}
		}
		public function actualizarCategoria(){
			if(isset($_POST["idA"])){
				$datosController = array(
					"id"=>$_POST["idA"],
      				"preparacion"=>$_POST["prepararA"],
					"nombre"=>$_POST["nombreA"]
				);

				$respuesta = modelCategoria::actualizarCategoria($datosController);
				if($respuesta == "success"){
					echo '<script> swal({
						title: "Editado",
						text: "Se edito exitosamente.",
						type: "success",
						showCancelButton: false,
						confirmButtonColor: "#54c6dd",
						confirmButtonText: "Ok",
						closeOnConfirm: false
					});</script>';
				}else{
					header("location:index.php");
				}
			}
		}

		public function vistaDetallePedidosEnCaja($datos){
			$respuesta = modelRealizarVenta::vistaDetallePedidosEnCaja($datos);
			return $respuesta;
		}

		public function borrarCategoria(){
			if(isset($_POST["IdE"])){
            	$datosController = $_POST["IdE"];
				$respuesta = modelCategoria::borrarCategoria($datosController);
				if($respuesta == "success"){
        			echo '<script> swal({
      					title: "Eliminado",
      					text: "Se elimino exitosamente.",
      					type: "success",
      					showCancelButton: false,
      					confirmButtonColor: "#54c6dd",
      					confirmButtonText: "Ok",
      					closeOnConfirm: false
    				});</script>';
				}else{
					header("location:index.php");
				}
			}
		}





		// DESCUENTO Y CARGOS
		public function Descuento(){
			if(isset($_POST["idPedidoDescuento"])){
				if($_POST["AgregarD"]=="A"){
					$DatosComprobarExistenciaMontoDescuentoCargo = array("idpedido"=>$_POST["idPedidoDescuento"],																							"idItem"=>"209");
					$ExistenciaMonto = modelRealizarVenta::ComprobarExistenciaMontoDescuentoCargo($DatosComprobarExistenciaMontoDescuentoCargo);
					if($ExistenciaMonto['Precio']==''){
						$idPedido = $_POST["idPedidoDescuento"];
						$PorcentajeIntroducido = $_POST["PorcentajeD"];
						$Monto = $_POST["MontoPedidoDescuento"];

						$PorcentajeImporte = ($PorcentajeIntroducido/100);
						$PorcentajeTotal = ($Monto * $PorcentajeImporte);
						$TotalModificar = $Monto - $PorcentajeTotal;
						$PropinaModificar = $TotalModificar * 0.10;

						$PorcentajeTotalM = truncateFloat($PorcentajeTotal, 2);
						$PropinaModificarM = truncateFloat($PropinaModificar, 2);
						$TotalM = truncateFloat($TotalModificar, 2);

						// $data1 = bcdiv($valor, '1', 1);
						$DatosActualizarItemDescuentoCargo = array(
							"porcentaje"=>$PorcentajeTotalM,
							"idItem"=>"209"
						);
						$DatosRegistroDetallePedido = array(
							"idpedido"=>$idPedido,
							"idItem"=>'209',
							"porcentaje"=>$PorcentajeTotalM
						);
						$DatosActualizarMontoPedido = array(
							"idpedido"=>$idPedido,
							"total"=>$TotalM,
							"propina"=>$PropinaModificarM
						);

						modelRealizarVenta::ActualizarItemDescuentoCargo($DatosActualizarItemDescuentoCargo);
						modelRealizarVenta::RegistroDetallePedido($DatosRegistroDetallePedido);
						$respuesta = modelRealizarVenta::ActualizarMontoPedido($DatosActualizarMontoPedido);
						if($respuesta == "success"){
							echo '<script>
								swal({
									title: "Registrado",
									text: "Se registro exitosamente",
									type: "success",
									showCancelButton: false,
									confirmButtonColor: "#3085d6",
									cancelButtonColor: "#d33",
									confirmButtonText: "Ok"
								}).then(function () {
										location = location;
								});
							</script>';
						}else{
							header("location:index.php");
						}
					} else {
						echo '<script>
							swal({
								title: "Error",
								text: "Ya existe un descuento en esta cuenta",
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
				} else {
					$DatosComprobarExistenciaMontoDescuentoCargo = array(
						"idpedido" => $_POST["idPedidoDescuento"],
						"idItem"=>"209"
					);
					$ExistenciaMonto = modelRealizarVenta::ComprobarExistenciaMontoDescuentoCargo($DatosComprobarExistenciaMontoDescuentoCargo);

					if($ExistenciaMonto['Precio']!=''){
						$idPedido = $_POST["idPedidoDescuento"];
						$Monto = $_POST["MontoPedidoDescuento"];

						$Total = ($Monto+$ExistenciaMonto['Precio']);
						$PropinaModificar = $Total * 0.10;
						// $TotalM = truncateFloat($Total, 2);
						// $PropinaModificarM = truncateFloat($PropinaModificar, 2);

						$DatosEliminarDescuentoCargo = array(
							"idpedido"=>$_POST["idPedidoDescuento"],
							"idItem"=>"209"
						);

						$DatosActualizarMontoPedido = array(
							"idpedido"=>$_POST["idPedidoDescuento"],
							"total"=>$Total,
							"propina"=>$PropinaModificar
						);

						modelRealizarVenta::EliminarDescuentoCargo($DatosEliminarDescuentoCargo);
						$respuesta = modelRealizarVenta::ActualizarMontoPedido($DatosActualizarMontoPedido);
						if($respuesta == "success"){
							echo '<script>
								swal({
									title: "Registrado",
									text: "Se registro exitosamente",
									type: "success",
									showCancelButton: false,
									confirmButtonColor: "#3085d6",
									cancelButtonColor: "#d33",
										confirmButtonText: "Ok"
								}).then(function () {
									location = location;
								});
							</script>';
						}else{
							header("location:index.php");
						}
					} else {
						echo '<script>
							swal({
								title: "Error",
								text: "No existe un descuento en esta cuenta",
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
		}
				


		// public function Cargo(){
		// 	if(isset($_POST["idPedidoCargo"])){
		// 		if($_POST["AgregarC"]=="A"){
		// 			$DatosComprobarExistenciaMontoDescuentoCargo = array(
		// 				"idpedido"=>$_POST["idPedidoCargo"],
		// 				"idItem"=>"210"
		// 			);
		// 			$ExistenciaMonto = modelRealizarVenta::ComprobarExistenciaMontoDescuentoCargo($DatosComprobarExistenciaMontoDescuentoCargo);
		// 			if($ExistenciaMonto['Precio']==''){
		// 				$idPedido = $_POST["idPedidoCargo"];
		// 				$PorcentajeIntroducido = $_POST["PorcentajeC"];
		// 				$Monto = $_POST["MontoPedidoCargo"];
		// 				$MontoM = truncateFloat($Monto, 2);

		// 				$PorcentajeImporte = ($PorcentajeIntroducido/100);
		// 				$PorcentajeTotal = ($MontoM * $PorcentajeImporte);
		// 				$PorcentajeTotalM = truncateFloat($PorcentajeTotal, 2);
		// 				$TotalModificar = $MontoM + $PorcentajeTotal;
		// 				$PropinaModificar = $TotalModificar * 0.10;
		// 				$PropinaModificarM = truncateFloat($PropinaModificar, 2);
		// 				$TotalM = truncateFloat($TotalModificar, 2);

		// 				$DatosActualizarItemDescuentoCargo = array(
		// 					"porcentaje"=>$PorcentajeTotalM,
		// 					"idItem"=>"210"
		// 				);
		// 				$DatosRegistroDetallePedido = array(
		// 					"idpedido"=>$idPedido,
		// 					"idItem"=>'210',
		// 					"porcentaje"=>$PorcentajeTotalM
		// 				);
		// 				$DatosActualizarMontoPedido = array(
		// 					"idpedido"=>$idPedido,
		// 					"total"=>$TotalM,
		// 					"propina"=>$PropinaModificarM
		// 				);

		// 				modelRealizarVenta::ActualizarItemDescuentoCargo($DatosActualizarItemDescuentoCargo);
		// 				modelRealizarVenta::RegistroDetallePedido($DatosRegistroDetallePedido);
		// 				$respuesta = modelRealizarVenta::ActualizarMontoPedido($DatosActualizarMontoPedido);
		// 				if($respuesta == "success"){
		// 					echo '<script>
		// 						swal({
		// 							title: "Registrado",
		// 							text: "Se registro exitosamente",
		// 							type: "success",
		// 							showCancelButton: false,
		// 							confirmButtonColor: "#3085d6",
		// 							cancelButtonColor: "#d33",
		// 							confirmButtonText: "Ok"
		// 						}).then(function () {
		// 								location = location;
		// 						});
		// 					</script>';
		// 				} else{
		// 					header("location:index.php");
		// 				}
		// 			} else {
		// 				echo '<script>
		// 					swal({
		// 						title: "Error",
		// 						text: "Ya existe un cargo en esta cuenta",
		// 						type: "error",
		// 						showCancelButton: false,
		// 						confirmButtonColor: "#3085d6",
		// 						cancelButtonColor: "#d33",
		// 							confirmButtonText: "Ok"
		// 					}).then(function () {
		// 					location = location;
		// 					});
		// 				</script>';
		// 			}
		// 		}else{
		// 			$DatosComprobarExistenciaMontoDescuentoCargo = array("idpedido"=>$_POST["idPedidoCargo"],"idItem"=>"210");
		// 			$ExistenciaMonto = modelRealizarVenta::ComprobarExistenciaMontoDescuentoCargo($DatosComprobarExistenciaMontoDescuentoCargo);

		// 			if($ExistenciaMonto['Precio']!=''){
		// 				$idPedido = $_POST["idPedidoCargo"];
		// 				$Monto = $_POST["MontoPedidoCargo"];

		// 				$Total = ($Monto-$ExistenciaMonto['Precio']);

		// 				$PropinaModificar = $Total * 0.10;
		// 				$PropinaModificarM = truncateFloat($PropinaModificar, 2);
		// 				$TotalM = truncateFloat($Total, 2);
		// 				$DatosEliminarDescuentoCargo = array(
		// 					"idpedido"=>$_POST["idPedidoCargo"],
		// 					"idItem"=>"210"
		// 				);
		// 				$DatosActualizarMontoPedido = array(
		// 					"idpedido"=>$_POST["idPedidoCargo"],
		// 					"total"=>$TotalM,
		// 					"propina"=>$PropinaModificar
		// 				);

	  	// 				modelRealizarVenta::EliminarDescuentoCargo($DatosEliminarDescuentoCargo);
		// 				$respuesta = modelRealizarVenta::ActualizarMontoPedido($DatosActualizarMontoPedido);
		// 				if($respuesta == "success"){
		// 					echo '<script>
		// 					swal({
		// 						title: "Registrado",
		// 						text: "Se registro exitosamente",
		// 						type: "success",
		// 						showCancelButton: false,
		// 						confirmButtonColor: "#3085d6",
		// 						cancelButtonColor: "#d33",
		// 							confirmButtonText: "Ok"
		// 						}).then(function () {
		// 							location = location;
		// 						});
		// 					</script>';
		// 				} else{
		// 					header("location:index.php");
		// 				}
		// 			} else {
		// 				echo '<script>
		// 					swal({
		// 						title: "Error",
		// 						text: "No existe un cargo en esta cuenta",
		// 						type: "error",
		// 						showCancelButton: false,
		// 						confirmButtonColor: "#3085d6",
		// 						cancelButtonColor: "#d33",
		// 							confirmButtonText: "Ok"
		// 					}).then(function () {
		// 						location = location;
		// 					});
		// 				</script>';
		// 			}
		// 		}
		// 	}
		// }
	}
?>
