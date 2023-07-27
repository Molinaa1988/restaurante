<?php
date_default_timezone_set('America/El_Salvador');
require_once "conexion.php";

class modelSucesos{

	public function registroAnularTodosLosPedidos($datosModel){
		$stmt = Conexion::conectar()->prepare("INSERT INTO sucesos (fecha,suceso,IdPersonal,IdUsuario) VALUES (:fecha,:suceso,:IdPersonal,:IdUsuario)");
    $stmt->bindParam(":fecha", date("Y-m-d H:i:s"), PDO::PARAM_STR);
		$stmt->bindParam(":suceso", $datosModel["suceso"], PDO::PARAM_STR);
		$stmt->bindParam(":IdPersonal", $datosModel["IdPersonal"], PDO::PARAM_STR);
		$stmt->bindParam(":IdUsuario", $datosModel["IdUsuario"], PDO::PARAM_STR);
		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}
		$stmt->close();
	}
  public function vistaSucesos(){
    $stmt = Conexion::conectar()->prepare("SELECT * FROM sucesos");
    $stmt->execute();
    return $stmt->fetchAll();
    $stmt->close();
  }
	public function vistaSucesosSinVer(){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM sucesos where visto = 'N'");
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->close();
	}

  public function actualizarSucesosVistos(){
  $stmt = Conexion::conectar()->prepare("UPDATE sucesos SET visto = 'S'");
  if($stmt->execute()){
    return "success";
  }
  else{
    return "error";
  }
  $stmt->close();
}



		public function borrarCategoria($datosModel){
		$stmt = Conexion::conectar()->prepare("DELETE FROM categoria WHERE IdCategoria = :id");
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
