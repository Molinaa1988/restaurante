<?php

class controllerCliente{
	#REGISTRO DE USUARIOS
	#------------------------------------
	public function registroCliente(){

		if(isset($_POST["nrcR"])){
			$datosController = array("nrc"=>$_POST["nrcR"],
								      "nit"=>$_POST["nitR"],
                      "cliente"=>$_POST["clienteR"],
                      "direccion"=>$_POST["direccionR"],
                      "departamento"=>$_POST["departamentoR"],
                      "municipio"=>$_POST["municipioR"],
                      "giro"=>$_POST["giroR"]);



			$respuesta = modelCliente::registroCliente($datosController);

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

  public function actualizarCliente(){
    if(isset($_POST["idA"])){
      $datosController = array("id"=>$_POST["idA"],
                      "nrc"=>$_POST["nrcA"],
                      "nit"=>$_POST["nitA"],
                      "cliente"=>$_POST["clienteA"],
                      "direccion"=>$_POST["direccionA"],
                      "departamento"=>$_POST["departamentoA"],
                      "municipio"=>$_POST["municipioA"],
                      "giro"=>$_POST["giroA"]);

    $respuesta = modelCliente::actualizarCliente($datosController);
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


		public function vistaCliente(){
		$respuesta = modelCliente::vistaCliente();
		return $respuesta;
	}



		public function borrarCliente(){
	if(isset($_POST["IdNRE"])){
            $datosController = $_POST["IdNRE"];
			$respuesta = modelCliente::borrarCliente($datosController);
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


  //funciones para los clientes normales o sea sin NRC
  public function vistaClientes1(){
    $respuesta = modelCliente::vistaClientes1();
		return $respuesta;
  }

  public function registroClientes1(){

		if(isset($_POST["nombreR"])){
			$datosController = array("nombre"=>$_POST["nombreR"],
                      "direccion"=>$_POST["direccionR"],
                      "celular"=>$_POST["celularR"]);



			$respuesta = modelCliente::registroClientes1($datosController);

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

  public function borrarClientes1(){
    if(isset($_POST["idE"])){
              $datosController = $_POST["idE"];
        $respuesta = modelCliente::borrarClientes1($datosController);
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


    public function actualizarClientes1(){
      if(isset($_POST["idA"])){
        $datosController = array("id"=>$_POST["idA"],
                        "nombre"=>$_POST["nombreA"],
                        "direccion"=>$_POST["direccionA"],
                        "celular"=>$_POST["celularA"]);
  
      $respuesta = modelCliente::actualizarClientes1($datosController);
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
    
//cierra todo  
}
