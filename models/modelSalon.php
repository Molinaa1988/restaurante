<?php
date_default_timezone_set('America/El_Salvador');

require_once "conexion.php";

class modelSalon{

	public function estadoMesa(){
		// $stmt = Conexion::conectar()->prepare("SELECT * from mesa WHERE naturaleza = 'L'"); Para que solo muestre los de llevar
		$stmt = Conexion::conectar()->prepare("SELECT * from mesa");
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->null;
	}

	// Nuevas Funciones Nahum Cruz
	public function cambioPedido(){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM pedido ORDER BY Cambios DESC LIMIT 1");
		$stmt->execute();
		return $stmt->fetch();
		$stmt->null;
	}

	public function CountPedido(){
		$stmt = Conexion::conectar()->prepare("SELECT COUNT(*) AS Cant FROM pedido");
		$stmt->execute();
		return $stmt->fetch();
		$stmt->null;
	}


	public function CountDetallePedido(){
		$stmt = Conexion::conectar()->prepare("SELECT COUNT(*) AS Cant FROM detallepedido");
		$stmt->execute();
		return $stmt->fetch();
		$stmt->null;
	}
	
	public function cambioDetallePedido(){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM detallepedido ORDER BY Cambios DESC LIMIT 1");
		$stmt->execute();
		return $stmt->fetch();
		$stmt->null;
	}
	
