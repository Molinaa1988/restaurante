<?php

class controllerUsuario{
	#REGISTRO DE USUARIOS
	#------------------------------------
	public function registroUsuario(){

		if(isset($_POST["usuarioR"])){
			$datosController = array(
				"usuario"=>$_POST["usuarioR"],
				"clave"=>$_POST["claveR"],
                "puesto"=>$_POST["puestoR"],
				"estado"=>$_POST["estadoR"],
				"IdPersonal"=>$_POST["IdPersonalR"]
			);
			$respuesta = modelUsuario::registroUsuario($datosController);

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

			} else {
				var_dump( $respuesta);
			}
		}
	}

	public function actualizarUsuario(){
		if(isset($_POST["idA"])){
			$datosController = array("id"=>$_POST["idA"],
				"usuario"=>$_POST["usuarioA"],
				"clave"=>$_POST["claveA"],
				"puesto"=>$_POST["idCargoA"],
				"estado"=>$_POST["estadoA"],
		  		"IdPersonal"=>$_POST["IdPersonalA"]
			);

			$respuesta = modelUsuario::actualizarUsuario($datosController);
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
			} else {
			header("location:index.php");

			}
		}
	}

	public function vistaUsuarios(){
		$respuesta = modelUsuario::vistaUsuarios();
		return $respuesta;
	}

	public function Cargos(){
		$respuesta = modelUsuario::Cargos();
		return $respuesta;
	}

	public function borrarUsuario(){
		if(isset($_POST["IdUsuarioE"])){
            $datosController = $_POST["IdUsuarioE"];
			$respuesta = modelUsuario::borrarUsuario($datosController);
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

}
