<?php

require_once "conexion.php";

class modelCompra{

	public function registroCompra($datosModel){
		$stmt = Conexion::conectar()->prepare("INSERT INTO compras (IdProveedor, NroComprobante, Serie,Fecha,TipoDoc,Total,Iva,Subtotal,Descripcion) VALUES (:idproveedor,:nrocomprobante,:formapago,:fecha,:tipodoc,:total,:iva,:subtotal,:descripcion)");
		$stmt->bindParam(":idproveedor", $datosModel["idproveedor"], PDO::PARAM_STR);
		$stmt->bindParam(":nrocomprobante", $datosModel["nrocomprobante"], PDO::PARAM_STR);
		$stmt->bindParam(":formapago", $datosModel["formapago"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha", $datosModel["fecha"], PDO::PARAM_STR);
		$stmt->bindParam(":tipodoc", $datosModel["tipodoc"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datosModel["total"], PDO::PARAM_STR);
		$stmt->bindParam(":iva", $datosModel["iva"], PDO::PARAM_STR);
    $stmt->bindParam(":subtotal", $datosModel["subtotal"], PDO::PARAM_STR);
    $stmt->bindParam(":descripcion", $datosModel["descripcion"], PDO::PARAM_STR);

		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}
		$stmt->close();
	}

  public function actualizarCompra($datosModel){
  $stmt = Conexion::conectar()->prepare("UPDATE compras SET IdProveedor = :idproveedor, NroComprobante = :nrocomprobante, Serie = :formapago, Fecha = :fecha, TipoDoc = :tipodoc, Total = :total, Iva = :iva, Subtotal = :subtotal, Descripcion=:descripcion WHERE IdCompra = :id");
  $stmt->bindParam(":id", $datosModel["id"], PDO::PARAM_STR);
  $stmt->bindParam(":idproveedor", $datosModel["idproveedor"], PDO::PARAM_STR);
  $stmt->bindParam(":nrocomprobante", $datosModel["nrocomprobante"], PDO::PARAM_STR);
  $stmt->bindParam(":formapago", $datosModel["formapago"], PDO::PARAM_STR);
  $stmt->bindParam(":fecha", $datosModel["fecha"], PDO::PARAM_STR);
  $stmt->bindParam(":tipodoc", $datosModel["tipodoc"], PDO::PARAM_STR);
  $stmt->bindParam(":total", $datosModel["total"], PDO::PARAM_STR);
  $stmt->bindParam(":iva", $datosModel["iva"], PDO::PARAM_STR);
  $stmt->bindParam(":subtotal", $datosModel["subtotal"], PDO::PARAM_STR);
  $stmt->bindParam(":descripcion", $datosModel["descripcion"], PDO::PARAM_STR);

  if($stmt->execute()){
    return "success";
  }
  else{
    return "error";
  }
  $stmt->close();
}

	public function vistaCompra($Fecha){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM compras where Fecha = :Fecha");
		$stmt->bindParam(":Fecha", $Fecha, PDO::PARAM_STR);

		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->close();
	}

	public function vistaCompraConFecha($fecha){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM compras where CAST(Fecha AS DATE ) = :fecha");
		$stmt -> bindParam(":fecha", $fecha, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->close();
	}

  public function vistaProveedor($datosModel){
    $stmt = Conexion::conectar()->prepare("SELECT IdProveedor, RazonSocial, DNI_Proveedor, RUC_Proveedor FROM proveedor WHERE IdProveedor = :idproveedor");
    $stmt->bindParam(":idproveedor", $datosModel["idproveedor"], PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch();
    $stmt->close();
  }

		public function borrarCompra($datosModel){
		$stmt = Conexion::conectar()->prepare("DELETE FROM compras WHERE IdCompra = :id");
		$stmt->bindParam(":id", $datosModel, PDO::PARAM_INT);
		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}
		$stmt->close();
	}

  public function encontrarProveedor($datosModel){
     $stmt = Conexion::conectar()->prepare("SELECT IdProveedor, RazonSocial FROM proveedor WHERE DNI_Proveedor=:id or RUC_Proveedor=:id");
     $stmt->bindParam(":id", $datosModel, PDO::PARAM_STR);
     $stmt -> execute();
 		return $stmt -> fetch();
 		$stmt -> close();
  }


}
