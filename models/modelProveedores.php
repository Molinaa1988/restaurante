<?php

require_once "conexion.php";

class modelProveedores{

	public function registroProveedor($datosModel){
		$stmt = Conexion::conectar()->prepare("INSERT INTO proveedor (DNI_Proveedor, RUC_Proveedor, RazonSocial,Rubro,Direccion,contacto,Telefono,Email,Estado) VALUES (:dui,:nit,:proveedor,:giro,:dirreccion,:contacto,:telefono,:email,:estado)");
		$stmt->bindParam(":dui", $datosModel["dui"], PDO::PARAM_STR);
		$stmt->bindParam(":nit", $datosModel["nit"], PDO::PARAM_STR);
		$stmt->bindParam(":proveedor", $datosModel["proveedor"], PDO::PARAM_STR);
		$stmt->bindParam(":giro", $datosModel["giro"], PDO::PARAM_STR);
		$stmt->bindParam(":dirreccion", $datosModel["dirreccion"], PDO::PARAM_STR);
		$stmt->bindParam(":contacto", $datosModel["contacto"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datosModel["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datosModel["email"], PDO::PARAM_STR);
		$stmt->bindParam(":estado", $datosModel["estado"], PDO::PARAM_STR);

		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}
		$stmt->close();
	}

	public function vistaProveedores(){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM proveedor order by estado");
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->close();
	}

		public function borrarProveedor($datosModel){
		$stmt = Conexion::conectar()->prepare("DELETE FROM proveedor WHERE IdProveedor = :id");
		$stmt->bindParam(":id", $datosModel, PDO::PARAM_INT);
		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}
		$stmt->close();
	}

		public function actualizarProveedor($datosModel){
		$stmt = Conexion::conectar()->prepare("UPDATE proveedor SET DNI_Proveedor = :dui, RUC_Proveedor = :nit, RazonSocial = :proveedor, Rubro = :giro, Direccion = :dirreccion, contacto = :contacto, Telefono = :telefono, Email = :email, Estado = :estado WHERE IdProveedor = :id");
		$stmt->bindParam(":id", $datosModel["id"], PDO::PARAM_STR);
		$stmt->bindParam(":dui", $datosModel["dui"], PDO::PARAM_STR);
		$stmt->bindParam(":nit", $datosModel["nit"], PDO::PARAM_STR);
		$stmt->bindParam(":proveedor", $datosModel["proveedor"], PDO::PARAM_STR);
		$stmt->bindParam(":giro", $datosModel["giro"], PDO::PARAM_STR);
		$stmt->bindParam(":dirreccion", $datosModel["dirreccion"], PDO::PARAM_STR);
		$stmt->bindParam(":contacto", $datosModel["contacto"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datosModel["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datosModel["email"], PDO::PARAM_STR);
		$stmt->bindParam(":estado", $datosModel["estado"], PDO::PARAM_STR);

		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}
		$stmt->close();
	}


}
