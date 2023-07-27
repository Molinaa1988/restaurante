<?php

require_once "conexion.php";

class modelConfiguraciones{
  public function configuracionesImpresora(){
    $stmt = Conexion::conectar()->prepare("SELECT ImpresoraTicket FROM configuraciones WHERE idConfiguraciones = 1");
    $stmt->execute();
    return $stmt->fetch();
    $stmt->null;
  }
  public function configuracionesCorreo(){
    $stmt = Conexion::conectar()->prepare("SELECT EmailEmisor, Contrasena, EmailReceptor  FROM configuraciones WHERE idConfiguraciones = 1");
    $stmt->execute();
    return $stmt->fetch();
    $stmt->null;
  }


  public function actualizarConfiguracionImpresora($datosModel){
  $stmt = Conexion::conectar()->prepare("UPDATE configuraciones SET ImpresoraTicket = :ImpresoraTicket WHERE idConfiguraciones = 1");
  $stmt->bindParam(":ImpresoraTicket", $datosModel["ImpresoraTicket"], PDO::PARAM_STR);

  if($stmt->execute()){
    return "success";
  }
  else{
    return "error";
  }
  $stmt->null;
}


public function actualizacionConfiguracionCorreo($datosModel){
$stmt = Conexion::conectar()->prepare("UPDATE configuraciones SET EmailReceptor = :EmailReceptor, EmailEmisor = :EmailEmisor, Contrasena = :Contrasena WHERE idConfiguraciones = 1");
$stmt->bindParam(":EmailReceptor", $datosModel["EmailReceptor"], PDO::PARAM_STR);
$stmt->bindParam(":EmailEmisor", $datosModel["EmailEmisor"], PDO::PARAM_STR);
$stmt->bindParam(":Contrasena", $datosModel["Contrasena"], PDO::PARAM_STR);

if($stmt->execute()){
  return "success";
}
else{
  return "error";
}
$stmt->null;
}


public function vistaZona(){
  // $stmt = Conexion::conectar()->prepare("SELECT * FROM zonas WHERE idzona = '5'");
  $stmt = Conexion::conectar()->prepare("SELECT * FROM zonas");
  $stmt->execute();
  return $stmt->fetchAll();
  $stmt->null;
}

public function registrarZona($datosModel){
  $stmt = Conexion::conectar()->prepare("INSERT INTO zonas (zona) VALUES (:zonaR)");
  $stmt->bindParam(":zonaR", $datosModel["zonaR"], PDO::PARAM_STR);

  if($stmt->execute()){
    return "success";
  }
  else{
    return "error";
  }
  $stmt->null;
}

public function ActualizarZona($datosModel){
$stmt = Conexion::conectar()->prepare("UPDATE zonas SET zona = :ZonaA WHERE idzona = :idZonaA");
$stmt->bindParam(":ZonaA", $datosModel["ZonaA"], PDO::PARAM_STR);
$stmt->bindParam(":idZonaA", $datosModel["idZonaA"], PDO::PARAM_STR);

if($stmt->execute()){
  return "success";
}
else{
  return "error";
}
$stmt->null;
}

public function EliminarZona($datosModel){
$stmt = Conexion::conectar()->prepare("DELETE FROM zonas WHERE idzona = :idZonaE");
$stmt->bindParam(":idZonaE", $datosModel, PDO::PARAM_INT);
if($stmt->execute()){
  return "success";
}
else{
  return "error";
}
$stmt->null;
}

public function vistaMesas1(){
  $stmt = Conexion::conectar()->prepare("SELECT NroMesa, idzona, naturaleza, Estado, Etiqueta FROM mesa where NroMesa BETWEEN 1 AND 20");
  $stmt->execute();
  return $stmt->fetchAll();
  $stmt->null;
}
public function vistaMesas2(){
  $stmt = Conexion::conectar()->prepare("SELECT NroMesa, idzona, naturaleza, Estado, Etiqueta FROM mesa where NroMesa BETWEEN 21 AND 40");
  $stmt->execute();
  return $stmt->fetchAll();
  $stmt->null;
}
public function vistaMesas3(){
  $stmt = Conexion::conectar()->prepare("SELECT NroMesa, idzona, naturaleza, Estado, Etiqueta FROM mesa where NroMesa BETWEEN 41 AND 60");
  $stmt->execute();
  return $stmt->fetchAll();
  $stmt->null;
}
public function ultimaMesa(){
  $stmt = Conexion::conectar()->prepare("SELECT max(NroMesa) + 1 as ultimo FROM mesa");
  $stmt->execute();
  return $stmt->fetch();
  $stmt->null;
}
public function nombreZona($idzona){
  $stmt = Conexion::conectar()->prepare("SELECT zona FROM zonas where idzona = :idzona");
    $stmt->bindParam(":idzona", $idzona, PDO::PARAM_STR);
  $stmt->execute();
  return $stmt->fetch();
  $stmt->null;
}

public function registrarMesa($datosModel){
  $stmt = Conexion::conectar()->prepare("INSERT INTO mesa (NroMesa, Estado, idzona, naturaleza) VALUES (:NroMesa, 'L', :idzona, :naturaleza)");
  $stmt->bindParam(":NroMesa", $datosModel["NroMesa"], PDO::PARAM_STR);
  $stmt->bindParam(":idzona", $datosModel["idzona"], PDO::PARAM_STR);
  $stmt->bindParam(":naturaleza", $datosModel["naturaleza"], PDO::PARAM_STR);

  if($stmt->execute()){
    return "success";
  }
  else{
    return "error";
  }
  $stmt->null;
}

public function ActualizarMesa($datosModel){
$stmt = Conexion::conectar()->prepare("UPDATE mesa SET  idzona = :idzona, naturaleza = :naturaleza, Etiqueta = :Etiqueta WHERE NroMesa = :NroMesa");
$stmt->bindParam(":NroMesa", $datosModel["NroMesa"], PDO::PARAM_STR);
$stmt->bindParam(":idzona", $datosModel["idzona"], PDO::PARAM_STR);
$stmt->bindParam(":naturaleza", $datosModel["naturaleza"], PDO::PARAM_STR);
$stmt->bindParam(":Etiqueta", $datosModel["Etiqueta"], PDO::PARAM_STR);
if($stmt->execute()){
  return "success";
}
else{
  return "error";
}
$stmt->null;
}

public function EliminarMesa($datosModel){
$stmt = Conexion::conectar()->prepare("DELETE FROM mesa WHERE NroMesa = :NroMesa");
$stmt->bindParam(":NroMesa", $datosModel, PDO::PARAM_INT);
if($stmt->execute()){
  return "success";
}
else{
  return "error";
}
$stmt->null;
}
public function configuracionesEliminarBebida(){
  $stmt = Conexion::conectar()->prepare("SELECT bebidaEliminar FROM configuraciones");
  $stmt->execute();
  return $stmt->fetchAll();
  $stmt->null;
}
public function actualizarEliminarBebida($datosModel){
$stmt = Conexion::conectar()->prepare("UPDATE configuraciones SET bebidaEliminar = :estado");
$stmt->bindParam(":estado", $datosModel, PDO::PARAM_STR);
if($stmt->execute()){
  return "success";
}
else{
  return "error";
}
$stmt->null;
}
public function PermitirEliminarBebida(){
  $stmt = Conexion::conectar()->prepare("SELECT bebidaEliminar FROM configuraciones");
  $stmt->execute();
  return $stmt->fetch();
  $stmt->null;
}
public function informacionTicket(){
  $stmt = Conexion::conectar()->prepare("SELECT * FROM configuracionesticket");
  $stmt->execute();
  return $stmt->fetch();
  $stmt->null;
}
public function actualizarInformacionTicket($datosModel){
$stmt = Conexion::conectar()->prepare("UPDATE configuracionesticket SET Restaurante = :Restaurante, Contribuyente = :Contribuyente, NroDeRegistro = :NroDeRegistro, NIT = :NIT, Giro = :Giro, Direccion = :Direccion, Resolucion = :Resolucion, Mensaje = :Mensaje, Mensaje2 = :Mensaje2");
$stmt->bindParam(":Restaurante", $datosModel['Restaurante'], PDO::PARAM_STR);
$stmt->bindParam(":Contribuyente", $datosModel['Contribuyente'], PDO::PARAM_STR);
$stmt->bindParam(":NroDeRegistro", $datosModel['NroDeRegistro'], PDO::PARAM_STR);
$stmt->bindParam(":NIT", $datosModel['NIT'], PDO::PARAM_STR);
$stmt->bindParam(":Giro", $datosModel['Giro'], PDO::PARAM_STR);
$stmt->bindParam(":Direccion", $datosModel['Direccion'], PDO::PARAM_STR);
$stmt->bindParam(":Resolucion", $datosModel['Resolucion'], PDO::PARAM_STR);
$stmt->bindParam(":Mensaje", $datosModel['Mensaje'], PDO::PARAM_STR);
$stmt->bindParam(":Mensaje2", $datosModel['Mensaje2'], PDO::PARAM_STR);
if($stmt->execute()){
  return "success";
}
else{
  return "error";
}
$stmt->null;
}

public function subirLogo($datos){
  $stmt = Conexion::conectar()->prepare("UPDATE configuracionesticket SET logo = :logo");
  $stmt -> bindParam(":logo", $datos, PDO::PARAM_STR);
  if($stmt->execute()){
    return "success";
  }
  else{
    return "error";
  }
  $stmt->null;
  }

