<?php
date_default_timezone_set('America/El_Salvador');
require_once "conexion.php";

class modelComprobantes{

  // public function comprobantesC($fechai){
	// 	$stmt = Conexion::conectar()->prepare("SELECT * FROM (
	//      SELECT
	// 	     IdcomprobanteC AS IdComprobante, IdPedido, Serie, NumeroDoc,
	// 	     Fecha, Total, FormaPago, TipoComprobante,
	// 	     NombreCliente, Documento, Propina,
	// 	     Hora, TotalPagar, MontoTicket,
	// 	     CorrelativoFCF, CorrelativoFCF2, MontoFCF,
  //        CorrelativoCCF, CorrelativoCCF2, MontoCCF, 'IDCC' AS Tbl
  //     FROM comprobantec
	// 	    UNION ALL
	//     SELECT
	// 	    IdComprobante AS IdComprobante, IdPedido, Serie, NumeroDoc,
  //       Fecha, Total, FormaPago, TipoComprobante,
  //       NombreCliente, Documento, Propina,
  //       Hora, TotalPagar, MontoTicket,
  //       CorrelativoFCF, CorrelativoFCF2, MontoFCF,
  //       CorrelativoCCF, CorrelativoCCF2, MontoCCF, 'IDC' AS Tbl
	//     FROM comprobante
  //   ) Comprobantes WHERE Comprobantes.Fecha = :fecha and Comprobantes.NumeroDoc != 10000 and Comprobantes.NumeroDoc != '' ORDER BY Comprobantes.Hora ASC");
  //   $stmt->bindParam(":fecha", $fechai, PDO::PARAM_STR);
	// 	$stmt->execute();
	// 	return $stmt->fetchAll();
	// 	$stmt->close();
	// }

  public function comprobantesC($fechai){
    $stmt = Conexion::conectar()->prepare("SELECT CC.* FROM comprobantec CC INNER JOIN pedido P ON P.IdPedido = CC.IdPedido WHERE CC.Fecha LIKE '".$fechai."%'  AND P.Estado = 'B' ORDER BY CC.Hora ASC");
    // $stmt->bindParam(":fecha", $fechai, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll();
    $stmt->close();
  }

  public function comprobantes($fechai){
    $stmt = Conexion::conectar()->prepare("SELECT CC.* FROM comprobante CC INNER JOIN pedido P ON P.IdPedido = CC.IdPedido WHERE CAST(CC.Fecha AS DATE) = :fecha AND P.Estado = 'B' AND CC.TipoComprobante != 'T' ORDER BY CC.Hora ASC");
    $stmt->bindParam(":fecha", $fechai, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll();
    $stmt->close();
  }



  public function comprobantesEliminados($fechai){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM comprobante WHERE Fecha = :fecha and eliminado = '1' ORDER BY Hora ASC");
    $stmt->bindParam(":fecha", $fechai, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->close();
	}

// Eliminar comprobanteC---------------------------------------------------------------------------------------
  public function eliminarComprobanteC($datosModel){
  $stmt = Conexion::conectar()->prepare("DELETE FROM comprobantec WHERE IdcomprobanteC = :id");
  $stmt->bindParam(":id", $datosModel['IdcomprobanteC'], PDO::PARAM_INT);
  if($stmt->execute()){
    return "success";
  }
  else{
    return "error";
  }
  $stmt->close();
}

// En la tbl comprobante cambiamos en el columna eliminado de 0 a 1---------------------------------------------------------------------------------------
public function eliminadoTblcomprobante($IdPedidoAjax){
$stmt = Conexion::conectar()->prepare("UPDATE comprobante set eliminado = 1 where IdPedido = :id");
$stmt->bindParam(":id", $IdPedidoAjax, PDO::PARAM_INT);
if($stmt->execute()){
  return "success";
}
else{
  return "error";
}
$stmt->close();
}

// Eliminar comprobante---------------------------------------------------------------------------------------
//   public function eliminarComprobante($datosModel){
//   $stmt = Conexion::conectar()->prepare("DELETE FROM comprobante WHERE IdComprobante = :id");
//   $stmt->bindParam(":id", $datosModel['IdcomprobanteC'], PDO::PARAM_INT);
//   if($stmt->execute()){
//     return "success";
//   }
//   else{
//     return "error";
//   }
//   $stmt->close();
// }




// PARA ELIMINAR COMPROBANTES QUE SON DE OTROS DIAS  (MODIFICAR SOLO COMPROBANTES.PHP Y MODELCOMPROBANTES.PHP LA SECCION COMENTADA)
// public function rangoNroComprobante($NumeroDoc){
//   $stmt = Conexion::conectar()->prepare("SELECT * FROM comprobantec where Fecha = :fecha and NumeroDoc > :NumeroDoc");
//   $fecha ='2019-05-10';
//   $stmt->bindParam(":fecha", $fecha, PDO::PARAM_STR);
//   $stmt->bindParam(":NumeroDoc", $NumeroDoc, PDO::PARAM_INT);
//   $stmt->execute();
//   return $stmt->fetchAll();
//   $stmt->close();
// }

  public function rangoNroComprobante($NumeroDoc){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM comprobantec where Fecha = :fecha and NumeroDoc > :NumeroDoc");
    $stmt->bindParam(":fecha", date('Y-m-d'), PDO::PARAM_STR);
    $stmt->bindParam(":NumeroDoc", $NumeroDoc, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
    $stmt->close();
	}
  public function actualizarNroComprobante($datosControllerr){
  $stmt = Conexion::conectar()->prepare("UPDATE comprobantec set NumeroDoc = :NumeroDoc where IdcomprobanteC = :id");
  $stmt->bindParam(":id", $datosControllerr['id'], PDO::PARAM_INT);
  $stmt->bindParam(":NumeroDoc", $datosControllerr['NumeroDoc'], PDO::PARAM_INT);
  if($stmt->execute()){
    return "success";
  }
  else{
    return "error";
  }
  $stmt->close();
}
// ------------------------------------------------------------------------------------
public function ultimoIdCaja(){
  $stmt = Conexion::conectar()->prepare("SELECT MAX(IdFcaja) as IdFcaja FROM fcaja ");
  $stmt->execute();
  return $stmt->fetch();
  $stmt->close();
}
public function nroMesa($datosController){
  $stmt = Conexion::conectar()->prepare("SELECT NroMesa FROM detallemesa where IdPedido = :id");
  $stmt->bindParam(":id", $datosController, PDO::PARAM_STR);
  $stmt->execute();
  return $stmt->fetch();
  $stmt->close();
}

public function actualizarMesa($datosControllerr){
$stmt = Conexion::conectar()->prepare("UPDATE mesa set Estado = 'P' where NroMesa = :id");
$stmt->bindParam(":id", $datosControllerr, PDO::PARAM_STR);
if($stmt->execute()){
  return "success";
}
else{
  return "error";
}
$stmt->close();
}

public function actualizarPedido($datosController){
$stmt = Conexion::conectar()->prepare("UPDATE pedido set Estado = 'P' where IdPedido = :id");
$stmt->bindParam(":id", $datosController, PDO::PARAM_STR);
if($stmt->execute()){
  return "success";
}
else{
  return "error";
}
$stmt->close();
}

  public function ComprobanteUnico($IdPedido){
    $stmt = Conexion::conectar()->prepare("SELECT C.*, P.Exentos, P.Retencion, P.consumo, P.Tarjeta 
    FROM comprobante C inner join pedido P on C.IdPedido = P.IdPedido where C.IdPedido = :id");
    $stmt->bindParam(":id", $IdPedido, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch();
    $stmt->close();
  }
}
