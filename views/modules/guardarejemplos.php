<?php
require_once "../../views/src/fpdf/fpdf.php";
require_once "../../models/modelSalon.php";
require_once "../../models/modelConfiguraciones.php";
require_once "../../models/modelRealizarVenta.php";


//IMPRIMIR COMANDA DE BAR =======================================================================================||
if(isset($_GET["IdPedidoBar"])){

  $fecha = date("Y-m-d");
  $hora = date("H:i");
  $mesero = $_GET["mesero"];
  $mesa = $_GET["NroMesa"];

   $pdf = new FPDF();
   $pdf->AddPage();
   $pdf->SetFont('arial','',10);
   $pdf->SetXY(3,5);
   $pdf->Cell(40,10,'Mesero: '.$mesero,0,0,'L');
   $pdf->SetXY(54,5);
   $pdf->Cell(40,10,'Mesa: '.$mesa,0,0,'L');
   $pdf->SetXY(3,10);
   $pdf->Cell(40,10,'Fecha: '.$fecha,0,0,'L');
   $pdf->SetXY(54,10);
   $pdf->Cell(40,10,'Hora: '.$hora,0,0,'L');
   $pdf->SetXY(3,15);
   $pdf->Cell(40,10,"===================================",0,0,'L');
   $pdf->SetXY(3,20);
   $pdf->Cell(40,10,"|           BEBIDA                                     | CANT",0,0,'L');
   $pdf->SetXY(3,25);
   $pdf->Cell(40,10,"===================================",0,0,'L');
   $pdf->SetXY(3,30);
   $y = 35;
   $respuesta = modelSalon::idDetallePedido($_GET["IdPedidoBar"]);
        foreach($respuesta as $row => $itemPedido){
         if ($itemPedido['Estado']=='B')
           {

             $cantidad = $itemPedido["Cantidad"];
             $DescripcionTicke = modelSalon::descripcionItem($itemPedido['IdItems']);
             $descripcion = $DescripcionTicke["Descripcion"];
             $pdf->Cell(65,10,substr($descripcion, 0, 31),0,0);
             // $pdf->Cell(0,10,'123456789123456789123456789123',0,0,'L');
             $pdf->Cell(0,10,$cantidad,0,0,'L');
             $pdf->SetXY(3,$y);
             $y = 5 + $y;
           }
        }

   $pdf->Output();

   // Si en las configuraciones esta registrado que puede eliminar bebida se registrara el estado de la bebida con la letra Q si con la letra D
   $respuestaPermitirEliminarBebida = modelConfiguraciones::PermitirEliminarBebida();
   $Permitir = $respuestaPermitirEliminarBebida["bebidaEliminar"];
   if($Permitir == 'N')
   {
     modelSalon::enviarPedidoBarNoPermitirBorrar($_GET["IdPedidoBar"]);
   }
   else {
     modelSalon::enviarPedidoBarPermitirBorrar($_GET["IdPedidoBar"]);
   }
}


