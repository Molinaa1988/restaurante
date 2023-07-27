<?php
date_default_timezone_set('America/El_Salvador');
class controllerCocina{

		 function idPedidos(){
		$respuesta = modelCocina::idPedidos();
		return $respuesta;
	}
     function nroMesa($datosModel){
    $respuesta = modelCocina::nroMesa($datosModel);
    return $respuesta;
  }
     function mesero($datosModel){
    $respuesta = modelCocina::mesero($datosModel);
    return $respuesta;
  }
     function minDemora($datosModel){
    $respuesta = modelCocina::minDemora($datosModel);
		//$minutos = ceil((strtotime(date('Y-m-d H:i:s')) - strtotime($respuesta['mi']) / 60));
		$fecha1 = new DateTime(date('Y-m-d H:i:s'));
		$fecha2 = new DateTime($respuesta['mi']);

		$intervalo = $fecha1->diff($fecha2);
    //$R =  $intervalo->format('%i minutos %s segundos');
		$R =  $intervalo->format('%i min');
    return $R;
  }
			function DetallePedido($datosModel){
 		$respuesta = modelCocina::DetallePedido($datosModel);
 		return $respuesta;
	}

}
