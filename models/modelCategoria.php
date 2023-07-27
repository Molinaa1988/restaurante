<?php

require_once "conexion.php";

class modelCategoria{

	public function registroCategoria($datosModel){
		$stmt = Conexion::conectar()->prepare("INSERT INTO categoria (FormaDePreparar,Nombre) VALUES (:preparacion,:nombre)");
		$stmt->bindParam(":preparacion", $datosModel["preparacion"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);

		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}
		$stmt->close();
	}

  public function actualizarCategoria($datosModel){
  $stmt = Conexion::conectar()->prepare("UPDATE categoria SET FormaDePreparar = :preparacion, Nombre = :nombre WHERE IdCategoria = :id");
  $stmt->bindParam(":id", $datosModel["id"], PDO::PARAM_STR);
  $stmt->bindParam(":preparacion", $datosModel["preparacion"], PDO::PARAM_STR);
  $stmt->bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);

  if($stmt->execute()){
    return "success";
  }
  else{
    return "error";
  }
  $stmt->close();
}

	public function vistaCategoria(){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM categoria");
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->close();
	}

	//vista pal modal de los ingredientes
	public function vistaIngredientes(){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM ingredientes");
		$stmt->execute();
		return $stmt->fetchAll();
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
