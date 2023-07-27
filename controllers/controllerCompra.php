<?php

class controllerCompra{
	#REGISTRO DE USUARIOS
	#------------------------------------
	public function registroCompra(){

		if(isset($_POST["idProveedorR"])){
      if($_POST["comprobanteR"] == "CCF")
      {
    $iva =  $_POST["costoR"] * 0.13;
    $subtotal = $_POST["costoR"] - $iva;
      }
      else {
        $iva =  "0";
        $subtotal = $_POST["costoR"];
      }
			$datosController = array("tipodoc"=>$_POST["comprobanteR"],
								      "nrocomprobante"=>$_POST["nrocomprobanteR"],
                      "idproveedor"=>$_POST["idProveedorR"],
                      "formapago"=>$_POST["formapagoR"],
                      "fecha"=>$_POST["fechaR"],
                      "descripcion"=>$_POST["descripcionR"],
                      "total"=>$_POST["costoR"],
                      "iva"=>$iva,
                      "subtotal"=>$subtotal);

			$respuesta = modelCompra::registroCompra($datosController);

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

  public function actualizarCompra(){
    if(isset($_POST["idA"])){
      if($_POST["comprobanteA"] == "CCF")
      {
    $iva =  $_POST["costoA"] * 0.13;
    $subtotal = $_POST["costoA"] - $iva;
      }
      else {
        $iva =  "0";
        $subtotal = $_POST["costoA"];
      }
      $datosController = array("id"=>$_POST["idA"],
                      "tipodoc"=>$_POST["comprobanteA"],
                      "nrocomprobante"=>$_POST["nrocomprobanteA"],
                      "idproveedor"=>$_POST["idProveedorA"],
                      "formapago"=>$_POST["formapagoA"],
                      "fecha"=>$_POST["fechaA"],
                      "descripcion"=>$_POST["descripcionA"],
                      "total"=>$_POST["costoA"],
                      "iva"=>$iva,
                      "subtotal"=>$subtotal);

    $respuesta = modelCompra::actualizarCompra($datosController);
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


		public function vistaCompra($Fecha){
		$respuesta = modelCompra::vistaCompra($Fecha);
		return $respuesta;
	}
	public function vistaCompraConFecha($fecha){
	$respuesta = modelCompra::vistaCompraConFecha($fecha);
	return $respuesta;
 }

  public function vistaProveedor($idPro){
      $datosController = array("idproveedor"=>$idPro);
      $respuesta = modelCompra::vistaProveedor($datosController);
      return $respuesta;
  }

		public function borrarCompra(){
	if(isset($_POST["idCompraE"])){
            $datosController = $_POST["idCompraE"];
			$respuesta = modelCompra::borrarCompra($datosController);
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
