<?php
  date_default_timezone_set('America/El_Salvador');
  require_once "../../models/modelComprobantes.php";
  require_once "../../models/modelConfiguraciones.php";
  require_once "../../models/modelRealizarVenta.php";
  require_once "../../models/modelReportes.php";

  // require __DIR__ . '../../../views/autoload.php';
  // use Mike42\Escpos\Printer;
  // use Mike42\Escpos\EscposImage;
  // use Mike42\Escpos\PrintConnectors\FilePrintConnector;
  // use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

  function truncateFloat($number, $digitos)
 {
     $raiz = 10;
     $multiplicador = pow ($raiz,$digitos);
     $resultado = ((int)($number * $multiplicador)) / $multiplicador;
     return number_format($resultado, $digitos);
 }

//Para eliminar comprobantes
// $numeroDoc2 = $_POST["NumeroDocAjax"];
  $nroComprobante = $_POST["NumeroDocAjax"];
  if(isset($_POST["IdcomprobanteAJAX"])){
  $datosController = array("IdcomprobanteC"=>$_POST["IdcomprobanteAJAX"]);
  $respuestaa = modelComprobantes::rangoNroComprobante($_POST["NumeroDocAjax"]);
   foreach($respuestaa as $row => $item){
     $datosControllerr = array("id"=>$item["IdcomprobanteC"],
                               "NumeroDoc"=>$nroComprobante);
     modelComprobantes::actualizarNroComprobante($datosControllerr);
    $nroComprobante = $nroComprobante + 1;
  }
    modelComprobantes::eliminarComprobanteC($datosController);
}