  public function eliminarPedidoDetalleMesa($datosModel){
  $stmt = Conexion::conectar()->prepare("DELETE FROM detallemesa WHERE IdPedido = :IdPedido");
  $stmt->bindParam(":IdPedido", $datosModel, PDO::PARAM_INT);
  if($stmt->execute()){
    return "success";
  }
  else{
    return "error";
  }
  $stmt->null;
  }
  public function eliminarPedidoDetallePedido($datosModel){
  $stmt = Conexion::conectar()->prepare("DELETE FROM detallepedido WHERE IdPedido = :IdPedido");
  $stmt->bindParam(":IdPedido", $datosModel, PDO::PARAM_INT);
  if($stmt->execute()){
    return "success";
  }
  else{
    return "error";
  }
  $stmt->null;
  }
  public function eliminarPedidoComprobante($datosModel){
  $stmt = Conexion::conectar()->prepare("DELETE FROM comprobante WHERE IdPedido = :IdPedido");
  $stmt->bindParam(":IdPedido", $datosModel, PDO::PARAM_INT);
  if($stmt->execute()){
    return "success";
  }
  else{
    return "error";
  }
  $stmt->null;
  }
  public function eliminarPedidoComprobanteC($datosModel){
  $stmt = Conexion::conectar()->prepare("DELETE FROM comprobantec WHERE IdPedido = :IdPedido");
  $stmt->bindParam(":IdPedido", $datosModel, PDO::PARAM_INT);
  if($stmt->execute()){
    return "success";
  }
  else{
    return "error";
  }
  $stmt->null;
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
  $stmt->null;
  }




}
