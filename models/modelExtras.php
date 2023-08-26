<?php
date_default_timezone_set('America/El_Salvador');
require_once "conexion.php";

class modelExtras{

  public function pedidosErrores(){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM pedido where DATE(FechaPedido) != :fecha and Estado = 'P'");
    $stmt->bindParam(":fecha", date('Y-m-d'), PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->close();
	}

  public function corregirEstadoPedido($datosControllerr){
  $stmt = Conexion::conectar()->prepare("UPDATE pedido set Estado = 'B' where IdPedido = :id");
  $stmt->bindParam(":id", $datosControllerr, PDO::PARAM_STR);
  if($stmt->execute()){
    return "success";
  }
  else{
    return "error";
  }
  $stmt->close();
  }
  public function cambiarEstadoMesa($datosControllerr){
  $stmt = Conexion::conectar()->prepare("UPDATE mesa set Estado = :estado where NroMesa = :mesa");
  $stmt->bindParam(":estado", $datosControllerr['estado'], PDO::PARAM_STR);
  $stmt->bindParam(":mesa", $datosControllerr['mesa'], PDO::PARAM_STR);
  if($stmt->execute()){
    return "success";
  }
  else{
    return "error";
  }
  $stmt->close();
  }

  public function DelDetallePedido($Dts)
  {
    $stmt = Conexion::conectar()->prepare("DELETE FROM detallepedido  WHERE IdPedido = :IdPedido");
    $stmt->bindParam(":IdPedido", $Dts['IdPedido'], PDO::PARAM_STR);
    if($stmt->execute()){
      return "success";
    }else{
      return "error";
    }
    $stmt->close();
  }
  /*DELETE  FROM comprobantec  WHERE IdPedido = :IdPedido
  DELETE  FROM comprobante  WHERE IdPedido = :IdPedido*/
  public function DelComprobanteC($Dts)
  {
    $stmt = Conexion::conectar()->prepare("UPDATE detallepedido SET Estado = 'X' WHERE IdPedido = :IdPedido");
    $stmt->bindParam(":IdPedido", $Dts['IdPedido'], PDO::PARAM_STR);
    if($stmt->execute()){
      return "success";
    }else{
      return "error";
    }
    $stmt->close();
  }

  public function UpPedido($Dts)
  {
    $stmt = Conexion::conectar()->prepare("UPDATE pedido SET Total = '0.00', Propina = '0.00', Estado = 'A' WHERE IdPedido = :IdPedido");
    $stmt->bindParam(":IdPedido", $Dts['IdPedido'], PDO::PARAM_STR);
    if($stmt->execute()){
      return "success";
    }else{
      return "error";
    }
    $stmt->close();
  }
}