//Para Anular
if(isset($_POST["AnularIdcomprobanteAJAX"])){
  $datosController = array("IdcomprobanteC"=>$_POST["AnularIdcomprobanteAJAX"]);

  if ($_POST["TblAjax"] == "IDCC") {
    modelComprobantes::eliminarComprobanteC($datosController);
  }else{
    modelComprobantes::eliminarComprobante($datosController);
  }

  $respuesta =  modelComprobantes::nroMesa($_POST["AnularNumeroDocAjax"]);
  modelComprobantes::actualizarMesa($respuesta["NroMesa"]);
  modelComprobantes::actualizarPedido($_POST["AnularNumeroDocAjax"]);
}
//
// //PARA IMPRIMIR COMPROBANTE
// if(isset($_POST["idPedidoPC"])){
//   $datosController = array("IdPedido"=>$_POST["idPedidoPC"],
//                            "Total"=>$_POST["SubTotalPC"],
//                            "Propina"=>$_POST["PropinaPC"],
//                            "TotalPagar"=>$_POST["TotalPagarPC"]);
//       $respuestaImpresora = modelConfiguraciones::configuracionesImpresora();
//       $ImpresoraTicket = $respuestaImpresora["ImpresoraTicket"];
//       $connector = new WindowsPrintConnector($ImpresoraTicket);
//         // $connector = new WindowsPrintConnector("EPSON20");
//        $printer = new Printer($connector);
//        $printer -> initialize();
//        $justification = array(
//            Printer::JUSTIFY_LEFT,
//            Printer::JUSTIFY_CENTER,
//            Printer::JUSTIFY_RIGHT);
//        $idPedido = $_POST["idPedidoPC"];
//        $fecha = $_POST["fechaPC"];
//        $hora = $_POST["horaPC"];
//        // $mesa = $_POST["mesaPC"];
//        // $mesero = $_POST["meseroPC"];
//
//        $propina = truncateFloat($_POST["PropinaPC"], 2);
//        $subTotal = truncateFloat($_POST["SubTotalPC"], 2);
//        $total = truncateFloat($_POST["TotalPagarPC"], 2);
//        $respuestaTicket= modelConfiguraciones::informacionTicket();
//        $Restaurante = $respuestaTicket["Restaurante"];
//  if($ImpresoraTicket == "EPSON20")
//  {
//          $printer -> setJustification($justification[1]);
//          $printer -> text("$Restaurante\n");
//          $printer -> text("PRE-CUENTA\n");
//          $printer -> setJustification();
//          // $printer -> text("ATENDIO: $mesero                NRO MESA: $mesa\n");
//          $printer -> text("FECHA: $fecha                     HORA:$hora\n");
//          $printer -> text("================================================\n");
//          $printer -> text("CANT|  DESCRIPCION             | P.U  |  TOTAL  \n");
//          $printer -> text("================================================\n");
//          $vistaDetallePedidosEnCaja = modelRealizarVenta::vistaDetallePedidosEnCaja($idPedido);
//          foreach($vistaDetallePedidosEnCaja as $row => $itemPedido){
//            $descripcion = $itemPedido["descripcion"];
//            $cantidad = $itemPedido["cantidad"];
//            $precio = $itemPedido["precio"];
//            $itemTotal = $itemPedido["precio"]*$itemPedido["cantidad"];
//            $espacio = "    ";
//                 if(strlen($descripcion) == 1){$espacio = "                          ";}
//            else if(strlen($descripcion) == 2){$espacio = "                         ";}
//            else if(strlen($descripcion) == 3){$espacio = "                        ";}
//            else if(strlen($descripcion) == 4){$espacio = "                       ";}
//            else if(strlen($descripcion) == 5){$espacio = "                      ";}
//            else if(strlen($descripcion) == 6){$espacio = "                     ";}
//            else if(strlen($descripcion) == 7){$espacio = "                    ";}
//            else if(strlen($descripcion) == 8){$espacio = "                   ";}
//            else if(strlen($descripcion) == 9){$espacio = "                  ";}
//            else if(strlen($descripcion) == 10){$espacio = "                 ";}
//            else if(strlen($descripcion) == 11){$espacio = "                ";}
//            else if(strlen($descripcion) == 12){$espacio = "               ";}
//            else if(strlen($descripcion) == 13){$espacio = "              ";}
//            else if(strlen($descripcion) == 14){$espacio = "             ";}
//            else if(strlen($descripcion) == 15){$espacio = "            ";}
//            else if(strlen($descripcion) == 16){$espacio = "           ";}
//            else if(strlen($descripcion) == 17){$espacio = "          ";}
//            else if(strlen($descripcion) == 18){$espacio = "         ";}
//            else if(strlen($descripcion) == 19){$espacio = "        ";}
//            else if(strlen($descripcion) == 20){$espacio = "       ";}
//            else if(strlen($descripcion) == 21){$espacio = "      ";}
//            else if(strlen($descripcion) == 22){$espacio = "     ";}
//
//          $printer -> text("$cantidad   $descripcion$espacio$precio  $itemTotal G\n");
//          }
//          $printer -> text("================================================\n");
//          $printer -> text("SUB-TOTAL................$               $subTotal\n");
//          $printer -> text("PROPINA..................$               $propina\n");
//          $printer -> text("TOTAL A PAGAR............$               $total\n");
//          $printer -> setJustification($justification[1]);
//          $printer -> setJustification();
//          $printer -> cut();
//          $printer -> close();
//          }
//          else if ($ImpresoraTicket == "EPSONTM")
//          {
//            $printer -> setJustification($justification[1]);
//            $printer -> text("$Restaurante\n");
//            $printer -> text("PRE-CUENTA\n");
//            $printer -> setJustification();
//            // $printer -> text("ATENDIO: $mesero          NRO MESA: $mesa\n");
//            $printer -> text("FECHA: $fecha               HORA:$hora\n");
//            $printer -> text("==========================================\n");
//            $printer -> text("CANT|  DESCRIPCION         | P.U  |  TOTAL  \n");
//            $printer -> text("==========================================\n");
//            $vistaDetallePedidosEnCaja = modelRealizarVenta::vistaDetallePedidosEnCaja($idPedido);
//            foreach($vistaDetallePedidosEnCaja as $row => $itemPedido){
//              $descripcion = $itemPedido["descripcion"];
//              $cantidad = $itemPedido["cantidad"];
//              $precio = $itemPedido["precio"];
//              $itemTotal = $itemPedido["precio"]*$itemPedido["cantidad"];
//              $espacio = "    ";
//              if(strlen($descripcion) == 1){$espacio = "                      ";}
//         else if(strlen($descripcion) == 2){$espacio = "                     ";}
//         else if(strlen($descripcion) == 3){$espacio = "                    ";}
//         else if(strlen($descripcion) == 4){$espacio = "                   ";}
//         else if(strlen($descripcion) == 5){$espacio = "                  ";}
//         else if(strlen($descripcion) == 6){$espacio = "                 ";}
//         else if(strlen($descripcion) == 7){$espacio = "                ";}
//         else if(strlen($descripcion) == 8){$espacio = "               ";}
//         else if(strlen($descripcion) == 9){$espacio = "              ";}
//         else if(strlen($descripcion) == 10){$espacio = "             ";}
//         else if(strlen($descripcion) == 11){$espacio = "            ";}
//         else if(strlen($descripcion) == 12){$espacio = "           ";}
//         else if(strlen($descripcion) == 13){$espacio = "          ";}
//         else if(strlen($descripcion) == 14){$espacio = "         ";}
//         else if(strlen($descripcion) == 15){$espacio = "        ";}
//         else if(strlen($descripcion) == 16){$espacio = "       ";}
//         else if(strlen($descripcion) == 17){$espacio = "      ";}
//         else if(strlen($descripcion) == 18){$espacio = "     ";}
//         else if(strlen($descripcion) == 19){$espacio = "    ";}
//         else if(strlen($descripcion) == 20){$espacio = "   ";}
//         else if(strlen($descripcion) == 21){$espacio = "  ";}
//         else if(strlen($descripcion) == 22){$espacio = " ";}
//
//            $printer -> text("$cantidad   $descripcion$espacio$precio  $itemTotal G\n");
//            }
//            $printer -> text("==========================================\n");
//            $printer -> text("SUB-TOTAL................$         $subTotal\n");
//            $printer -> text("PROPINA..................$         $propina\n");
//            $printer -> text("TOTAL A PAGAR............$         $total\n");
//            $printer -> setJustification($justification[1]);
//            $printer -> setJustification();
//            $printer -> cut();
//            $printer -> close();
//          }
// }


    if(isset($_POST["AccionAjax"])){
        $Accion = $_POST["AccionAjax"];
        if($Accion == "EditCorrelativo"){
            $ID = $_POST["IdComprobanteAjax"];
            $Corre = $_POST["CorreAjax"];

           $R = modelReportes::EditCorrelativo($Corre, $ID);
           echo $R;

        }
    }


?>
