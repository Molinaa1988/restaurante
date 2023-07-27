<?php

require_once "conexion.php";

class modelGastoIngreso{

	public function registroGasto($datosModel){
		$stmt = Conexion::conectar()->prepare("INSERT INTO detallecaja (IdFCaja, Tipo, Monto, Descripcion, Fecha) VALUES (:idfcaja,'Egreso',:monto,:descripcion,:fecha)");
    $stmt->bindParam(":idfcaja", $datosModel["idfcaja"], PDO::PARAM_STR);
    $stmt->bindParam(":monto", $datosModel["monto"], PDO::PARAM_STR);
    $stmt->bindParam(":descripcion", $datosModel["descripcion"], PDO::PARAM_STR);
    $stmt->bindParam(":fecha", date('Y-m-d'), PDO::PARAM_STR);
		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}
		$stmt->close();
	}
	public function registroIngreso($datosModel){
		$stmt = Conexion::conectar()->prepare("INSERT INTO detallecaja (IdFCaja, Tipo, Monto, Descripcion, Fecha) VALUES (:idfcaja,'Ingreso',:monto,:descripcion,:fecha)");
		$stmt->bindParam(":idfcaja", $datosModel["idfcaja"], PDO::PARAM_STR);
		$stmt->bindParam(":monto", $datosModel["monto"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datosModel["descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha", $datosModel["fecha"], PDO::PARAM_STR);
		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}
		$stmt->close();
	}

  public function actualizarGastoIngreso($datosModel){
  $stmt = Conexion::conectar()->prepare("UPDATE detallecaja SET Monto = :monto, Descripcion = :descripcion, Fecha = :fecha WHERE IdDetalleCaja = :id");
  $stmt->bindParam(":id", $datosModel["id"], PDO::PARAM_STR);
  $stmt->bindParam(":monto", $datosModel["monto"], PDO::PARAM_STR);
  $stmt->bindParam(":descripcion", $datosModel["descripcion"], PDO::PARAM_STR);
  $stmt->bindParam(":fecha", date('Y-m-d'), PDO::PARAM_STR);
  if($stmt->execute()){
    return "success";
  }
  else{
    return "error";
  }
  $stmt->close();
}

	public function vistaGasto(){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM detallecaja WHERE Tipo='Egreso'");
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->close();
	}
	public function vistaGastoConFecha($fecha){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM detallecaja WHERE Tipo='Egreso' and CAST(Fecha AS DATE ) = :fecha");
		$stmt -> bindParam(":fecha", $fecha, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->close();
	}
	public function vistaIngreso(){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM detallecaja WHERE Tipo='Ingreso'");
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->close();
	}
	public function vistaIngresoConFecha($fecha){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM detallecaja WHERE Tipo='Ingreso' and CAST(Fecha AS DATE ) = :fecha");
		$stmt -> bindParam(":fecha", $fecha, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->close();
	}

	//Para ver las cuentas por cobrar cancelados
	public function vistaCxcc($fecha){
		$stmt = Conexion::conectar()->prepare("SELECT Pd.IdUsuario, P.Nombres, Pd.FechaPedido, c.Total, c.Propina, c.TotalPagar, 
		c.FormaPago ,c.TipoComprobante, c.NumeroDoc, c.FechaFact, Pd.IdPedido, c.Documento, cc.Estado, cc.FechaC, cc.Tipo, cli.Nombre 
		from personal P inner join pedido Pd on P.IdPersonal = Pd.IdPersonal  
		inner join comprobantec c on Pd.IdPedido = c.IdPedido 
		INNER JOIN cuentasporcobrar cc ON	Pd.IdPedido = cc.IdPedido
		inner join clientes cli on cli.IdCliente= cc.IdCliente 
		WHERE CAST(cc.FechaC AS DATE) = :fecha 
		and cc.Estado = 'C'");
		$stmt -> bindParam(":fecha", $fecha, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->close();
	}

		public function borrarGastoIngreso($datosModel){
		$stmt = Conexion::conectar()->prepare("DELETE FROM detallecaja WHERE IdDetalleCaja = :id");
		$stmt->bindParam(":id", $datosModel, PDO::PARAM_INT);
		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}
		$stmt->close();
	}


}
