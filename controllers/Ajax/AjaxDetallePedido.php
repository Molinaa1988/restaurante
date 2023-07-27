<?php
  require_once "../../models/modelRealizarVenta.php";
  $respuesta = modelRealizarVenta::vistaDetallePedidosEnCaja($_POST["idPedidoA"]);
  
  
  $Tbody = array();
  foreach($respuesta as $row => $item){
    // $total = $item["cantidad"] *  $item["precio"];
    // $Tbody .= '<tr class="odd gradeX">
    //   <td>'.$item["cantidad"].'</td>
    //   <td>'.$item["descripcion"].'</td>
    //   <td>'.$item["precio"].'</td>
    //   <td>'.number_format($total, 2, '.', '').'</td>
    // </tr>';

    $Tbody[$row] = array(
      'cantidad' => $item["cantidad"],
      'descripcion' => utf8_encode($item["descripcion"]),
      'precio' => $item["precio"],
      'total' => ROUND($item["cantidad"] * $item["precio"],2),
      'IdItem' => $item['IdItems']
    );
    // $Tbody['cantidad'] = $item["cantidad"];
    // $Tbody['descripcion'] = utf8_encode($item["descripcion"]);
    // $Tbody['cantidad'] = $item["cantidad"];

  }

  $R = modelRealizarVenta::ComprobanteC($_POST["idPedidoA"]);
  if ($R) {
    $Json['Existe'] = $R;
  }else{
    $R = modelRealizarVenta::Comprobante($_POST["idPedidoA"]);
    if ($R) {
      $Json['Existe'] = $R;
    }else{
      $Json['Existe'] = 'No';
    }
  }

  $pedido = modelRealizarVenta::getPedido($_POST["idPedidoA"]);

  $Json['DetallePedido'] = $Tbody;
  $Json['Totales'] = array(
    "Propina" => $pedido['Propina'],
    "Exentos" => $pedido['Exentos'],
    "Retencion" => $pedido['Retencion'],
    "Subtotal" => $pedido['Total'] 
  );
  echo json_encode($Json);
?>
