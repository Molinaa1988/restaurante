<?php

require_once "conexion.php";

class modelPersonal{

	public function registroPersonal($datosModel){
		$stmt = Conexion::conectar()->prepare("INSERT INTO personal (IdCargo, DUI, Apellidos,Nombres,FechaNacimiento,Sexo,EstadoCivil,Direccion,Telefono,Estado) VALUES (:idCargo,:dui,:apellidos,:nombres,:fechaNacimiento,:sexo,:estadoCivil,:direccion,:telefono,:estado)");
		$stmt->bindParam(":idCargo", $datosModel["idCargo"], PDO::PARAM_STR);
		$stmt->bindParam(":dui", $datosModel["dui"], PDO::PARAM_STR);
		$stmt->bindParam(":apellidos", $datosModel["apellidos"], PDO::PARAM_STR);
		$stmt->bindParam(":nombres", $datosModel["nombres"], PDO::PARAM_STR);
		$stmt->bindParam(":fechaNacimiento", $datosModel["fechaNacimiento"], PDO::PARAM_STR);
		$stmt->bindParam(":sexo", $datosModel["sexo"], PDO::PARAM_STR);
		$stmt->bindParam(":estadoCivil", $datosModel["estadoCivil"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datosModel["direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datosModel["telefono"], PDO::PARAM_STR);
    $stmt->bindParam(":estado", $datosModel["estado"], PDO::PARAM_STR);

		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}
		$stmt->null;
	}

  public function actualizarPersonal($datosModel){
  $stmt = Conexion::conectar()->prepare("UPDATE personal SET IdCargo = :idCargo, DUI = :dui, Apellidos = :apellidos, Nombres = :nombres, FechaNacimiento = :fechaNacimiento, Sexo = :sexo, EstadoCivil = :estadoCivil, Direccion = :direccion, Telefono = :telefono, Estado = :estado WHERE IdPersonal = :id");
  $stmt->bindParam(":id", $datosModel["id"], PDO::PARAM_STR);
  $stmt->bindParam(":idCargo", $datosModel["idCargo"], PDO::PARAM_STR);
  $stmt->bindParam(":dui", $datosModel["dui"], PDO::PARAM_STR);
  $stmt->bindParam(":apellidos", $datosModel["apellidos"], PDO::PARAM_STR);
  $stmt->bindParam(":nombres", $datosModel["nombres"], PDO::PARAM_STR);
  $stmt->bindParam(":fechaNacimiento", $datosModel["fechaNacimiento"], PDO::PARAM_STR);
  $stmt->bindParam(":sexo", $datosModel["sexo"], PDO::PARAM_STR);
  $stmt->bindParam(":estadoCivil", $datosModel["estadoCivil"], PDO::PARAM_STR);
  $stmt->bindParam(":direccion", $datosModel["direccion"], PDO::PARAM_STR);
  $stmt->bindParam(":telefono", $datosModel["telefono"], PDO::PARAM_STR);
  $stmt->bindParam(":estado", $datosModel["estado"], PDO::PARAM_STR);

  if($stmt->execute()){
    return "success";
  }
  else{
    return "error";
  }
  $stmt->null;
}

	public function vistaPersonal(){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM personal");
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->null;
	}

		public function borrarPersonal($datosModel){
		$stmt = Conexion::conectar()->prepare("DELETE FROM personal WHERE IdPersonal = :id");
		$stmt->bindParam(":id", $datosModel, PDO::PARAM_INT);
		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}
		$stmt->null;
	}

	public function Personal($id){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM personal where IdPersonal = :id");
		$stmt->bindParam(":id", $id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch();
		$stmt->null;
	}



}
