<?php

require_once "conexion.php";

class modelReportes{
//1.1
	public function ReporteVentasporDia($Fecha1, $Fecha2){
		$stmt = Conexion::conectar()->prepare("SELECT Pd.IdUsuario, P.Nombres,c.Total,c.Propina, c.TotalPagar, 
                  c.FormaPago,c.TipoComprobante,c.NumeroDoc, Pd.IdPedido, c.Documento  
                  from personal P inner join pedido Pd on P.IdPersonal = Pd.IdPersonal 
                  inner join comprobantec c  on Pd.IdPedido = c.IdPedido
                  WHERE	c.Fecha BETWEEN :fecha1 AND  :fecha2
                  and (c.FormaPago ='T' OR c.FormaPago ='E' OR c.FormaPago ='CH'  OR c.FormaPago ='H')
		");
		$stmt -> bindParam(":fecha1", $Fecha1, PDO::PARAM_STR);
		$stmt -> bindParam(":fecha2", $Fecha2, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> null;
	}
	//1.1.1  Para vista ReporteVentas
		public function ReporteVentasporDia1($x,$y){
			$stmt = Conexion::conectar()->prepare("SELECT Pd.IdUsuario, P.Nombres,c.Total,c.Propina, c.TotalPagar, c.FormaPago,c.TipoComprobante, c.IdPedido,
                                c.NumeroDoc, Pd.IdPedido, c.Documento  from personal P inner join pedido Pd on P.IdPersonal = Pd.IdPersonal 
                                inner join comprobantec c  on Pd.IdPedido = c.IdPedido
                                WHERE CAST(Fecha AS DATE )  BETWEEN :fecha1 AND :fecha2
                                and (c.FormaPago ='T' OR c.FormaPago ='E' OR c.FormaPago ='CH' OR c.FormaPago = 'CR' OR c.FormaPago ='H') AND (c.TipoComprobante ='T' OR c.TipoComprobante ='O' ) ");
			$stmt -> bindParam(":fecha1", $x, PDO::PARAM_STR);
			$stmt -> bindParam(":fecha2", $y, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetchAll();
			$stmt -> null;
		}
    
    //1.14.5  Para cinta de auditoria
      public function ReporteVxD($x,$y){
        $stmt = Conexion::conectar()->prepare("SELECT Pd.IdUsuario, P.Nombres,c.Total,c.Propina, c.TotalPagar, c.FormaPago,c.TipoComprobante,
                                  c.NumeroDoc, Pd.IdPedido, c.Documento  from personal P inner join pedido Pd on P.IdPersonal = Pd.IdPersonal 
                                  inner join comprobantec c  on Pd.IdPedido = c.IdPedido
                                  WHERE CAST(Fecha AS DATE )  BETWEEN :fecha1 AND :fecha2
                                  and (c.FormaPago ='T' OR c.FormaPago ='E' OR c.FormaPago ='CH' OR c.FormaPago = 'CR' OR c.FormaPago ='H') AND (c.TipoComprobante ='T' ) ");
        $stmt -> bindParam(":fecha1", $x, PDO::PARAM_STR);
        $stmt -> bindParam(":fecha2", $y, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> null;
      }
    //1.3  Para vista Tickets
      public function ReporteTickets($x,$y){
        $stmt = Conexion::conectar()->prepare("SELECT c.IdComprobante, c.NumeroDoc, c.Total, c.Propina, c.TotalPagar, c.FormaPago, c.TipoComprobante  
                                              from comprobante c WHERE CAST(Fecha AS DATE )  BETWEEN :fecha1 AND :fecha2
                                              AND (c.TipoComprobante ='T' ) ");
        $stmt -> bindParam(":fecha1", $x, PDO::PARAM_STR);
        $stmt -> bindParam(":fecha2", $y, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> null;
      }
    
    //1.3  Para vista Tickets de comprobantec
      public function ReporteTicketsC($x,$y){
        $stmt = Conexion::conectar()->prepare("SELECT c.IdComprobanteC, c.NumeroDoc, c.Total, c.Propina, c.TotalPagar, c.FormaPago, c.TipoComprobante  
                                              from comprobantec c WHERE CAST(Fecha AS DATE )  BETWEEN :fecha1 AND :fecha2
                                              AND (c.TipoComprobante ='T' ) ");
        $stmt -> bindParam(":fecha1", $x, PDO::PARAM_STR);
        $stmt -> bindParam(":fecha2", $y, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> null;
      }
      
      //1.4  Para vista Otros
        public function ReporteOtros($x,$y){
          $stmt = Conexion::conectar()->prepare("SELECT c.IdComprobante, c.NumeroDoc, c.Total, c.Propina, c.TotalPagar, c.FormaPago, c.TipoComprobante  
                                                from comprobante c WHERE CAST(Fecha AS DATE )  BETWEEN :fecha1 AND :fecha2
                                                AND (c.TipoComprobante ='O' ) ");
          $stmt -> bindParam(":fecha1", $x, PDO::PARAM_STR);
          $stmt -> bindParam(":fecha2", $y, PDO::PARAM_STR);
          $stmt -> execute();
          return $stmt -> fetchAll();
          $stmt -> null;
        }
      
      //1.4  Para vista Otros de comprobantec
        public function ReporteOtrosC($x,$y){
          $stmt = Conexion::conectar()->prepare("SELECT c.IdComprobanteC, c.NumeroDoc, c.Total, c.Propina, c.TotalPagar, c.FormaPago, c.TipoComprobante  
                                                from comprobantec c WHERE CAST(Fecha AS DATE )  BETWEEN :fecha1 AND :fecha2
                                                AND (c.TipoComprobante ='O' ) ");
          $stmt -> bindParam(":fecha1", $x, PDO::PARAM_STR);
          $stmt -> bindParam(":fecha2", $y, PDO::PARAM_STR);
          $stmt -> execute();
          return $stmt -> fetchAll();
          $stmt -> null;
        }

    
    //1.1.1  Para vista de los cortes
      public function ReporteVentasporDia2($x,$y){
        $stmt = Conexion::conectar()->prepare("SELECT * from comprobantec c
                                                WHERE	CAST(c.Fecha AS DATE) BETWEEN :fecha1 AND  :fecha2
                                                and (c.FormaPago ='CORTE Z' OR c.FormaPago ='CORTE X' OR c.FormaPago ='CORTE GRAN Z')");
        $stmt -> bindParam(":fecha1", $x, PDO::PARAM_STR);
        $stmt -> bindParam(":fecha2", $y, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> null;
      }

	//1.3
		public function ReporteVentasporDiaFacturas($datosModel){
			$stmt = Conexion::conectar()->prepare("SELECT c.IdComprobante, Pd.IdUsuario, Pd.FechaPedido, P.Nombres, c.Total,c.Propina, c.TotalPagar, c.FormaPago,c.TipoComprobante,c.NumeroDoc, Pd.IdPedido, c.Documento  from personal P inner join pedido Pd on P.IdPersonal = Pd.IdPersonal inner join comprobante c  on Pd.IdPedido = c.IdPedido
			WHERE 				CAST(c.Fecha AS DATE ) = :fecha
				AND (c.FormaPago ='T' OR c.FormaPago = 'E' OR c.FormaPago ='CH' OR c.FormaPago ='CR' OR c.FormaPago ='H') AND (c.TipoComprobante = 'FCF' OR c.TipoComprobante = 'CCF')");
			$stmt -> bindParam(":fecha", $datosModel, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetchAll();
			$stmt -> null;
		}

		//1.3.1 Para vista ReporteVentas
			public function ReporteVentasporDiaFacturas1($x,$y){
				$stmt = Conexion::conectar()->prepare("SELECT c.IdComprobante, Pd.IdUsuario, P.Nombres, c.Total,c.Propina, c.TotalPagar, c.FormaPago,c.TipoComprobante,c.NumeroDoc, Pd.IdPedido, c.Documento  from personal P inner join pedido Pd on P.IdPersonal = Pd.IdPersonal inner join comprobante c  on Pd.IdPedido = c.IdPedido
				WHERE
					CAST(Fecha AS DATE )  BETWEEN :fecha1 AND :fecha2
					AND (c.FormaPago ='T' OR c.FormaPago = 'E' OR c.FormaPago ='CH' OR c.FormaPago ='CR' OR c.FormaPago ='H') AND (c.TipoComprobante = 'FCF' OR c.TipoComprobante = 'CCF')");
					$stmt -> bindParam(":fecha1", $x, PDO::PARAM_STR);
					$stmt -> bindParam(":fecha2", $y, PDO::PARAM_STR);
				$stmt -> execute();
				return $stmt -> fetchAll();
				$stmt -> null;
			}

	//1.2
		public function ReporteVentasporDiaDetalleT($datosModel){
			$stmt = Conexion::conectar()->prepare("SELECT I.Descripcion, DP.Cantidad, DP.Precio
			from  items I inner join detallepedido DP on I.IdItems=DP.IdItems inner join pedido P on P.IdPedido=DP.IdPedido
			inner join comprobantec c ON c.IdPedido = P.IdPedido where c.NumeroDoc = :nrocomprobante AND c.TipoComprobante='T'");
			$stmt -> bindParam(":nrocomprobante", $datosModel, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetchAll();
			$stmt -> null;
		}
	//1.2
		public function ReporteVentasporDiaDetalleO($datosModel){
			$stmt = Conexion::conectar()->prepare("SELECT I.Descripcion, DP.Cantidad, DP.Precio
			from  items I inner join detallepedido DP on I.IdItems=DP.IdItems inner join pedido P on P.IdPedido=DP.IdPedido
			inner join comprobantec c ON c.IdPedido = P.IdPedido where c.NumeroDoc = :nrocomprobante AND c.TipoComprobante='O' ");
			$stmt -> bindParam(":nrocomprobante", $datosModel, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetchAll();
			$stmt -> null;
		}
		//1.2.2
			public function ReporteVentasporDiaDetalleFactura($datosModel){
				$stmt = Conexion::conectar()->prepare("SELECT I.Descripcion, DP.Cantidad, DP.Precio
				from  items I inner join detallepedido DP on I.IdItems=DP.IdItems inner join pedido P on P.IdPedido=DP.IdPedido
				inner join comprobante c ON c.IdPedido = P.IdPedido where c.NumeroDoc = :nrocomprobante and c.TipoComprobante != 'T'");
				$stmt -> bindParam(":nrocomprobante", $datosModel, PDO::PARAM_STR);
				$stmt -> execute();
				return $stmt -> fetchAll();
				$stmt -> null;
			}
			//1.4
			//9
			public function cajero ($datosModel){
				$stmt = Conexion::conectar()->prepare("SELECT Usuario from usuario WHERE IdUsuario  = :IdUsuario");
				$stmt -> bindParam(":IdUsuario", $datosModel, PDO::PARAM_STR);
				$stmt -> execute();
				return $stmt -> fetch();
				$stmt -> null;
			}
//2
  public function ReporteVentasporMes($x,$y){
    $stmt = Conexion::conectar()->prepare("SELECT
			DATE_FORMAT(c.Fecha, '%d')  as Dia,
			SUM(c.Total) as Total,
			SUM(c.Propina) as Propina,
			SUM(c.TotalPagar) as TotalPagar
		from
			personal P inner join pedido Pd on P.IdPersonal = Pd.IdPersonal
			inner join comprobante c  on Pd.IdPedido = c.IdPedido
		WHERE
			c.Fecha  BETWEEN :fecha1 AND :fecha2
			and (c.TipoComprobante ='DEV' OR c.TipoComprobante ='T'  OR c.TipoComprobante ='FCF' OR c.TipoComprobante ='CCF')
		GROUP BY c.Fecha ORDER BY c.Fecha ASC");
    $stmt -> bindParam(":fecha1", $x, PDO::PARAM_STR);
    $stmt -> bindParam(":fecha2", $y, PDO::PARAM_STR);
    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> null;
  }
//3
  public function ReporteVentasporAnio($x,$y){
    $stmt = Conexion::conectar()->prepare("SELECT SUM(c.Total) AS Total, DATE_FORMAT(Pd.FechaPedido,'%M')  as Mes, SUM(c.Propina) as Propina, SUM(c.TotalPagar) as TotalPagar from personal P inner join pedido Pd on P.IdPersonal = Pd.IdPersonal inner join comprobante c  on Pd.IdPedido = c.IdPedido WHERE CAST(Pd.FechaPedido AS DATE ) BETWEEN :fecha1 AND :fecha2 and (c.TipoComprobante ='DEV' OR c.TipoComprobante ='T')  GROUP BY DATE_FORMAT(Pd.FechaPedido,'%M') ");
		$stmt -> bindParam(":fecha1", $x, PDO::PARAM_STR);
    $stmt -> bindParam(":fecha2", $y, PDO::PARAM_INT);
    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> null;
  }

//4
  public function ReporteComparacionporAnios(){
    $stmt = Conexion::conectar()->prepare("SELECT SUM(c.TotalPagar) AS Total, DATE_FORMAT(Pd.FechaPedido,'%Y')  as Anio  from personal P inner join pedido Pd on P.IdPersonal = Pd.IdPersonal inner join comprobante c  on Pd.IdPedido = c.IdPedido WHERE CAST(Pd.FechaPedido AS DATE ) BETWEEN '2016-01-01' AND '2024-12-31' and (c.TipoComprobante ='DEV' OR c.TipoComprobante ='T') GROUP BY DATE_FORMAT(Pd.FechaPedido,'%Y')");
		$stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> null;
  }

//5
  public function ReporteMejoresVendedores($x,$y){
    $stmt = Conexion::conectar()->prepare("SELECT P.Nombres as Nombres, sum(c.Total) as Total  
                    from personal P inner join pedido Pd on P.IdPersonal = Pd.IdPersonal 
                    inner join comprobante c  on Pd.IdPedido = c.IdPedido  
                    WHERE  CAST(Pd.FechaPedido AS DATE ) BETWEEN :fecha1 AND :fecha2 
                    AND (c.TipoComprobante ='DEV' OR c.TipoComprobante ='T' OR c.TipoComprobante ='O' ) 
                    GROUP BY P.Nombres order by sum(Pd.Total) desc");
		$stmt -> bindParam(":fecha1", $x, PDO::PARAM_STR);
    $stmt -> bindParam(":fecha2", $y, PDO::PARAM_STR);
    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> null;
  }

  //6
  public function ReportePlatosmasVendidos($x,$y){
    $stmt = Conexion::conectar()->prepare("SELECT	SUM(DP.Cantidad) as Cantidad,	I.Descripcion,	I.PrecioVenta, 
                                (I.PrecioVenta*SUM(DP.Cantidad)) as Total 
                                from	items I inner join detallepedido DP on I.IdItems=DP.IdItems 
                                inner join pedido P on P.IdPedido=DP.IdPedido 
                                inner join categoria C ON C.IdCategoria = I.IdCategoria 
                                where (I.IdTipoItem = 2) AND P.FechaPedido 
                                BETWEEN :fecha1 AND :fecha2 AND C.FormaDePreparar = 'Cocina'
		                            group by I.Descripcion, I.PrecioVenta  order by (Cantidad) desc  LIMIT 10000");
  	$stmt -> bindParam(":fecha1", $x, PDO::PARAM_STR);
	  $stmt -> bindParam(":fecha2", $y, PDO::PARAM_STR);
    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> null;
  }

  //7
  public function ReporteBebidasmasVendidas ($x,$y){
    $stmt = Conexion::conectar()->prepare("SELECT SUM(DP.Cantidad) as Cantidad,I.Descripcion,I.PrecioVenta,(I.PrecioVenta* SUM(DP.Cantidad)) as Total
                    from items I inner join detallepedido DP on I.IdItems=DP.IdItems 
                    inner join pedido P on P.IdPedido=DP.IdPedido
                    inner join categoria C ON C.IdCategoria = I.IdCategoria 
                    where (I.IdTipoItem = 2) AND P.FechaPedido
                    BETWEEN :fecha1 AND :fecha2 AND C.FormaDePreparar = 'Bar'
                    group by I.Descripcion, I.PrecioVenta
                    order by (Cantidad) desc LIMIT 10000");
		$stmt -> bindParam(":fecha1", $x, PDO::PARAM_STR);
    $stmt -> bindParam(":fecha2", $y, PDO::PARAM_STR);
    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> null;
  }
  //8
  public function ReporteExistenciaMinima (){
    $stmt = Conexion::conectar()->prepare("SELECT  I.Descripcion ,I.Stock
    from tipoitem T inner join items I on T.IdTipoItem=I.IdTipoItem
    where I.Stock between 0 and 20 and T.IdTipoItem = 2");
    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> null;
  }

  //9
  public function ReporteIngresoEgresospordia ($datosModel){
    $stmt = Conexion::conectar()->prepare("SELECT Tipo, Monto, Descripcion from detallecaja WHERE CAST(Fecha AS DATE )  = :fecha");
    $stmt -> bindParam(":fecha", $datosModel, PDO::PARAM_STR);
    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> null;
  }

//10.1
  public function ReporteIngresoEgresospormes1 ($x,$y){
    $stmt = Conexion::conectar()->prepare("SELECT sum(Monto) as Total,  DATE_FORMAT(Fecha,'%e') as Dia from detallecaja
    WHERE CAST(Fecha AS DATE )  BETWEEN :fecha1 AND :fecha2 and Tipo = 'Ingreso'
    GROUP BY DATE_FORMAT(Fecha,'%e') ORDER BY Fecha ASC");
		$stmt -> bindParam(":fecha1", $x, PDO::PARAM_STR);
    $stmt -> bindParam(":fecha2", $y, PDO::PARAM_INT);
    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> null;
  }
//10.2
  public function ReporteIngresoEgresospormes2 ($x,$y){
    $stmt = Conexion::conectar()->prepare("SELECT sum(Monto) as Total,  DATE_FORMAT(Fecha,'%e') as Dia from detallecaja
    WHERE CAST(Fecha AS DATE )  BETWEEN :fecha1 AND :fecha2 and Tipo = 'Egreso'
    GROUP BY DATE_FORMAT(Fecha,'%e') ORDER BY Fecha ASC");
		$stmt -> bindParam(":fecha1", $x, PDO::PARAM_STR);
    $stmt -> bindParam(":fecha2", $y, PDO::PARAM_INT);
    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> null;
  }

//11.1
  public function ReporteIngresoEgresosporaño1 ($x,$y){
    $stmt = Conexion::conectar()->prepare("SELECT sum(Monto) as Total, DATE_FORMAT(Fecha,'%M')  as Mes  from detallecaja
    WHERE CAST(Fecha AS DATE ) BETWEEN :fecha1 AND :fecha2 and Tipo = 'Ingreso'
    GROUP BY DATE_FORMAT(Fecha,'%M') ORDER BY Mes ASC ");
		$stmt -> bindParam(":fecha1", $x, PDO::PARAM_STR);
    $stmt -> bindParam(":fecha2", $y, PDO::PARAM_INT);
    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> null;
  }
  //11.2
  public function ReporteIngresoEgresosporaño2 ($x,$y){
    $stmt = Conexion::conectar()->prepare("SELECT sum(Monto) as Total, DATE_FORMAT(Fecha,'%M')  as Mes  from detallecaja
    WHERE CAST(Fecha AS DATE ) BETWEEN :fecha1 AND :fecha2 and Tipo = 'Egreso'
    GROUP BY DATE_FORMAT(Fecha,'%M') ORDER BY Mes ASC ");
		$stmt -> bindParam(":fecha1", $x, PDO::PARAM_STR);
    $stmt -> bindParam(":fecha2", $y, PDO::PARAM_INT);
    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> null;
  }
//12
  public function ReporteCompraspordia ($datosModel){
    $stmt = Conexion::conectar()->prepare("SELECT TipoDoc, NroComprobante,Serie, Total FROM compras WHERE CAST(Fecha AS DATE )  = :fecha");
    $stmt -> bindParam(":fecha", $datosModel, PDO::PARAM_STR);
    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> null;
  }
//13
  public function ReporteCompraspormes ($x,$y){
    $stmt = Conexion::conectar()->prepare("SELECT  DATE_FORMAT(Fecha,'%e') as Dia, sum(Total) as Total  FROM compras
    WHERE CAST(Fecha AS DATE )  BETWEEN :fecha1 AND :fecha2
    GROUP BY DATE_FORMAT(Fecha,'%e') ORDER BY Fecha ASC");
		$stmt -> bindParam(":fecha1", $x, PDO::PARAM_STR);
    $stmt -> bindParam(":fecha2", $y, PDO::PARAM_INT);
    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> null;
  }
//14
  public function ReporteComprasporaño ($x,$y){
    $stmt = Conexion::conectar()->prepare("SELECT DATE_FORMAT(Fecha,'%M')  as Mes , sum(Total) as Total  FROM compras
    WHERE CAST(Fecha AS DATE )  BETWEEN :fecha1 AND :fecha2
    GROUP BY  DATE_FORMAT(Fecha,'%M')  ORDER BY Fecha ASC");
		$stmt -> bindParam(":fecha1", $x, PDO::PARAM_STR);
    $stmt -> bindParam(":fecha2", $y, PDO::PARAM_INT);
    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> null;
  }
//15
  public function ReporteGastospordia ($datosModel){
    $stmt = Conexion::conectar()->prepare("SELECT Descripcion, Monto FROM detallecaja
    WHERE CAST(Fecha AS DATE )  = :fecha and LEFT(Descripcion,6) != 'Compra' and Tipo = 'Egreso'
    ORDER BY Fecha ASC");
    $stmt -> bindParam(":fecha", $datosModel, PDO::PARAM_STR);
    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> null;
  }
//16
  public function ReporteGastospormes ($x,$y){
    $stmt = Conexion::conectar()->prepare("SELECT DATE_FORMAT(Fecha,'%e') as Dia, sum(Monto) as Total  FROM detallecaja
    WHERE CAST(Fecha AS DATE )  BETWEEN :fecha1 AND :fecha2 and LEFT(Descripcion,6) != 'Compra' and Tipo = 'Egreso'
    GROUP BY DATE_FORMAT(Fecha,'%e') ORDER BY Fecha ASC");
		$stmt -> bindParam(":fecha1", $x, PDO::PARAM_STR);
    $stmt -> bindParam(":fecha2", $y, PDO::PARAM_INT);
    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> null;
  }
//17
  public function ReporteGastosporaño ($x,$y){
    $stmt = Conexion::conectar()->prepare("SELECT DATE_FORMAT(Fecha,'%M') as Mes, sum(Monto) as Total FROM detallecaja
    WHERE CAST(Fecha AS DATE )  BETWEEN :fecha1 AND :fecha2 and LEFT(Descripcion,6) != 'Compra' and Tipo = 'Egreso'
    GROUP BY DATE_FORMAT(Fecha,'%M') ORDER BY Fecha ASC");
		$stmt -> bindParam(":fecha1", $x, PDO::PARAM_STR);
    $stmt -> bindParam(":fecha2", $y, PDO::PARAM_INT);
    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> null;
  }
    //18
  public function ReporteCuentrasPorCobrar ($Fecha1,$Fecha2,$Estado, $Tipo){
    $stmt = Conexion::conectar()->prepare("SELECT Pd.IdUsuario, P.Nombres, Pd.FechaPedido, c.Total, c.Propina, c.TotalPagar, 
                  c.FormaPago ,c.TipoComprobante, c.NumeroDoc, c.FechaFact, Pd.IdPedido, c.Documento, cc.Estado, cc.FechaC, cc.Tipo, cli.Nombre 
                  from personal P inner join pedido Pd on P.IdPersonal = Pd.IdPersonal  
                  inner join comprobantec c on Pd.IdPedido = c.IdPedido 
                  INNER JOIN cuentasporcobrar cc ON	Pd.IdPedido = cc.IdPedido
                  inner join clientes cli on cli.IdCliente= cc.IdCliente 
                  WHERE CAST(c.Fecha AS DATE) BETWEEN :fecha1 AND :fecha2 
                  and (cc.Tipo=:Tipo) and cc.Estado = :Estado");
			$stmt -> bindParam(":fecha1", $Fecha1, PDO::PARAM_STR);
			$stmt -> bindParam(":fecha2", $Fecha2, PDO::PARAM_STR);
			$stmt -> bindParam(":Estado", $Estado, PDO::PARAM_STR);
      $stmt -> bindParam(":Tipo", $Tipo, PDO::PARAM_STR);
    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> null;
  }
  public function ReporteCuentrasPorCobrarFacturas ($Fecha1,$Fecha2,$Estado){
    $stmt = Conexion::conectar()->prepare("SELECT Pd.IdUsuario, P.Nombres, Pd.FechaPedido, c.Total, c.Propina, 
            c.TotalPagar, c.FormaPago, c.TipoComprobante, 
            c.NumeroDoc, Pd.IdPedido, c.Documento, cc.Estado 
            from personal P inner join pedido Pd on P.IdPersonal = Pd.IdPersonal 
            inner join comprobante c on Pd.IdPedido = c.IdPedido 
            INNER JOIN cuentasporcobrar cc ON Pd.IdPedido = cc.IdPedido 
            WHERE c.TipoComprobante != 'T' 
            AND CAST(c.Fecha AS DATE ) BETWEEN :fecha1 AND :fecha2 
            and (c.FormaPago = 'CR' or c.FormaPago ='H') and cc.Estado = :Estado");
			$stmt -> bindParam(":fecha1", $Fecha1, PDO::PARAM_STR);
			$stmt -> bindParam(":fecha2", $Fecha2, PDO::PARAM_STR);
			$stmt -> bindParam(":Estado", $Estado, PDO::PARAM_STR);
    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> null;
  }
//19
  public function ReporteCuentasporcobrarsolventes (){
    $stmt = Conexion::conectar()->prepare("SELECT c.TipoComprobante, c.NumeroDoc, c.NombreCliente, cc.Monto, Min(dcc.SaldoPendiente) as SaldoPendiente, (dcc.Fecha) as UltimoAbono
    FROM comprobante c  inner join cuentasporcobrar cc on c.IdComprobante = cc.IdComprobante inner join detallecuentaporcobrar dcc
    on cc.IdCuentasPorCobrar = dcc.IdCuentaPorCobrar where cc.Estado = 'Solvente' GROUP BY dcc.IdCuentaPorCobrar order by sum(dcc.Fecha) desc");
    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> null;
    }
//20
  public function ReporteCuentasporpagarpendientes (){
    $stmt = Conexion::conectar()->prepare("SELECT c.TipoDoc, c.NroComprobante, p.RazonSocial, cp.Monto, Min(dcp.SaldoPendiente) as SaldoPendiente, (dcp.Fecha) as UltimoAbono
    from proveedor p inner join  compras c on p.IdProveedor = c.IdProveedor inner join cuentasporpagar cp on c.IdCompra = cp.IdCompra
    inner join detallecuentaporpagar dcp on cp.IdCuentaPorPagar = dcp.IdCuentaPorPagar where cp.Estado = 'Pendiente'
    GROUP BY dcp.IdCuentaPorPagar order by sum(dcp.Fecha) desc");
    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> null;
    }


    //21
  public function ReporteCuentasporpagarsolventes (){
    $stmt = Conexion::conectar()->prepare("SELECT c.TipoDoc, c.NroComprobante, p.RazonSocial, cp.Monto, Min(dcp.SaldoPendiente) as SaldoPendiente, (dcp.Fecha) as UltimoAbono
    from proveedor p inner join  compras c on p.IdProveedor = c.IdProveedor inner join cuentasporpagar cp on c.IdCompra = cp.IdCompra
    inner join detallecuentaporpagar dcp on cp.IdCuentaPorPagar = dcp.IdCuentaPorPagar where cp.Estado = 'Solvente'
    GROUP BY dcp.IdCuentaPorPagar order by sum(dcp.Fecha) desc");
    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> null;
    }

    //22 by Rm 
    public function ReporteCortesias ($Fecha1, $Fecha2){
      $stmt = Conexion::conectar()->prepare("SELECT Cor.IdPedido, Cor.Total, Cor.NombreCliente, Pd.FechaPedido 
        FROM cortesias Cor INNER JOIN pedido Pd ON  Pd.IdPedido = Cor.IdPedido WHERE CAST(Pd.FechaPedido AS DATE ) BETWEEN :fecha1 AND :fecha2");
      $stmt -> bindParam(":fecha1", $Fecha1, PDO::PARAM_STR);
      $stmt -> bindParam(":fecha2", $Fecha2, PDO::PARAM_STR);
      $stmt -> execute();
      return $stmt -> fetchAll();
      $stmt -> null;
    }

    public function EditCorrelativo ($V1, $V2){
    $stmt = Conexion::conectar()->prepare("UPDATE comprobante SET NumeroDoc = :NumeroDoc WHERE IdComprobante = :IdComprobante");
    $stmt -> bindParam(":NumeroDoc", $V1, PDO::PARAM_STR);
    $stmt -> bindParam(":IdComprobante", $V2, PDO::PARAM_STR);
    if($stmt->execute()){
        return "success";
      }else{
        return "error";
      }
      $stmt->null;
    }


    //22.1 by Rm

    public function ReporVenDiaIdPed($datosModel){
      $stmt = Conexion::conectar()->prepare("SELECT I.Descripcion, DP.Cantidad, DP.Precio
			from  items I inner join detallepedido DP on I.IdItems=DP.IdItems inner join pedido P on P.IdPedido=DP.IdPedido
			inner join cortesias Cor ON Cor.IdPedido = P.IdPedido where Cor.IdPedido = :IdPedido");
			$stmt -> bindParam(":IdPedido", $datosModel, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetchAll();
			$stmt -> null;

		}
    
    //


    //23 by Rm
    public function ReporteIngredientes($datosModel){
      $stmt = Conexion::conectar()->prepare("SELECT Ing.DescripcionIng, Ing.UnidadMedida, rel.CantidadU, 
                i.IdItems, i.Descripcion, rel.IdRelacion
                from  ingredientes Ing inner join relacioningitem rel ON Ing.IdIngredientes = rel.IdIngredientes  
                INNER join items i on i.IdItems=rel.IdItems   
                where rel.IdItems = :IdItems");
			$stmt -> bindParam(":IdItems", $datosModel, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetchAll();
			$stmt -> null;

		}


    //24 

    public function ReporteItemsPorDia($x){
      $stmt = Conexion::conectar()->prepare("SELECT	SUM(DP.Cantidad) as Cantidad,	I.Descripcion,	I.PrecioVenta, 
                              (I.PrecioVenta*SUM(DP.Cantidad)) as Total 
                              from	items I inner join detallepedido DP on I.IdItems=DP.IdItems 
                              inner join pedido P on P.IdPedido=DP.IdPedido 
                              inner join categoria C ON C.IdCategoria = I.IdCategoria 
                              where (I.IdTipoItem = 2) AND CAST(P.FechaPedido AS DATE ) = :fecha
                              AND (C.FormaDePreparar = 'Cocina'  or C.FormaDePreparar = 'Bar')  
                              AND (DP.Actualizar = 0 or DP.Actualizar=1) 
                              group by I.Descripcion, I.PrecioVenta  order by (Cantidad) desc  LIMIT 10000");
      $stmt -> bindParam(":fecha", $x, PDO::PARAM_STR);
      $stmt -> execute();
      return $stmt -> fetchAll();
      $stmt -> null;
    }


    public function ReporNomItem($x){
      $stmt = Conexion::conectar()->prepare("SELECT Descripcion FROM items where IdItems=:IdItems");
      $stmt -> bindParam(":IdItems", $x, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();
			$stmt -> null;
    }

    //26 solo pa ver los ingredientes()

      public function ReporIng(){
        $stmt = Conexion::conectar()->prepare("SELECT * FROM ingredientes ORDER BY Cantidad");
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> null;  
      }
    

      //--------------PASAR TICKETS DE T A O POR SU IDPEDIDO

    public function cambiarTicket($id){
      $stmt = Conexion::conectar()->prepare("UPDATE comprobante  SET TipoComprobante = 'O' WHERE IdPedido = :id");
      $stmt -> bindParam(":id" , $id, PDO::PARAM_INT);
      $stmt -> execute();
      return $stmt -> fetchAll();
      $stmt -> null;
    }

    public function cambiarTicketC($id){ //AHORA POR EL IDPEDIDO
      $stmt = Conexion::conectar()->prepare("UPDATE comprobantec SET TipoComprobante = 'O' WHERE IdPedido = :id");
      $stmt -> bindParam(":id" , $id, PDO::PARAM_INT);
      $stmt -> execute();
      return $stmt -> fetchAll();
      $stmt -> null;
    }
    
    public function cambiarCorrelativo($id, $corre){
      $stmt = Conexion::conectar()->prepare("UPDATE comprobante SET NumeroDoc = :num WHERE IdPedido = :id");
      $stmt -> bindParam(":id" , $id, PDO::PARAM_STR);
      $stmt -> bindParam(":num" , $corre, PDO::PARAM_STR);
      $stmt -> execute();
      return $stmt -> fetchAll();
      $stmt -> null;
    }
    
    public function cambiarCorrelativoC($id, $corre){
      $stmt = Conexion::conectar()->prepare("UPDATE comprobantec SET NumeroDoc = :num WHERE IdPedido = :id");
      $stmt -> bindParam(":id" , $id, PDO::PARAM_STR);
      $stmt -> bindParam(":num" , $corre, PDO::PARAM_STR);
      $stmt -> execute();
      return $stmt -> fetchAll();
      $stmt -> null;
    }

    public function menorCorrelativo($id){
      $stmt = Conexion::conectar()->prepare("SELECT IdComprobante, NumeroDoc FROM comprobante WHERE TipoComprobante = 'T' AND IdPedido< :id ORDER BY IdComprobante DESC  LIMIT 1");
      $stmt -> bindParam(":id" , $id, PDO::PARAM_STR);
      $stmt -> execute();
      return $stmt -> fetch();
      $stmt -> null;
    }
    
    public function menorCorrelativoC($id){
      $stmt = Conexion::conectar()->prepare("SELECT IdComprobanteC, NumeroDoc FROM comprobantec WHERE TipoComprobante = 'T' AND IdPedido< :id ORDER BY IdComprobanteC DESC  LIMIT 1");
      $stmt -> bindParam(":id" , $id, PDO::PARAM_STR);
      $stmt -> execute();
      return $stmt -> fetch();
      $stmt -> null;
    }
    
    public function menorCorrelativoO($id){
      $stmt = Conexion::conectar()->prepare("SELECT IdComprobante, NumeroDoc FROM comprobante WHERE TipoComprobante = 'O' AND IdPedido< :id ORDER BY IdComprobante DESC  LIMIT 1");
      $stmt -> bindParam(":id" , $id, PDO::PARAM_STR);
      $stmt -> execute();
      return $stmt -> fetch();
      $stmt -> null;
    }
    
    public function menorCorrelativoOC($id){
      $stmt = Conexion::conectar()->prepare("SELECT IdComprobanteC, NumeroDoc FROM comprobantec WHERE TipoComprobante = 'O' AND IdPedido< :id ORDER BY IdComprobanteC DESC  LIMIT 1");
      $stmt -> bindParam(":id" , $id, PDO::PARAM_STR);
      $stmt -> execute();
      return $stmt -> fetch();
      $stmt -> null;
    }

    public function ticketsMayoresC($id){
      $stmt = Conexion::conectar()->prepare("SELECT IdComprobanteC, NumeroDoc, IdPedido FROM comprobantec WHERE TipoComprobante = 'T' AND IdPedido>= :id");
      $stmt -> bindParam(":id" , $id, PDO::PARAM_STR);
      $stmt -> execute();
      return $stmt -> fetchAll();
      $stmt -> null;
    }
    
    public function otrosMayoresC($id){
      $stmt = Conexion::conectar()->prepare("SELECT IdComprobanteC, NumeroDoc, IdPedido FROM comprobantec WHERE TipoComprobante = 'O' AND IdPedido>= :id");
      $stmt -> bindParam(":id" , $id, PDO::PARAM_STR);
      $stmt -> execute();
      return $stmt -> fetchAll();
      $stmt -> null;
    }
    
    public function ticketsMayores($id){
      $stmt = Conexion::conectar()->prepare("SELECT IdComprobante, NumeroDoc, IdPedido FROM comprobante WHERE TipoComprobante = 'T' AND IdPedido> :id");
      $stmt -> bindParam(":id" , $id, PDO::PARAM_STR);
      $stmt -> execute();
      return $stmt -> fetchAll();
      $stmt -> null;
    }

    public function ReporteEliminados ($Fecha1, $Fecha2){
      $stmt = Conexion::conectar()->prepare("SELECT p.IdPedido, pe.Nombres,i.Descripcion, dp.Cantidad, dp.Precio, dp.Cambios   
                                              FROM pedido p INNER JOIN detallepedido dp ON  dp.IdPedido = p.IdPedido
                                              INNER JOIN items i ON i.IdItems = dp.IdItems
                                              INNER JOIN personal pe ON pe.IdPersonal = p.IdPersonal
                                              WHERE CAST(p.FechaPedido AS DATE ) BETWEEN :fecha1 AND :fecha2
                                              AND p.Estado = 'X'");
      $stmt -> bindParam(":fecha1", $Fecha1, PDO::PARAM_STR);
      $stmt -> bindParam(":fecha2", $Fecha2, PDO::PARAM_STR);
      $stmt -> execute();
      return $stmt -> fetchAll();
      $stmt -> null;
    }
}

