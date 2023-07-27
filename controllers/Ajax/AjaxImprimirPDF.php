<?php
    
  date_default_timezone_set('America/El_Salvador');



  require_once "../../views/src/fpdf/fpdf.php";
  require_once "../../models/modelSalon.php";
  require_once "../../models/modelCaja.php";
  require_once "../../models/modelConfiguraciones.php";
  require_once "../../models/modelReportes.php";
  require_once "../../models/modelRealizarVenta.php";
  require_once "../../models/modelCierre.php";
  require_once "../../controllers/controllerGastoIngreso.php";
  require_once "../../models/modelGastoIngreso.php";

  
  $modelRV = new modelRealizarVenta();
  $modelSalon = new modelSalon();
  $modelConfig = new modelConfiguraciones();
  $modelCierre = new modelCierre();
  $modelCaja = new modelCaja();
  $conGasIng = new controllerGastoIngreso();
  $modelReporte = new modelReportes();

  //IMPRIMIR COMANDA DE BAR =======================================================================================||
  if(isset($_GET["IdPedidoBar"])){

    $fecha = date("Y-m-d");
    $hora = date("H:i");
    $mesero = $_GET["mesero"];
    $mesa = $_GET["NroMesa"];
    $NumMesa =$modelSalon->verificarEstadoMesa($_GET['NroMesa']);
     $pdf = new FPDF();
     $pdf->AddPage();
     $pdf->SetMargins(5, 2, 0);
     $pdf->SetFont('Arial','',10);
     $pdf->Cell(40,5,'',0,1,'L');
     $pdf->Cell(40,5,'Mesero: '.$mesero,0,0,'L');
     $pdf->Cell(40,5,'Mesa: '.$NumMesa['Etiqueta'],0,1,'L');
     $pdf->Cell(40,5,'Fecha: '.$fecha,0,0,'L');
     $pdf->Cell(40,5,'Hora: '.$hora,0,1,'L');
     $pdf->Cell(80,5,"===================================",0,1,'L');
     $pdf->Cell(80,5,"|           BEBIDA                           | CANT",0,1,'L');
     $pdf->Cell(80,5,"===================================",0,1,'L');
     $respuesta =$modelSalon->idDetallePedido($_GET["IdPedidoBar"]);
     //var_dump($respuesta);
          foreach($respuesta as $row => $itemPedido){
            // estado q si quisiera repetir
            if ($itemPedido['Estado']=='B' OR $itemPedido['Estado']=='B' ){
              $cantidad = $itemPedido["Cantidad"];
              $comen = $itemPedido["comentario"];
              $DescripcionTicke =$modelSalon->descripcionItem($itemPedido['IdItems']);
              $descripcion = $DescripcionTicke["Descripcion"];
              $pdf->Cell(60,5,substr($descripcion, 0, 25),0,0);
              $pdf->Cell(10,5,$cantidad,0,1,'L');
              if ($comen != NULL ){
              $pdf->Cell(80,5,substr($comen, 0, 25),0,1);
              }else{}
            }
          }

          //para sacar comida en la comanda
      // $pdf->Ln(1);      
      // $pdf->Cell(80,5,"===================================",0,1,'L');
      // $pdf->Cell(40,5,"|           COMIDA                           | CANT",0,1,'L');
      // $pdf->Cell(40,5,"===================================",0,1,'L');
      // $respuesta =$modelSalon->idDetallePedido($_GET["IdPedidoBar"]);
      // //var_dump($respuesta);
      //       foreach($respuesta as $row => $itemPedido){
      //       if ($itemPedido['Estado']=='S' )
      //         {

      //           $cantidad = $itemPedido["Cantidad"];
      //           $comen = $itemPedido["comentario"];
      //           $DescripcionTicke =$modelSalon->descripcionItem($itemPedido['IdItems']);
      //           $descripcion = $DescripcionTicke["Descripcion"];
      //           $pdf->Cell(60,5,substr($descripcion, 0, 25),0,0);
      //           $pdf->Cell(10,5,$cantidad,0,1,'L');
      //           if ($comen != NULL ){
      //             $pdf->Cell(80,5,substr($comen, 0, 25),0,1);
      //             }else{}
      //         }
      //       }
     $pdf->Output();



     // Si en las configuraciones esta registrado que puede eliminar bebida se registrara el estado de la bebida con la letra Q si con la letra D
     $respuestaPermitirEliminarBebida =$modelConfig->PermitirEliminarBebida();
     $Permitir = $respuestaPermitirEliminarBebida["bebidaEliminar"];
     if($Permitir == 'N')
     {
      $modelSalon->enviarPedidoBarNoPermitirBorrar($_GET["IdPedidoBar"]);
     }
     else {
      $modelSalon->enviarPedidoBarPermitirBorrar($_GET["IdPedidoBar"]);
     }
     echo "<script>window.print();</script>";
  }

  //PARA PRE-CUENTA =======================================================================================||
  if(isset($_GET["idPedidoPC"])){
    $datosController = array("IdPedido"=>$_GET["idPedidoPC"],
                             "Total"=>$_GET["SubTotalPC"],
                             "Propina"=>$_GET["PropinaPC"],
                             "Retencion" => $_GET["RetencionPagar"],
                             "Exentos" => $_GET["ExentoPagar"],
                             "TotalPagar"=>$_GET["TotalPagarPC"],);
       $modelSalon->preCuenta($datosController);
        $datosControllerMesa = array("NroMesa"=>$_GET["mesaPC"],
                                 "Estado"=>"P");
        if($_GET["cantidadCuentasPC"] == 1){
         $modelSalon->cambioEstadoMesa($datosControllerMesa);
        }
       $modelRV->Comensales($_GET["idPedidoPC"], $_GET["comensales"]);
        $idPedido = $_GET["idPedidoPC"];
        $fecha = date("Y-m-d");
        $hora = date("H:i");
        $mesa = $_GET["mesaPC"];
        $cliente = $_GET["clientePC"];
        $NumMesa =$modelSalon->verificarEstadoMesa($_GET['mesaPC']);
        $mesero = $_GET["meseroPC"];
        $propina = number_format($_GET["PropinaPC"], 2, '.', ',');
        $Exento = number_format($_GET["ExentoPagar"], 2, '.', ',');
        $subTotal = number_format($_GET["SubTotalPC"], 2, '.', ',');
        $total = number_format($_GET["TotalPagarPC"], 2, '.', ',');
        $respuestaTicket =$modelConfig->informacionTicket();

        $Restaurante = $respuestaTicket["Restaurante"];
        $logo= $respuestaTicket["logo"];

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',10);
        $pdf->Image('../../views/dist/img/logo/'.$logo.'.jpg',20,2,35);
        
        // $pdf->Image('../../views/dist/img/logo/'.$logo.'.jpeg',18,0,-840);
        // $pdf->Image('../../views/dist/img/logo/'.$logo.'.jpeg',10,0,60);
        $pdf->SetXY(0,20);
        $pdf->Cell(80,10,$Restaurante,0,0,'C');
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(27,25);
        $pdf->Cell(40,10,'PRE-CUENTA',0,0,'L');
        $pdf->SetXY(5,30);
        $pdf->Cell(40,10,'ATENDIO: '.$mesero,0,0,'L');
        $pdf->SetXY(47,30);
        $pdf->Cell(40,10,'NRO MESA: '.$NumMesa['Etiqueta'],0,0,'L');
        $pdf->SetXY(5,35);
        $pdf->Cell(40,10,'FECHA: '.$fecha,0,0,'L');
        $pdf->SetXY(47,35);
        $pdf->Cell(40,10,'HORA: '.$hora,0,0,'L');
        $pdf->SetXY(5,40);
        $pdf->Cell(40,10,'COMENSALES: '.$_GET["comensales"],0,0,'L');
        $pdf->SetXY(47,40);
        $pdf->Cell(40,10,'CLIENTE: '.$cliente,0,0,'L');
        $pdf->SetXY(47,40);
        $pdf->Cell(40,10,'',0,0,'L');
        $pdf->SetXY(5,45);
        $pdf->Cell(40,10,"========================================",0,0,'L');
        $pdf->SetXY(5,50);
        $pdf->Cell(40,10,"CANT|  DESCRIPCION                   | P.U  |  TOTAL  ",0,0,'L');
        $pdf->SetXY(5,55);
        $pdf->Cell(40,10,"========================================",0,0,'L');
        $pdf->SetXY(5,60);
        $y = 65;
        $yPrecioYitemTotal = 60;
        $vistaDetallePedidosEnCaja =$modelRV->vistaDetallePedidosEnCaja($idPedido);
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
        $pdf->Cell(5,10,$cantidad,0,0,'L');
        $pdf->SetXY(12,$yPrecioYitemTotal);
        $pdf->Cell(40,10,substr($descripcion, 0, 19),0,0,'L');
        $pdf->SetXY($xprecio,$yPrecioYitemTotal);
        $pdf->Cell(5,10,$precio,0,0,'L');
        $pdf->SetXY($xitemTotal,$yPrecioYitemTotal);
        $pdf->Cell(5,10,$itemTotal,0,0,'L');

        $pdf->SetXY(3,$y);
        $y = 5 + $y;
        $yPrecioYitemTotal = 5 + $yPrecioYitemTotal;
        }
        $y = $y - 5;
        $pdf->SetXY(5,$y);
        $pdf->Cell(40,10,"========================================",0,0,'L');

        $xsubTotal = 0;
        $xpropina = 0;
        $xtotal = 0;
  if(strlen($subTotal) == 4){$xsubTotal = 63;}elseif(strlen($subTotal) == 5){$xsubTotal = 62;}else{$xsubTotal=61;}
  if(strlen($propina) == 4){$xpropina = 64;}elseif(strlen($propina) == 5){$xpropina = 63;}else{$xpropina=67;}
  if(strlen($total) == 4){$xtotal = 63;}elseif(strlen($subTotal) == 5){$xtotal = 62;}else{$xtotal=61;}

        $y = 5 + $y;
        $pdf->SetXY(5,$y);
        $pdf->Cell(5,10,"              SUB-TOTAL....................$",0,0,'L');
        $pdf->SetXY($xsubTotal,$y);
        $pdf->Cell(5,10,$subTotal,0,0,'L');
        $y = 5 + $y;
        $pdf->SetXY(5,$y);
        $pdf->Cell(5,10,"              PROPINA........................$",0,0,'L');
        $pdf->SetXY($xpropina,$y);
        $pdf->Cell(5,10,$propina,0,0,'L');
        $y = 5 + $y;
        $pdf->SetXY(5,$y);
        $pdf->Cell(5,10,"              EXENTOS.......................$",0,0,'L');
        $pdf->SetXY($xpropina,$y);
        $pdf->Cell(5,10,"-".$Exento,0,0,'L');
        $y = 5 + $y;
        $pdf->SetFont('arial','B',9);
        $pdf->SetXY(5,$y);
        $pdf->Cell(5,10,"              TOTAL A PAGAR..........$",0,0,'L');
        $pdf->SetXY($xtotal,$y);
        $pdf->Cell(5,10,$total,0,0,'L');

        $pdf->Output();
    }

    //PARA PAGAR Y ENTREGAR TICKET =======================================================================================||
    if($_GET["tipo"]=='t'){
      
      // DATOS
      $idPedido = $_GET["idPedidoA"];
      $Info =$modelRV->Pedido($idPedido);
      
      if (!$Info) {
        $Info["Fecha"] = date('Y-m-d');
        $Info["Hora"] = date('H:i:s');
      }
      //vamos a sacar la fecha de facturado
      $info2 = $modelRV -> Pedido1( $idPedido ); 
      

      $fecha = date( "d-m-Y", strtotime( $info2["FechaFact"] ) );
      $hora = date( "H:i:s", strtotime( $info2["FechaFact"] ) );
      $importe = $info2['Importe'];
      $mesero = $_GET["meseroA"];
      $nrocomprobanteC = sprintf("%04d",$_GET["nrocomprobanteCA"]);
      $propina = $_GET["propinaA"];
      $subTotal = $_GET["totalA"];
      $total = $_GET["totalpagarA"];
      if (isset ($_GET["cliente"])){
        $cliente =$_GET["cliente"];
       } else{
        $cliente="";}
        
      $respuestaTicket =$modelConfig->informacionTicket();
      $Restaurante = $respuestaTicket["Restaurante"];
      $Contribuyente = $respuestaTicket["Contribuyente"];
      $NroDeRegistro= $respuestaTicket["NroDeRegistro"];
      $NIT = $respuestaTicket["NIT"];
      $Giro = $respuestaTicket["Giro"];
      $DireccionPrimeraParte = substr($respuestaTicket["Direccion"],0,35);
      $DireccionSegundaParte = substr($respuestaTicket["Direccion"],35,80);
      $Res= strtoupper($respuestaTicket["Resolucion"]);
      $Mensaje= $respuestaTicket["Mensaje"];
      $Mensaje2= $respuestaTicket["Mensaje2"];
      $logo= $respuestaTicket["logo"];
      $exento= '0.00';
      $NoSujeto= '0.00';

      $pdf = new FPDF();
      $pdf->SetMargins(4, 30 , 134);
      $pdf->AddPage();

      $pdf->SetFont('arial','B',12);
      $pdf->Image('../../views/dist/img/logo/'.$logo.'.jpg',20,0,32);
      $pdf->SetXY(2,20);
      $pdf->Cell(0,5,$Restaurante,0,1,'C');
      $pdf->SetFont('arial','',10);
      $pdf->Cell(0,5,$Contribuyente,0,1,'C');
      $pdf->SetFont('arial','',9);
      $pdf->Cell(0,5,'NRC: '.$NroDeRegistro.'  NIT: '.$NIT,0,1,'C');
      $pdf->Cell(0,5,strtoupper($Giro),0,1,'C');
      $pdf->Cell(0,5,$DireccionPrimeraParte,0,1,'C');
      $pdf->Cell(0,5,$DireccionSegundaParte,0,1,'C');
      $pdf->Cell(40,5,'CAJA # 1',0,0,'L');
      $pdf->Cell(33,5,'TICKET: '.$nrocomprobanteC,0,1,'R');
      $pdf->Cell(0,5,"=======================================",0,1,'L');
      $pdf->Cell(0,5,'ATENDIO: '.strtoupper($mesero),0,0,'L');
      $pdf->Cell(0,5,'CLIENTE: '.strtoupper($cliente),0,1,'R');
      $pdf->Cell(40,5,'FECHA: '.$fecha,0,0,'L');
      $pdf->Cell(33,5,'HORA: '.$hora,0,1,'R');
      $pdf->Cell(0,5,"=======================================",0,1,'L');
      $pdf->Cell(11,5,'CANT','R',0,'L');
      $pdf->Cell(38,5,'DESCRIPCION','R',0,'C');
      $pdf->Cell(11,5,'P.U','R',0,'C');
      $pdf->Cell(13,5,'TOTAL',0,1,'C');
      $pdf->Cell(0,5,"=======================================",0,1,'L');
      $vistaDetallePedidosEnCaja =$modelRV->vistaDetallePedidosEnCaja($idPedido);
      foreach($vistaDetallePedidosEnCaja as $row => $itemPedido){
        $cantidad = $itemPedido["cantidad"];
        $descripcion = $itemPedido["descripcion"];
        $precio = number_format($itemPedido["precio"], 2, '.', ',');
        $itemTotal = number_format($itemPedido["precio"]*$itemPedido["cantidad"], 2, '.', ',');

        $pdf->Cell(11,5,$cantidad,0,0,'L');
        $pdf->Cell(38,5,utf8_decode(substr($descripcion, 0, 19)),0,0,'L');
        $pdf->Cell(11,5,$precio,0,0,'R');
        $pdf->Cell(13,5,$itemTotal,0,1,'R');
      }
      $pdf->Cell(0,5,"=======================================",0,1,'L');
      $pdf->Cell(60,5,'SUB-TOTAL GRAVADO........$',0,0,'R');
      $pdf->Cell(13,5,$subTotal,0,1,'R');
      $pdf->Cell(60,5,'SUB-TOTAL EXENTO...........$',0,0,'R');
      $pdf->Cell(13,5,$_GET["Exentos"],0,1,'R');
      $pdf->Cell(60,5,'SUB-TOTAL NO SUJETAS...$',0,0,'R');
      $pdf->Cell(13,5,'0.00',0,1,'R');
      $pdf->Cell(60,5,'TOTAL...................................$',0,0,'R');
      $pdf->Cell(13,5,number_format($subTotal + $_GET["Exentos"],2),0,1,'R');
      $pdf->Cell(60,5,'PROPINA..............................$',0,0,'R');
      $pdf->Cell(13,5,number_format($propina,2),0,1,'R');
      $pdf->Cell(60,5,'IMPORTE..............................$',0,0,'R');
      $pdf->Cell(13,5,number_format($importe,2),0,1,'R');
      $pdf->Cell(60,5,'TOTAL A PAGAR..................$',0,0,'R');
      $pdf->Cell(13,5,number_format($total,2),0,1,'R');
      $pdf->Cell(60,5,'CAMBIO................................$',0,0,'R');
      $pdf->Cell(13,5,number_format(($importe-$total),2),0,1,'R');
      if ($total > 200) {
        $pdf->Cell(0,5,"Nombre:_________________________________",0,1,'L');
        $pdf->Cell(0,5,"NIT o DUI:_______________________________",0,1,'L');
        $pdf->Cell(0,5,"FIRMA:__________________________________",0,1,'L');
      }
      $pdf->SetFont('arial','',9);
      $pdf->Cell(0,5,substr( $Res, 0, 37 ),0,1,'C');
      $pdf->Cell(0,5,substr( $Res, 37, 39 ),0,1,'C');
      $pdf->Cell(0,5,substr( $Res, 76, 39 ),0,1,'C');
      $pdf->SetFont('arial','B',9);
      $pdf->Cell(0,5,$Mensaje,0,1,'C');
      $pdf->Cell(0,5,$Mensaje2,0,1,'C');

      $pdf->Output();
    }

    //PARA PAGAR Y ENTREGAR TICKET =======================================================================================||
    if($_GET["tipo"]=='O'){
      // DATOS
      $idPedido = $_GET["idPedidoA"];
      $Info =$modelRV->Pedido($idPedido);
      
      if (!$Info) {
        $Info["Fecha"] = date('Y-m-d');
        $Info["Hora"] = date('H:i:s');
      }
      //vamos a sacar la fecha de facturado
      $info2 = $modelRV -> Pedido1( $idPedido ); 

      $fecha = date( "d-m-Y", strtotime( $info2["FechaFact"] ) );
      $hora = date( "H:i:s", strtotime( $info2["FechaFact"] ) );
      $mesero = $_GET["meseroA"];
      $importe = $info2['Importe'];
      $nrocomprobanteC = sprintf("%04d",$_GET["nrocomprobanteCA"]);
      $propina = $_GET["propinaA"];
      $subTotal = $_GET["totalA"];
      $total = $_GET["totalpagarA"];
      if (isset ($_GET["cliente"])){
        $cliente =$_GET["cliente"];
       } else{
        $cliente="";}
      
      $respuestaTicket =$modelConfig->informacionTicket();
      $Restaurante = $respuestaTicket["Restaurante"];
      $Contribuyente = $respuestaTicket["Contribuyente"];
      $NroDeRegistro= $respuestaTicket["NroDeRegistro"];
      $NIT = $respuestaTicket["NIT"];
      $Giro = $respuestaTicket["Giro"];
      $DireccionPrimeraParte = substr($respuestaTicket["Direccion"],0,35);
      $DireccionSegundaParte = substr($respuestaTicket["Direccion"],35,80);
      $ResolucionPrimeraParte = substr($respuestaTicket["Resolucion"],0,40);
      $ResolucionSegundaParte = substr($respuestaTicket["Resolucion"],40,80);
      // $Resolucion = $respuestaTicket["Resolucion"];
      $Mensaje= $respuestaTicket["Mensaje"];
      $Mensaje2= $respuestaTicket["Mensaje2"];
      $logo= $respuestaTicket["logo"];
      $exento= '0.00';
      $NoSujeto= '0.00';

      $pdf = new FPDF();
      $pdf->SetMargins(4, 30 , 134);
      $pdf->AddPage();

      $pdf->SetFont('arial','B',12);
      $pdf->Image('../../views/dist/img/logo/'.$logo.'.jpg',20,0,32);
      $pdf->SetXY(2,20);
      $pdf->Cell(0,5,$Restaurante,0,1,'C');
      $pdf->SetFont('arial','',10);
      $pdf->Cell(0,5,$Contribuyente,0,1,'C');
      $pdf->SetFont('arial','',9);
      $pdf->Cell(0,5,$DireccionPrimeraParte,0,1,'C');
      $pdf->Cell(0,5,$DireccionSegundaParte,0,1,'C');
      $pdf->Cell(40,5,'CAJA # 1',0,0,'L');
      $pdf->Cell(33,5,'TICKET: '.$nrocomprobanteC,0,1,'R');
      $pdf->Cell(0,5,"=======================================",0,1,'L');
      $pdf->Cell(0,5,'ATENDIO: '.strtoupper($mesero),0,0,'L');
      $pdf->Cell(0,5,'CLIENTE: '.strtoupper($cliente),0,1,'R');
      $pdf->Cell(40,5,'FECHA: '.$fecha,0,0,'L');
      $pdf->Cell(33,5,'HORA: '.$hora,0,1,'R');
      $pdf->Cell(0,5,"=======================================",0,1,'L');
      $pdf->Cell(11,5,'CANT','R',0,'L');
      $pdf->Cell(38,5,'DESCRIPCION','R',0,'C');
      $pdf->Cell(11,5,'P.U','R',0,'C');
      $pdf->Cell(13,5,'TOTAL',0,1,'C');
      $pdf->Cell(0,5,"=======================================",0,1,'L');
      $vistaDetallePedidosEnCaja =$modelRV->vistaDetallePedidosEnCaja($idPedido);
      foreach($vistaDetallePedidosEnCaja as $row => $itemPedido){
        $cantidad = $itemPedido["cantidad"];
        $descripcion = $itemPedido["descripcion"];
        $precio = number_format($itemPedido["precio"], 2, '.', ',');
        $itemTotal = number_format($itemPedido["precio"]*$itemPedido["cantidad"], 2, '.', ',');

        $pdf->Cell(11,5,$cantidad,0,0,'L');
        $pdf->Cell(38,5,utf8_decode(substr($descripcion, 0, 19)),0,0,'L');
        $pdf->Cell(11,5,$precio,0,0,'R');
        $pdf->Cell(13,5,$itemTotal,0,1,'R');
      }
      $pdf->Cell(0,5,"=======================================",0,1,'L');
      $pdf->Cell(60,5,'SUB-TOTAL GRAVADO........$',0,0,'R');
      $pdf->Cell(13,5,$subTotal,0,1,'R');
      $pdf->Cell(60,5,'SUB-TOTAL EXENTO...........$',0,0,'R');
      $pdf->Cell(13,5,$_GET["Exentos"],0,1,'R');
      $pdf->Cell(60,5,'SUB-TOTAL NO SUJETAS...$',0,0,'R');
      $pdf->Cell(13,5,'0.00',0,1,'R');
      $pdf->Cell(60,5,'TOTAL...................................$',0,0,'R');
      $pdf->Cell(13,5,number_format($subTotal + $_GET["Exentos"],2),0,1,'R');
      $pdf->Cell(60,5,'PROPINA..............................$',0,0,'R');
      $pdf->Cell(13,5,number_format($propina,2),0,1,'R');
      $pdf->Cell(60,5,'IMPORTE..............................$',0,0,'R');
      $pdf->Cell(13,5,number_format($importe,2),0,1,'R');
      $pdf->Cell(60,5,'TOTAL A PAGAR..................$',0,0,'R');
      $pdf->Cell(13,5,number_format($total,2),0,1,'R');
      $pdf->Cell(60,5,'CAMBIO................................$',0,0,'R');
      $pdf->Cell(13,5,number_format(($importe-$total),2),0,1,'R');
      if ($total > 200) {
        $pdf->Cell(0,5,"Nombre:_________________________________",0,1,'L');
        $pdf->Cell(0,5,"NIT o DUI:_______________________________",0,1,'L');
        $pdf->Cell(0,5,"FIRMA:__________________________________",0,1,'L');
      }
      $pdf->SetFont('arial','B',9);
      $pdf->Cell(0,5,$Mensaje,0,1,'C');
      $pdf->Cell(0,5,$Mensaje2,0,1,'C');

      $pdf->Output();
    }


    //PARA PAGAR Y ENTREGAR FACTURA CONSUMIDOR FINAL =======================================================================================||
    if($_GET["tipo"]=='fcf'){
        // DATOS
          $idPedido = $_GET["idPedidoA"];
          $consumo = 0;
          if (isset($_GET['Consumo'])) {
            $consumo = $_GET['Consumo'];
           $modelRV->Consumo($idPedido, $consumo);

            if($_GET['Consumo'] == 1){
              $consumo = 1;
            }
          }
          $Info =$modelRV->Pedido($idPedido);
          if (!$Info) {
            $Info["Fecha"] = date('Y-m-d');
            $Info["Hora"] = date('H:i:s');
          }else{
            $consumo = $Info['consumo'];
          }
          $fecha = date("Y-m-d");
          $hora = date("H:i");
          $mesero = $_GET["meseroA"];
          $nrocomprobanteC = $_GET["nrocomprobanteCA"];
          $propina = $_GET["propinaA"];
          $subTotal = $_GET["totalA"];
          $total = $_GET["totalpagarA"];
          $cliente = $_GET["Acliente"];
          // $Resolucion = $respuestaTicket["Resolucion"];
          $exento= '0.00';
          $NoSujeto= '0.00';

          $Title = array(
            "Cliente" =>  $cliente,
            "Fecha" => $Info["Fecha"],
            "Hora" => substr($Info["Hora"], 0, -3),
            "TipoSucursal" => '',
            "FechaImpresion" => ''
          );

          $Top = 7.5;
          // $Top = 55;

          class PDF extends FPDF {
            public function MyCell($w, $h, $x, $t, $cant, $aling){
              $height = $h/3;
              $first = $height + 2;
              $second = $height + $height + $height + 3;
              //$second = $height + $height + $height + 3;


              $len = strlen($t);
              if ($len>$cant) {
                $txt = str_split($t,$cant);
                $this->SetX($x);
                $this->Cell($w, $first, $txt[0],"","",$aling);
                $this->SetX($x);
                $this->Cell($w, $second, $txt[1],"","",$aling);
                $this->SetX($x);
                $this->Cell($w, $h,'',0,0,'L',0);
              }else{
                $this->SetX($x);
                $this->Cell($w, $h,$t,0,0,'L',0);

              }
            }

            public function Header(){
              global $Title;
              global $Top;
              $fechaCorta = substr($Title["Fecha"],0,10);
              $fechaSeparada = explode('-', $fechaCorta);
              $this->SetFont('Helvetica','B',12);
              $this->SetMargins(40, 2, 0);
              $this->Ln($Top);
              $this->Ln(15);
              $this->Cell(145,10,'',0,0,'L');
              $this->Cell(10,4,$fechaSeparada[2],0,0,'L');
              $this->Cell(5,4,$fechaSeparada[1],0,0,'C');
              $this->Cell(15,4,$fechaSeparada[0],0,1,'R');
              $this->Ln(2);
              $this->Cell(100,20,'',0,0,'L');
              
              $this->Cell(50,4,$Title["Cliente"],0,0,'L');
              $this->Cell(20,4,'',0,1,'L');
            }
          }

          $pdf = new PDF('P','mm',array(230,290));
          //$pdf->AliasNbPages();
          $pdf->AddPage();
          $pdf->SetFont('Helvetica','B',9);

          $pdf->Ln(20);

          $Suma = 0;
          $Contador = 1;
          $vistaDetallePedidosEnCaja =$modelRV->vistaDetallePedidosEnCaja($idPedido);
          foreach($vistaDetallePedidosEnCaja as $row => $itemPedido){
            $cantidad = $itemPedido["cantidad"];
            $descripcion = $itemPedido["descripcion"];
            $precio = number_format($itemPedido["precio"], 2, '.', ',');
            $itemTotal = number_format($itemPedido["precio"]*$itemPedido["cantidad"], 2, '.', ',');

            if ($Contador == 11) {
              $pdf->Cell(49,6,'',0,0,'R');
              $pdf->Cell(31,6,"--------------------------->",0,1,'R');
              $Top = 14.5;
              $pdf->AddPage();
              $pdf->SetFont('Helvetica','B',9);
              $pdf->Ln(20);
              $Contador = 1;
            }

            if($consumo == 1){
              $pdf->Cell(110,6,'',0,0,'L');
              $x = $pdf->GetX();
              $pdf->MyCell(70,6,$x,utf8_decode('POR CONSUMO DE ALIMENTO'),30,'L');
              $pdf->Cell(10,6,'',0,0,'R');
              $pdf->Cell(5,6,'',0,0,'R');
              $pdf->Cell(16,6,number_format($_GET['totalA'], 2),0,1,'R');
              $Suma = $_GET['totalA'];
              $Contador += 1;
              break;
            }
            
            $pdf->Cell(100,6,' ',0,0,'L');
            $pdf->Cell(10,6,$cantidad,0,0,'L');
            $x = $pdf->GetX();
            $pdf->MyCell(40,6,$x,utf8_decode($descripcion),20,'L');
            $pdf->Cell(8,6,$precio,0,0,'R');
            $pdf->Cell(1,6,'',0,0,'R');
            $pdf->Cell(12,6,number_format($itemTotal, 2),0,1,'R');

            $Suma += $itemTotal;
            $Contador += 1;
          }
          $Res = 11 - $Contador;
          for ($i=0; $i <  $Res; $i++) {
            $pdf->Cell(16,6,'',0,0,'R');
            $pdf->Cell(10,6,'',0,0,'L');
            $x = $pdf->GetX();
            $pdf->MyCell(39,6,$x,'',25,'L');
            $pdf->Cell(10,6,'',0,0,'R');
            $pdf->Cell(5,6,'',0,0,'R');
            $pdf->Cell(16,6,'',0,1,'R');
          }

          $Propina = $_GET['propinaA'];

          $pdf->SetFont('Helvetica','B',9);

          $pdf->SetXY(200,190);
          $pdf->Cell(15,4,"Pro. ".number_format($Propina, 2),0,1,'R');
          
          $total = $Suma + $Propina;
          $pdf->SetXY(200,195);
          $pdf->Cell(15,4,number_format($total - $_GET["Exentos"], 2),0,1,'R');
          $pdf->SetXY(200,200);
          $pdf->Cell(15,3,number_format($total, 2),0,1,'R');

          $pdf->Output();
      }

      if($_GET["tipo"]=='ccf'){
          // DATOS
            $idPedido = $_GET["idPedidoA"];
            $consumo = 0;

            $modelRV = new modelRealizarVenta();

            if (isset($_GET['Consumo'])) {
              $consumo = $_GET['Consumo'];
              $modelRV->Consumo($idPedido, $consumo);

              if($_GET['Consumo'] == 1){
                $consumo = 1;
              }
            }
            $Info = $modelRV->Pedido($idPedido);
            $Info1 = $modelRV->verCliente($_GET['Anrc']);
            if (!$Info) {
              $Info["Fecha"] = date('Y-m-d');
              $Info["Hora"] = date('H:i:s');
            }else{
              $consumo = $Info['consumo'];
            }
            $fecha = date("d-m-Y");
            $hora = date("H:i");
            $mesero = $_GET["meseroA"];
            $nrocomprobanteC = $_GET["nrocomprobanteCA"];
            $propina = $_GET["propinaA"];
            $subTotal = 0;
            $total = $_GET["totalpagarA"];
            $cliente = $_GET["Acliente"];

            $exento= '0.00';
            $NoSujeto= '0.00';

            $Title = array(
              "NRC" => $_GET["Anrc"],
              "Cliente" =>  $cliente,
              "Fecha" => substr($Info["FechaFact"],0,10),
              "Hora" => $Info["Hora"],
              "Direccion" => utf8_decode($Info1['Direccion']),
              "Departamento" => utf8_decode( $Info1['Departamento'] ),
              "Giro" => $Info1['Giro'],
              "NIT" => $Info1['NIT'],
              "TipoSucursal" => '',
              "FechaImpresion" => ''
            );

            $Top = 37;


            class PDF extends FPDF {
              public function MyCell($w, $h, $x, $t, $cant, $aling){
                $height = $h/3;
                $first = $height + 2;
                $second = $height + $height + $height + 3;
                //$second = $height + $height + $height + 3;


                $len = strlen($t);
                if ($len>$cant) {
                  $txt = str_split($t,$cant);
                  $this->SetX($x);
                  $this->Cell($w, $first, $txt[0],"","",$aling);
                  $this->SetX($x);
                  $this->Cell($w, $second, $txt[1],"","",$aling);
                  $this->SetX($x);
                  $this->Cell($w, $h,'',0,0,'L',0);
                }else{
                  $this->SetX($x);
                  $this->Cell($w, $h,$t,0,0,'L',0);

                }
              }

              public function Header()
              {
                global $Title;
                global $Top;
                $this->SetFont('Helvetica','B',8);
                $this->SetMargins(100, 5, 0);
                $this->Ln($Top);
                $fechaCorta = substr($Title["Fecha"],0,10);
                $fechaSeparada = explode('-', $fechaCorta);
                $this->Cell(85,5,'',0,0,'L');
                $this->Cell(10,5,$fechaSeparada[2],0,0,'L');
                $this->Cell(10,5,$fechaSeparada[1],0,0,'L');
                $this->Cell(10,5,$fechaSeparada[0],0,1,'L');
                $this->Cell(30,5,'',0,0,'L');
                $this->Cell(40,7,strtoupper($Title["Cliente"]),0,1,'L');
                $this->Cell(30,7,'',0,0,'L');
                $this->Cell(40,7, strtoupper(substr( $Title["Direccion"],0,35)),0,0,'L');
                $this->Cell(30,7,$Title["NRC"],0,1,'R');
                $this->Cell(20,7,'',0,0,'L');
                $this->Cell(70,7, strtoupper( substr( $Title["Departamento"],0,35 ) ),0,0,'L');
                $this->Cell(30,7,strtoupper( substr( $Title["Giro"] ,0,15 ) ),0,1,'R');
                $this->Cell(20,7,'',0,0,'L');
                $this->Cell(70,7, strtoupper( substr( $Title["NIT"],0,35 ) ),0,0,'L');
                $this->Cell(20,4,'',0,1,'L');
              }
            }


            $pdf = new PDF('P','mm',array(230,297));
            $pdf->AddPage();
            $pdf->SetFont('Helvetica','B',8);

            $pdf->Ln(15);

            $Suma = 0;
            $Contador = 1;
            $vistaDetallePedidosEnCaja = $modelRV->vistaDetallePedidosEnCaja($idPedido);
            foreach($vistaDetallePedidosEnCaja as $row => $itemPedido){
              $cantidad = $itemPedido["cantidad"];
              $descripcion = $itemPedido["descripcion"];
              $precio = round($itemPedido["precio"] / 1.13, 2);
              $itemTotal = round($precio * $itemPedido["cantidad"], 2);

              if($consumo == 1){
                $pdf->Cell(10,6,'',0,0,'L');
                $x = $pdf->GetX();
                $pdf->MyCell(39,6,$x,utf8_decode('POR CONSUMO DE ALIMENTO'),20,'L');
                $pdf->Cell(10,6,'',0,0,'R');
                $pdf->Cell(5,6,'',0,0,'R');
                $pdf->Cell(16,6,number_format($_GET['totalA'], 2),0,1,'R');
                $Suma = $_GET['totalA'];
                $Contador += 1;
                break;
              }

              if ($Contador == 11) {
                $pdf->Cell(49,6,'',0,0,'R');
                $pdf->Cell(31,6,"--------------------------->",0,1,'R');
                $Top = 63;
                $pdf->AddPage();
                $pdf->SetFont('Helvetica','B',8);
                $pdf->Ln(8);
                $Contador = 1;
              }
              $pdf->Cell(15,6,$cantidad,0,0,'L');
              $x = $pdf->GetX();
              $pdf->MyCell(60,6,$x,utf8_decode($descripcion),20,'L');
              $pdf->Cell(10,6,$precio,0,0,'R');
              $pdf->Cell(10,6,'',0,0,'R');
              $pdf->Cell(16,6,number_format($itemTotal, 2),0,1,'R');

              $Suma += $itemTotal;
              $Contador += 1;
            }
            $Res = 11 - $Contador;
            for ($i=0; $i <  $Res; $i++) {

              $pdf->Cell(16,6,'',0,0,'R');
              $pdf->Cell(10,6,'',0,0,'L');
              $x = $pdf->GetX();
              $pdf->MyCell(39,6,$x,'',25,'L');
              $pdf->Cell(10,6,'',0,0,'R');
              $pdf->Cell(5,6,'',0,0,'R');
              $pdf->Cell(16,6,'',0,1,'R');
            }

            $pdf->Ln(20);
            
            $pdf->SetXY(200,150); // para fijarlo

            $propina = $_GET["propinaA"];
            if($_GET['propinaA'] == 0){
              $propina = 0;
            }

            $pdf->Cell(15,7,"Pro. ".number_format($_GET["propinaA"] + $propina, 2),0,1,'R');
            $pdf->Cell(100,7,' ',0,0,'R');
            $pdf->Cell(15,7,number_format($Suma, 2),0,1,'R');
            $pdf->Cell(100,7,' ',0,0,'R');
            $pdf->Cell(15,7,number_format($Suma * 0.13, 2),0,1,'R');
            $pdf->Cell(100,7,' ',0,0,'R');
            $pdf->Cell(15,7,number_format($total, 2),0,1,'R');
            $pdf->Cell(100,7,' ',0,0,'R');
            $pdf->Cell(15,7,number_format($_GET['Retencion'], 2),0,1,'R');
            $pdf->Cell(100,7,' ',0,0,'R');
            $pdf->Cell(15,7,number_format($_GET["Exentos"], 2),0,1,'R');
            $pdf->Cell(100,7,' ',0,0,'R');
            $pdf->Cell(15,7,'0.00',0,1,'R');
            $pdf->Cell(100,7,' ',0,0,'R');
            $pdf->Cell(15,7,number_format($total, 2),0,1,'R');
        


          $pdf->Output();
        }

        //resumen por días  
        

          if ($_GET["tipo"] == "RSD") {

            $FechaI = $_GET["FechaI"];
            $id = $_GET["caja"];
            $caja = $modelCaja->caja($id);
            
            if (!$caja['HoraCierre']) {
              $caja['HoraCierre'] = date("Y-m-d H:i:s");
            }
            $Fechatxt = date("d-m-Y", strtotime($FechaI));
            
            $pdf = new FPDF('P','mm',array(80,297));
            $pdf->AddPage();
            $pdf->SetMargins(4, 2, 0);
            $pdf->Ln(5);
            $pdf->SetFont('Helvetica','B',14);
            $pdf->Cell(72,4,'TIERRAMAR USULUTAN',0,1,'C');
            $pdf->SetFont('Helvetica','B',10);
            $pdf->Cell(72,4,'RESUMEN DIARIO',0,1,'C');
            $pdf->Cell(72,4,$Fechatxt,0,1,'C');
            $pdf->Ln(5);
            $pdf->Cell(72,4,'*************************   INGRESOS   *************************',0,1,'C');
            $pdf->Cell(76,4,'TICKETS',0,1,'L');
            $pdf->Cell(20,4,'Numero #',0,0,'L');
            $pdf->Cell(4,4,'||',0,0,'R');
            $pdf->Cell(25,4,'Forma de  pago',0,0,'C');
            $pdf->Cell(4,4,'||',0,0,'R');
            $pdf->Cell(19,4,'Monto',0,1,'R');
            $TKT = $modelCierre->correoresumenticket($caja['Fecha'], $caja['HoraCierre']);
            $TotalTKT = 0;
            $PropinaTKT = 0;
            $ResumenTKT = array(
              "E" => 0,
              "T" => 0,
              "ET" => 0,
              "CH" => 0,
              "BTC" => 0,
              "CR" => 0,
              "H"  => 0
            );
            foreach ($TKT as $key => $value) {
              $F = "";
              if ($value["FormaPago"] == "E") {
                $F = "EFECTIVO";
                $ResumenTKT["E"] += $value["TotalPagar"];
              }elseif ($value["FormaPago"] == "T") {
                $F = "TARJETA";
                $ResumenTKT["T"] += $value["TotalPagar"];
              }elseif ($value["FormaPago"] == "BTC") {
                $F = "BTC";
                $ResumenTKT["BTC"] += $value["TotalPagar"];
              }elseif ($value["FormaPago"] == "ET") {
                $F = "EFECT./TARJ.";
                $ResumenTKT["E"] += $value["TotalPagar"] - $value["Tarjeta"];
                $ResumenTKT["T"] += $value["Tarjeta"];
              }elseif ($value["FormaPago"] == "CH") {
                $F = "CHEQUE";
                $ResumenTKT["CH"] += $value["TotalPagar"];
              }
              // else if ($value["FormaPago"] == "CR"){
              //   $F = "CREDITO";
              //   $ResumenTKT["CR"] += $value["TotalPagar"];
              //   //$F = $value["FormaPago"];
              // }
              else if ($value["FormaPago"] == "H"){
                $F = "HUGO";
                $ResumenTKT["H"] += $value ["TotalPagar"];
              }

              $pdf->Cell(20,4,sprintf("%04d",$value["NumeroDoc"]),0,0,'L');
              $pdf->Cell(4,4,'',0,0,'R');
              $pdf->Cell(25,4,$F,0,0,'L');
              $pdf->Cell(4,4,'',0,0,'R');
              $pdf->Cell(19,4,number_format($value["Total"],2),0,1,'R');
              $TotalTKT += $value["Total"];
              $PropinaTKT += $value["Propina"];
            }
            $pdf->Cell(53,4,'TOTAL $',0,0,'R');
            $pdf->Cell(19,4,number_format($TotalTKT,2),0,1,'R');
            
            // //para los otros
            // $pdf->Ln(5);
            // $pdf->Cell(76,4,'OTROS',0,1,'L');
            // $pdf->Cell(20,4,'Numero #',0,0,'L');
            // $pdf->Cell(4,4,'||',0,0,'R');
            // $pdf->Cell(25,4,'Forma de  pago',0,0,'C');
            // $pdf->Cell(4,4,'||',0,0,'R');
            // $pdf->Cell(19,4,'Monto',0,1,'R');
            //  $O = $modelCierre->correoresumenotros($caja['Fecha'], $caja['HoraCierre']);
             $TotalO = 0;
              $PropinaO = 0;
            
            // foreach ($O as $key => $value) {
            //   $F = "";
            //   if ($value["FormaPago"] == "E") {
            //     $F = "EFECTIVO";
            //     $ResumenTKT["E"] += $value["TotalPagar"];
            //   }elseif ($value["FormaPago"] == "T") {
            //     $F = "TARJETA";
            //     $ResumenTKT["T"] += $value["TotalPagar"];
            //   }elseif ($value["FormaPago"] == "ET") {
            //     $F = "EFECT./TARJ.";
            //     $ResumenTKT["E"] += $value["TotalPagar"] - $value["Tarjeta"];
            //     $ResumenTKT["T"] += $value["Tarjeta"];
            //   }elseif ($value["FormaPago"] == "CH") {
            //     $F = "CHEQUE";
            //     $ResumenTKT["CH"] += $value["TotalPagar"];
            //   }
            //   // else if ($value["FormaPago"] == "CR"){
            //   //   $F = "CREDITO";
            //   //   $ResumenO["CR"] += $value["TotalPagar"];
            //   //   //$F = $value["FormaPago"];
            //   // }
            //   else if ($value["FormaPago"] == "H"){
            //     $F = "HUGO";
            //     $ResumenTKT["H"] += $value ["TotalPagar"];
            //   }

            //   $pdf->Cell(20,4,sprintf("%04d",$value["NumeroDoc"]),0,0,'L');
            //   $pdf->Cell(4,4,'',0,0,'R');
            //   $pdf->Cell(25,4,$F,0,0,'L');
            //   $pdf->Cell(4,4,'',0,0,'R');
            //   $pdf->Cell(19,4,number_format($value["Total"],2),0,1,'R');
            //   $TotalO += $value["Total"];
            //   $PropinaO += $value["Propina"];
            // }
            // $pdf->Cell(53,4,'TOTAL $',0,0,'R');
            // $pdf->Cell(19,4,number_format($TotalO,2),0,1,'R');

            $pdf->Ln(5);

            $pdf->Cell(76,4,'FACTURAS CONSUMIDOR FINAL(FCF)',0,1,'L');
            $pdf->Cell(20,4,'Numero #',0,0,'L');
            $pdf->Cell(4,4,'||',0,0,'R');
            $pdf->Cell(25,4,'Forma de Pago',0,0,'C');
            $pdf->Cell(4,4,'||',0,0,'R');
            $pdf->Cell(19,4,'Monto',0,1,'R');
            $FCF = $modelCierre->correoresumenfcf($caja['Fecha'], $caja['HoraCierre']);
            $TotalFCF = 0;
            $PropinaFCF = 0;
            foreach ($FCF as $key => $value) {
              $F = "";
              if ($value["FormaPago"] == "E") {
                $F = "EFECTIVO";
                $ResumenTKT["E"] += $value["TotalPagar"];
              }elseif ($value["FormaPago"] == "T") {
                $F = "TARJETA";
                $ResumenTKT["T"] += $value["TotalPagar"];
              }elseif ($value["FormaPago"] == "BTC") {
                $F = "BTC";
                $ResumenTKT["BTC"] += $value["TotalPagar"];
              }elseif ($value["FormaPago"] == "ET") {
                $F = "EFECT./TARJ.";
                $ResumenTKT["E"] += $value["TotalPagar"] - $value["Tarjeta"];
                $ResumenTKT["T"] += $value["Tarjeta"];
              }elseif ($value["FormaPago"] == "CH") {
                $F = "TRANSACCION";
                $ResumenTKT["CH"] += $value["TotalPagar"];
              }else{
                $F = "CREDITO";
                $ResumenTKT["CR"] += $value["TotalPagar"];
                //$F = $value["FormaPago"];
              }

              $pdf->Cell(20,4,$value["NumeroDoc"],0,0,'L');
              $pdf->Cell(4,4,'',0,0,'R');
              $pdf->Cell(25,4,$F,0,0,'L');
              $pdf->Cell(4,4,'',0,0,'R');
              $pdf->Cell(19,4,number_format($value["Total"],2),0,1,'R');
              $TotalFCF += $value["Total"];
              $PropinaFCF += $value["Propina"];
            }
            
            $pdf->Cell(53,4,'TOTAL $',0,0,'R');
            $pdf->Cell(19,4,number_format($TotalFCF,2),0,1,'R');

            $pdf->Ln(5);
            $pdf->Cell(76,4,'COMPROBANTE CREDITO FISCAL(CCF)',0,1,'L');
            $pdf->Cell(20,4,'Numero #',0,0,'L');
            $pdf->Cell(4,4,'||',0,0,'R');
            $pdf->Cell(25,4,'Forma de Pago',0,0,'C');
            $pdf->Cell(4,4,'||',0,0,'R');
            $pdf->Cell(19,4,'Monto',0,1,'R');
            $CCF = $modelCierre->correoresumenccf($caja['Fecha'], $caja['HoraCierre']);
            $TotalCCF = 0;
            $PropinaCCF = 0;
            foreach ($CCF as $key => $value) {
              $F = "";
              if ($value["FormaPago"] == "E") {
                $F = "EFECTIVO";
                $ResumenTKT["E"] += $value["TotalPagar"];
              }elseif ($value["FormaPago"] == "T") {
                $F = "TARJETA";
                $ResumenTKT["T"] += $value["TotalPagar"];
              }elseif ($value["FormaPago"] == "ET") {
                $F = "EFECT./TARJ.";
                $ResumenTKT["E"] += $value["TotalPagar"] - $value["Tarjeta"];
                $ResumenTKT["T"] += $value["Tarjeta"];
              }elseif ($value["FormaPago"] == "CH") {
                $F = "CHEQUE";
                $ResumenTKT["CH"] += $value["TotalPagar"];
              }else{
                $F = "CREDITO";
                $ResumenTKT["CR"] += $value["TotalPagar"];
                //$F = $value["FormaPago"];
              }

              $pdf->Cell(20,4,$value["NumeroDoc"],0,0,'L');
              $pdf->Cell(4,4,'',0,0,'R');
              $pdf->Cell(25,4,$F,0,0,'L');
              $pdf->Cell(4,4,'',0,0,'R');
              $pdf->Cell(19,4,number_format($value["Total"],2),0,1,'R');
              $TotalCCF += $value["Total"];
              $PropinaCCF += $value["Propina"];
            }

            $pdf->Cell(53,4,'TOTAL $',0,0,'R');
            $pdf->Cell(19,4,number_format($TotalCCF,2),0,1,'R');

            $pdf->Ln(5);
            $pdf->Cell(76,4,'CXC CANCELADAS',0,1,'L');
            $pdf->Cell(48,4,'Numero #',0,0,'L');
            $pdf->Cell(4,4,'||',0,0,'R');
            $pdf->Cell(20,4,'Monto',0,1,'R');
             
            $Cxc = $conGasIng->vistaCxcc($FechaI);
            $TotalCxc = 0;
            foreach ($Cxc as $key => $value){

              $pdf->Cell(48,4,$value["NumeroDoc"],0,0,'L');
              $pdf->Cell(4,4,'',0,0,'R');
              $pdf->Cell(19,4,number_format($value["TotalPagar"],2),0,1,'R');
              $TotalCxc += $value["TotalPagar"];
            }
            $pdf->Cell(52,4,'TOTAL $',0,0,'R');
            $pdf->Cell(20,4,number_format($TotalCxc,2),0,1,'R');

            $pdf->Ln(5);
            $pdf->Cell(76,4,'INGRESOS',0,1,'L');
            $pdf->Cell(48,4,'Descripcion',0,0,'L');
            $pdf->Cell(4,4,'||',0,0,'R');
            $pdf->Cell(20,4,'Monto',0,1,'R');
           
            $Ingresos = $modelCierre->correoresumenIngresos($FechaI);
            $TotalIngresos = 0;
            foreach ($Ingresos as $key => $value){

              $pdf->Cell(48,4,$value["Descripcion"],0,0,'L');
              $pdf->Cell(4,4,'',0,0,'R');
              $pdf->Cell(19,4,number_format($value["Monto"],2),0,1,'R');
              $TotalIngresos += $value["Monto"];
            }
            $pdf->Cell(52,4,'TOTAL $',0,0,'R');
            $pdf->Cell(20,4,number_format($TotalIngresos,2),0,1,'R');

            $pdf->Ln(5);
            $TG = $TotalTKT + $TotalFCF + $TotalCCF+$TotalO;
            $pdf->Cell(53,4,'SUBTOTAL $',0,0,'R');
            $pdf->Cell(19,4,number_format($TG,2),0,1,'R');

            //pa los ingresos otros ingresos
            $pdf->Cell(53,4,'OTROS INGRESOS $',0,0,'R');
            $pdf->Cell(19,4,number_format(($TotalIngresos+$TotalCxc),2),0,1,'R');

            $TP = $PropinaTKT + $PropinaFCF + $PropinaCCF+$PropinaO;
            $pdf->Cell(53,4,'PROPINA $',0,0,'R');
            $pdf->Cell(19,4,number_format($TP,2),0,1,'R');

            $TIngreso = $TG + $TP + $TotalIngresos + $TotalCxc;
            $pdf->Cell(53,4,'TOTAL INGRESO $',0,0,'R');
            $pdf->Cell(19,4,number_format($TIngreso,2),0,1,'R');

            $pdf->Ln(5);
            $pdf->Cell(72,4,'*************************   DETALLE   *************************',0,1,'C');

            $Index = array('E', 'T', 'ET', 'CR', 'CH', 'H', 'BTC');
            $Sum = 0;
            for ($i=0; $i < count($Index); $i++) {

              $F = "";
              if ($Index[$i] == "E") {
                $F = "EFECTIVO";
              }elseif ($Index[$i] == "T") {
                $F = "TARJETA";
              }elseif ($Index[$i] == "BTC") {
                $F = "BTC";
              }elseif ($Index[$i] == "CH") {
                $F = "CHEQUE";
              }elseif ($Index[$i] == "CR") {
                $F = "CREDITO";
              }elseif($Index[$i] == "H"){
                $F= "HUGO";
              }
              if ($Index[$i] != "ET") {
                $pdf->Cell(53,4,$F.' $',0,0,'R');
                $pdf->Cell(19,4,number_format($ResumenTKT[$Index[$i]],2),0,1,'R');
                $Sum += $ResumenTKT[$Index[$i]];
              }
            }

            $pdf->Cell(53,4,'TOTAL $',0,0,'R');
            $pdf->Cell(19,4,number_format($Sum ,2),0,1,'R');

            // intento 001 de editar esto
            $pdf->Ln(5);
            $pdf->Cell(72,4,'*************************   CORTESIAS  *************************',0,1,'C');
            $pdf->Cell(48,4,'Pedido #',0,0,'L');
            //$pdf->Cell(4,4,'||',0,0,'R');
            //$pdf->Cell(25,4,'Forma de Pago',0,0,'C');
            $pdf->Cell(4,4,'||',0,0,'R');
            $pdf->Cell(19,4,'Monto',0,1,'R');


            
            $COR = $modelCierre->correoresumenCor($caja['Fecha'], $caja['HoraCierre']);
            $TotalCompra = 0;
            
            foreach ($COR as $key => $value) {
              
              
              $pdf->Cell(20,4,sprintf("%04d",$value["IdPedido"]),0,0,'L');
              $pdf->Cell(4,4,'',0,0,'R');
              $pdf->Cell(25,4,'',0,0,'L');
              $pdf->Cell(4,4,'',0,0,'R');
              $pdf->Cell(19,4,number_format($value["Total"],2),0,1,'R');
              $TotalCompra += $value["Total"];
              //$TotalTKT += $value["Total"];
              //$PropinaTKT += $value["Propina"];
            }
            $pdf->Cell(53,4,'TOTAL $',0,0,'R');
            $pdf->Cell(19,4,number_format($TotalCompra,2),0,1,'R');

            //ahora para los Hugos
            $pdf->Ln(5);
            $pdf->Cell(72,4,'*************************   HUGO  *************************',0,1,'C');
            $pdf->Cell(48,4,'Pedido #',0,0,'L');
            //$pdf->Cell(4,4,'||',0,0,'R');
            //$pdf->Cell(25,4,'Forma de Pago',0,0,'C');
            $pdf->Cell(4,4,'||',0,0,'R');
            $pdf->Cell(19,4,'Monto',0,1,'R');


            
            $HUG = $modelCierre->correoresumenHugo($caja['Fecha'], $caja['HoraCierre']);
            $TotalCompra = 0;
            
            foreach ($HUG as $key => $value) {
              
              
              $pdf->Cell(20,4,sprintf("%04d",$value["IdPedido"]),0,0,'L');
              $pdf->Cell(4,4,'',0,0,'R');
              $pdf->Cell(25,4,'',0,0,'L');
              $pdf->Cell(4,4,'',0,0,'R');
              $pdf->Cell(19,4,number_format($value["Total"],2),0,1,'R');
              $TotalCompra += $value["Total"];
              //$TotalTKT += $value["Total"];
              //$PropinaTKT += $value["Propina"];
            }
            $pdf->Cell(53,4,'TOTAL $',0,0,'R');
            $pdf->Cell(19,4,number_format($TotalCompra,2),0,1,'R');
            

            //ahora para los creditos 

                //ahora para los Hugos
                $pdf->Ln(5);
                $pdf->Cell(72,4,'*************************   CREDITOS  *************************',0,1,'C');
                $pdf->Cell(48,4,'Pedido #',0,0,'L');
                //$pdf->Cell(4,4,'||',0,0,'R');
                //$pdf->Cell(25,4,'Forma de Pago',0,0,'C');
                $pdf->Cell(4,4,'||',0,0,'R');
                $pdf->Cell(19,4,'Monto',0,1,'R');
    
    
                
                $HUG = $modelCierre->correoresumenCr($caja['Fecha'], $caja['HoraCierre']);
                $TotalCompra = 0;
                
                foreach ($HUG as $key => $value) {
                  
                  
                  $pdf->Cell(20,4,sprintf("%04d",$value["IdPedido"]),0,0,'L');
                  $pdf->Cell(4,4,'',0,0,'R');
                  $pdf->Cell(25,4,'',0,0,'L');
                  $pdf->Cell(4,4,'',0,0,'R');
                  $pdf->Cell(19,4,number_format($value["Total"],2),0,1,'R');
                  $TotalCompra += $value["Total"];
                  //$TotalTKT += $value["Total"];
                  //$PropinaTKT += $value["Propina"];
                }
                $pdf->Cell(53,4,'TOTAL $',0,0,'R');
                $pdf->Cell(19,4,number_format($TotalCompra,2),0,1,'R');
    


            $pdf->Ln(5);
            $pdf->Cell(72,4,'*************************   EGRESOS   *************************',0,1,'C');
            $pdf->Cell(76,4,'COMPRAS',0,1,'L');
            $pdf->Cell(20,4,'Numero #',0,0,'L');
            $pdf->Cell(4,4,'||',0,0,'R');
            $pdf->Cell(25,4,'T. Comprobante',0,0,'C');
            $pdf->Cell(4,4,'||',0,0,'R');
            $pdf->Cell(19,4,'Monto',0,1,'R');
            $Compras = $modelCierre->correoresumenCompras($FechaI);
            $TotalCompra = 0;
            foreach ($Compras as $key => $value) {
              $F = $value["TipoDoc"];

              $pdf->Cell(20,4,$value["NroComprobante"],0,0,'L');
              $pdf->Cell(4,4,'',0,0,'R');
              $pdf->Cell(25,4,$F,0,0,'L');
              $pdf->Cell(4,4,'',0,0,'R');
              $pdf->Cell(19,4,number_format($value["Total"],2),0,1,'R');
              $TotalCompra += $value["Total"];
            }
            $pdf->Cell(53,4,'TOTAL $',0,0,'R');
            $pdf->Cell(19,4,number_format($TotalCompra,2),0,1,'R');

            $pdf->Ln(5);
            $pdf->Cell(76,4,'GASTOS',0,1,'L');
            $pdf->Cell(48,4,'Descripcion',0,0,'L');
            $pdf->Cell(4,4,'||',0,0,'R');
            $pdf->Cell(20,4,'Monto',0,1,'R');
            $Gastos = $modelCierre->correoresumenGastos($FechaI);
            $TotalGastos = 0;
            foreach ($Gastos as $key => $value){

              $pdf->Cell(48,4,$value["Descripcion"],0,0,'L');
              $pdf->Cell(4,4,'',0,0,'R');
              $pdf->Cell(19,4,number_format($value["Monto"],2),0,1,'R');
              $TotalGastos += $value["Monto"];
            }
            $pdf->Cell(52,4,'TOTAL $',0,0,'R');
            $pdf->Cell(20,4,number_format($TotalGastos,2),0,1,'R');

            $TEgreso = $TotalCompra + $TotalGastos;
            $pdf->Ln(5);
            $pdf->Cell(53,4,'TOTAL EGRESOS $',0,0,'R');
            $pdf->Cell(19,4,number_format($TEgreso,2),0,1,'R');

            $pdf->Ln(5);
            $pdf->Cell(72,4,'*************************   BALANCE   *************************',0,1,'C');
            $pdf->Cell(53,4,'CAJA INICIAL $',0,0,'R');
            $pdf->Cell(19,4,number_format($caja['MontoApertura'],2),0,1,'R');
            $pdf->Cell(53,4,'TOTAL INGRESOS $',0,0,'R');
            $pdf->Cell(19,4,number_format($TIngreso,2),0,1,'R');
            $pdf->Cell(53,4,'TOTAL EGRESOS $',0,0,'R');
            $pdf->Cell(19,4,"-".number_format($TEgreso,2),0,1,'R');
            $pdf->Cell(53,4,'TOTAL $',0,0,'R');
            $pdf->Cell(19,4,number_format(($TIngreso) - $TEgreso,2),0,1,'R');
            
            
            
            $PlatosMasVendido = $modelReporte->ReportePlatosmasVendidos($caja['Fecha'], $caja['HoraCierre']);
            
            $pdf->Ln(5);
            $pdf->Cell(72,4,'*************************   RESUMEN   *************************',0,1,'C');

            $pdf->Ln(5);
            $pdf->Cell(76,4,'PLATOS',0,1,'L');
            $pdf->Cell(42,4,'Plato',0,0,'L');
            $pdf->Cell(4,4,'||',0,0,'R');
            $pdf->Cell(3,4,'C.',0,0,'C');
            $pdf->Cell(4,4,'||',0,0,'R');
            $pdf->Cell(4,4,'P.',0,0,'C');
            $pdf->Cell(4,4,'||',0,0,'R');
            $pdf->Cell(14,4,'Monto',0,1,'R');
            
            foreach ($PlatosMasVendido as $key => $plato) {
              $pdf->Cell(42,4,substr($plato['Descripcion'],0,18),0,0,'L');
              $pdf->Cell(9,4,$plato['Cantidad'],0,0,'R');
              $pdf->Cell(10,4,$plato['PrecioVenta'],0,0,'R');
              $pdf->Cell(14,4,$plato['Total'],0,1,'R');
            }



            $pdf->Ln(5);
            $pdf->Cell(76,4,'BEBIDAS',0,1,'L');
            $pdf->Cell(42,4,'Bebida',0,0,'L');
            $pdf->Cell(4,4,'||',0,0,'R');
            $pdf->Cell(3,4,'C.',0,0,'C');
            $pdf->Cell(4,4,'||',0,0,'R');
            $pdf->Cell(4,4,'P.',0,0,'C');
            $pdf->Cell(4,4,'||',0,0,'R');
            $pdf->Cell(14,4,'Monto',0,1,'R');

            $BebidasMasVendido = $modelReporte->ReporteBebidasmasVendidas($caja['Fecha'], $caja['HoraCierre']);

            
            foreach ($BebidasMasVendido as $key => $bebida) {
              $pdf->Cell(42,4,substr(utf8_decode($bebida['Descripcion']), 0, 19),0,0,'L');
              $pdf->Cell(9,4,$bebida['Cantidad'],0,0,'R');
              $pdf->Cell(10,4,$bebida['PrecioVenta'],0,0,'R');
              $pdf->Cell(14,4,$bebida['Total'],0,1,'R');
            }

            $pdf->Ln(5);
            $pdf->Cell(72,4,'********************   STOCK INGREDIENTES   ********************',0,1,'C');

            $pdf->Ln(5);
            $pdf->Cell(30,4,'INGREDIENTE',0,0,'L');
            $pdf->Cell(3,4,'||',0,0,'R');
            $pdf->Cell(23,4,'MEDIDA',0,0,'C');
            $pdf->Cell(3,4,'||',0,0,'R');
            $pdf->Cell(15,4,'STOCK',0,1,'R');

            $Ingredientes = $modelReporte->ReporIng();

            foreach ($Ingredientes as $key => $ing) {
              $pdf->Cell(30,4,substr(utf8_decode($ing['DescripcionIng']), 0, 12),0,0,'L');
              $pdf->Cell(25,4,$ing['UnidadMedida'],0,0,'R');
              $pdf->Cell(18,4,$ing['Cantidad'],0,1,'R');
            }

            $apdf = $pdf->Output('prueba','S');
            //sendMail($apdf);

            
            $pdf->Output();
           





          }elseif ($_GET["tipo"] == "CorteZ") {

            $FechaI = $_GET["FechaI"];

            $respuestaTicket=$modelConfig->informacionTicket();
            $Restaurante = $respuestaTicket["Restaurante"];
            $Contribuyente = $respuestaTicket["Contribuyente"];
            $NroDeRegistro= $respuestaTicket["NroDeRegistro"];
            $NIT = $respuestaTicket["NIT"];
            $Giro = $respuestaTicket["Giro"];
            $Direccion = $respuestaTicket["Direccion"];
            $Resolucion = $respuestaTicket["Resolucion"];
            $Mensaje= $respuestaTicket["Mensaje"];
            $Mensaje2= $respuestaTicket["Mensaje2"];

            $caja = $modelCaja->caja($_GET['caja']);

            $ListarTicketCinta = $modelCierre->ListarTicketCinta($caja['Fecha'], $caja['HoraCierre']);

            class PDF extends FPDF {
              public function MyCell($w, $h, $x, $t, $cant, $aling){
                $height = $h/3;
                $first = $height + 2;
                $second = $height + $height + $height + 3;
                //$second = $height + $height + $height + 3;


                $len = strlen($t);
                if ($len>$cant) {
                  $txt = str_split($t,$cant);
                  $this->SetX($x);
                  $this->Cell($w, $first, $txt[0],'','',$aling);
                  $this->SetX($x);
                  $this->Cell($w, $second, $txt[1],'','',$aling);
                  $this->SetX($x);
                  $this->Cell($w, $h,'',0,1,'L',0);
                }else{
                  $this->SetX($x);
                  $this->Cell($w, $h,$t,0,0,'L',0);

                }
              }
            }


            $pdf = new PDF('P','mm',array(80,297));
            $pdf->AddPage();
            $pdf->SetMargins(4, 2, 0);
            $pdf->Ln(5);
            $pdf->SetFont('Courier','B',10);

            $salto = 0;

            foreach($ListarTicketCinta as $row => $item){
              if($item["TipoComprobante"] == "CORTE Z"){
                  $tipoCorte = $item["FormaPago"];
                  $fecha = $item["Fecha"];
                  $hora = $item["Hora"];
                  $ticketInicial =$item["Serie"];
                  $ticketFinal = $item["NumeroDoc"];
                  $montoTicket = $item["MontoTicket"];
                  $fcfInicial =$item["CorrelativoFCF"];
                  $fcfFinal = $item["CorrelativoFCF2"];
                  $montofcf = $item["MontoFCF"];
                  $ccfInicial =$item["CorrelativoCCF"];
                  $ccfFinal = $item["CorrelativoCCF2"];
                  $montoccf = $item["MontoCCF"];
                  $propina = $item["Propina"];
                  $subTotal = $item["TotalPagar"];
                  $total= $item["Total"];
                  if ($salto > 0) {
                    $pdf->Ln(20);
                  }
                  $salto++;

                  $pdf->Cell(72,4,$Restaurante,0,1,'C');
                  $pdf->Cell(72,4,$Contribuyente,0,1,'C');
                  $pdf->Cell(32,4,'NRC '.$NroDeRegistro,0,0,'C');
                  $pdf->Cell(40,4,'NIT '.$NIT,0,1,'C');

                  $pdf->Cell(72,4,'GIRO: '.$Giro,0,1,'C');
                  $pdf->SetFont('Courier','B',9.5);
                  $x = $pdf->GetX();
                  // $pdf->MyCell(72,12,$x,strtoupper($Direccion),38,'C');
                  $pdf->SetFont('Courier','B',10);
                  $pdf->Cell(40,4,$tipoCorte,0,0,'L');
                  $pdf->Cell(32,4,'Ticket: '.sprintf("%04d",$ticketFinal),0,0,'R');
                  $pdf->Ln(5);
                  $pdf->Cell(72,4,"=======================================",0,1,'C');
                  $pdf->Cell(72,4,"CAJA 01",0,1,'L');
                  $pdf->Cell(40,4,'Fecha: '.$fecha,0,0,'L');
                  $pdf->Cell(32,4,'Hora: '.$hora,0,1,'R');
                  $pdf->Cell(72,4,"TICKET",0,1,'L');
                  $pdf->Cell(40,4,'Inicial',0,0,'L');
                  $pdf->Cell(32,4,sprintf("%04d",$ticketInicial),0,1,'R');
                  $pdf->Cell(40,4,'Final',0,0,'L');
                  $pdf->Cell(32,4,sprintf("%04d",$ticketFinal),0,1,'R');
                  $pdf->Cell(62,4,'$ '.$montoTicket,0,0,'R');
                  $pdf->Cell(10,4,'',0,1,'R');

                  $pdf->Cell(72,4,"CONSUMIDOR FINAL",0,1,'L');
                  $pdf->Cell(40,4,'Inicial',0,0,'L');
                  $pdf->Cell(32,4,$fcfInicial,0,1,'R');
                  $pdf->Cell(40,4,'Final',0,0,'L');
                  $pdf->Cell(32,4,$fcfFinal,0,1,'R');
                  $pdf->Cell(62,4,'$ '.$montofcf,0,0,'R');
                  $pdf->Cell(10,4,'',0,1,'R');

                  $pdf->Cell(72,4,"CREDITO FISCAL",0,1,'L');
                  $pdf->Cell(40,4,'Inicial',0,0,'L');
                  $pdf->Cell(32,4,$ccfInicial,0,1,'R');
                  $pdf->Cell(40,4,'Final',0,0,'L');
                  $pdf->Cell(32,4,$ccfFinal,0,1,'R');
                  $pdf->Cell(62,4,'$ '.$montoccf,0,0,'R');
                  $pdf->Cell(10,4,'',0,1,'R');
                  $pdf->Cell(72,4,"=======================================",0,1,'C');

                  $pdf->Cell(50,4,'Dotacion Inicial',0,0,'L');
                  $pdf->Cell(2,4,'$',0,0,'C');
                  $pdf->Cell(20,4,'0.00',0,1,'R');

                  $pdf->Cell(50,4,'Sub Total',0,0,'L');
                  $pdf->Cell(2,4,'$',0,0,'C');
                  $pdf->Cell(20,4,number_format($subTotal, 2),0,1,'R');

                  $pdf->Cell(50,4,'Venta Gravada',0,0,'L');
                  $pdf->Cell(2,4,'$',0,0,'C');
                  $pdf->Cell(20,4,number_format($subTotal, 2),0,1,'R');

                  $pdf->Cell(50,4,'Venta Exenta',0,0,'L');
                  $pdf->Cell(2,4,'$',0,0,'C');
                  $pdf->Cell(20,4,'0.00',0,1,'R');

                  $pdf->Cell(50,4,'Venta No Sujetas',0,0,'L');
                  $pdf->Cell(2,4,'$',0,0,'C');
                  $pdf->Cell(20,4,'0.00',0,1,'R');

                  $pdf->Cell(50,4,'Menos Devolucion',0,0,'L');
                  $pdf->Cell(2,4,'$',0,0,'C');
                  $pdf->Cell(20,4,number_format($propina, 2),0,1,'R');

                  $pdf->Cell(50,4,'Venta Total',0,0,'L');
                  $pdf->Cell(2,4,'$',0,0,'C');
                  $pdf->Cell(20,4,number_format($total, 2),0,1,'R');

                  $pdf->Cell(50,4,'Venta Contado',0,0,'L');
                  $pdf->Cell(2,4,'$',0,0,'C');
                  $pdf->Cell(20,4,number_format($total, 2),0,1,'R');

                  $pdf->Cell(50,4,'Venta Credito',0,0,'L');
                  $pdf->Cell(2,4,'$',0,0,'C');
                  $pdf->Cell(20,4,'0.00',0,1,'R');
              }
            }

            $pdf->Output();
          }elseif ($_GET["tipo"] == "PxEmpleado") {

            $FechaI = $_GET["FechaI"];

            $pdf = new FPDF('P','mm',array(80,297));
            $pdf->AddPage();
            $pdf->SetMargins(4, 2, 0);
            //$pdf->Ln(5);
            $pdf->Cell(72,1,'',0,1,'C');
            $pdf->SetFont('Helvetica','B',10);
            $pdf->Cell(72,4,'TIERRAMAR USULUTAN',0,1,'C');
            $pdf->SetFont('Helvetica','B',8);
            $pdf->Cell(72,4,'PROPINA POR EMPLEADO',0,1,'C');
            $pdf->Cell(72,4,$FechaI,0,1,'C');

            $pdf->Cell(45,4,'Numero Pedido',0,0,'L');
            $pdf->Cell(4,4,'||',0,0,'R');
            $pdf->Cell(23,4,'Monto',0,1,'R');
            $PropinaxEmpleado = $modelCierre->PropinaxEmpleado($FechaI);
            $TotalPxP = 0;
            $Personal = 0;
            $NamePersonal = "";
            $Count = 0;
            foreach ($PropinaxEmpleado as $key => $value) {

              if($key == 0){
                  $Personal = $value["IdPersonal"];
                  $pdf->Cell(72,4,'******************************************************************',0,1,'C');
                  $pdf->Cell(72,4,strtoupper($value["Nombres"]),0,1,'C');
                  $pdf->Cell(72,4,'******************************************************************',0,1,'C');
              }

              if($Personal != $value["IdPersonal"]){
                $pdf->Cell(53,4,'TOTAL ('.$Count.') $',0,0,'R');
                $pdf->Cell(19,4,number_format($TotalPxP,2),0,1,'R');
                $pdf->Cell(72,4,'******************************************************************',0,1,'C');
                $pdf->Cell(72,4,strtoupper($value["Nombres"]),0,1,'C');
                $pdf->Cell(72,4,'******************************************************************',0,1,'C');
                $Personal = $value["IdPersonal"];
                $Count = 0;
                $TotalPxP = 0;
              }

              $pdf->Cell(45,4,sprintf("#%04d",$value["IdPedido"]),0,0,'L');
              $pdf->Cell(4,4,'',0,0,'R');
              $pdf->Cell(23,4,number_format($value["Propina"],2),0,1,'R');
              $TotalPxP += $value["Propina"];
              $Count++;


            }

            $pdf->Cell(53,4,'TOTAL ('.$Count.') $',0,0,'R');
            $pdf->Cell(19,4,number_format($TotalPxP,2),0,1,'R');

            
            
             $pdf->Output();
            //send email

          }


          elseif ($_GET["tipo"] == "MejorVendedor") {

            $FechaI = $_GET["Fechai"];
            $FechaF = $_GET["Fechaf"];
            

            $pdf = new FPDF('P','mm',array(80,297));
            $pdf->AddPage();
            $pdf->SetMargins(4, 2, 0);
            //$pdf->Ln(5);
            $pdf->Cell(72,1,'',0,1,'C');
            $pdf->SetFont('Helvetica','B',10);
            $pdf->Cell(72,4,'TIERRAMAR USULUTAN',0,1,'C');
            $pdf->SetFont('Helvetica','B',8);
            $pdf->Cell(72,4,'MEJORES VENDEDORES',0,1,'C');
            $pdf->Cell(30,4,'DEL',0,0,'C');
            $pdf->Cell(1,4,$FechaI,0,0,'C');
            $pdf->Cell(20,4,'AL',0,0,'C');
            $pdf->Cell(10,4,$FechaF,0,1,'C');

            $pdf->Cell(45,4,'Nombre',0,0,'L');
            $pdf->Cell(4,4,'||',0,0,'R');
            $pdf->Cell(23,4,'Monto',0,1,'R');
            $VenxMesero = $modelReporte->ReporteMejoresVendedores($FechaI, $FechaF);
            $TotalPxP = 0;
            $Personal = 0;
            $NamePersonal = "";
            $Count = 0;
            foreach ($VenxMesero as $key => $value) {

              

              $pdf->Cell(45,4,sprintf("%s",$value["Nombres"]),0,0,'L');
              $pdf->Cell(4,4,'',0,0,'R');
              $pdf->Cell(23,4,number_format($value["Total"],2),0,1,'R');
              $TotalPxP += $value["Total"];
              $Count++;


            }

            $pdf->Cell(53,4,'TOTAL ('.$Count.') $',0,0,'R');
            $pdf->Cell(19,4,number_format($TotalPxP,2),0,1,'R');

             $pdf->Output();
          }



         

?>
