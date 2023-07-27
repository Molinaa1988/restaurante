<?php

  class controllerPersonal{
    #REGISTRO DE USUARIOS
    #------------------------------------
    public function registroPersonal(){

      if(isset($_POST["duiR"])){
        $datosController = array(
          "IdCargo"=>$_POST["idCargoR"],
          "dui"=>$_POST["duiR"],
          "apellidos"=>$_POST["apellidosR"],
          "nombres"=>$_POST["nombresR"],
          "fechaNacimiento"=>$_POST["fechaNacimientoR"],
          "sexo"=>$_POST["sexoR"],
          "estadoCivil"=>$_POST["estadoCivilR"],
          "direccion"=>$_POST["direccionR"],
          "telefono"=>$_POST["telefonoR"],
          "estado"=>$_POST["estadoR"] 
        );
      
        $respuesta = modelPersonal::registroPersonal($datosController);

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
          header("location:index.php");
        }
      }
    }

    public function actualizarPersonal(){
      if(isset($_POST["idA"])){
        $datosController = array(
          "id"=>$_POST["idA"],
          "IdCargo"=>$_POST["idCargoA"],
          "dui"=>$_POST["duiA"],
          "apellidos"=>$_POST["apellidosA"],
          "nombres"=>$_POST["nombresA"],
          "fechaNacimiento"=>$_POST["fechaNacimientoA"],
          "sexo"=>$_POST["sexoA"],
          "estadoCivil"=>$_POST["estadoCivilA"],
          "direccion"=>$_POST["direccionA"],
          "telefono"=>$_POST["telefonoA"],
          "estado"=>$_POST["estadoA"]
        );

        // var_dump($datosController);

        $respuesta = modelPersonal::actualizarPersonal($datosController);
        if($respuesta == "success"){
          echo '<script> swal({
            title: "Editado",
            text: "Se edito exitosamente.",
            type: "success",
            showCancelButton: false,
            confirmButtonColor: "#54c6dd",
            confirmButtonText: "Ok"
          }).then(function () {
            location = location;
          });
          </script>';
        } else {
          header("location:index.php");
        }
      }
    }



		public function vistaPersonal(){
		  $respuesta = modelPersonal::vistaPersonal();
		  return $respuesta;
	  }

		public function borrarPersonal(){
      if(isset($_POST["idPersonalE"])){
        $datosController = $_POST["idPersonalE"];
        $respuesta = modelPersonal::borrarPersonal($datosController);
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
        } else {
          header("location:index.php");
        }
		  }
    }
  }
?>
