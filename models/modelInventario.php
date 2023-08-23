<?php

require_once "conexion.php";

class modelInventario{

		public function registroInventario($datosModel){
		$stmt = Conexion::conectar()->prepare("INSERT INTO items (IdTipoItem, IdFamilia, IdCategoria,PrecioVenta,Stock,Descripcion) VALUES (:tipoitem,:familia,:idcategoria,:precio,:stock,:descripcion)");
		$stmt->bindParam(":tipoitem", $datosModel["tipoitem"], PDO::PARAM_STR);
		$stmt->bindParam(":familia", $datosModel["familia"], PDO::PARAM_STR);
		$stmt->bindParam(":idcategoria", $datosModel["idcategoria"], PDO::PARAM_STR);
		$stmt->bindParam(":precio", $datosModel["precio"], PDO::PARAM_STR);
		$stmt->bindParam(":stock", $datosModel["stock"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datosModel["descripcion"], PDO::PARAM_STR);
		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}
		$stmt->close();
	}

	public function actualizarInventario($datosModel){
	$stmt = Conexion::conectar()->prepare("UPDATE items SET IdCategoria = :idcategoria, PrecioVenta = :precio, Stock = :stock, Descripcion = :descripcion WHERE IdItems = :id");
	$stmt->bindParam(":id", $datosModel["id"], PDO::PARAM_STR);
	$stmt->bindParam(":idcategoria", $datosModel["idcategoria"], PDO::PARAM_STR);
	$stmt->bindParam(":precio", $datosModel["precio"], PDO::PARAM_STR);
	$stmt->bindParam(":stock", $datosModel["stock"], PDO::PARAM_STR);
	$stmt->bindParam(":descripcion", $datosModel["descripcion"], PDO::PARAM_STR);
	if($stmt->execute()){
		return "success";
	}
	else{
		return "error";
	}
	$stmt->close();
}
	//actualziar el table
	public function updateTableIngredientes($datosModel){
		
		$stmt = Conexion::conectar()->prepare("UPDATE ingredientes 
			set ".$datosModel['columna']."= :valor WHERE IdIngredientes= :id");
		$stmt->bindParam(":id", $datosModel["id"], PDO::PARAM_STR);
		$stmt->bindParam(":valor", $datosModel["valor"], PDO::PARAM_STR);
		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}
		$stmt->close();
	}	

	public function vistaInventario(){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM items");
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->close();
	}

	public function vistaIngredientes(){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM ingredientes");
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->close();
	}

