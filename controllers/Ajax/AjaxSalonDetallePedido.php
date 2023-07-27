<?php

date_default_timezone_set('America/El_Salvador');

  require_once "../../models/modelSalon.php";
  require_once "../../models/modelConfiguraciones.php";
  require_once "../../models/modelRealizarVenta.php";
  require_once "../../models/modelCocina.php";

  function truncateFloat($number, $digitos)
 {
     $raiz = 10;
     $multiplicador = pow ($raiz,$digitos);
     $resultado = ((int)($number * $multiplicador)) / $multiplicador;
     return number_format($resultado, $digitos);
 }

  // REGISTRAR DETALLE PEDIDO COCINA
if(isset($_POST["idItemA"])){
  $datosController = array("IdItems"=>$_POST["idItemA"],
                           "IdPedido"=>$_POST["idPedidoDP"],
													 "Precio"=>$_POST["PrecioA"],
                           "Cantidad" => $_POST["CantidadA"]);
  $respuesta = modelSalon::registrarDetallePedidoCocina($datosController);
  return $respuesta;
}
// REGISTRAR DETALLE PEDIDO BAR
if(isset($_POST["idItemB"])){
$datosController = array("IdItems"=>$_POST["idItemB"],
                         "IdPedido"=>$_POST["idPedidoDP"],
                         "Precio"=>$_POST["PrecioA"],
                         "Cantidad" => $_POST["CantidadA"]);
$respuesta = modelSalon::registrarDetallePedidoBar($datosController);
return $respuesta;
}

//PARA ELIMINAR Y ANULAR
if(isset($_POST["IdDetallePedidoAJAX"])){
  $datosController = array("IdDetallePedido"=>$_POST["IdDetallePedidoAJAX"],
													 "Estado"=>$_POST["EstadoAJAX"]);
    if($_POST["EstadoAJAX"] == "M" || $_POST["EstadoAJAX"] == "B"){
      $respuesta = modelSalon::borrarDetallePedido($datosController);
      return $respuesta;
    }
    elseif($_POST["EstadoAJAX"] == "S" || $_POST["EstadoAJAX"] == "P" || $_POST["EstadoAJAX"] == "Q"){
      $respuesta = modelSalon::actualizarDetallePedido($datosController);
      return $respuesta;
    }
}
//PARA AGREGAR
if(isset($_POST["IdDetallePedidoAumentar"])){
  $datosController = array("IdDetallePedido"=>$_POST["IdDetallePedidoAumentar"],
                           "cantidad"=>$_POST["cantidadAumentar"],
                           "precio"=>$_POST["precioAumentar"]);

   $datosPedido = modelSalon::seleccionarDetallePedido($datosController);
   $precioPedido = $datosPedido['Precio'];
   $precioActualizar =   $precioPedido + $_POST["precioAumentar"];
   $cantidadActualizar = $_POST["cantidadAumentar"] + 1;

   $datosActualizar = array("IdDetallePedido"=>$_POST["IdDetallePedidoAumentar"],
                            "cantidad"=>$cantidadActualizar,
                            "precio"=>$precioActualizar);
      $respuesta = modelSalon::aumentarDetallePedido($datosActualizar);
      return $respuesta;
}
//PARA DISMINUIR
if(isset($_POST["IdDetallePedidoDisminuir"])){
  $datosController = array("IdDetallePedido"=>$_POST["IdDetallePedidoDisminuir"],
                          "cantidad"=>$_POST["cantidadDisminuir"],
                           "precio"=>$_POST["precioDisminuir"]);

   $datosPedido = modelSalon::seleccionarDetallePedido($datosController);
   $precioPedido = $datosPedido['Precio'];
   $precioActualizar =   $precioPedido - $_POST["precioDisminuir"];
   $cantidadActualizar = $_POST["cantidadDisminuir"] - 1;

   $datosActualizar = array("IdDetallePedido"=>$_POST["IdDetallePedidoDisminuir"],
                            "cantidad"=>$cantidadActualizar,
                            "precio"=>$precioActualizar);
      $respuesta = modelSalon::aumentarDetallePedido($datosActualizar);
      return $respuesta;
}
//PARA ELIMINAR PEDIDO
if(isset($_POST["idPedidoEliminar"])){
      modelSalon::eliminarDetalleMesa($_POST["idPedidoEliminar"]);
      modelSalon::eliminarDetallePedido($_POST["idPedidoEliminar"]);
      modelSalon::eliminarPedido($_POST["idPedidoEliminar"]);
      $datosController = array("NroMesa"=>$_POST["MesaActualizar"],
                              "Estado"=>"L");
      if($_POST["eliminarCantidadCuentas"] == 1){
      modelSalon::cambioEstadoMesa($datosController);
                              }
}
//PARA ENVIAR PEDIDO
if(isset($_POST["idPedidoEnviar"])){
  $respuesta = modelSalon::idDetallePedido($_POST["idPedidoEnviar"]);
       foreach($respuesta as $row => $item){
         if($item['Estado']=='M')
         {
           modelSalon::enviarPedidoCocina($_POST["idPedidoEnviar"]);
         }
       }
     }

// Crear nueva cuenta
if(isset($_POST["idPersonalNuevaCuenta"])){
$datosController = array("IdPedido"=>$_POST["idPersonalNuevaCuenta"],
                         "NroMesa"=>$_POST["nroMesaNuevaCuenta"]);
                         modelSalon::crearPedido($_POST["idPersonalNuevaCuenta"]);
                         $ultimoPedido = modelSalon::ultimoIdPedido();
                   			 $respuesta = modelSalon::crearDetalleMesa($_POST["nroMesaNuevaCuenta"],$ultimoPedido['idPedido']);
}

?>
