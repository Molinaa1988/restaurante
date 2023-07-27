<?php

class controllerInicio{

	function listarCobrosDia($x){
			$respuesta = modelInicio::listarCobrosDia($x);
		  return $respuesta;
	}
	function listarVentaDia($x){
		  $respuesta = modelInicio::listarVentaDia($x);
		  return $respuesta;
 	}
	function listarVentaDiaFCFyCCF($x){
			$respuesta = modelInicio::listarVentaDiaFCFyCCF($x);
			return $respuesta;
	}
 	function listarComprasDia($x){
			$respuesta = modelInicio::listarComprasDia($x);
			return $respuesta;
	}
	function listarPagosDia($x){
	    $respuesta = modelInicio::listarPagosDia($x);
	    return $respuesta;
  }


}
