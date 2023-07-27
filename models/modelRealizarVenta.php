<?php
date_default_timezone_set('America/El_Salvador');
require_once "conexion.php";

class modelRealizarVenta{

  public function registroCompra($datosModel){
		   $con = new Conexion();
    $stmt = $con->conectar()->prepare("INSERT INTO comprobantec (IdPedido,Serie,NumeroDoc,Fecha, FechaFact, Total,
    FormaPago,TipoComprobante,Propina, Hora, TotalPagar, Importe, NombreCliente, Documento,evitarDuplicacion) 
    VALUES (:idpedido,'0',:nrocomprobante,:fecha,:fechafact,:total,:formapago,:comprobante,:propina,:hora,:totalpagar,
    :importe, :cliente, :Documento,:evitarDuplicacion)");
		$stmt->bindParam(":idpedido", $datosModel["idpedido"], PDO::PARAM_STR);
		$stmt->bindParam(":nrocomprobante", $datosModel["nrocomprobante"], PDO::PARAM_STR);
    // $fecha= date('Y-m-d H:i:s');
    $fecha = $datosModel['Fecha'];
    $fechafact=$datosModel['FechaFact'];
		$stmt->bindParam(":fecha", $fecha, PDO::PARAM_STR);
    $stmt->bindParam(":fechafact", $fechafact, PDO::PARAM_STR);
    $stmt->bindParam(":total", $datosModel["total"], PDO::PARAM_STR);
		$stmt->bindParam(":formapago", $datosModel["formapago"], PDO::PARAM_STR);
		$stmt->bindParam(":comprobante", $datosModel["comprobante"], PDO::PARAM_STR);
		$stmt->bindParam(":propina", $datosModel["propina"], PDO::PARAM_STR);
    $hora = date('H:i:s');
    $stmt->bindParam(":hora", $hora, PDO::PARAM_STR);
    $stmt->bindParam(":totalpagar", $datosModel["totalpagar"], PDO::PARAM_STR);
    $stmt->bindParam(":importe", $datosModel["importe"], PDO::PARAM_STR);
    $stmt->bindParam(":evitarDuplicacion", $datosModel["evitarDuplicacion"], PDO::PARAM_STR);
    $stmt->bindParam(":cliente", $datosModel["cliente"], PDO::PARAM_STR);
    $stmt->bindParam(":Documento", $datosModel["nrc"], PDO::PARAM_STR);

		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}
		$stmt->null;
	}

  public function registroCompraOriginal($datosModel){
		$con = new Conexion();
    $stmt = $con->conectar()->prepare("INSERT INTO comprobante (IdPedido,Serie,NumeroDoc,Fecha, FechaFact, Total,
      FormaPago,TipoComprobante,Propina, Hora, TotalPagar,Importe,NombreCliente, Documento,evitarDuplicacion) 
      VALUES (:idpedido,'0',:nrocomprobante,:fecha,:fechafact,:total,:formapago,:comprobante,:propina,:hora,:totalpagar,
      :importe, :cliente, :Documento,:evitarDuplicacion)");
		$stmt->bindParam(":idpedido", $datosModel["idpedido"], PDO::PARAM_STR);
		$stmt->bindParam(":nrocomprobante", $datosModel["nrocomprobante"], PDO::PARAM_STR);
    // $fecha= date('Y-m-d H:i:s');
		$fecha = $datosModel['Fecha'];
		$fechafact=$datosModel['FechaFact'];
		$stmt->bindParam(":fecha", $fecha, PDO::PARAM_STR);
    $stmt->bindParam(":fechafact", $fechafact, PDO::PARAM_STR);$stmt->bindParam(":total", $datosModel["total"], PDO::PARAM_STR);
		$stmt->bindParam(":formapago", $datosModel["formapago"], PDO::PARAM_STR);
		$stmt->bindParam(":comprobante", $datosModel["comprobante"], PDO::PARAM_STR);
		$stmt->bindParam(":propina", $datosModel["propina"], PDO::PARAM_STR);
    $hora = date("H:i:s");
    $stmt->bindParam(":hora", $hora, PDO::PARAM_STR);
    $stmt->bindParam(":totalpagar", $datosModel["totalpagar"], PDO::PARAM_STR);
    $stmt->bindParam(":importe", $datosModel["importe"], PDO::PARAM_STR);
    $stmt->bindParam(":evitarDuplicacion", $datosModel["evitarDuplicacion"], PDO::PARAM_STR);
    $stmt->bindParam(":cliente", $datosModel["cliente"], PDO::PARAM_STR);
    $stmt->bindParam(":Documento", $datosModel["nrc"], PDO::PARAM_STR);

		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}
		$stmt->null;
	}