	public function MesaxZona($idZona){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM mesa WHERE idzona = :idZona");
		$stmt->bindParam(":idZona", $idZona, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->null;
	}


	public function Pedido($IdPedido){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM pedido WHERE IdPedido = :IdPedido");
		$stmt->bindParam(":IdPedido", $IdPedido, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch();
		$stmt->null;
	}

	public function DetalleMesaxPedido($IdPedido){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM detallemesa WHERE IdPedido = :IdPedido");
		$stmt->bindParam(":IdPedido", $IdPedido, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch();
		$stmt->null;
	}


	// Modificado 27/11/20
	public function DetalleEnviado($Dts){
		$stmt = Conexion::conectar()->prepare("SELECT COUNT(*) AS Cant FROM detallepedido WHERE IdPedido = :IdPedido AND (Estado = 'P' OR Estado = 'D')");
		$stmt->bindParam(":IdPedido", $Dts['IdPedido'], PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch();
		$stmt->null;
	}


	public function UltDetalleRegistardo($Dts){
		$stmt = Conexion::conectar()->prepare("SELECT MAX(IdDetallePedido) AS IdDetallePedido FROM detallepedido WHERE IdPedido = :IdPedido");
		$stmt->bindParam(":IdPedido", $Dts['IdPedido'], PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch();
		$stmt->null;
	}

	// Actualizar newadd
	
	public function UpnewAdd($IdDetallePedido, $Valor){
		$stmt = Conexion::conectar()->prepare("UPDATE detallepedido SET newadd = :newadd WHERE IdDetallePedido = :IdDetallePedido");

		$stmt->bindParam(":IdDetallePedido", $IdDetallePedido, PDO::PARAM_INT);
		$stmt->bindParam(":newadd", $Valor, PDO::PARAM_STR);
		if($stmt->execute()){
			return "success";
		}else{
			return "error";
		}
		$stmt->null;
	}

	


	// ******************************* //

	public function AddDetallePedido($Dts){
		$stmt = Conexion::conectar()->prepare("INSERT INTO detallepedido 
			(IdPedido, Estado, IdItems, Cantidad, Precio, comentario) 
		VALUES (:IdPedido, :Estado, :IdItems, :Cant, :Precio, :Comentario)");
		$stmt->bindParam(":IdPedido", $Dts['IdPedido'], PDO::PARAM_STR);
		$stmt->bindParam(":IdItems", $Dts['IdPlato'], PDO::PARAM_STR);
		$stmt->bindParam(":Cant", $Dts['Cantidad'], PDO::PARAM_STR);
		$stmt->bindParam(":Precio", $Dts['Precio'], PDO::PARAM_STR);
		$stmt->bindParam(":Comentario", $Dts['Comentario'], PDO::PARAM_STR);
		$stmt->bindParam(":Estado", $Dts['Estado'], PDO::PARAM_STR);
		
		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}
		$stmt->null;
	}

	public function UpEstadoDetallePedido($Id, $Estado){
		$stmt = Conexion::conectar()->prepare("UPDATE detallepedido SET Estado = :Estado WHERE IdDetallePedido = :Id");

		$stmt->bindParam(":Id", $Id, PDO::PARAM_STR);
		$stmt->bindParam(":Estado", $Estado, PDO::PARAM_STR);

		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}
		$stmt->null;
	}

	public function DetallePedido($Id){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM detallepedido WHERE IdDetallePedido = :Id");
		$stmt->bindParam(":Id", $Id, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetch();
		$stmt->null;
	}

	public function MesaPediente($Mesa){
		$stmt = Conexion::conectar()->prepare("SELECT P.* FROM pedido P INNER JOIN detallemesa DM ON P.IdPedido = DM.IdPedido  WHERE DM.NroMesa = :Mesa AND P.Estado = 'P' LIMIT 1");
		$stmt->bindParam(":Mesa", $Mesa, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetch();
		$stmt->null;
	}
	// Fin de Funciones Nahum Cruz

  public function ListadoMeseros(){
    $stmt = Conexion::conectar()->prepare("SELECT IdPersonal, Nombres from personal where IdCargo = 5 and Estado = '1'");
    $stmt->execute();
    return $stmt->fetchAll();
    $stmt->null;
  }
  public function Mesero($idMesero){
    $stmt = Conexion::conectar()->prepare("SELECT * from personal where IdPersonal = :id");
    $stmt->bindParam(":id", $idMesero, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch();
    $stmt->null;
  }
	public function Usuario($idUsuario){
		$stmt = Conexion::conectar()->prepare("SELECT Usuario from usuario where IdUsuario = :id");
		$stmt->bindParam(":id", $idUsuario, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch();
		$stmt->null;
	}
  public function ListadoCategorias(){
    $stmt = Conexion::conectar()->prepare("SELECT * from categoria ORDER BY Nombre ASC");
    $stmt->execute();
    return $stmt->fetchAll();
    $stmt->null;
  }
  public function ListadoPlatos($idCategoria){
    $stmt = Conexion::conectar()->prepare("SELECT i.IdItems as IdItems, i.PrecioVenta as PrecioVenta, i.Descripcion as Descripcion, c.FormaDePreparar as FormaDePreparar 
	from items i 
	inner join categoria c on i.IdCategoria = c.IdCategoria 
	where i.IdCategoria=:id and i.Descripcion != 'Descuento' and i.Descripcion !='Cargo' and i.Descripcion !='Cupon' AND i.Estado = '1' 
	ORDER BY i.Descripcion ASC");
    $stmt->bindParam(":id", $idCategoria, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
    $stmt->null;
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
		$stmt->null;
	}
	//Cambio de mesas
	public function idDetalleMesa($idMesero){
		$stmt = Conexion::conectar()->prepare("SELECT DM.IdDetalleMesa as IdDetalleMesa from mesa M INNER JOIN
		detallemesa DM on M.NroMesa=DM.NroMesa inner join pedido P on P.IdPedido=DM.IdPedido inner join personal PR on P.IdPersonal=PR.IdPersonal
		WHERE M.NroMesa = :mesa and P.Estado = 'A'");
		$stmt->bindParam(":mesa", $idMesero['mesa1'], PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->null;
	}

	public function cambioMesaIdDetalleMesa($datosModel){
		$stmt = Conexion::conectar()->prepare("UPDATE detallemesa set NroMesa=:mesa where IdDetalleMesa=:IdDetalleMesa");
		$stmt->bindParam(":mesa", $datosModel['mesa'], PDO::PARAM_INT);
		$stmt->bindParam(":IdDetalleMesa", $datosModel['IdDetalleMesa'], PDO::PARAM_INT);
		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}
		$stmt->null;
	}
	public function cambioEstadoMesa($datosModel){
		$stmt = Conexion::conectar()->prepare("UPDATE mesa set Estado=:Estado where NroMesa=:NroMesa");
		$stmt->bindParam(":Estado", $datosModel['Estado'], PDO::PARAM_STR);
		$stmt->bindParam(":NroMesa", $datosModel['NroMesa'], PDO::PARAM_INT);
		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}
		$stmt->null;
	}
	public function verificarEstadoMesa($datosModel){
		$stmt = Conexion::conectar()->prepare("SELECT Estado, naturaleza, Etiqueta FROM mesa where NroMesa = :NroMesa");
		$stmt->bindParam(":NroMesa", $datosModel, PDO::PARAM_INT);
		$stmt->execute();
    return $stmt->fetch();
    $stmt->null;
	}
  // MANEJO DE IDPEDIDO
	public function crearPedido($datosModel){
		$stmt = Conexion::conectar()->prepare("INSERT INTO pedido (IdPersonal, FechaPedido, Estado) VALUES (:IdPersonal,:FechaPedido,'A')");
    	$stmt->bindParam(":IdPersonal", $datosModel, PDO::PARAM_STR);
		$Fecha= date("Y-m-d H:i:s");
		$stmt->bindParam(":FechaPedido", $Fecha, PDO::PARAM_STR);
		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}
		$stmt->null;
	}
	public function ultimoIdPedido(){
		$stmt = Conexion::conectar()->prepare("SELECT max(IdPedido) as idPedido FROM pedido");
		$stmt->execute();
		return $stmt->fetch();
		$stmt->null;
	}
	public function crearDetalleMesa($nroMesa,$idPedido){
		$stmt = Conexion::conectar()->prepare("INSERT INTO detallemesa (NroMesa, IdPedido) VALUES (:NroMesa,:IdPedido)");
		$stmt->bindParam(":NroMesa", $nroMesa, PDO::PARAM_STR);
		$stmt->bindParam(":IdPedido", $idPedido, PDO::PARAM_STR);
		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}
		$stmt->null;
	}
	public function idPedido($nroMesa){
		$stmt = Conexion::conectar()->prepare("SELECT P.IdPedido as Pedido from pedido P INNER JOIN detallemesa DM on P.IdPedido = DM.IdPedido INNER JOIN mesa M on DM.NroMesa = M.NroMesa where P.Estado = 'A' AND M.NroMesa = :NroMesa");
		$stmt->bindParam(":NroMesa", $nroMesa, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetch();
		$stmt->null;
	}
	public function idPersonal($idPedido){
		$stmt = Conexion::conectar()->prepare("SELECT IdPersonal from pedido where IdPedido = :idPedido");
		$stmt->bindParam(":idPedido", $idPedido, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetch();
		$stmt->null;
	}
	public function idDetallePedido($idPedido){
		$stmt = Conexion::conectar()->prepare("SELECT IdDetallePedido, IdItems, Cantidad, Precio, Estado, comentario, Cambios, newadd 
												FROM detallepedido where IdPedido =  :idPedido");
		$stmt->bindParam(":idPedido", $idPedido, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->null;
	}
	public function descripcionItem($IdItems){
		$stmt = Conexion::conectar()->prepare("SELECT Descripcion, PrecioVenta FROM items where IdItems = :IdItems");
		$stmt->bindParam(":IdItems", $IdItems, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetch();
		$stmt->null;
	}
	public function registrarDetallePedidoCocina($datosModel){
		$stmt = Conexion::conectar()->prepare("INSERT INTO detallepedido (IdPedido, Estado, IdItems, Cantidad, Precio) VALUES (:IdPedido,'M',:IdItems,:Cant,:Precio)");
		$stmt->bindParam(":IdPedido", $datosModel['IdPedido'], PDO::PARAM_STR);
		$stmt->bindParam(":IdItems", $datosModel['IdItems'], PDO::PARAM_STR);
		$stmt->bindParam(":Precio", $datosModel['Precio'], PDO::PARAM_STR);
		$stmt->bindParam(":Cant", $datosModel['Cantidad'], PDO::PARAM_STR);

		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}
		$stmt->null;
	}
	public function registrarDetallePedidoBar($datosModel){
		$stmt = Conexion::conectar()->prepare("INSERT INTO detallepedido (IdPedido, Estado, IdItems, Cantidad, Precio) VALUES (:IdPedido,'B',:IdItems,:Cant,:Precio)");
		$stmt->bindParam(":IdPedido", $datosModel['IdPedido'], PDO::PARAM_STR);
		$stmt->bindParam(":IdItems", $datosModel['IdItems'], PDO::PARAM_STR);
		$stmt->bindParam(":Precio", $datosModel['Precio'], PDO::PARAM_STR);
		$stmt->bindParam(":Cant", $datosModel['Cantidad'], PDO::PARAM_STR);

		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}
		$stmt->null;
	}
	public function borrarDetallePedido($datosModel){
	$stmt = Conexion::conectar()->prepare("DELETE FROM detallepedido WHERE IdDetallePedido = :IdDetallePedido");
	$stmt->bindParam(":IdDetallePedido", $datosModel['IdDetallePedido'], PDO::PARAM_INT);
	if($stmt->execute()){
		return "success";
	}
	else{
		return "error";
	}
	$stmt->null;
}
public function actualizarDetallePedido($datosModel){
$stmt = Conexion::conectar()->prepare("UPDATE detallepedido SET Estado = 'A' WHERE IdDetallePedido = :IdDetallePedido");
$stmt->bindParam(":IdDetallePedido", $datosModel['IdDetallePedido'], PDO::PARAM_INT);
if($stmt->execute()){
	return "success";
}
else{
	return "error";
}
$stmt->null;
}
public function seleccionarDetallePedido($datosModel){
$stmt = Conexion::conectar()->prepare("SELECT Cantidad, Precio FROM detallepedido where IdDetallePedido = :IdDetallePedido");
$stmt->bindParam(":IdDetallePedido", $datosModel['IdDetallePedido'], PDO::PARAM_INT);
$stmt->execute();
return $stmt->fetch();
$stmt->null;
}
public function aumentarDetallePedido($datosModel){
$stmt = Conexion::conectar()->prepare("UPDATE detallepedido SET Cantidad = :cantidad, Precio = :precio  WHERE IdDetallePedido =  :IdDetallePedido");
$stmt->bindParam(":IdDetallePedido", $datosModel['IdDetallePedido'], PDO::PARAM_INT);
$stmt->bindParam(":cantidad", $datosModel['cantidad'], PDO::PARAM_STR);
$stmt->bindParam(":precio", $datosModel['precio'], PDO::PARAM_STR);
if($stmt->execute()){
	return "success";
}
else{
	return "error";
}
$stmt->null;
}
public function pagoPedido($datosModel){
$stmt = Conexion::conectar()->prepare("SELECT sum(Precio) as subTotal FROM detallepedido where IdPedido = :IdPedido and Estado != 'A' and Estado != 'X'");
$stmt->bindParam(":IdPedido", $datosModel, PDO::PARAM_INT);
$stmt->execute();
return $stmt->fetch();
$stmt->null;
}
public function eliminarDetalleMesa($datosModel){
$stmt = Conexion::conectar()->prepare("DELETE FROM detallemesa WHERE IdPedido = :IdPedido");
$stmt->bindParam(":IdPedido", $datosModel, PDO::PARAM_INT);
if($stmt->execute()){
	return "success";
}
else{
	return "error";
}
}
public function eliminarDetallePedido($datosModel){
$stmt = Conexion::conectar()->prepare("DELETE FROM detallepedido WHERE IdPedido = :IdPedido");
$stmt->bindParam(":IdPedido", $datosModel, PDO::PARAM_INT);
if($stmt->execute()){
	return "success";
}
else{
	return "error";
}
}
public function eliminarPedido($datosModel){
$stmt = Conexion::conectar()->prepare("DELETE FROM pedido WHERE IdPedido = :IdPedido");
$stmt->bindParam(":IdPedido", $datosModel, PDO::PARAM_INT);
if($stmt->execute()){
	return "success";
}
else{
	return "error";
}
}
public function enviarPedidoCocina($datosModel){
$stmt = Conexion::conectar()->prepare("UPDATE detallepedido SET Estado = 'S' WHERE IdPedido = :IdPedido and Estado = 'M'");
$stmt->bindParam(":IdPedido", $datosModel, PDO::PARAM_INT);
if($stmt->execute()){
	return "success";
}
else{
	return "error";
}
$stmt->null;
}
// PARA NO ELIMINAR BEBIDA
public function enviarPedidoBarNoPermitirBorrar($datosModel){
$stmt = Conexion::conectar()->prepare("UPDATE detallepedido SET Estado = 'D' WHERE IdPedido = :IdPedido and Estado = 'B'");
$stmt->bindParam(":IdPedido", $datosModel, PDO::PARAM_INT);
if($stmt->execute()){
	return "success";
}
else{
	return "error";
}
$stmt->null;
}
// PARA PERMITIR ELIMINAR BEBIDA Y PARA EL ESTADO OCUPARES Q
public function enviarPedidoBarPermitirBorrar($datosModel){
$stmt = Conexion::conectar()->prepare("UPDATE detallepedido SET Estado = 'Q' WHERE IdPedido = :IdPedido and Estado = 'B'");
$stmt->bindParam(":IdPedido", $datosModel, PDO::PARAM_INT);
if($stmt->execute()){
	return "success";
}
else{
	return "error";
}
$stmt->null;
}
public function preCuenta($datosModel){
$stmt = Conexion::conectar()->prepare("UPDATE pedido SET Total = :Total, Propina = :Propina, Exentos = :Exentos, Retencion = :Retencion, Estado = 'P' WHERE IdPedido = :IdPedido and Estado = 'A'");
$stmt->bindParam(":Total", $datosModel['Total'], PDO::PARAM_STR);
$stmt->bindParam(":Propina", $datosModel['Propina'], PDO::PARAM_STR);
$stmt->bindParam(":Exentos", $datosModel['Exentos'], PDO::PARAM_STR);
$stmt->bindParam(":Retencion", $datosModel['Retencion'], PDO::PARAM_STR);
$stmt->bindParam(":IdPedido", $datosModel['IdPedido'], PDO::PARAM_STR);
if($stmt->execute()){
	return "success";
}
else{
	return "error";
}
$stmt->null;
}
public function ActualizarDP($datosModel){
$stmt = Conexion::conectar()->prepare("UPDATE detallepedido SET comentario = :mensaje, Cantidad = :Cant WHERE IdDetallePedido = :idDetalle");
$stmt->bindParam(":mensaje", $datosModel['Comentario'], PDO::PARAM_STR);
$stmt->bindParam(":Cant", $datosModel['Cantidad'], PDO::PARAM_STR);
$stmt->bindParam(":idDetalle", $datosModel['IdDetallePedido'], PDO::PARAM_STR);
if($stmt->execute()){
	return "success";
}
else{
	return "error";
}
$stmt->null;
}

public function UpTarjeta($IdPedido, $Tarjeta){
$stmt = Conexion::conectar()->prepare("UPDATE pedido SET Tarjeta = :Tarjeta WHERE IdPedido = :ID");
$stmt->bindParam(":Tarjeta", $Tarjeta, PDO::PARAM_STR);
$stmt->bindParam(":ID", $IdPedido, PDO::PARAM_STR);
if($stmt->execute()){
	return "success";
}
else{
	return "error";
}
$stmt->null;
}



public function idPedidoReapertura($nroMesa){
	$stmt = Conexion::conectar()->prepare("SELECT P.IdPedido as Pedido from pedido P 
									INNER JOIN detallemesa DM on P.IdPedido = DM.IdPedido 
									INNER JOIN mesa M on DM.NroMesa = M.NroMesa 
									where P.Estado = 'P' AND M.NroMesa = :NroMesa");
	$stmt->bindParam(":NroMesa", $nroMesa, PDO::PARAM_STR);
	$stmt->execute();
	return $stmt->fetch();
	$stmt->null;
}

public function idPedidoReapertura1($nroMesa){
	$stmt = Conexion::conectar()->prepare("SELECT P.IdPedido as Pedido from pedido P 
									INNER JOIN detallemesa DM on P.IdPedido = DM.IdPedido 
									INNER JOIN mesa M on DM.NroMesa = M.NroMesa 
									where P.Estado = 'P' AND M.NroMesa = :NroMesa");
	$stmt->bindParam(":NroMesa", $nroMesa, PDO::PARAM_STR);
	$stmt->execute();
	return $stmt->fetchAll();
	$stmt->null;
}

public function reApertura($datosModel){
$stmt = Conexion::conectar()->prepare("UPDATE pedido SET Estado = 'A' WHERE IdPedido = :IdPedido and Estado = 'P'");
$stmt->bindParam(":IdPedido", $datosModel, PDO::PARAM_STR);
if($stmt->execute()){
	return "success";
}else{
	return "error";
}
$stmt->null;
}
public function pedidosPorMesa($mesa){
	$stmt = Conexion::conectar()->prepare("SELECT DM.*, P.NombreCliente FROM 
		detallemesa DM INNER JOIN pedido P ON P.IdPedido = DM.IdPedido 
	WHERE NroMesa = :Mesa AND P.Estado = 'A'");
	$stmt->bindParam(":Mesa", $mesa, PDO::PARAM_STR);
	$stmt->execute();
	return $stmt->fetchAll();
	$stmt->null;
}
public function crearPedidoConNombre($datosModel){
	$stmt = Conexion::conectar()->prepare("INSERT INTO pedido (IdPersonal, NombreCliente, FechaPedido, Estado) VALUES (:IdPersonal,:NombreCliente,:FechaPedido,'A')");
	$stmt->bindParam(":IdPersonal", $datosModel['IdPersonal'], PDO::PARAM_STR);
	$stmt->bindParam(":NombreCliente", $datosModel['NombreCliente'], PDO::PARAM_STR);
	$stmt->bindParam(":FechaPedido", date("Y-m-d H:i:s"), PDO::PARAM_STR);
	if($stmt->execute()){
		return "success";
	}
	else{
		return "error";
	}
	$stmt->null;
}
public function cliente($idPedido){
	$stmt = Conexion::conectar()->prepare("SELECT NombreCliente FROM pedido where IdPedido =  :id");
	$stmt->bindParam(":id", $idPedido, PDO::PARAM_INT);
	$stmt->execute();
	return $stmt->fetch();
	$stmt->null;
}
public function cambiarNombreCliente($datosModel){
$stmt = Conexion::conectar()->prepare("UPDATE pedido SET NombreCliente = :NombreCliente WHERE IdPedido = :IdPedido");
$stmt->bindParam(":IdPedido", $datosModel['IdPedido'], PDO::PARAM_STR);
$stmt->bindParam(":NombreCliente", $datosModel['NombreCliente'], PDO::PARAM_STR);
if($stmt->execute()){
	return "success";
}
else{
	return "error";
}
$stmt->null;
}
public function actualizarCombinarPedido($datosModel){
$stmt = Conexion::conectar()->prepare("UPDATE pedido SET Compartida = 'S' WHERE IdPedido = :IdPedido");
$stmt->bindParam(":IdPedido", $datosModel, PDO::PARAM_STR);
if($stmt->execute()){
	return "success";
}
else{
	return "error";
}
$stmt->null;
}
public function anularTodosLosPedidos($datosModel){
$stmt = Conexion::conectar()->prepare("UPDATE detallepedido set Estado='A' where IdPedido=:idPedido");
$stmt->bindParam(":idPedido", $datosModel['idPedido'], PDO::PARAM_STR);
if($stmt->execute()){
	return "success";
}
else{
	return "error";
}
$stmt->null;
}
public function verificarAutorizacion($datosModel){
	$stmt = Conexion::conectar()->prepare("SELECT IdUsuario FROM usuario where Usuario = :Usuario and Clave = :Clave and (Puesto = 1  OR Puesto = 3)");
	$stmt->bindParam(":Usuario", $datosModel['Usuario'], PDO::PARAM_INT);
	$stmt->bindParam(":Clave", $datosModel['Clave'], PDO::PARAM_INT);
	$stmt->execute();
	return $stmt->fetch();
	$stmt->null;
}


}
