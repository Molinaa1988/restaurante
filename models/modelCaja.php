<?php

  require_once "conexion.php";

  class modelCaja{

    public function vereficarAperturaCaja(){
      $stmt = Conexion::conectar()->prepare("SELECT IdFcaja, MontoApertura, Fecha, HoraCierre, Estado FROM fcaja order by IdFcaja DESC limit 1");
      $stmt->execute();
      return $stmt->fetch();
      $stmt->close();
    }

    public function AperturaCaja($datosModel){
      $stmt = Conexion::conectar()->prepare("INSERT INTO fcaja (IdPersonal, Fecha, MontoApertura, Estado) VALUES (:id,:fecha,:montoapertura,'A')");
      $Fecha= date('Y-m-d H:i:s');
      $stmt->bindParam(":fecha", $Fecha, PDO::PARAM_STR);
      $stmt->bindParam(":montoapertura", $datosModel["montoapertura"], PDO::PARAM_STR);
      $stmt->bindParam(":id", $datosModel["IdPersonal"], PDO::PARAM_STR);

      if($stmt->execute()){
        return "success";
      } else {
        return "error";
      }
      $stmt->close();
    }

    public function ReAperturaCaja($IdFCaja){
      $stmt = Conexion::conectar()->prepare("UPDATE fcaja SET Estado='A' WHERE IdFCaja=:IdFCaja");
      $stmt->bindParam(":IdFCaja", $IdFCaja, PDO::PARAM_STR);
      if($stmt->execute()){
        return "success";
      }else{
        return "error";
      }
      $stmt->close();
    }
    public function actualizarMesas(){
      $stmt = Conexion::conectar()->prepare("UPDATE mesa set Estado='L'");
      if($stmt->execute()){
        return "success";
      }
      else{
        return "error";
      }
      $stmt->close();
    }
    public function actualizarPedidos(){
      $stmt = Conexion::conectar()->prepare("UPDATE pedido set Estado='B'");
      if($stmt->execute()){
        return "success";
      } else {
        return "error";
      }
      $stmt->close();
    }

    public function CierreCaja(){
      $stmt = Conexion::conectar()->prepare("UPDATE fcaja SET Estado='C', HoraCierre = :fecha where IdFcaja = :IdFcaja");
      $Fecha= date("Y-m-d");
      $stmt->bindParam(":fecha", $Fecha, PDO::PARAM_STR);
      if($stmt->execute()){
        return "success";
      } else {
        return "error";
      }
      $stmt->close();
    }

  public function ultimoIdCaja(){
    $stmt = Conexion::conectar()->prepare("SELECT MAX(IdFcaja) as IdFcaja FROM fcaja ");
    $stmt->execute();
    return $stmt->fetch();
    $stmt->close();
  }

  public function ultimoIdCajaCajaChica(){
    $stmt = Conexion::conectar()->prepare("SELECT IdFcaja, MontoApertura, Fecha, HoraCierre, Estado FROM fcaja order by IdFcaja DESC limit 1");
    $stmt->execute();
    return $stmt->fetch();
    $stmt->close();
  }

  //Sirve para enlistar los id de las cajas por fecha
	public function iDCajas($Fecha){
		$stmt = Conexion::conectar()->prepare("SELECT IdFcaja, MontoApertura, Fecha, HoraCierre, Estado FROM fcaja WHERE Fecha like CONCAT(:fecha,'%')");
    $stmt->bindParam(":fecha", $Fecha, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->close();
	}

  public function ultimoIdcomprobanteC(){
    $stmt = Conexion::conectar()->prepare("SELECT MAX(IdcomprobanteC) as IdcomprobanteC FROM comprobantec");
    $stmt->execute();
    return $stmt->fetch();
    $stmt->close();
  }

  public function EliminarUltimoIdcomprobanteC($IdcomprobanteC){
    $stmt = Conexion::conectar()->prepare("DELETE FROM comprobantec WHERE IdcomprobanteC = :id");
    $stmt->bindParam(":id", $IdcomprobanteC["IdcomprobanteC"], PDO::PARAM_INT);
    if($stmt->execute()){
      return "success";
    }else{
      return "error";
    }
    $stmt->close();
  }

// Por que se relaciono aqui la tbl detallecaja ?
  public function caja($id){
    $stmt = Conexion::conectar()->prepare("SELECT * FROM fcaja fc  WHERE IdFcaja = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch();
    $stmt->close();
  }

}