public function actualizarEstadoMesa($datosModel){
     $con = new Conexion();
    $stmt = $con->conectar()->prepare("UPDATE mesa set Estado='L' WHERE NroMesa=:id");
  $stmt->bindParam(":id", $datosModel["id"], PDO::PARAM_STR);
  if($stmt->execute()){
    return "success";
  }
  else{
    return "error";
  }
  $stmt->null;
}


public function UpEstadoMesa($Dts){
     $con = new Conexion();
    $stmt = $con->conectar()->prepare("UPDATE mesa set Estado='O' WHERE NroMesa=:id");
  $stmt->bindParam(":id", $Dts["NroMesa"], PDO::PARAM_STR);
  if($stmt->execute()){
    return "success";
  }
  else{
    return "error";
  }
  $stmt->null;
}



public function actualizarEstadoPedido($datosModel){
   $con = new Conexion();
    $stmt = $con->conectar()->prepare("UPDATE pedido set Estado='B' where IdPedido=:id");
$stmt->bindParam(":id", $datosModel["id"], PDO::PARAM_STR);
if($stmt->execute()){
  return "success";
}else{
  return "error";
}
$stmt->null;
}

public function Comensales($IdPedido, $Cant){
     $con = new Conexion();
    $stmt = $con->conectar()->prepare("UPDATE pedido set  NroComensales = :Cant where IdPedido=:id");
  $stmt->bindParam(":id", $IdPedido, PDO::PARAM_STR);
  $stmt->bindParam(":Cant", $Cant, PDO::PARAM_STR);
  if($stmt->execute()){
    return "success";
  }else{
    return "error";
  }
  $stmt->null;
}

public function Consumo($IdPedido, $Consumo){
     $con = new Conexion();
    $stmt = $con->conectar()->prepare("UPDATE pedido set  consumo = :valor where IdPedido=:id");
  $stmt->bindParam(":id", $IdPedido, PDO::PARAM_STR);
  $stmt->bindParam(":valor", $Consumo, PDO::PARAM_STR);
  if($stmt->execute()){
    return "success";
  }else{
    return "error";
  }
  $stmt->null;
}

public function NombreEdit($IdPedido, $NewNombre){
     $con = new Conexion();
    $stmt = $con->conectar()->prepare("UPDATE pedido set  NombreCliente = :valor where IdPedido=:id");
  $stmt->bindParam(":id", $IdPedido, PDO::PARAM_STR);
  $stmt->bindParam(":valor", $NewNombre, PDO::PARAM_STR);
  if($stmt->execute()){
    return "success";
  }else{
    return "error";
  }
  $stmt->null;
}

public function MeseroEdit($IdPedido, $Mesero){
     $con = new Conexion();
    $stmt = $con->conectar()->prepare("UPDATE pedido set  IdPersonal = :valor where IdPedido=:id");
  $stmt->bindParam(":id", $IdPedido, PDO::PARAM_STR);
  $stmt->bindParam(":valor", $Mesero, PDO::PARAM_STR);
  if($stmt->execute()){
    return "success";
  }else{
    return "error";
  }
  $stmt->null;
}

