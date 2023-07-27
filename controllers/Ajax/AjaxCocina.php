<?php
  date_default_timezone_set('America/El_Salvador');
  require_once "../../models/modelCocina.php";
  require_once "../../models/modelSalon.php";

// REGISTRAR DETALLE PEDIDO COCINA
if(isset($_POST["idPedidoCocina"])){
$respuesta = modelCocina::DetallePedidoPorIdPedido($_POST["idPedidoCocina"]);
   foreach($respuesta as $row => $item){
     if($item['Estado'] == 'S')
     {
       modelCocina::cambiarEstadoDetalle($item['IdDetallePedido']);
     }
   }
 }

 // REGISTRAR ELIMINAR PEDIDO DE COCINA
 if(isset($_POST["idPedidoEliminar"])){
 $respuesta = modelCocina::DetallePedidoPorIdPedido($_POST["idPedidoEliminar"]);
    foreach($respuesta as $row => $item){
      if($item['Estado'] == 'P'  OR $item['Estado'] == 'Q' )
      {
        modelCocina::cambiarEstadoDetalleEliminar($item['IdDetallePedido']);
      }
      elseif($item['Estado'] == 'A')
      {
        modelCocina::cambiarEstadoDetalleEliminarAnulado($item['IdDetallePedido']);
      }
    }
  }

  if(isset($_POST['AccionAjax'])){
    $Accion = $_POST['AccionAjax'];
    if ($Accion === 'Cargar') {
      $Json = array();
      $Pedidos = modelCocina::idPedidos();
      foreach ($Pedidos as $key => $Pedido) {
        $Mesa = modelCocina::nroMesa($Pedido['IdPedido']);
        $Tiempo = modelCocina::minDemora($Pedido['IdPedido']);
        $Meseros = modelCocina::mesero($Pedido['IdPedido']);
        $DetallePedidos = modelCocina::DetallePedido($Pedido['IdPedido']);
        $Naturaleza = modelSalon::verificarEstadoMesa($Mesa['NroMesa']);

        $Now = new DateTime(date('Y-m-d H:i:s'));
        
        $CantS = 0;
        $CantN = 0;
        $Old = new DateTime($Tiempo[0]);
        $Cronometro = $Old->diff($Now);
        
        foreach ($DetallePedidos as $key1 => $Detalle) {
           $DetallePedidos[$key1]['Plato'] = utf8_encode($Detalle['Plato']);
           $DetallePedidos[$key1][1] = utf8_encode($Detalle[1]);
        //   $DetallePedidos[$key1]['Plato'] = $Detalle['Plato'];
          
        //   $DetallePedidos[$key1][1] = $Detalle[1];
          
          $OldD = new DateTime($Detalle[5]);
          $CronometroD = $OldD->diff($Now);

          if ($CronometroD->i < 2 && $Detalle[5] != null) {
            $CantN++;
          }else{
            modelSalon::UpnewAdd($Detalle['idDetalle'], null);
          }
          
          if ($Detalle['Estado'] == 'S') {
            $CantS++;
            modelCocina::cambiarEstadoDetalle($Detalle['idDetalle']);
          }
        }

        
        $ResCro = str_pad($Cronometro->h, 2, "0", STR_PAD_LEFT).":".str_pad($Cronometro->i, 2, "0", STR_PAD_LEFT).":".str_pad($Cronometro->s, 2, "0", STR_PAD_LEFT);
        $label = 'label-info';
        $panel = 'box-primary';
        $war = 0;
        if ($Cronometro->i >= 9 || $Cronometro->h > 0) {
          $label = 'label-danger';
          $panel = 'box-danger';
          $war = 1;
        }
        if ($CantN > 0) {
          $label = 'label-success';
          $panel = 'box-success';
          $war = 0;
        }
        
        $Nat = "Salon";
        if ( $Naturaleza['naturaleza'] === 'L') {
          $Nat = "Llevar";
        }
        $Json[$key] = array(
          "IdPedido" => $Pedido['IdPedido'],
          "Mesa" => "# ".$Naturaleza['Etiqueta'],
          "Mesero" => $Meseros['Nombre'],
          "DetallePedido" => $DetallePedidos,
          "Tiempo" => $ResCro,
          "Label" => $label,
          "Panel" => $panel,
          "war" => $war,
          "CantS" => $CantS,
          "Naturaleza" => $Nat
        );
      }

      echo json_encode($Json);
    }
  }

?>
