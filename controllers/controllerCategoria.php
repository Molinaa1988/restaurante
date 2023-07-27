<?php

class controllerCategoria{
	#REGISTRO DE USUARIOS
	#------------------------------------
	public function registroCategoria(){

		if(isset($_POST["nombreR"])){
			$datosController = array("usuario"=>$_POST["nombreR"],
                                "preparacion"=>$_POST["prepararR"],
                                "nombre"=>$_POST["nombreR"] );
			$respuesta = modelCategoria::registroCategoria($datosController);

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

	public function actualizarCategoria(){
		if(isset($_POST["idA"])){
			$datosController = array("id"=>$_POST["idA"],
      "preparacion"=>$_POST["prepararA"],
      "nombre"=>$_POST["nombreA"] );

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
		}
		else{
		header("location:index.php");

		}
	}
}

		public function vistaCategoria(){
		$respuesta = modelCategoria::vistaCategoria();
		return $respuesta;
	}

	public function vistaIngredientes(){
		$respuesta = modelCategoria::vistaIngredientes();
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
			}
			else{
			header("location:index.php");
			}
		}
	}

}
