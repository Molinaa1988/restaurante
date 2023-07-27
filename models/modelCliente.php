<?php

require_once "conexion.php";

class modelCliente{

	public function registroCliente($datosModel){
		$stmt = Conexion::conectar()->prepare("INSERT INTO clientenrc (NRC, NIT, Cliente,Direccion,Departamento,Municipio,Giro) VALUES (:nrc,:nit,:cliente,:direccion,:departamento,:municipio,:giro)");
		$stmt->bindParam(":nrc", $datosModel["nrc"], PDO::PARAM_STR);
		$stmt->bindParam(":nit", $datosModel["nit"], PDO::PARAM_STR);
		$stmt->bindParam(":cliente", $datosModel["cliente"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datosModel["direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":departamento", $datosModel["departamento"], PDO::PARAM_STR);
		$stmt->bindParam(":municipio", $datosModel["municipio"], PDO::PARAM_STR);
		$stmt->bindParam(":giro", $datosModel["giro"], PDO::PARAM_STR);

		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}
		$stmt->close();
	}

  public function actualizarCliente($datosModel){
  $stmt = Conexion::conectar()->prepare("UPDATE clientenrc SET NRC = :nrc, NIT = :nit, Cliente = :cliente, Direccion = :direccion, Departamento = :departamento, Municipio = :municipio, Giro = :giro WHERE IdNRC = :id");
  $stmt->bindParam(":id", $datosModel["id"], PDO::PARAM_STR);
  $stmt->bindParam(":nrc", $datosModel["nrc"], PDO::PARAM_STR);
  $stmt->bindParam(":nit", $datosModel["nit"], PDO::PARAM_STR);
  $stmt->bindParam(":cliente", $datosModel["cliente"], PDO::PARAM_STR);
  $stmt->bindParam(":direccion", $datosModel["direccion"], PDO::PARAM_STR);
  $stmt->bindParam(":departamento", $datosModel["departamento"], PDO::PARAM_STR);
  $stmt->bindParam(":municipio", $datosModel["municipio"], PDO::PARAM_STR);
  $stmt->bindParam(":giro", $datosModel["giro"], PDO::PARAM_STR);

  if($stmt->execute()){
    return "success";
  }
  else{
    return "error";
  }
  $stmt->close();
}

	public function vistaCliente(){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM clientenrc");
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->close();
	}

		public function borrarCliente($datosModel){
		$stmt = Conexion::conectar()->prepare("DELETE FROM clientenrc WHERE IdNRC = :id");
		$stmt->bindParam(":id", $datosModel, PDO::PARAM_INT);
		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}
		$stmt->close();
	}

	public function Dui($datosModel){
		 $stmt = Conexion::conectar()->prepare("SELECT RazonSocial FROM proveedor WHERE DNI_Proveedor=:id");
		 $stmt->bindParam(":id", $datosModel, PDO::PARAM_STR);
		 $stmt->execute();
		 return $stmt->fetchAll();
		 $stmt->close();
	}

//funcion para los otros clientes los sin nrc

	public function vistaClientes1(){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM clientes");
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->close();
	}

	public function registroClientes1($datosModel){
		$stmt = Conexion::conectar()->prepare("INSERT INTO clientes (Nombre, Direccion, Celular) 
							VALUES (:nombre, :direccion, :celular)");
		$stmt->bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datosModel["direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":celular", $datosModel["celular"], PDO::PARAM_STR);

		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}
		$stmt->close();
	}

	public function borrarClientes1($datosModel){
		$stmt = Conexion::conectar()->prepare("DELETE FROM clientes WHERE IdCliente = :id");
		$stmt->bindParam(":id", $datosModel, PDO::PARAM_INT);
		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}
		$stmt->close();
	}


	public function actualizarClientes1($datosModel){
		$stmt = Conexion::conectar()->prepare("UPDATE clientes SET Nombre = :nombre, Direccion = :direccion, Celular = :celular
							 WHERE IdCliente = :id");
		$stmt->bindParam(":id", $datosModel["id"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datosModel["direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":celular", $datosModel["celular"], PDO::PARAM_STR);
	  
		if($stmt->execute()){
		  return "success";
		}
		else{
		  return "error";
		}
		$stmt->close();
	  }

} // cierra todo

