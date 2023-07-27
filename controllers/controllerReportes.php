<?php

class controllerReportes{

//1.1
	function ReporteVentasporDia($idCaja){
        $caja = modelCaja::caja($idCaja);
        if ($caja) {
            if($caja['HoraCierre'] == null){
                $caja['HoraCierre'] = date('Y-m-d H:i:s');
            }
            $respuesta = modelReportes::ReporteVentasporDia($caja['Fecha'], $caja['HoraCierre']);
            return $respuesta;
        }else{
            return array();
        }
	}
	//1.1.1  Para vista ReporteVentas
		function ReporteVentasporDia1($x,$y){
				$respuesta = modelReportes::ReporteVentasporDia1($x,$y);
			  return $respuesta;
		}
	//1.3
		function ReporteVentasporDiaFacturas($x){
				$respuesta = modelReportes::ReporteVentasporDiaFacturas($x);
				return $respuesta;
		}
		//1.3.1 Para vista ReporteVentas
			function ReporteVentasporDiaFacturas1($x,$y){
					$respuesta = modelReportes::ReporteVentasporDiaFacturas1($x,$y);
					return $respuesta;
			}
	//1.2
		function ReporteVentasporDiaDetalle($x){
				$respuesta = modelReportes::ReporteVentasporDiaDetalle($x);
			  return $respuesta;
		}
		//1.2.2
			function ReporteVentasporDiaDetalleFactura($x){
					$respuesta = modelReportes::ReporteVentasporDiaDetalleFactura($x);
					return $respuesta;
			}
			//1.4
				function cajero($x){
						$respuesta = modelReportes::cajero($x);
						return $respuesta;
				}
  //2
	function ReporteVentasporMes($x,$y){
		  $respuesta = modelReportes::ReporteVentasporMes($x,$y);
		  return $respuesta;
 	}
  //3
 	function ReporteVentasporAnio($x,$y){
			$respuesta = modelReportes::ReporteVentasporAnio($x,$y);
			return $respuesta;
	}
  //4
	function ReporteComparacionporAnios(){
	    $respuesta = modelReportes::ReporteComparacionporAnios();
	    return $respuesta;
  }
  //5
  function ReporteMejoresVendedores($x,$y){
      $respuesta = modelReportes::ReporteMejoresVendedores($x,$y);
      return $respuesta;
  }
  //6
  function ReportePlatosmasVendidos($x,$y){
      $respuesta = modelReportes::ReportePlatosmasVendidos($x,$y);
      return $respuesta;    
  }
  //7
  function ReporteBebidasmasVendidas($x,$y){
      $respuesta = modelReportes::ReporteBebidasmasVendidas($x,$y);
      return $respuesta;
  }
  //8
  function ReporteExistenciaMinima(){
      $respuesta = modelReportes::ReporteExistenciaMinima();
      return $respuesta;
  }
  //9
  	function ReporteIngresoEgresospordia($x){
  			$respuesta = modelReportes::ReporteIngresoEgresospordia($x);
  		  return $respuesta;
  	}
    //10.1
    function ReporteIngresoEgresospormes1($x,$y){
        $respuesta = modelReportes::ReporteIngresoEgresospormes1($x,$y);
        return $respuesta;
    }
    //10.2
    function ReporteIngresoEgresospormes2($x,$y){
        $respuesta = modelReportes::ReporteIngresoEgresospormes2($x,$y);
        return $respuesta;
    }
    //11.1
    function ReporteIngresoEgresosporaño1($x,$y){
        $respuesta = modelReportes::ReporteIngresoEgresosporaño1($x,$y);
        return $respuesta;
    }
    //11.2
    function ReporteIngresoEgresosporaño2($x,$y){
        $respuesta = modelReportes::ReporteIngresoEgresosporaño2($x,$y);
        return $respuesta;
    }
    //12
    function ReporteCompraspordia($x){
        $respuesta = modelReportes::ReporteCompraspordia($x);
        return $respuesta;
    }
    //13
    function ReporteCompraspormes($x,$y){
        $respuesta = modelReportes::ReporteCompraspormes($x,$y);
        return $respuesta;
    }
    //14
    function ReporteComprasporaño($x,$y){
        $respuesta = modelReportes::ReporteComprasporaño($x,$y);
        return $respuesta;
    }
    //15
    function ReporteGastospordia($x){
        $respuesta = modelReportes::ReporteGastospordia($x);
        return $respuesta;
    }
    //16
    function ReporteGastospormes($x,$y){
        $respuesta = modelReportes::ReporteGastospormes($x,$y);
        return $respuesta;
    }
    //17
    function ReporteGastosporaño($x,$y){
        $respuesta = modelReportes::ReporteGastosporaño($x,$y);
        return $respuesta;
    }
    //18
    function ReporteCuentrasPorCobrar($x,$y,$E,$T){

			$fechaii = date_create($x);
			$fechai =	date_format($fechaii, 'Y-m-d H:i:s');

			$fechaff = date_create($y);
			$fechaf =	date_format($fechaff, 'Y-m-d 23:59:59');

        $respuesta = modelReportes::ReporteCuentrasPorCobrar($fechai,$fechaf,$E, $T);
        return $respuesta;
    }
    //19
    function ReporteCuentasporcobrarsolventes(){
        $respuesta = modelReportes::ReporteCuentasporcobrarsolventes();
        return $respuesta;
    }
    //20
    function ReporteCuentasporpagarpendientes(){
        $respuesta = modelReportes::ReporteCuentasporpagarpendientes();
        return $respuesta;
    }
    //21
    function ReporteCuentasporpagarsolventes(){
        $respuesta = modelReportes::ReporteCuentasporpagarsolventes();
        return $respuesta;
    }

    //22
    function ReporteCortesias($fecha1,$fecha2){
        $respuesta = modelReportes::ReporteCortesias($fecha1, $fecha2);
        return $respuesta;
    }

    //22.1
    function ReporVenDiaIdPed($x){
        $respuesta = modelReportes::ReporVenDiaIdPed($x);
        return $respuesta;

    }

    //23
    function ReporteIngredientes($x){
        $respuesta = modelReportes::ReporteIngredientes($x);
        return $respuesta;

    }

    //24
    function ReporteItemsPorDia($x){
        $respuesta = modelReportes::ReporteItemsPorDia($x);
        return $respuesta;
    }

    //25 para el nombre del plato
    function ReporNomItem($x){
        $respuesta = modelReportes::ReporNomItem($x);
        return $respuesta;
    }





}
