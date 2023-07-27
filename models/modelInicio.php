<?php

require_once "conexion.php";

class modelInicio{

	public function listarCobrosDia($datosModel){
		$stmt = Conexion::conectar()->prepare("SELECT Tipo, sum(Monto) as Monto from detallecaja WHERE CAST(Fecha AS DATE )  = :fecha and Tipo = 'Ingreso'");
		$stmt -> bindParam(":fecha", $datosModel, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetch();
		$stmt -> close();
	}

	public function listarVentaDia($datosModel){
		$stmt = Conexion::conectar()->prepare("SELECT  sum(TotalPagar) as Monto from comprobantec WHERE CAST(Fecha AS DATE )  = :fecha and (FormaPago ='T' OR FormaPago ='E' OR FormaPago ='CH' )");
		$stmt -> bindParam(":fecha", $datosModel, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetch();
		$stmt -> close();
	}
	public function listarVentaDiaFCFyCCF($datosModel){
		$stmt = Conexion::conectar()->prepare("SELECT sum(TotalPagar) as Monto from comprobante WHERE CAST(Fecha AS DATE ) = :fecha and (FormaPago ='T' OR FormaPago ='E' OR FormaPago ='CH' ) AND (TipoComprobante = 'FCF' OR TipoComprobante = 'CCF')");
		$stmt -> bindParam(":fecha", $datosModel, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetch();
		$stmt -> close();
	}
	public function listarComprasDia($datosModel){
		$stmt = Conexion::conectar()->prepare("SELECT sum(Total) as Total from compras WHERE CAST(Fecha AS DATE ) = :fecha");
		$stmt -> bindParam(":fecha", $datosModel, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetch();
		$stmt -> close();
	}

	public function listarPagosDia($datosModel){
		$stmt = Conexion::conectar()->prepare("SELECT Tipo, sum(Monto) as Monto from detallecaja WHERE CAST(Fecha AS DATE )  = :fecha and Tipo = 'Egreso' ");
		$stmt -> bindParam(":fecha", $datosModel, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetch();
		$stmt -> close();
	}

}
