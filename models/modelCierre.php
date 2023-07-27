<?php
date_default_timezone_set('America/El_Salvador');
require_once "conexion.php";

class modelCierre{


// PARA REPORTES-------------------------------------------------------------------------
  public function correoresumenticket($Fecha1, $Fecha2){
		$stmt = Conexion::conectar()->prepare("SELECT CPC.NumeroDoc, CPC.FormaPago, CPC.Total, CPC.Propina, P.Tarjeta, CPC.TotalPagar 
    from comprobantec CPC INNER JOIN pedido P ON CPC.IdPedido = P.IdPedido 
    where CPC.Fecha BETWEEN :fecha1 AND :fecha2 and CPC.TipoComprobante ='T'
    AND CPC.FormaPago!= 'CR'");
    $stmt->bindParam(":fecha1", $Fecha1, PDO::PARAM_STR);
    $stmt->bindParam(":fecha2", $Fecha2, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->null;
	}

  public function correoresumenotros($Fecha1, $Fecha2){
		$stmt = Conexion::conectar()->prepare("SELECT CPC.NumeroDoc, CPC.FormaPago, CPC.Total, CPC.Propina, P.Tarjeta, CPC.TotalPagar 
    from comprobantec CPC INNER JOIN pedido P ON CPC.IdPedido = P.IdPedido 
    where CPC.Fecha BETWEEN :fecha1 AND :fecha2 and CPC.TipoComprobante ='O'
    AND CPC.FormaPago!= 'CR'");
    $stmt->bindParam(":fecha1", $Fecha1, PDO::PARAM_STR);
    $stmt->bindParam(":fecha2", $Fecha2, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->null;
	}

  public function correoresumenfcf($Fecha1, $Fecha2){
    $stmt = Conexion::conectar()->prepare("SELECT CP.NumeroDoc, CP.FormaPago, CP.Total, CP.Propina, P.Tarjeta, CP.TotalPagar FROM comprobante CP INNER JOIN pedido P  ON CP.IdPedido = P.IdPedido 
                                            WHERE CP.Fecha BETWEEN :fecha1 AND :fecha2 and CP.TipoComprobante ='FCF'");
    $stmt->bindParam(":fecha1", $Fecha1, PDO::PARAM_STR);
    $stmt->bindParam(":fecha2", $Fecha2, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll();
    $stmt->null;
  }
  public function correoresumenccf($Fecha1, $Fecha2){
    $stmt = Conexion::conectar()->prepare("SELECT CP.NumeroDoc, CP.FormaPago, CP.Total, CP.Propina, P.Tarjeta, CP.TotalPagar FROM comprobante CP INNER JOIN pedido P  ON CP.IdPedido = P.IdPedido 
                                            WHERE CP.Fecha BETWEEN :fecha1 AND :fecha2 and CP.TipoComprobante ='CCF'");
    $stmt->bindParam(":fecha1", $Fecha1, PDO::PARAM_STR);
    $stmt->bindParam(":fecha2", $Fecha2, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll();
    $stmt->null;
  }

  // INTENTO 001 DE MOSTRAR CORTESIAS 
  public function correoresumenCor($Fecha1, $Fecha2){
    $stmt = Conexion::conectar()->prepare("SELECT Cor.IdPedido, Cor.Total, Cor.NombreCliente, Pd.FechaPedido 
                                    FROM cortesias Cor INNER JOIN pedido Pd ON Pd.IdPedido = Cor.IdPedido 
                                    WHERE Pd.FechaPedido BETWEEN :fecha1 AND :fecha2");
    $stmt->bindParam(":fecha1", $Fecha1, PDO::PARAM_STR);
    $stmt->bindParam(":fecha2", $Fecha2, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll();
    $stmt->null;
  }

  //ahora para los Hugos
  public function correoresumenHugo($Fecha1, $Fecha2){
    $stmt = Conexion::conectar()->prepare("SELECT Pd.IdUsuario, P.Nombres, Pd.FechaPedido, c.Total,c.Propina, c.TotalPagar, 
    c.FormaPago,c.TipoComprobante,c.NumeroDoc, Pd.IdPedido, c.Documento, cc.Estado 
    from personal P inner join pedido Pd on P.IdPersonal = Pd.IdPersonal 
    inner join comprobantec c on Pd.IdPedido = c.IdPedido 
    INNER JOIN cuentasporcobrar cc ON Pd.IdPedido = cc.IdPedido 
    WHERE c.Fecha BETWEEN :fecha1 AND :fecha2 and c.FormaPago = 'H' and cc.Estado = 'P'");
    $stmt->bindParam(":fecha1", $Fecha1, PDO::PARAM_STR);
    $stmt->bindParam(":fecha2", $Fecha2, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll();
    $stmt->null;

  }

    //ahora para los creditos 040521
       //ahora para los Hugos
  public function correoresumenCr($Fecha1, $Fecha2){
    $stmt = Conexion::conectar()->prepare("SELECT Pd.IdUsuario, P.Nombres, Pd.FechaPedido, c.Total,c.Propina, c.TotalPagar, 
    c.FormaPago,c.TipoComprobante,c.NumeroDoc, Pd.IdPedido, c.Documento, cc.Estado 
    from personal P inner join pedido Pd on P.IdPersonal = Pd.IdPersonal 
    inner join comprobantec c on Pd.IdPedido = c.IdPedido 
    INNER JOIN cuentasporcobrar cc ON Pd.IdPedido = cc.IdPedido 
    WHERE c.Fecha BETWEEN :fecha1 AND :fecha2 and c.FormaPago = 'CR' and cc.Estado = 'P'");
    $stmt->bindParam(":fecha1", $Fecha1, PDO::PARAM_STR);
    $stmt->bindParam(":fecha2", $Fecha2, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll();
    $stmt->null;

  }

  public function correoresumenCompras($Fecha){
    $stmt = Conexion::conectar()->prepare("SELECT NroComprobante,TipoDoc,Descripcion,Subtotal,Iva,Total from compras WHERE Fecha =  :fecha");
    $stmt->bindParam(":fecha", $Fecha, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll();
    $stmt->null;
  }
  public function correoresumenGastos($Fecha){
    $stmt = Conexion::conectar()->prepare("SELECT Descripcion, Monto from detallecaja where Tipo = 'Egreso' and CAST(Fecha AS DATE ) = :fecha");
    $stmt->bindParam(":fecha", $Fecha, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll();
    $stmt->null;
  }
  
  // para mostrar los ingresos
  public function correoresumenIngresos($Fecha){
    $stmt = Conexion::conectar()->prepare("SELECT Descripcion, Monto from detallecaja where Tipo = 'Ingreso' and CAST(Fecha AS DATE ) = :fecha");
    $stmt->bindParam(":fecha", $Fecha, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll();
    $stmt->null;
  }

  // -----------------------------------------------------------------------------------------
  // CORTES X & Y
  public function DatosCorrelativoTickets(){ //Se hace aparte del total por que si incluimos el total en el query se sumara con los cortes
    $stmt = Conexion::conectar()->prepare("SELECT min(NumeroDoc) AS Menor, max(NumeroDoc) as Mayor 
                                            from comprobantec where CAST(Fecha AS DATE) = :fecha
                                            And (TipoComprobante ='DEV'
                                            OR TipoComprobante ='CORTE GRAN Z'
                                            OR TipoComprobante ='CORTE Z'
                                            OR TipoComprobante ='CORTE X'
                                            OR TipoComprobante ='T')");
    $fecha=date('Y-m-d');
    $stmt->bindParam(":fecha", $fecha, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt -> fetch();
		$stmt -> null;
  }
  
  // DatosCorr t entre dos fechas
  public function DatosCorrelativoTickets2($f1, $f2){ //Se hace aparte del total por que si incluimos el total en el query se sumara con los cortes
    $stmt = Conexion::conectar()->prepare("SELECT min(NumeroDoc) AS Menor, max(NumeroDoc) as Mayor 
                                            from comprobantec WHERE Fecha BETWEEN  :f1 AND :f2
                                            And (TipoComprobante ='DEV'
                                            OR TipoComprobante ='CORTE GRAN Z'
                                            OR TipoComprobante ='CORTE Z'
                                            OR TipoComprobante ='CORTE X'
                                            OR TipoComprobante ='T')");
    $stmt->bindParam(":f1", $f1, PDO::PARAM_STR);
    $stmt->bindParam(":f2", $f2, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt -> fetch();
		$stmt -> null;
  }

  public function DatosTotalVentaTickets2($f1, $f2){ //Se hace aparte del total por que si incluimos el total en el query se sumara con los cortes
    $stmt = Conexion::conectar()->prepare("SELECT sum(Total) as Total 
                                          from comprobantec WHERE Fecha BETWEEN  :f1 AND :f2  
                                          and TipoComprobante ='T';");
    $stmt->bindParam(":f1", $f1, PDO::PARAM_STR);
    $stmt->bindParam(":f2", $f2, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt -> fetch();
		$stmt -> null;
  }
  
  public function DatosTotalVentaTickets(){ //Se hace aparte del total por que si incluimos el total en el query se sumara con los cortes
    $stmt = Conexion::conectar()->prepare("SELECT sum(Total) as Total from comprobantec where  
                          CAST(Fecha AS DATE )= :fecha and TipoComprobante ='T';");
    $stmt->bindParam(":fecha", date('Y-m-d'), PDO::PARAM_STR);
    $stmt->execute();
    return $stmt -> fetch();
		$stmt -> null;
  }

  public function DatosFCF(){
    $stmt = Conexion::conectar()->prepare("SELECT  min(NumeroDoc) AS Menor,max(NumeroDoc) as Mayor,sum(Total) as Total  
                                  from comprobante where TipoComprobante ='FCF' and CAST(Fecha AS DATE )= :fecha");
    $stmt->bindParam(":fecha", date('Y-m-d'), PDO::PARAM_STR);
    $stmt->execute();
    return $stmt -> fetch();
		$stmt -> null;
  }

  public function DatosFCF2($f1,$f2){
    $stmt = Conexion::conectar()->prepare("SELECT  min(NumeroDoc) AS Menor,max(NumeroDoc) as Mayor,sum(Total) as Total  
                                  from comprobante where TipoComprobante ='FCF' AND Fecha BETWEEN  :f1 AND :f2");
    $stmt->bindParam(":f1", $f1, PDO::PARAM_STR);
    $stmt->bindParam(":f2", $f2, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt -> fetch();
		$stmt -> null;
  }

  public function DatosCCF(){
    $stmt = Conexion::conectar()->prepare("SELECT  min(NumeroDoc) AS Menor,max(NumeroDoc) as Mayor,sum(Total) as Total   from comprobante where TipoComprobante ='CCF'and CAST(Fecha AS DATE )= :fecha");
    $stmt->bindParam(":fecha", date('Y-m-d'), PDO::PARAM_STR);
    $stmt->execute();
    return $stmt -> fetch();
		$stmt -> null;
  }

  public function DatosCCF2($f1,$f2){
    $stmt = Conexion::conectar()->prepare("SELECT  min(NumeroDoc) AS Menor,max(NumeroDoc) as Mayor,sum(Total) as Total   
                                          from comprobante where TipoComprobante ='CCF' AND Fecha BETWEEN  :f1 AND :f2");
    $stmt->bindParam(":f1", $f1, PDO::PARAM_STR);
    $stmt->bindParam(":f2", $f2, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt -> fetch();
		$stmt -> null;
  }

  public function DatosDevolucion(){
    $stmt = Conexion::conectar()->prepare("SELECT  min(Serie) AS Menor,max(Serie) as Mayor,sum(Total) as Total   from comprobantec where TipoComprobante ='DEV'
    and CAST(Fecha AS DATE )= :fecha");
    $stmt->bindParam(":fecha", date('Y-m-d'), PDO::PARAM_STR);
    $stmt->execute();
    return $stmt -> fetch();
		$stmt -> null;
  }
  // Corte GRAN Z
  public function DatosCorrelativoTicketsGranZ($datosModel){//Se hace aparte del total por que si incluimos el total en el query se sumara con los cortes
    $stmt = Conexion::conectar()->prepare("SELECT min(NumeroDoc) AS Menor,max(NumeroDoc) as Mayor from comprobantec WHERE Year(Fecha) = :anio and Month(Fecha) = :mes
     and (TipoComprobante ='T'or
     TipoComprobante ='DEV' or
	   TipoComprobante ='CORTE GRAN Z' or
	   TipoComprobante ='CORTE Z' or
	   TipoComprobante ='CORTE X' )");
    $stmt->bindParam(":anio", $datosModel["anio"], PDO::PARAM_STR);
    $stmt->bindParam(":mes", $datosModel["mes"], PDO::PARAM_STR);
    $stmt->execute();
    return $stmt -> fetch();
		$stmt -> null;
  }
  public function DatosTotalVentaTicketsGranZ($datosModel){//Se hace aparte del total por que si incluimos el total en el query se sumara con los cortes
    $stmt = Conexion::conectar()->prepare("SELECT sum(Total) as Total from comprobantec WHERE Year(Fecha) = :anio and Month(Fecha) = :mes
    and (TipoComprobante ='T')");
    $stmt->bindParam(":anio", $datosModel["anio"], PDO::PARAM_STR);
    $stmt->bindParam(":mes", $datosModel["mes"], PDO::PARAM_STR);
    $stmt->execute();
    return $stmt -> fetch();
		$stmt -> null;
  }
  public function DatosFCFGranZ($datosModel){
    $stmt = Conexion::conectar()->prepare("SELECT  min(NumeroDoc) AS Menor,max(NumeroDoc) as Mayor,sum(Total) as Total from comprobante where TipoComprobante ='FCF'and
    Year(Fecha) = :anio and Month(Fecha) = :mes");
    $stmt->bindParam(":anio", $datosModel["anio"], PDO::PARAM_STR);
    $stmt->bindParam(":mes", $datosModel["mes"], PDO::PARAM_STR);
    $stmt->execute();
    return $stmt -> fetch();
		$stmt -> null;
  }
  public function DatosCCFGranZ($datosModel){
    $stmt = Conexion::conectar()->prepare("SELECT  min(NumeroDoc) AS Menor,max(NumeroDoc) as Mayor,sum(Total) as Total from comprobante where TipoComprobante ='CCF'and
    Year(Fecha) = :anio and Month(Fecha) = :mes");
    $stmt->bindParam(":anio", $datosModel["anio"], PDO::PARAM_STR);
    $stmt->bindParam(":mes", $datosModel["mes"], PDO::PARAM_STR);
    $stmt->execute();
    return $stmt -> fetch();
		$stmt -> null;
  }
  public function DatosDevolucionGranZ($datosModel){
    $stmt = Conexion::conectar()->prepare("SELECT  min(Serie) AS Menor,max(Serie) as Mayor, sum(Total) as Total from comprobantec where TipoComprobante ='DEV' and Year(Fecha) = :anio and Month(Fecha) = :mes");
    $stmt->bindParam(":anio", $datosModel["anio"], PDO::PARAM_STR);
    $stmt->bindParam(":mes", $datosModel["mes"], PDO::PARAM_STR);
    $stmt->execute();
    return $stmt -> fetch();
		$stmt -> null;
  }
  public function registroDeCortes($datosModel){
    $stmt = Conexion::conectar()->prepare("INSERT INTO comprobantec (IdPedido,Serie,NumeroDoc,Fecha,Total,FormaPago,TipoComprobante,Propina, Hora, TotalPagar,MontoTicket,CorrelativoFCF,CorrelativoFCF2,MontoFCF,CorrelativoCCF,CorrelativoCCF2,MontoCCF) 
    VALUES (:idpedido,:serie,:nrocomprobante,:fecha,:total,:formapago,:comprobante,:propina,:hora,:totalpagar,:MontoTicket,:CorrelativoFCF,:CorrelativoFCF2,:MontoFCF,:CorrelativoCCF,:CorrelativoCCF2,:MontoCCF)");
    $stmt->bindParam(":idpedido", $datosModel["idpedido"], PDO::PARAM_STR);
    $stmt->bindParam(":serie", $datosModel["serie"], PDO::PARAM_STR);
		$stmt->bindParam(":nrocomprobante", $datosModel["nrocomprobante"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha", date("Y-m-d H:i:s"), PDO::PARAM_STR);
		$stmt->bindParam(":total", $datosModel["total"], PDO::PARAM_STR);
		$stmt->bindParam(":formapago", $datosModel["formapago"], PDO::PARAM_STR);
		$stmt->bindParam(":comprobante", $datosModel["comprobante"], PDO::PARAM_STR);
		$stmt->bindParam(":propina", $datosModel["propina"], PDO::PARAM_STR);
    $stmt->bindParam(":hora", date("H:i:s"), PDO::PARAM_STR);
    $stmt->bindParam(":totalpagar", $datosModel["totalpagar"], PDO::PARAM_STR);

    $stmt->bindParam(":MontoTicket", $datosModel["MontoTicket"], PDO::PARAM_STR);
    $stmt->bindParam(":CorrelativoFCF", $datosModel["CorrelativoFCF"], PDO::PARAM_STR);
    $stmt->bindParam(":CorrelativoFCF2", $datosModel["CorrelativoFCF2"], PDO::PARAM_STR);
    $stmt->bindParam(":MontoFCF", $datosModel["MontoFCF"], PDO::PARAM_STR);
    $stmt->bindParam(":CorrelativoCCF", $datosModel["CorrelativoCCF"], PDO::PARAM_STR);
    $stmt->bindParam(":CorrelativoCCF2", $datosModel["CorrelativoCCF2"], PDO::PARAM_STR);
    $stmt->bindParam(":MontoCCF", $datosModel["MontoCCF"], PDO::PARAM_STR);
    if($stmt->execute()){
      return "success";
    }
    else{
      return "error";
    }
    $stmt->null;
  }
  
  //para agregar el corte Z a la tabla comprobante c
  public function registroDeCortes2($x,$y, $z, $doc){
    $stmt = Conexion::conectar()->prepare("INSERT INTO comprobantec (NumeroDoc, Fecha, FormaPago, TipoComprobante, Documento) 
                                            VALUES (:NumeroDoc,:Fecha,:Tipo,:Tipo, :Docu)");
		$stmt->bindParam(":NumeroDoc", $x, PDO::PARAM_STR);
    $stmt->bindParam(":Fecha", $y, PDO::PARAM_STR);
		$stmt->bindParam(":Tipo", $z, PDO::PARAM_STR);
		$stmt->bindParam(":Docu", $doc, PDO::PARAM_STR);
		
    if($stmt->execute()){
      return "success";
    }
    else{
      return "error";
    }
    $stmt->null;
  }
  

  

  public function CierreCaja($IdFcaja){
    $stmt = Conexion::conectar()->prepare("UPDATE fcaja SET Estado='C', HoraCierre = :fecha where IdFcaja = :IdFcaja");
    $stmt->bindParam(":IdFcaja", $IdFcaja, PDO::PARAM_INT);
    $Fecha= date('Y-m-d H:i:s');
    $stmt->bindParam(":fecha", $Fecha, PDO::PARAM_STR);
    if($stmt->execute()){
      return "success";
    }
    else{
      return "error";
    }
    $stmt->null;
  }

  // CINTA DE AUDITORIA
  public function ListarLeyendaCinta(){
    $stmt = Conexion::conectar()->prepare("SELECT Restaurante,Contribuyente,NroDeRegistro,Giro,Direccion from configuracionesticket");
    $stmt->execute();
    return $stmt -> fetch();
		$stmt -> null;
    }
  public function ListarTicketCinta($fecha1, $fecha2){
    $stmt = Conexion::conectar()->prepare("SELECT IdPedido,Serie,NumeroDoc, Fecha, Total, TipoComprobante, FormaPago,NombreCliente, Propina,  
    DATE_FORMAT(Hora,' %H:%i') as Hora, TotalPagar,Documento,MontoTicket,CorrelativoFCF,CorrelativoFCF2,MontoFCF,CorrelativoCCF,CorrelativoCCF2,MontoCCF
      from comprobantec where Fecha BETWEEN :fecha1 AND :fecha2");
    $stmt -> bindParam(":fecha1", $fecha1, PDO::PARAM_STR);
    $stmt -> bindParam(":fecha2", $fecha2, PDO::PARAM_STR);

    $stmt->execute();
    return $stmt->fetchAll();
		$stmt->null;
    }


    public function PropinaxEmpleado($Fecha){
        $stmt = Conexion::conectar()->prepare("SELECT
            CC.IdPedido, CC.NumeroDoc, PS.IdPersonal, PS.Nombres, CC.Propina
        FROM
            comprobantec CC
                INNER JOIN
            pedido P ON CC.IdPedido = P.IdPedido
                INNER JOIN
            personal PS ON PS.IdPersonal = P.IdPersonal
        WHERE
            CC.Fecha = :Fecha
            AND P.Propina != 0.00
        ORDER BY P.IdPersonal");
        $stmt -> bindParam(":Fecha", $Fecha, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
		$stmt->null;
    }
    
    public function corte($id){
        $stmt = Conexion::conectar()->prepare("SELECT * FROM comprobantec WHERE NumeroDoc = :id");
        $stmt -> bindParam(":id", $id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
		$stmt->null;
    }

    public function corte2($id){
      $stmt = Conexion::conectar()->prepare("SELECT * FROM comprobantec WHERE Documento = :Caja");
      $stmt->bindParam(":Caja", $id, PDO::PARAM_STR);
      $stmt->execute();
      $stmt->execute();
      return $stmt->fetch();
      $stmt->null;
    } 

    public function existeCorteZ($Dts){
      $stmt = Conexion::conectar()->prepare("SELECT * FROM comprobantec WHERE CAST(Fecha AS DATE) = :Fecha AND FormaPago = :Corte");
      $stmt->bindParam(":Fecha", $Dts["Fecha"], PDO::PARAM_STR);
      $stmt->bindParam(":Corte", $Dts["Corte"], PDO::PARAM_STR);
      $stmt->execute();
  		return $stmt->fetch();
  		$stmt->null;
    }
    
    public function existeCorteZ2($Dts){
      $stmt = Conexion::conectar()->prepare("SELECT * FROM comprobantec WHERE Documento = :Caja AND FormaPago = :Corte");
      $stmt->bindParam(":Caja", $Dts["Caja"], PDO::PARAM_STR);
      $stmt->bindParam(":Corte", $Dts["Corte"], PDO::PARAM_STR);
      $stmt->execute();
  		return $stmt->fetch();
  		$stmt->null;
    }

}
