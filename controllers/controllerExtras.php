<?php

class controllerExtras{

		 function pedidosErrores(){
	 	$respuesta = modelExtras::pedidosErrores();
		return $respuesta;
	}

  public function cambiarEstadoMesa(){
    if(isset($_POST["NroMesaA"])){
      $datosController = array("mesa"=>$_POST["NroMesaA"],
                      "estado"=>$_POST["EstadoA"]);
      $respuesta = modelExtras::cambiarEstadoMesa($datosController);
      if($respuesta == "success"){
        echo '<script>
        swal({
          title: "Actulizada",
          text: "Se Actulizada exitosamente",
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
        echo "No paso nada";
      }
    }
  }


}