// DESCUENTOS Y CARGOS
public function ActualizarItemDescuentoCargo($datosModel){
   $con = new Conexion();
    $stmt = $con->conectar()->prepare("UPDATE items set PrecioVenta = :porcentaje where IdItems=:idItem");
$stmt->bindParam(":porcentaje", $datosModel["porcentaje"], PDO::PARAM_STR);
$stmt->bindParam(":idItem", $datosModel["idItem"], PDO::PARAM_STR);
if($stmt->execute()){
  return "success";
}
else{
  return "error";
    }
$stmt->null;
}
public function RegistroDetallePedido($datosModel){
     $con = new Conexion();
    $stmt = $con->conectar()->prepare("INSERT INTO detallepedido (IdPedido,Estado,IdItems,Cantidad,Precio) VALUES (:idpedido,'S',:idItem,'1',:porcentaje)");
  $stmt->bindParam(":idpedido", $datosModel["idpedido"], PDO::PARAM_STR);
  $stmt->bindParam(":idItem", $datosModel["idItem"], PDO::PARAM_STR);
  $stmt->bindParam(":porcentaje", $datosModel["porcentaje"], PDO::PARAM_STR);
  if($stmt->execute()){
    return "success";
  }
  else{
    return "error";
  }
  $stmt->null;
}
public function ActualizarMontoPedido($datosModel){
   $con = new Conexion();
    $stmt = $con->conectar()->prepare("UPDATE pedido set Total = :total, Propina = :propina, Exentos = :exentos, Retencion = :retencion where IdPedido=:idpedido");
$stmt->bindParam(":total", $datosModel["total"], PDO::PARAM_STR);
$stmt->bindParam(":propina", $datosModel["propina"], PDO::PARAM_STR);
$stmt->bindParam(":exentos", $datosModel["exentos"], PDO::PARAM_STR);
$stmt->bindParam(":retencion", $datosModel["retencion"], PDO::PARAM_STR);
$stmt->bindParam(":idpedido", $datosModel["idpedido"], PDO::PARAM_STR);
if($stmt->execute()){
  return "success";
}else{
  return "error";
}
$stmt->null;
}
public function EliminarDescuentoCargo($datosModel){
   $con = new Conexion();
    $stmt = $con->conectar()->prepare("DELETE FROM detallepedido  where IdItems = :idItem and IdPedido = :idpedido");
$stmt->bindParam(":idpedido", $datosModel["idpedido"], PDO::PARAM_STR);
$stmt->bindParam(":idItem", $datosModel["idItem"], PDO::PARAM_STR);
if($stmt->execute()){
  return "success";
}
else{
  return "error";
}
$stmt->null;
}

public function ExisteDescuentoOCargo($datosModel){
     $con = new Conexion();
    $stmt = $con->conectar()->prepare("SELECT * from detallepedido where IdItems = :idItem and IdPedido = :idpedido");
  $stmt->bindParam(":idItem", $datosModel["idItem"], PDO::PARAM_STR);
  $stmt->bindParam(":idpedido", $datosModel["idPedido"], PDO::PARAM_STR);
  $stmt->execute();
  return $stmt->fetch();
  $stmt->null;
}

////////////////////////////////////////////////////


