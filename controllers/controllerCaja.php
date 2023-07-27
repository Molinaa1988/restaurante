<?php

  class controllerCaja{

    public function vereficarAperturaCaja(){
      $respuesta = modelCaja::vereficarAperturaCaja();
      return $respuesta;
    }

    public function ultimoIdCajaCajaChica(){
      $respuesta = modelCaja::ultimoIdCajaCajaChica();
      return $respuesta;
    }

    function iDCajas($Fecha){
      $respuesta = modelCaja::iDCajas($Fecha);
      return $respuesta;
    }


    public function AperturaCaja(){
      if(isset($_POST["montoaperturarR"])){
        $datosController = array(
          "montoapertura" => $_POST["montoaperturarR"],
          "IdPersonal" => $_POST["IdPersonal"]
        );
        modelCaja::CierreCaja();
        $respuesta = modelCaja::AperturaCaja($datosController);

        if($respuesta == "success"){
          modelCaja::actualizarMesas();
          modelCaja::actualizarPedidos();

          $respuesta = modelCaja::ultimoIdCajaCajaChica();
          $datosParaCrearCajaChica = array(
                          "idfcaja"=>$respuesta["IdFcaja"],
                          "monto"=>$respuesta["MontoApertura"],
                          "descripcion"=>"Caja chica",
                          "fecha"=>date('Y-m-d'));
         modelGastoIngreso::registroIngreso($datosParaCrearCajaChica);

          echo '<script>
            swal({
              title: "Aperturada",
              text: "Se aperturo exitosamente",
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

    public function ReAperturaCaja(){
      if(isset($_POST["reapertura"])){
        $respuesta = modelCaja::ReAperturaCaja();
        if($respuesta == "success"){
          echo '<script>
          swal({
            title: "Aperturada",
            text: "Se aperturo exitosamente",
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

    public function ultimoIdCaja(){
      $respuesta = modelCaja::ultimoIdCaja();
      return $respuesta;
    }


  public function Eliminarcortez(){
  if(isset($_POST["reapertura"])){
    modelCaja::ReAperturaCaja();
   $respuest = modelCaja::ultimoIdcomprobanteC();
   $IdcomprobanteC = array("IdcomprobanteC"=>$respuest["IdcomprobanteC"]);
  $respuesta =  modelCaja::EliminarUltimoIdcomprobanteC($IdcomprobanteC);

  }
}

}

?>