	// pa los ingredientes usados
	public function vistaIngredientesUsados($fecha){
		$stmt = Conexion::conectar()->prepare("SELECT	SUM(DP.Cantidad) as Cantidad,	I.Descripcion, rel.CantidadU, ing.DescripcionIng, 
								ing.UnidadMedida, ing.IdIngredientes, DP.IdPedido, DP.Actualizar,
								SUM(DP.Cantidad*rel.CantidadU) as Total
								from	items I 
								inner join detallepedido DP on 	I.IdItems=DP.IdItems 
								inner join pedido P on P.IdPedido=DP.IdPedido 
								inner join categoria C on C.IdCategoria = I.IdCategoria 
								inner join relacioningitem rel on rel.IdItems = I.IdItems
								inner join ingredientes ing on ing.IdIngredientes = rel.IdIngredientes
								where (I.IdTipoItem = 2) AND CAST(P.FechaPedido AS DATE ) = :fecha
								AND (C.FormaDePreparar = 'Cocina' OR C.FormaDePreparar = 'Bar')
								AND (DP.Actualizar = 0)
								group by DP.IdDetallePedido order by (Cantidad) DESC");
		$stmt->bindParam(":fecha", $fecha, PDO::PARAM_STR);		   
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->close();
	}

	public function vistaIngredientesUsadosS($fecha){
		$stmt = Conexion::conectar()->prepare("SELECT	SUM(DP.Cantidad) as Cantidad,	I.Descripcion, rel.CantidadU, ing.DescripcionIng, 
								ing.UnidadMedida, ing.IdIngredientes, DP.IdPedido, DP.Actualizar,
								SUM(DP.Cantidad*rel.CantidadU) as Total
								from	items I 
								inner join detallepedido DP on 	I.IdItems=DP.IdItems 
								inner join pedido P on P.IdPedido=DP.IdPedido 
								inner join categoria C on C.IdCategoria = I.IdCategoria 
								inner join relacioningitem rel on rel.IdItems = I.IdItems
								inner join ingredientes ing on ing.IdIngredientes = rel.IdIngredientes
								where (I.IdTipoItem = 2) AND CAST(P.FechaPedido AS DATE ) = :fecha
								AND (C.FormaDePreparar = 'Cocina' OR C.FormaDePreparar = 'Bar')
								AND (DP.Actualizar = 0)
								group by ing.DescripcionIng order by (Cantidad) DESC");
		$stmt->bindParam(":fecha", $fecha, PDO::PARAM_STR);		   
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->close();
	}


	public function vistaCategoria($datosModel){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM categoria WHERE IdCategoria = :idcategoria");
		$stmt->bindParam(":idcategoria", $datosModel["idcategoria"], PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetch();
		$stmt->close();
	}

		public function borrarInventario($datosModel){
		$stmt = Conexion::conectar()->prepare("DELETE FROM items WHERE IdItems = :id");
		$stmt->bindParam(":id", $datosModel, PDO::PARAM_INT);
		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}
		$stmt->close();
	}
	
	public function registroIngredientes($datosModel){
	$stmt = Conexion::conectar()->prepare("INSERT INTO ingredientes (DescripcionIng, UnidadMedida, Cantidad ) 
											VALUES (:descripcion,:unidad,:cantidad)");
	$stmt->bindParam(":unidad", $datosModel["unidad"], PDO::PARAM_STR);
	$stmt->bindParam(":cantidad", $datosModel["cantidad"], PDO::PARAM_STR);
	$stmt->bindParam(":descripcion", $datosModel["descripcion"], PDO::PARAM_STR);
	if($stmt->execute()){
		return "success";
	}
	else{
		return "error";
	}
	$stmt->close();
	}

	public function actualizarIngredientes($datosModel){
		$stmt = Conexion::conectar()->prepare("UPDATE ingredientes 
		SET DescripcionIng = :descripcion, UnidadMedida = :unidad, cantidad = :cantidad 
		WHERE IdIngredientes = :id");
		$stmt->bindParam(":id", $datosModel["id"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datosModel["descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":unidad", $datosModel["unidad"], PDO::PARAM_STR);
		$stmt->bindParam(":cantidad", $datosModel["cantidad"], PDO::PARAM_STR);
		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}
		$stmt->close();
	}

	public function borrarIngrediente($datosModel){
		$stmt = Conexion::conectar()->prepare("DELETE FROM ingredientes WHERE IdIngredientes = :id");
		$stmt->bindParam(":id", $datosModel, PDO::PARAM_INT);
		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}
		$stmt->close();
	}

	//borar relacions
	public function borrarRelacion($datosModel){
		$stmt = Conexion::conectar()->prepare("DELETE FROM relacioningitem WHERE IdRelacion = :id");
		$stmt->bindParam(":id", $datosModel, PDO::PARAM_INT);
		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}
		$stmt->close();
	}


	public function registroIngPorItems($datosModel){
		$stmt = Conexion::conectar()->prepare("INSERT INTO relacioningitem (IdIngredientes, IdItems, CantidadU) 
												VALUES (:IdIngredientes,:IdItems,:CantidadU)");
		$stmt->bindParam(":IdIngredientes", $datosModel["IdIngredientes"], PDO::PARAM_STR);
		$stmt->bindParam(":IdItems", $datosModel["IdItems"], PDO::PARAM_STR);
		$stmt->bindParam(":CantidadU", $datosModel["CantidadU"], PDO::PARAM_STR);
		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}
		$stmt->close();
		}

// funciones para los ingredientes e items usados

		public function descontarIngredientes($IdIngredientes, $Total){
			$stmt = Conexion::conectar()->prepare("UPDATE ingredientes 
									SET Cantidad = Cantidad-:Total WHERE IdIngredientes = :IdIngredientes");
			$stmt->bindParam(":IdIngredientes", $IdIngredientes, PDO::PARAM_STR);
			$stmt->bindParam(":Total", $Total, PDO::PARAM_STR);
			if($stmt->execute()){
				return "success1";
			}
			else{
				return "error";
			}
			$stmt->close();
			}
	
		public function	actualizarItemsDescontados($IdPedido){
			$stmt = Conexion::conectar()->prepare("UPDATE detallepedido 
									SET Actualizar=1 WHERE IdPedido = :IdPedido");
			$stmt->bindParam(":IdPedido", $IdPedido, PDO::PARAM_STR);
			if($stmt->execute()){
				return "success2";
			}
			else{
				return "error";
			}
			$stmt->close();
			}







}