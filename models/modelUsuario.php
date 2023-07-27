<?php

require_once "conexion.php";

class modelUsuario{

	public function registroUsuario($datosModel){
		$stmt = Conexion::conectar()->prepare("INSERT INTO usuario (Usuario, Clave, Puesto, Estado, IdPersonal) VALUES (:usuario,:clave,:puesto,:estado,:IdPersonal)");
		$stmt->bindParam(":usuario", $datosModel["usuario"], PDO::PARAM_STR);
		$stmt->bindParam(":clave", $datosModel["clave"], PDO::PARAM_STR);
		$stmt->bindParam(":puesto", $datosModel["puesto"], PDO::PARAM_STR);
		$stmt->bindParam(":estado", $datosModel["estado"], PDO::PARAM_STR);
		$stmt->bindParam(":IdPersonal", $datosModel["IdPersonal"], PDO::PARAM_STR);

		if($stmt->execute()){
			return "success";
		} else {
			return "error";
		}
		$stmt->close();
	}

  	public function actualizarUsuario($datosModel){
  		$stmt = Conexion::conectar()->prepare("UPDATE usuario SET Usuario = :usuario, Clave = :clave, Puesto = :puesto, Estado = :estado, IdPersonal = :IdPersonal WHERE IdUsuario = :id");
		$stmt->bindParam(":id", $datosModel["id"], PDO::PARAM_STR);
		$stmt->bindParam(":usuario", $datosModel["usuario"], PDO::PARAM_STR);
		$stmt->bindParam(":clave", $datosModel["clave"], PDO::PARAM_STR);
		$stmt->bindParam(":puesto", $datosModel["puesto"], PDO::PARAM_STR);
		$stmt->bindParam(":estado", $datosModel["estado"], PDO::PARAM_STR);
		$stmt->bindParam(":IdPersonal", $datosModel["IdPersonal"], PDO::PARAM_STR);

		if($stmt->execute()){
			return "success";
		} else {
    		return "error";
  		}
  		$stmt->close();
	}

	public function vistaUsuarios(){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM usuario order by estado");
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->close();
	}

	public function borrarUsuario($datosModel){
		$stmt = Conexion::conectar()->prepare("DELETE FROM usuario WHERE IdUsuario = :id");
		$stmt->bindParam(":id", $datosModel, PDO::PARAM_INT);
		if($stmt->execute()){
			return "success";
		} else {
			return "error";
		}
		$stmt->close();
	}

	public function Cargos(){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM cargo");
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->close();
	}

}
