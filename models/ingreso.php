<?php

require_once "conexion.php";

class IngresoModels{

	public function ingresoModel($datosModel, $tabla){
		$stmt = Conexion::conectar()->prepare("SELECT IdUsuario, Usuario, Clave, intentos, Puesto, IdPersonal FROM $tabla WHERE Usuario = :Usuario");
		$stmt -> bindParam(":Usuario", $datosModel["Usuario"], PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetch();
		$stmt -> close();
	}

	public function intentosModel($datosModel, $tabla){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET intentos = :intentos WHERE Usuario = :Usuario");
		$stmt -> bindParam(":intentos", $datosModel["actualizarIntentos"], PDO::PARAM_INT);
		$stmt -> bindParam(":Usuario", $datosModel["usuarioActual"], PDO::PARAM_STR);
		if($stmt -> execute()){
			return "ok";
		}
		else{
			return "error";
		}
	}

}
