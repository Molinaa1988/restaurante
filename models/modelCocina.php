<?php

require_once "conexion.php";

class modelCocina{


//Sirve para listar los pedidos que estan para cocinar 
// and I.IdItems<>209  para que no cargue el descuento
	public function idPedidos(){
		$stmt = Conexion::conectar()->prepare("SELECT Distinct D.IdPedido as IdPedido 
    From detallepedido D inner join pedido P on P.IdPedido=D.IdPedido 
    where D.estado<>'D' and D.estado<>'X' and D.estado<>'M' and D.estado<>'B'  and D.estado<>'Q' 
    and D.IdItems<>209 
    and  DATE_FORMAT(P.FechaPedido,'%d-%m-%Y')   = DATE_FORMAT(NOW(),'%d-%m-%Y') 
    Group by D.IdPedido order by P.IdPedido");
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->null;
	}
//Mesa
public function nroMesa($datosModel){
  $stmt = Conexion::conectar()->prepare("SELECT Min(NroMesa) as NroMesa from detallemesa where IdPedido=:idpedido");
  $stmt->bindParam(":idpedido", $datosModel, PDO::PARAM_INT);
  $stmt->execute();
  return $stmt->fetch();
  $stmt->null;
}
//Mesero
public function mesero($datosModel){
  $stmt = Conexion::conectar()->prepare("SELECT P.Nombres as Nombre from personal P inner join pedido Pd on P.IdPersonal = Pd.IdPersonal where Pd.IdPedido=:idpedido");
  $stmt->bindParam(":idpedido", $datosModel, PDO::PARAM_INT);
  $stmt->execute();
  return $stmt->fetch();
  $stmt->null;
}
//Minutos demorados
public function minDemora($datosModel){
  $stmt = Conexion::conectar()->prepare("SELECT FechaPedido AS mi
  from pedido where IdPedido=:idpedido");
  $stmt->bindParam(":idpedido", $datosModel, PDO::PARAM_INT);
  $stmt->execute();
  return $stmt->fetch();
  $stmt->null;
}
//DetallePedido
// and C.FormaDePreparar ='Cocina' se le quitó eso para que muestre bebidas también
// and C.FormaDePreparar ='Cocina'
public function DetallePedido($datosModel){
  $stmt = Conexion::conectar()->prepare("SELECT D.IdDetallePedido as idDetalle, I.Descripcion as Plato, D.Cantidad as Cantidad,D.Estado as Estado, D.comentario as comentario, D.newadd as newadd
	from detallepedido D inner Join items I on D.IdItems=I.IdItems inner join categoria C on C.IdCategoria = I.IdCategoria
	where D.IdPedido=:idpedido and D.Estado<>'D'
	and D.Estado<>'X' and D.Estado<>'M'
	and I.IdTipoItem=2 and I.IdItems<>209 and C.FormaDePreparar ='Cocina'
	order by D.Estado");
  $stmt->bindParam(":idpedido", $datosModel, PDO::PARAM_INT);
  $stmt->execute();
  return $stmt->fetchAll();
  $stmt->null;
}
//DetallePedido
public function DetallePedidoPorIdPedido($datosModel){
  $stmt = Conexion::conectar()->prepare("SELECT IdDetallePedido, Estado FROM detallepedido where IdPedido = :idpedido");
  $stmt->bindParam(":idpedido", $datosModel, PDO::PARAM_INT);
  $stmt->execute();
  return $stmt->fetchAll();
  $stmt->null;
}

public function cambiarEstadoDetalle($datosModel){
$stmt = Conexion::conectar()->prepare("UPDATE detallepedido SET Estado = 'P' WHERE IdDetallePedido = :id");
$stmt->bindParam(":id", $datosModel, PDO::PARAM_STR);
if($stmt->execute()){
	return "success";
}
else{
	return "error";
}
$stmt->null;
}
public function cambiarEstadoDetalleEliminar($datosModel){
$stmt = Conexion::conectar()->prepare("UPDATE detallepedido SET Estado = 'D' WHERE IdDetallePedido = :id");
$stmt->bindParam(":id", $datosModel, PDO::PARAM_STR);
if($stmt->execute()){
	return "success";
}
else{
	return "error";
}
$stmt->null;
}
public function cambiarEstadoDetalleEliminarAnulado($datosModel){
$stmt = Conexion::conectar()->prepare("UPDATE detallepedido SET Estado = 'X' WHERE IdDetallePedido = :id");
$stmt->bindParam(":id", $datosModel, PDO::PARAM_STR);
if($stmt->execute()){
	return "success";
}
else{
	return "error";
}
$stmt->null;
}


}
