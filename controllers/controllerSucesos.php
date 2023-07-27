<?php

class controllerSucesos{

public function vistaSucesos(){
$respuesta = modelSucesos::vistaSucesos();
return $respuesta;
}
public function vistaSucesosSinVer(){
$respuesta = modelSucesos::vistaSucesosSinVer();
return $respuesta;
}
public function actualizarSucesosVistos(){
$respuesta = modelSucesos::actualizarSucesosVistos();
if($respuesta == "success"){
  echo '<script>
  location = location;
  </script>';
  }
}

public function AperturaCaja(){
  if(isset($_POST["montoaperturarR"])){
    $datosController = array("montoapertura"=>$_POST["montoaperturarR"]);
    $respuesta = modelCaja::AperturaCaja($datosController);

    if($respuesta == "success"){
       modelCaja::actualizarMesas();
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


}

 ?>
