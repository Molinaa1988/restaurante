<?php

class controllerProveedores{
	#REGISTRO DE USUARIOS
	#------------------------------------
	public function registroProveedor(){

		if(isset($_POST["duiR"])){
			$datosController = array("dui"=>$_POST["duiR"],
								      "nit"=>$_POST["nitR"],
                      "proveedor"=>$_POST["proveedorR"],
                      "giro"=>$_POST["giroR"],
                      "dirreccion"=>$_POST["direccionR"],
                      "contacto"=>$_POST["contactoR"],
                      "telefono"=>$_POST["telefonoR"],
                      "email"=>$_POST["emailR"],
								      "estado"=>$_POST["estadoR"] );
			$respuesta = modelProveedores::registroProveedor($datosController);

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

	public function actualizarProveedor(){
		if(isset($_POST["idA"])){
			$datosController = array("id"=>$_POST["idA"],
											"dui"=>$_POST["duiA"],
											"nit"=>$_POST["nitA"],
											"proveedor"=>$_POST["proveedorA"],
											"giro"=>$_POST["giroA"],
											"dirreccion"=>$_POST["direccionA"],
											"contacto"=>$_POST["contactoA"],
											"telefono"=>$_POST["telefonoA"],
											"email"=>$_POST["emailA"],
											"estado"=>$_POST["estadoA"] );

		$respuesta = modelProveedores::actualizarProveedor($datosController);
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

		public function vistaProveedores(){
		$respuesta = modelProveedores::vistaProveedores();
		return $respuesta;
	}

		public function borrarProveedor(){
	if(isset($_POST["idProveedorE"])){
            $datosController = $_POST["idProveedorE"];
			$respuesta = modelProveedores::borrarProveedor($datosController);
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
