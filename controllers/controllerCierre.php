<?php

class controllerCierre{
// CORTE X & X
public function DatosCorrelativoTickets(){
  $respuesta = modelCierre::DatosCorrelativoTickets();
  return $respuesta;
}
public function DatosCorrelativoTickets2($f1,$f2){
  $respuesta = modelCierre::DatosCorrelativoTickets2($f1, $f2);
  return $respuesta;
}
public function DatosTotalVentaTickets(){
  $respuesta = modelCierre::DatosTotalVentaTickets();
  return $respuesta;
}
public function DatosFCF(){
  $respuesta = modelCierre::DatosFCF();
  return $respuesta;
}
public function DatosCCF(){
  $respuesta = modelCierre::DatosCCF();
  return $respuesta;
}
public function DatosDevolucion(){
  $respuesta = modelCierre::DatosDevolucion();
  return $respuesta;
}
//CORTE GRAN Z
public function DatosCorrelativoTicketsGranZ(){
  if(isset($_POST["cortegranz"])){
  $datosController = array("anio"=>$_POST["anio"],
                           "mes"=>$_POST["mes"]);
    $respuesta = modelCierre::DatosCorrelativoTicketsGranZ($datosController);
    return $respuesta;
    }
  }
public function DatosTotalVentaTicketsGranZ(){
  if(isset($_POST["cortegranz"])){
  $datosController = array("anio"=>$_POST["anio"],
                           "mes"=>$_POST["mes"]);
    $respuesta = modelCierre::DatosTotalVentaTicketsGranZ($datosController);
    return $respuesta;
    }
  }
public function DatosFCFGranZ(){
  if(isset($_POST["cortegranz"])){
  $datosController = array("anio"=>$_POST["anio"],
                           "mes"=>$_POST["mes"]);
    $respuesta = modelCierre::DatosFCFGranZ($datosController);
    return $respuesta;
    }
  }
public function DatosCCFGranZ(){
  if(isset($_POST["cortegranz"])){
  $datosController = array("anio"=>$_POST["anio"],
                           "mes"=>$_POST["mes"]);
    $respuesta = modelCierre::DatosCCFGranZ($datosController);
    return $respuesta;
    }
  }
public function DatosDevolucionGranZ(){
  if(isset($_POST["cortegranz"])){
  $datosController = array("anio"=>$_POST["anio"],
                           "mes"=>$_POST["mes"]);
    $respuesta = modelCierre::DatosDevolucionGranZ($datosController);
    return $respuesta;
    }
  }
  public function RegistroDeCortes(){
    if(isset($_POST["seguridad"])){
    $datosController = array("idpedido"=>1,
                             "serie"=>$_POST["ti"],
                             "nrocomprobante"=>$_POST["tf"],
                             "total"=>$_POST["Total"],
                             "formapago"=>$_POST["corte"],
                             "comprobante"=>$_POST["corte"],
                             "propina"=>$_POST["devolucion"],
                             "totalpagar"=>$_POST["Total"],

                             "totalpagar"=>$_POST["Total"],
                             "MontoTicket"=>$_POST["tTtotal"],
                             "CorrelativoFCF"=>$_POST["fcfi"],
                             "CorrelativoFCF2"=>$_POST["fcff"],
                             "MontoFCF"=>$_POST["fcfTtotal"],
                             "CorrelativoCCF"=>$_POST["ccfi"],
                             "CorrelativoCCF2"=>$_POST["ccff"],
                             "MontoCCF"=>$_POST["ccfTtotal"]);
      $respuesta = modelCierre::registroDeCortes($datosController);
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
        echo '<script> swal({
      title: "Error",
      text: "Ocurrio un error.",
      type: "error",
      showCancelButton: false,
      confirmButtonColor: "#54c6dd",
      confirmButtonText: "Ok",
      closeOnConfirm: false
    });</script>';
			// header("location:index.php");
			}
      }
    }

public function ListarLeyendaCinta(){
    $respuesta = modelCierre::ListarLeyendaCinta();
    return $respuesta;
  }
public function ListarTicketCinta(){
  if(isset($_POST["fecha"])){
    $datosController = $_POST["fecha"];
    $respuesta = modelCierre::ListarTicketCinta($datosController, $datosController);
    return $respuesta;
    }
  }
}

 ?>