//PARA PRE-CUENTA =======================================================================================||
if(isset($_GET["idPedidoPC"])){
  $datosController = array("IdPedido"=>$_GET["idPedidoPC"],
                           "Total"=>$_GET["SubTotalPC"],
                           "Propina"=>$_GET["PropinaPC"],
                           "TotalPagar"=>$_GET["TotalPagarPC"]);
      modelSalon::preCuenta($datosController);
      $datosControllerMesa = array("NroMesa"=>$_GET["mesaPC"],
                               "Estado"=>"P");
      if($_GET["cantidadCuentasPC"] == 1){
      modelSalon::cambioEstadoMesa($datosControllerMesa);
      }
      $idPedido = $_GET["idPedidoPC"];
      $fecha = date("Y-m-d");
      $hora = date("H:i");
      $mesa = $_GET["mesaPC"];
      $mesero = $_GET["meseroPC"];
      $propina = number_format($_GET["PropinaPC"], 2, '.', ',');
      $subTotal = number_format($_GET["SubTotalPC"], 2, '.', ',');
      $total = number_format($_GET["TotalPagarPC"], 2, '.', ',');
      $respuestaTicket = modelConfiguraciones::informacionTicket();
      $Restaurante = $respuestaTicket["Restaurante"];
      $logo= $respuestaTicket["logo"];

      $pdf = new FPDF();
      $pdf->AddPage();
      $pdf->SetFont('arial','',9);
      $pdf->Image('../../views/dist/img/logo/'.$logo.'.jpeg',18,5,-300);
      $pdf->SetXY(15,20);
      $pdf->Cell(40,10,$Restaurante,0,0,'L');
      $pdf->SetXY(30,25);
      $pdf->Cell(40,10,'PRE-CUENTA',0,0,'L');
      $pdf->SetXY(3,30);
      $pdf->Cell(40,10,'ATENDIO: '.$mesero,0,0,'L');
      $pdf->SetXY(50,30);
      $pdf->Cell(40,10,'NRO MESA: '.$mesa,0,0,'L');
      $pdf->SetXY(3,35);
      $pdf->Cell(40,10,'FECHA: '.$fecha,0,0,'L');
      $pdf->SetXY(50,35);
      $pdf->Cell(40,10,'HORA: '.$hora,0,0,'L');
      $pdf->SetXY(3,40);
      $pdf->Cell(40,10,"========================================",0,0,'L');
      $pdf->SetXY(3,45);
      $pdf->Cell(40,10,"CANT|  DESCRIPCION                   | P.U  |  TOTAL  ",0,0,'L');
      $pdf->SetXY(3,50);
      $pdf->Cell(40,10,"========================================",0,0,'L');
      $pdf->SetXY(3,55);
      $y = 60;
      $yPrecioYitemTotal = 55;
      $vistaDetallePedidosEnCaja = modelRealizarVenta::vistaDetallePedidosEnCaja($idPedido);
      foreach($vistaDetallePedidosEnCaja as $row => $itemPedido){
        $descripcion = $itemPedido["descripcion"];
        $cantidad = $itemPedido["cantidad"];
        $precio = number_format($itemPedido["precio"], 2, '.', ',');
        $itemTotal = number_format($itemPedido["precio"]*$itemPedido["cantidad"], 2, '.', ',');

        $xcantidad = 0;
        $xprecio = 0;
        $xitemTotal = 0;
if(strlen($cantidad) == 1){$xcantidad = 7;}elseif(strlen($precio) == 2){$xcantidad = 6;}else{$xcantidad=5;}
if(strlen($precio) == 4){$xprecio = 56;}elseif(strlen($precio) == 5){$xprecio = 54;}else{$xprecio=64;}
if(strlen($itemTotal) == 4){$xitemTotal = 67;}elseif(strlen($itemTotal) == 5){$xitemTotal = 65;}else{$xitemTotal=64;}
      $pdf->SetXY($xcantidad,$yPrecioYitemTotal);
      $pdf->Cell(0,10,$cantidad,0,0,'L');
      $pdf->SetXY(12,$yPrecioYitemTotal);
      $pdf->Cell(40,10,$descripcion,0,0,'L');
      $pdf->SetXY($xprecio,$yPrecioYitemTotal);
      $pdf->Cell(0,10,$precio,0,0,'L');
      $pdf->SetXY($xitemTotal,$yPrecioYitemTotal);
      $pdf->Cell(0,10,$itemTotal,0,0,'L');

      $pdf->SetXY(3,$y);
      $y = 5 + $y;
      $yPrecioYitemTotal = 5 + $yPrecioYitemTotal;
      }
      $y = $y - 5;
      $pdf->SetXY(3,$y);
      $pdf->Cell(40,10,"========================================",0,0,'L');

      $xsubTotal = 0;
      $xpropina = 0;
      $xtotal = 0;
if(strlen($subTotal) == 4){$xsubTotal = 66;}elseif(strlen($subTotal) == 5){$xsubTotal = 65;}else{$xsubTotal=64;}
if(strlen($propina) == 4){$xpropina = 67;}elseif(strlen($propina) == 5){$xpropina = 66;}else{$xpropina=70;}
if(strlen($total) == 4){$xtotal = 66;}elseif(strlen($subTotal) == 5){$xtotal = 65;}else{$xtotal=64;}

      $y = 5 + $y;
      $pdf->SetXY(3,$y);
      $pdf->Cell(0,10,"              SUB-TOTAL....................$",0,0,'L');
      $pdf->SetXY($xsubTotal,$y);
      $pdf->Cell(0,10,$subTotal,0,0,'L');
      $y = 5 + $y;
      $pdf->SetXY(3,$y);
      $pdf->Cell(0,10,"              PROPINA........................$",0,0,'L');
      $pdf->SetXY($xpropina,$y);
      $pdf->Cell(0,10,$propina,0,0,'L');
      $y = 5 + $y;
      $pdf->SetFont('arial','B',9);
      $pdf->SetXY(3,$y);
      $pdf->Cell(0,10,"              TOTAL A PAGAR..........$",0,0,'L');
      $pdf->SetXY($xtotal,$y);
      $pdf->Cell(0,10,$total,0,0,'L');
// ESTO ERA UNA PRUEBA PARA VER CUANTOS CARACTERES TENIAN LA DESCRIPCION Y LOS TOTALES
      // $vistaDetallePedidosEnCaja = modelRealizarVenta::vistaDetallePedidosEnCaja($idPedido);
      // foreach($vistaDetallePedidosEnCaja as $row => $itemPedido){
      //   $descripcion = $itemPedido["descripcion"];
      //   $y = 5 + $y;
      //   $pdf->SetXY(3,$y);
      //   $pdf->Cell(40,10,strlen($descripcion),0,0,'L');
      // }
      // $y = 5 + $y;
      // $pdf->SetXY(3,$y);
      // $pdf->Cell(40,10,strlen($subTotal),0,0,'L');
      // $y = 5 + $y;
      // $pdf->SetXY(3,$y);
      // $pdf->Cell(40,10,strlen($propina),0,0,'L');
      // $y = 5 + $y;
      // $pdf->SetXY(3,$y);
      // $pdf->Cell(40,10,strlen($total),0,0,'L');
      $pdf->Output();
  }

  //PARA PAGAR Y ENTREGAR TICKET =======================================================================================||
  if(isset($_GET["idPedidoA"])){
      // DATOS
        $idPedido = $_GET["idPedidoA"];
        $fecha = date("Y-m-d");
        $hora = date("H:i");
        $mesero = $_GET["meseroA"];
        $nrocomprobanteC = $_GET["nrocomprobanteCA"];
        $propina = $_GET["propinaA"];
        $subTotal = $_GET["totalA"];
        $total = $_GET["totalpagarA"];
        $respuestaTicket = modelConfiguraciones::informacionTicket();
        $Restaurante = $respuestaTicket["Restaurante"];
        $Contribuyente = $respuestaTicket["Contribuyente"];
        $NroDeRegistro= $respuestaTicket["NroDeRegistro"];
        $NIT = $respuestaTicket["NIT"];
        $Giro = $respuestaTicket["Giro"];
        $DireccionPrimeraParte = substr($respuestaTicket["Direccion"],0,40);
        $DireccionSegundaParte = substr($respuestaTicket["Direccion"],40,80);
        $ResolucionPrimeraParte = substr($respuestaTicket["Resolucion"],0,40);
        $ResolucionSegundaParte = substr($respuestaTicket["Resolucion"],40,80);
        // $Resolucion = $respuestaTicket["Resolucion"];
        $Mensaje= $respuestaTicket["Mensaje"];
        $Mensaje2= $respuestaTicket["Mensaje2"];
        $logo= $respuestaTicket["logo"];
        $exento= '0.00';
        $NoSujeto= '0.00';

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('arial','',9);
        $pdf->Image('../../views/dist/img/logo/'.$logo.'.jpeg',18,5,-300);
        $pdf->SetXY(15,20);
        $pdf->Cell(40,10,$Restaurante,0,0,'L');
        $pdf->SetXY(10,25);
        $pdf->Cell(75,10,$Contribuyente,0,0,'L');
        $pdf->SetXY(10,30);
        $pdf->Cell(40,10,'NRC: '.$NroDeRegistro.' NIT: '.$NIT,0,0,'L');
        $pdf->SetXY(3,35);
        $pdf->Cell(75,10,'GIRO: '.$Giro,0,0,'C');
        $pdf->SetXY(3,40);
        $pdf->SetFont('arial','',8);
        $pdf->Cell(75,10,$DireccionPrimeraParte,0,0,'C');
        $pdf->SetXY(3,45);
        $pdf->Cell(75,7,$DireccionSegundaParte,0,0,'C');
        $pdf->SetFont('arial','',9);
        $pdf->SetXY(3,50);
        $pdf->Cell(75,7,'CAJA # 1                   TICKET: '.$nrocomprobanteC,0,0,'C');
        $pdf->SetXY(3,55);
        $pdf->Cell(40,3,"========================================",0,0,'L');
        $pdf->SetXY(3,60);
        $pdf->Cell(75,0,'ATENDIO: '.$mesero,0,0,'L');
        $pdf->SetXY(3,64);
        $pdf->Cell(75,0,'CLIENTE: ',0,0,'L');
        $pdf->SetXY(3,68);
        $pdf->Cell(75,0,'FECHA: '.$fecha.'                            '.'HORA: '.$hora,0,0,'C');
        $pdf->SetXY(3,72);
        $pdf->Cell(40,0,"========================================",0,0,'L');
        $pdf->SetXY(3,76);
        $pdf->Cell(40,0,"CANT|  DESCRIPCION                   | P.U  |  TOTAL  ",0,0,'L');
        $pdf->SetXY(3,80);
        $pdf->Cell(40,0,"========================================",0,0,'L');
        $pdf->SetXY(3,84);
        $y = 88;
        $yPrecioYitemTotal = 84;
        $vistaDetallePedidosEnCaja = modelRealizarVenta::vistaDetallePedidosEnCaja($idPedido);
        foreach($vistaDetallePedidosEnCaja as $row => $itemPedido){
          $descripcion = $itemPedido["descripcion"];
          $cantidad = $itemPedido["cantidad"];
          $precio = number_format($itemPedido["precio"], 2, '.', ',');
          $itemTotal = number_format($itemPedido["precio"]*$itemPedido["cantidad"], 2, '.', ',');

          $xcantidad = 0;
          $xprecio = 0;
          $xitemTotal = 0;
if(strlen($cantidad) == 1){$xcantidad = 7;}elseif(strlen($precio) == 2){$xcantidad = 6;}else{$xcantidad=5;}
if(strlen($precio) == 4){$xprecio = 56;}elseif(strlen($precio) == 5){$xprecio = 54;}else{$xprecio=64;}
if(strlen($itemTotal) == 4){$xitemTotal = 67;}elseif(strlen($itemTotal) == 5){$xitemTotal = 65;}else{$xitemTotal=64;}
        $pdf->SetXY($xcantidad,$yPrecioYitemTotal);
        $pdf->Cell(0,0,$cantidad,0,0,'L');
        $pdf->SetXY(12,$yPrecioYitemTotal);
        $pdf->Cell(40,0,$descripcion,0,0,'L');
        $pdf->SetXY($xprecio,$yPrecioYitemTotal);
        $pdf->Cell(0,0,$precio,0,0,'L');
        $pdf->SetXY($xitemTotal,$yPrecioYitemTotal);
        $pdf->Cell(0,0,$itemTotal,0,0,'L');

        $pdf->SetXY(3,$y);
        $y = 5 + $y;
        $yPrecioYitemTotal = 5 + $yPrecioYitemTotal;
        }
        $y = $y - 5;
        $pdf->SetXY(3,$y);
        $pdf->Cell(40,0,"========================================",0,0,'L');

        $xsubTotal = 0;
        $xpropina = 0;
        $xtotal = 0;
if(strlen($subTotal) == 4){$xsubTotal = 66;}elseif(strlen($subTotal) == 5){$xsubTotal = 65;}else{$xsubTotal=64;}
if(strlen($propina) == 4){$xpropina = 67;}elseif(strlen($propina) == 5){$xpropina = 66;}else{$xpropina=70;}
if(strlen($total) == 4){$xtotal = 66;}elseif(strlen($subTotal) == 5){$xtotal = 65;}else{$xtotal=64;}
if(strlen($exento) == 4){$xexento = 67;}elseif(strlen($exento) == 5){$xexento = 66;}else{$xexento=70;}

        $y = 5 + $y;
        $pdf->SetXY(3,$y);
        $pdf->Cell(0,0,"              SUB-TOTAL GRAVADO.........$",0,0,'L');
        $pdf->SetXY($xsubTotal,$y);
        $pdf->Cell(0,0,$subTotal,0,0,'L');
        $y = 5 + $y;
        $pdf->SetXY(3,$y);
        $pdf->Cell(0,0,"              SUB-TOTAL EXENTO............$",0,0,'L');
        $pdf->SetXY($xexento,$y);
        $pdf->Cell(0,0,'0.00',0,0,'L');
        $y = 5 + $y;
        $pdf->SetXY(3,$y);
        $pdf->Cell(0,0,"              SUB-TOTAL NO SUJETAS.....$",0,0,'L');
        $pdf->SetXY($xexento,$y);
        $pdf->Cell(0,0,'0.00',0,0,'L');
        $y = 5 + $y;
        $pdf->SetXY(3,$y);
        $pdf->Cell(0,0,"              TOTAL.....................................$",0,0,'L');
        $pdf->SetXY($xsubTotal,$y);
        $pdf->Cell(0,0,$subTotal,0,0,'L');
        $y = 5 + $y;
        $pdf->SetXY(3,$y);
        $pdf->Cell(0,0,"              PROPINA................................$",0,0,'L');
        $pdf->SetXY($xpropina,$y);
        $pdf->Cell(0,0,$propina,0,0,'L');
        $y = 5 + $y;
        $pdf->SetFont('arial','B',9);
        $pdf->SetXY(3,$y);
        $pdf->Cell(0,0,"              TOTAL A PAGAR...................$",0,0,'L');
        $pdf->SetXY($xtotal,$y);
        $pdf->Cell(0,0,$total,0,0,'L');
        $y = 5 + $y;
        $pdf->SetFont('arial','',8);
        $pdf->SetXY(3,$y);
        $pdf->Cell(75,0,"G = ART. GRAVADO E = ART.EXENTO N = NO SUJ",0,0,'C');
        if ($total>200) {
          $y = 5 + $y;
          $pdf->SetXY(3,$y);
          $pdf->Cell(0,0,"Nombre:________________________________",0,0,'L');
          $y = 5 + $y;
          $pdf->SetXY(3,$y);
          $pdf->Cell(0,0,"NIT o DUI:_____________________________",0,0,'L');
          $y = 5 + $y;
          $pdf->SetXY(3,$y);
          $pdf->Cell(0,0,"FIRMA:_________________________________",0,0,'L');
          }
          $y = 5 + $y;
          $pdf->SetXY(3,$y);
          $pdf->Cell(75,0,$ResolucionPrimeraParte,0,0,'C');
          $y = 5 + $y;
          $pdf->SetXY(3,$y);
          $pdf->Cell(75,0,$ResolucionSegundaParte,0,0,'C');
          $y = 5 + $y;
          $pdf->SetXY(3,$y);
          $pdf->SetFont('arial','B',8);
          $pdf->Cell(75,0,"$Mensaje",0,0,'C');
//       // ESTO ERA UNA PRUEBA PARA VER CUANTOS CARACTERES TENIAN LA DESCRIPCION Y LOS TOTALES
//             // $vistaDetallePedidosEnCaja = modelRealizarVenta::vistaDetallePedidosEnCaja($idPedido);
//             // foreach($vistaDetallePedidosEnCaja as $row => $itemPedido){
//             //   $descripcion = $itemPedido["descripcion"];
//             //   $y = 5 + $y;
//             //   $pdf->SetXY(3,$y);
//             //   $pdf->Cell(40,10,strlen($descripcion),0,0,'L');
//             // }
//             // $y = 5 + $y;
//             // $pdf->SetXY(3,$y);
//             // $pdf->Cell(40,10,strlen($subTotal),0,0,'L');
//             // $y = 5 + $y;
//             // $pdf->SetXY(3,$y);
//             // $pdf->Cell(40,10,strlen($propina),0,0,'L');
//             // $y = 5 + $y;
//             // $pdf->SetXY(3,$y);
//             // $pdf->Cell(40,10,strlen($total),0,0,'L');
        $pdf->Output();
    }

?>
