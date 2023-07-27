<?php

class controllerGastoIngreso{
	#REGISTRO DE USUARIOS
	#------------------------------------
	public function registroGasto(){
		if(isset($_POST["montoR"])){
			$datosController = array(
								      "idfcaja"=>$_POST["idFcaja"],
								      "monto"=>$_POST["montoR"],
                      "descripcion"=>$_POST["descripcionR"]);
			$respuesta = modelGastoIngreso::registroGasto($datosController);
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
        echo $respuesta;
			// header("location:index.php");
			}
		}
	}



	public function actualizarGasto(){
		if(isset($_POST["idA"])){
			$datosController = array("id"=>$_POST["idA"],
      "monto"=>$_POST["montoA"],
      "descripcion"=>$_POST["descripcionA"]);
		$respuesta = modelGastoIngreso::actualizarGastoIngreso($datosController);
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

	public function vistaGasto(){
		$respuesta = modelGastoIngreso::vistaGasto();
		return $respuesta;
	}
	public function vistaGastoConFecha($fecha){
	$respuesta = modelGastoIngreso::vistaGastoConFecha($fecha);
	return $respuesta;
}

	public function borrarGasto(){
	if(isset($_POST["IdGastoE"])){
            $datosController = $_POST["IdGastoE"];
			$respuesta = modelGastoIngreso::borrarGastoIngreso($datosController);
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

	public function registroIngreso(){
		if(isset($_POST["montoingresoR"])){
			$datosController = array(
											"idfcaja"=>$_POST["idfcajaIngreso"],
											"monto"=>$_POST["montoingresoR"],
											"descripcion"=>$_POST["descripcionRIngreso"]);
			$respuesta = modelGastoIngreso::registroIngreso($datosController);
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
				echo $respuesta;
			// header("location:index.php");
			}
		}
	}

	public function registroIngresoCajaChica($idfcaja,$monto){
		if(isset($_POST["montoingresoR"])){
			$datosController = array(
											"idfcaja"=>$idfcaja,
											"monto"=>$monto,
											"descripcion"=>"Caja chica");
			$respuesta = modelGastoIngreso::registroIngreso($datosController);
			if($respuesta == "success"){

			}
			else{
				echo $respuesta;
			}
		}
	}

	public function actualizarIngreso(){
		if(isset($_POST["idIngresoA"])){
			$datosController = array("id"=>$_POST["idIngresoA"],
			"monto"=>$_POST["montoAIngreso"],
			"descripcion"=>$_POST["descripcionAIngreso"]);
		$respuesta = modelGastoIngreso::actualizarGastoIngreso($datosController);
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

	public function vistaIngreso(){
		$respuesta = modelGastoIngreso::vistaIngreso();
		return $respuesta;
	}
	public function vistaIngresoConFecha($fecha){
	$respuesta = modelGastoIngreso::vistaIngresoConFecha($fecha);
	return $respuesta;
	}
	public function vistaCxcc($fecha){
		$respuesta = modelGastoIngreso::vistaCxcc($fecha);
		return $respuesta;
	}

	public function borrarIngreso(){
	if(isset($_POST["IdIngresoE"])){
						$datosController = $_POST["IdIngresoE"];
			$respuesta = modelGastoIngreso::borrarGastoIngreso($datosController);
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

}