public function BuscarCliente($datosModel){
     $con = new Conexion();
    $stmt = $con->conectar()->prepare("SELECT NRC, NIT, Cliente, Direccion, Departamento, Municipio, Giro 
                        FROM clientenrc WHERE NRC=:nrc");
  $stmt->bindParam(":nrc", $datosModel, PDO::PARAM_STR);
  $stmt->execute();
  return $stmt->fetchAll();
  $stmt->null;
}



///buscar los otros clientes

public function BuscarClientes1($datosModel){
     $con = new Conexion();
    $stmt = $con->conectar()->prepare("SELECT IdCliente, Nombre, Direccion, Celular 
                            FROM clientes WHERE IdCliente=:nrc");
  $stmt->bindParam(":nrc", $datosModel, PDO::PARAM_STR);
  $stmt->execute();
  return $stmt->fetchAll();
  $stmt->null;
}




public function conteoDeMesasPendientes(){
      $con = new Conexion();
    $stmt = $con->conectar()->prepare("SELECT NroMesa as nromesa from mesa WHERE Estado = 'O' OR Estado='P'");
   $stmt->execute();
   return $stmt->fetchAll();
   $stmt->null;
 }

	public function vistaPedidosEnCaja(){
        $con = new Conexion();
    $stmt = $con->conectar()->prepare("SELECT
      M.NroMesa as nromesa,
      PR.Nombres as mesero,
      P.Total as total,
      DM.IdPedido as idpedido,
      M.naturaleza as naturaleza,
      P.NombreCliente as Cliente,
      P.Exentos
    from
      mesa M INNER JOIN detallemesa DM on M.NroMesa = DM.NroMesa
      inner join pedido P on P.IdPedido = DM.IdPedido
      inner join personal PR on P.IdPersonal = PR.IdPersonal
    WHERE M.Estado != 'L' and  P.Estado='P'");

    $stmt->execute();
		return $stmt->fetchAll();
		$stmt->null;
	}



  public function vistaDetallePedidosEnCaja($datosModel){
       $con = new Conexion();
    $stmt = $con->conectar()->prepare("SELECT D.Cantidad as cantidad, SUBSTRING(I.Descripcion,1,25) as descripcion, D.Precio as precio,D.Estado,D.IdDetallePedido,D.IdItems from detallepedido D inner join items I on D.IdItems=I.IdItems where D.IdPedido=:idpedido and D.estado<>'A' and D.estado<>'X'");
    $stmt->bindParam(":idpedido", $datosModel, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll();
    $stmt->null;
  }

  public function UltimoComprobanteTicket1(){ // de la tabla comprobante
       $con = new Conexion();
    $stmt = $con->conectar()->prepare("SELECT  max(NumeroDoc)+1 as NumeroDoc  from comprobante 
                                            where TipoComprobante ='T' or TipoComprobante ='DEV' or TipoComprobante ='CORTE GRAN Z'
                                            or TipoComprobante ='CORTE Z' or TipoComprobante ='CORTE X'");
    $stmt->execute();
    return $stmt->fetch();
    $stmt->null;
  }

  public function UltimoComprobanteOtro(){ //con ticket otro
       $con = new Conexion();
    $stmt = $con->conectar()->prepare("SELECT  max(NumeroDoc)+1 as NumeroDoc  from comprobante 
                                            where TipoComprobante ='O'");
    $stmt->execute();
    return $stmt->fetch();
    $stmt->null;
  }
  
  public function UltimoComprobanteOtro1(){ //con ticket o comprobanteC
       $con = new Conexion();
    $stmt = $con->conectar()->prepare("SELECT  max(NumeroDoc)+1 as NumeroDoc  from comprobantec 
                                            where TipoComprobante ='O'");
    $stmt->execute();
    return $stmt->fetch();
    $stmt->null;
  }

  public function UltimoComprobanteTicket2(){
       $con = new Conexion();
    $stmt = $con->conectar()->prepare("SELECT  max(NumeroDoc)+1 as NumeroDoc from comprobantec 
                                            where TipoComprobante ='T' or TipoComprobante ='DEV' or TipoComprobante ='CORTE GRAN Z' 
                                            or TipoComprobante ='CORTE Z' or TipoComprobante ='CORTE X'");
    $stmt->execute();
    return $stmt->fetch();
    $stmt->null;
  }
  public function UltimoComprobanteFCF(){
       $con = new Conexion();
    $stmt = $con->conectar()->prepare("SELECT  max(NumeroDoc)+1 as NumeroDoc from comprobante where TipoComprobante ='FCF'");
    $stmt->execute();
    return $stmt->fetch();
    $stmt->null;
  }
  public function UltimoComprobanteCFF(){
       $con = new Conexion();
    $stmt = $con->conectar()->prepare("SELECT  max(NumeroDoc)+1 as NumeroDoc from comprobante where TipoComprobante ='CCF'");
    $stmt->execute();
    return $stmt->fetch();
    $stmt->null;
  }
  public function nroMesa($datosModel){
       $con = new Conexion();
    $stmt = $con->conectar()->prepare("SELECT M.NroMesa as NroMesa, M.naturaleza from pedido P INNER JOIN detallemesa DM on P.IdPedido = DM.IdPedido
    INNER JOIN mesa M on DM.NroMesa = M.NroMesa where P.IdPedido =:idpedido");
    $stmt->bindParam(":idpedido", $datosModel, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch();
    $stmt->null;
  }
  public function pedidosPorMesaCaja($mesa){
  	   $con = new Conexion();
    $stmt = $con->conectar()->prepare("SELECT P.IdPedido as IdPedido from mesa M INNER JOIN
  		detallemesa DM on M.NroMesa=DM.NroMesa inner join pedido P on P.IdPedido=DM.IdPedido inner join personal PR on P.IdPersonal=PR.IdPersonal WHERE M.NroMesa = :mesa and (P.Estado = 'P' OR P.Estado = 'A') ");
  	$stmt->bindParam(":mesa", $mesa, PDO::PARAM_STR);
  	$stmt->execute();
  	return $stmt->fetchAll();
  	$stmt->null;
  }
  public function cajeroQueRealizoVenta($datosModel){
     $con = new Conexion();
    $stmt = $con->conectar()->prepare("UPDATE pedido set IdUsuario=:IdUsuario where IdPedido=:idpedido");
  $stmt->bindParam(":IdUsuario", $datosModel["IdUsuario"], PDO::PARAM_STR);
  $stmt->bindParam(":idpedido", $datosModel["idpedido"], PDO::PARAM_STR);
  if($stmt->execute()){
    return "success";
  }
  else{
    return "error";
      }
  $stmt->null;
  }
  //Index para evitar la duplicacion de registros
  public function evitarDuplicacionC(){
       $con = new Conexion();
    $stmt = $con->conectar()->prepare("SELECT max(evitarDuplicacion)+1 as evitarDuplicacion from comprobantec");
    $stmt->execute();
    return $stmt->fetch();
    $stmt->null;
  }
  public function evitarDuplicacion(){
       $con = new Conexion();
    $stmt = $con->conectar()->prepare("SELECT max(evitarDuplicacion)+1 as evitarDuplicacion from comprobante");
    $stmt->execute();
    return $stmt->fetch();
    $stmt->null;
  }


  public function Pedido($IdPedido){
       $con = new Conexion();
    $stmt = $con->conectar()->prepare("SELECT C.*, P.NroComensales, P.consumo 
    FROM comprobante C INNER JOIN pedido P ON C.IdPedido = P.IdPedido WHERE C.IdPedido = :ID");
    $stmt->bindParam(":ID", $IdPedido, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch();
    $stmt->null;
  }
  // para traer mas datos D1
  public function Pedido1($IdPedido){
       $con = new Conexion();
    $stmt = $con->conectar()->prepare("SELECT C.*, P.NroComensales, P.consumo, P.IdPersonal, Pe.Nombres, (Cc.NumeroDoc) AS Nro 
                                          FROM comprobante C INNER JOIN pedido P ON C.IdPedido = P.IdPedido
                                          INNER JOIN personal Pe ON P.IdPersonal = Pe.IdPersonal
                                          INNER JOIN comprobantec Cc ON P.IdPedido = Cc.IdPedido
                                          WHERE C.IdPedido = :ID");
    $stmt->bindParam(":ID", $IdPedido, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch();
    $stmt->null;
  }

  public function getPedido($IdPedido){
       $con = new Conexion();
    $stmt = $con->conectar()->prepare("SELECT * FROM pedido WHERE IdPedido = :ID");
    $stmt->bindParam(":ID", $IdPedido, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch();
    $stmt->null;
  }


  public function ComprobanteC($IdPedido){
       $con = new Conexion();
    $stmt = $con->conectar()->prepare("SELECT * FROM comprobantec WHERE IdPedido = :ID");
    $stmt->bindParam(":ID", $IdPedido, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch();
    $stmt->null;
  }

  public function Comprobante($IdPedido){
       $con = new Conexion();
    $stmt = $con->conectar()->prepare("SELECT * FROM comprobante WHERE IdPedido = :ID");
    $stmt->bindParam(":ID", $IdPedido, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch();
    $stmt->null;
  }

  public function UPregistroCompra($datosModel, $Id){
		   $con = new Conexion();
    $stmt = $con->conectar()->prepare("UPDATE comprobantec SET
          Fecha = :fecha,
          FechaFact = FechaFact,
          Total = :total,
          Propina = :propina,
          Hora = :hora,
          TotalPagar = :totalpagar,
          Importe = :importe,
          NombreCliente = :cliente
         WHERE IdcomprobanteC = :ID");
    
    $fecha = $datosModel['Fecha'];
    $fechafact=$datosModel['FechaFact'];
    $stmt->bindParam(":fecha", $fecha, PDO::PARAM_STR);
    $stmt->bindParam(":fechafact", $fechafact, PDO::PARAM_STR);$stmt->bindParam(":total", $datosModel["total"], PDO::PARAM_STR);
    $stmt->bindParam(":propina", $datosModel["propina"], PDO::PARAM_STR);
    $hora = date("H:i:s");
    $stmt->bindParam(":hora", $hora, PDO::PARAM_STR);
    $stmt->bindParam(":totalpagar", $datosModel["totalpagar"], PDO::PARAM_STR);
    $stmt->bindParam(":importe", $datosModel["importe"], PDO::PARAM_STR);
    $stmt->bindParam(":cliente", $datosModel["cliente"], PDO::PARAM_STR);
    $stmt->bindParam(":ID", $Id, PDO::PARAM_INT);

		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}
		$stmt->null;
  }

  public function UPregistroCompraOriginal($datosModel, $Id){
		   $con = new Conexion();
    $stmt = $con->conectar()->prepare("UPDATE comprobante SET
            Fecha = :fecha,
            FechaFact= :FechaFact,
            Total = :total,
            Propina = :propina,
            Hora = :hora,
            TotalPagar = :totalpagar,
            Importe = :importe,
            NombreCliente = :cliente
        WHERE IdComprobante = :ID");

    //   $fecha = date("Y-m-d");
        $fecha = $datosModel['Fecha'];
        $fechafact=$datosModel['FechaFact'];
        $stmt->bindParam(":fecha", $fecha, PDO::PARAM_STR);
        $stmt->bindParam(":fechafact", $fechafact, PDO::PARAM_STR);
        $stmt->bindParam(":total", $datosModel["total"], PDO::PARAM_STR);
        $stmt->bindParam(":propina", $datosModel["propina"], PDO::PARAM_STR);
        $hora = date("H:i:s");
        $stmt->bindParam(":hora", $hora, PDO::PARAM_STR);
        $stmt->bindParam(":totalpagar", $datosModel["totalpagar"], PDO::PARAM_STR);
        $stmt->bindParam(":importe", $datosModel["importe"], PDO::PARAM_STR);
        $stmt->bindParam(":cliente", $datosModel["cliente"], PDO::PARAM_STR);
        $stmt->bindParam(":ID", $Id, PDO::PARAM_INT);

		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}
		$stmt->null;
	}
	
	
	public function updateCuenta($IdPedido, $estado){
        $fechaC= date('Y-m-d H:i:s');
           $con = new Conexion();
    $stmt = $con->conectar()->prepare("UPDATE cuentasporcobrar SET Estado =:estado, FechaC=:fechaC    where IdPedido = :id");
        $stmt->bindParam(":fechaC", $fechaC, PDO::PARAM_STR);
        $stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
        $stmt->bindParam(":id", $IdPedido, PDO::PARAM_STR);
        if($stmt->execute()){
			return "0";
		}
		else{
			return "1";
		}
		$stmt->null;
  }
//para des-cancelar
  public function updateCuenta2($IdPedido, $estado){
    $fechaC= null;
       $con = new Conexion();
    $stmt = $con->conectar()->prepare("UPDATE cuentasporcobrar SET Estado =:estado, FechaC=:fechaC    where IdPedido = :id");
    $stmt->bindParam(":fechaC", $fechaC, PDO::PARAM_STR);
    $stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
    $stmt->bindParam(":id", $IdPedido, PDO::PARAM_STR);
    if($stmt->execute()){
      return "0";
    }
    else{
      return "1";
    }
      $stmt->null;
    }
  
  // registrar CxC
  public function Resgistrarcuentasporcobrar($datosModel){
       $con = new Conexion();
    $stmt = $con->conectar()->prepare("INSERT INTO cuentasporcobrar (IdPedido, Tipo, IdCliente) 
                                            VALUES (:idpedido, 'C', :idCliente)");
		$stmt->bindParam(":idpedido", $datosModel['idpedido'], PDO::PARAM_INT);
    $stmt->bindParam(":idCliente", $datosModel['idCliente'], PDO::PARAM_INT);
    if($stmt->execute()){
      return "success";
    }
    else{
      return "error";
    }
    $stmt->null;
  }

  //registrar hugo
  public function RegistrarCxcHugo($datosModel){
       $con = new Conexion();
    $stmt = $con->conectar()->prepare("INSERT INTO cuentasporcobrar (IdPedido, Tipo, IdCliente) 
                                            VALUES (:idpedido, 'H', :idCliente)");
    $stmt->bindParam(":idpedido", $datosModel['idpedido'], PDO::PARAM_INT);
    $stmt->bindParam(":idCliente", $datosModel['idCliente'], PDO::PARAM_INT);
    if($stmt->execute()){
      return "success";
    }
    else{
      return "error";
    }
    $stmt->null;
  }




  public function registrarCortesias($Dts){
		   $con = new Conexion();
    $stmt = $con->conectar()->prepare("INSERT INTO cortesias (IdCortesias, IdPedido, Total, NombreCliente) 
      VALUES (NULL, :idPedido, :TotalPagar, :NombreCliente)");
		$stmt->bindParam(":idPedido", $Dts["idPedido"], PDO::PARAM_STR);
		$stmt->bindParam(":TotalPagar", $Dts["TotalPagar"], PDO::PARAM_STR);
    $stmt->bindParam(":NombreCliente", $Dts["Cliente"], PDO::PARAM_STR);
    
		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}
		$stmt->null;
	}

  public function verCliente($id){ // para ver los datos del cliente
    $con = new Conexion();
    $stmt = $con->conectar()->prepare("SELECT * FROM clientenrc WHERE NRC = :ID");
    $stmt->bindParam(":ID", $id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch();
    $stmt->null;
  }

}
