<?php

class controllerConfiguraciones{

	function configuracionesImpresora(){
			$respuesta = modelConfiguraciones::configuracionesImpresora();
		  return $respuesta;
	}
  function configuracionesCorreo(){
      $respuesta = modelConfiguraciones::configuracionesCorreo();
      return $respuesta;
  }


  public function actualizarConfiguracionImpresora(){
    if(isset($_POST["ImpresoraTicket"])){
      $datosController = array("ImpresoraTicket"=>$_POST["ImpresoraTicket"]);

    $respuesta = modelConfiguraciones::actualizarConfiguracionImpresora($datosController);
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
    }
    else{
    header("location:index.php");

    }
  }
}

  public function actualizacionConfiguracionCorreo(){
    if(isset($_POST["EmailEmisor"])){
      $datosController = array("EmailReceptor"=>$_POST["EmailReceptor"],
                      "EmailEmisor"=>$_POST["EmailEmisor"],
                      "Contrasena"=>$_POST["Contrasena"]);

    $respuesta = modelConfiguraciones::actualizacionConfiguracionCorreo($datosController);
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
    }
    else{
    // header("location:index.php");
    }
  }
}

public function vistaZona(){
$respuesta = modelConfiguraciones::vistaZona();
return $respuesta;
}

public function registrarZona(){
	if(isset($_POST["zonaR"])){
		$datosController = array("zonaR"=>$_POST["zonaR"]);

	$respuesta = modelConfiguraciones::registrarZona($datosController);
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
	}
	else{
	header("location:index.php");

	}
}
}

public function ActualizarZona(){
	if(isset($_POST["idZonaA"])){
		$datosController = array("idZonaA"=>$_POST["idZonaA"],
															"ZonaA"=>$_POST["zonaA"]);

	$respuesta = modelConfiguraciones::ActualizarZona($datosController);
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
	}
	else{
	header("location:index.php");

	}
}
}

public function EliminarZona(){
if(isset($_POST["idZonaE"])){
				$datosController = $_POST["idZonaE"];
	$respuesta = modelConfiguraciones::EliminarZona($datosController);
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
	}
	else{
	header("location:index.php");
	}
}
}

public function vistaMesas1(){
$respuesta = modelConfiguraciones::vistaMesas1();
return $respuesta;
}
public function vistaMesas2(){
$respuesta = modelConfiguraciones::vistaMesas2();
return $respuesta;
}
public function vistaMesas3(){
$respuesta = modelConfiguraciones::vistaMesas3();
return $respuesta;
}
public function nombreZona($idzona){
$respuesta = modelConfiguraciones::nombreZona($idzona);
return $respuesta;
}

public function registrarMesa(){
	if(isset($_POST["idzonaR"])){
$ultimaMesa = modelConfiguraciones::ultimaMesa();
		$datosController = array("idzona"=>$_POST["idzonaR"],
															"naturaleza"=>$_POST["naturalezaR"],
														  "NroMesa"=>$ultimaMesa["ultimo"]);

	$respuesta = modelConfiguraciones::registrarMesa($datosController);
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
	}
	else{
	header("location:index.php");

	}
}
}

public function ActualizarMesa(){
	if(isset($_POST["idzonaA"])){
		$datosController = array("idzona"=>$_POST["idzonaA"],
														 "NroMesa"=>$_POST["NroMesaA"],
														"naturaleza"=>$_POST["naturalezaA"],
													"Etiqueta" => $_POST['EtiquetaA']);

	$respuesta = modelConfiguraciones::ActualizarMesa($datosController);
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
	}
	else{
	header("location:index.php");

	}
}
}

public function EliminarMesa(){
if(isset($_POST["NroMesaE"])){
				$datosController = $_POST["NroMesaE"];
	$respuesta = modelConfiguraciones::EliminarMesa($datosController);
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
	}
	else{
	header("location:index.php");
	}
}
}
function configuracionesEliminarBebida(){
		$respuesta = modelConfiguraciones::configuracionesEliminarBebida();
		return $respuesta;
}
public function actualizarEliminarBebida(){
	if(isset($_POST["EstadoEliminarBebida"])){
			$datosController = $_POST["EstadoEliminarBebida"];
			$respuesta = modelConfiguraciones::actualizarEliminarBebida($datosController);
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
	}
	else{
	header("location:index.php");
		}
	}
}
function informacionTicket(){
		$respuesta = modelConfiguraciones::informacionTicket();
		return $respuesta;
}

public function actualizarInformacionTicket(){
	if(isset($_POST["nombreNegocio"])){
		$datosController = array("Restaurante"=>$_POST["nombreNegocio"],
														 "Contribuyente"=>$_POST["nombreContribuyente"],
														 "NroDeRegistro"=>$_POST["nroRegistro"],
													   "NIT"=>$_POST["nit"],
														 "Giro"=>$_POST["giro"],
														 "Direccion"=>$_POST["direccion"],
														 "Resolucion"=>$_POST["resolucion"],
													   "Mensaje"=>$_POST["mensaje"],
													   "Mensaje2"=>$_POST["mensaje2"],);
	$respuesta = modelConfiguraciones::actualizarInformacionTicket($datosController);
		if($respuesta == "success"){
			echo '<script>
			swal({
				title: "Actualizado",
				text: "Se actualizo exitosamente",
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
	// header("location:index.php");

	}
}
}

public function eliminarPedido(){
	if(isset($_POST["IdPedido"])){
		$IdPedido =	$_POST["IdPedido"];
		// Actualizar la mesa a estado L (LIBRE) y eliminar de la tabla detallemesa, detallepedido, comprobante, comprobante c Y  pedido por medido de idpedido
		modelConfiguraciones::eliminarPedidoDetalleMesa($IdPedido);
		modelConfiguraciones::eliminarPedidoDetallePedido($IdPedido);
		modelConfiguraciones::eliminarPedidoComprobante($IdPedido);
		modelConfiguraciones::eliminarPedidoComprobanteC($IdPedido);
  	$respuesta = modelConfiguraciones::eliminarPedido($IdPedido);
		if($respuesta == "success"){
			echo '<script>
			swal({
				title: "Eliminado",
				text: "Se elimino exitosamente",
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
			title: "Error",
			text: "Sucedio un error",
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
}


  }
