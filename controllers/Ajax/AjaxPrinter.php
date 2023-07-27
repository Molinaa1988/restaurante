<?php
  date_default_timezone_set('America/El_Salvador');
  setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

  require __DIR__ . '/../../vendor/autoload.php';
  use Mike42\Escpos\Printer;
  use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
  use Mike42\Escpos\EscposImage;


  require_once "../../views/src/fpdf/fpdf.php";
  require_once "../../models/modelSalon.php";
  require_once "../../models/modelCaja.php";
  require_once "../../models/modelConfiguraciones.php";
  require_once "../../models/modelReportes.php";
  require_once "../../models/modelRealizarVenta.php";
  require_once "../../models/modelCierre.php";
  require_once "../../models/modelPersonal.php";
  require_once "../../controllers/controllerGastoIngreso.php";
  require_once "../../controllers/controllerCierre.php";
  require_once "../../models/modelGastoIngreso.php";

  $modelRV = new modelRealizarVenta();
  $modelSalon = new modelSalon();
  $modelConfig = new modelConfiguraciones();
  $modelCierre = new modelCierre();
  $modelCaja = new modelCaja();
  $conGasIng = new controllerGastoIngreso();
  $modelReporte = new modelReportes();
  
  
    if (isset($_GET['tipo'])) {
    $Accion = $_GET["tipo"];

        // pa los tickets 
        if ($Accion == "t") {

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
            $nrocomprobanteC = sprintf("%04d",$_GET["nrocomprobanteCA"]);
            $propina = $_GET["propinaA"];
            $subTotal = $_GET["totalA"];
            $importe = $info2['Importe'];
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

            try {
                // Enter the share name for your USB printer here
                // $connector = null;
                   $connector = new WindowsPrintConnector("POS");
            
                /* Print a "Hello world" receipt" */
                $printer = new Printer($connector);

              
                /* Font modes */
                $modes = array(
                    Printer::MODE_FONT_B,
                    Printer::MODE_EMPHASIZED,
                    Printer::MODE_DOUBLE_HEIGHT,
                    Printer::MODE_DOUBLE_WIDTH,
                    Printer::MODE_UNDERLINE);
                /* Justification */
                $justification = array(
                    Printer::JUSTIFY_LEFT,
                    Printer::JUSTIFY_CENTER,
                    Printer::JUSTIFY_RIGHT);
                    
                $printer -> setEmphasis(3);
                $printer -> setJustification($justification[1]);
                
                
                $printer -> text($Restaurante);
                $printer -> selectPrintMode(); // Reset
                $printer -> feed();
                $printer -> text($Contribuyente);
                $printer -> feed();
                $printer -> text('NRC: '.$NroDeRegistro.'  NIT: '.$NIT);
                $printer -> feed();
                $printer -> text(strtoupper($Giro));
                $printer -> feed();
                $printer -> text($DireccionPrimeraParte);
                $printer -> feed();
                $printer -> text($DireccionSegundaParte);
                $printer -> feed();
                $printer -> text('CAJA # 1                   ');
                $printer -> text('TICKET: '.$nrocomprobanteC);
                $printer -> feed();
                $printer -> text("==========================================");
                $printer -> feed();
                $printer -> text('ATENDIO: '.strtoupper($mesero));
                $printer -> text('       CLIENTE: '.strtoupper($cliente));
                $printer -> feed();
                $printer -> text('FECHA: '.$fecha);
                $printer -> text('         HORA: '.$hora);
                $printer -> feed();
                $printer -> text("==========================================");
                $printer -> feed();
                $printer -> setJustification($justification[0]);
                $printer -> text('CANT     DESCRIPCION     P.U      TOTAL' );
                $printer -> feed();
                $printer -> text("==========================================");
                $printer -> feed();
                
                $vistaDetallePedidosEnCaja =$modelRV->vistaDetallePedidosEnCaja($idPedido);
                foreach($vistaDetallePedidosEnCaja as $row => $itemPedido){
                    $cantidad = $itemPedido["cantidad"];
                    $descripcion = $itemPedido["descripcion"];
                    $precio = number_format($itemPedido["precio"], 2, '.', ',');
                    $itemTotal = number_format($itemPedido["precio"]*$itemPedido["cantidad"], 2, '.', ',');
                    $printer -> text( $cantidad.'  ' );
                    $printer -> text( utf8_decode(substr($descripcion, 0, 22)) );
                    $size = 22-(strlen($descripcion));
                    for ($i=0; $i<$size ; $i++) { 
                        $printer -> text( '.' );
                    }
                    $printer -> setJustification($justification[2]);
                    $printer -> text( ' '.$precio.'  ' );
                    $printer -> text( '  '.$itemTotal );
                    $printer -> feed();
                }
                $printer -> text ( "==========================================");
                $printer -> feed();
                $printer -> text ( 'SUB-TOTAL GRAVADO..................$'.$subTotal );
                $printer -> feed();
                $printer -> text ( 'SUB-TOTAL EXENTO...................$'.$_GET["Exentos"] );
                $printer -> feed();
                $printer -> text ( 'SUB-TOTAL NO SUJETAS...............$'.'0.00' );
                $printer -> feed();
                $printer -> text ( 'TOTAL..............................$'.number_format($subTotal + $_GET["Exentos"],2) );
                $printer -> feed();
                $printer -> text ( 'PROPINA............................$'.number_format($propina,2) );
                $printer -> feed();
                $printer -> text ( 'TOTAL A PAGAR......................$'. number_format($total,2) );
                $printer -> feed();
                $printer -> text ( 'IMPORTE............................$'. number_format($importe,2) );
                $printer -> feed();
                $printer -> text ( 'CAMBIO.............................$'. number_format( $importe - $total,2) );
                $printer -> feed(2);
                
                if ($total > 200) {
                    $printer ->text( "Nombre:_________________________________" );
                    $printer -> feed();
                    $printer ->text( "NIT o DUI:_______________________________" );
                    $printer -> feed();
                    $printer ->text( "FIRMA:__________________________________" );
                    $printer -> feed();
                }
                
                $printer -> setJustification($justification[1]);
                $printer -> text( $Res );
                $printer -> feed();
                $printer -> text( $Mensaje );
                $printer -> feed();
                $printer -> text( $Mensaje2 );
                $printer -> feed();
                $printer -> cut();

                

                
                /* Close printer */
                $printer -> close();
            } catch (Exception $e) {
                echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
            }


        
        }

        // pa los tickets 
        if ($Accion == "O") {

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
            $nrocomprobanteC = sprintf("%04d",$_GET["nrocomprobanteCA"]);
            $propina = $_GET["propinaA"];
            $subTotal = $_GET["totalA"];
            $total = $_GET["totalpagarA"];
            $importe = $info2['Importe'];
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

            try {
                // Enter the share name for your USB printer here
                // $connector = null;
                   $connector = new WindowsPrintConnector("POS");
            
                /* Print a "Hello world" receipt" */
                $printer = new Printer($connector);

              
                /* Font modes */
                $modes = array(
                    Printer::MODE_FONT_B,
                    Printer::MODE_EMPHASIZED,
                    Printer::MODE_DOUBLE_HEIGHT,
                    Printer::MODE_DOUBLE_WIDTH,
                    Printer::MODE_UNDERLINE);
                /* Justification */
                $justification = array(
                    Printer::JUSTIFY_LEFT,
                    Printer::JUSTIFY_CENTER,
                    Printer::JUSTIFY_RIGHT);
                    
                $printer -> setEmphasis(3);
                $printer -> setJustification($justification[1]);
                
                
                $printer -> text($Restaurante);
                $printer -> selectPrintMode(); // Reset
                $printer -> feed();
                $printer -> text($Contribuyente);
                $printer -> feed();
                $printer -> text(strtoupper($Giro));
                $printer -> feed();
                $printer -> text($DireccionPrimeraParte);
                $printer -> feed();
                $printer -> text($DireccionSegundaParte);
                $printer -> feed();
                $printer -> text('CAJA # 1                      ');
                $printer -> text('TICKET: '.$nrocomprobanteC);
                $printer -> feed();
                $printer -> text("================================================");
                $printer -> feed();
                $printer -> text('ATENDIO: '.strtoupper($mesero));
                $printer -> text('         CLIENTE: '.strtoupper($cliente));
                $printer -> feed();
                $printer -> text('FECHA: '.$fecha);
                $printer -> text('            HORA: '.$hora);
                $printer -> feed();
                $printer -> text("================================================");
                $printer -> feed();
                $printer -> setJustification($justification[0]);
                $printer -> text('CANT     DESCRIPCION     P.U      TOTAL' );
                $printer -> feed();
                $printer -> text("================================================");
                $printer -> feed();
                
                $vistaDetallePedidosEnCaja =$modelRV->vistaDetallePedidosEnCaja($idPedido);
                foreach($vistaDetallePedidosEnCaja as $row => $itemPedido){
                    $cantidad = $itemPedido["cantidad"];
                    $descripcion = $itemPedido["descripcion"];
                    $precio = number_format($itemPedido["precio"], 2, '.', ',');
                    $itemTotal = number_format($itemPedido["precio"]*$itemPedido["cantidad"], 2, '.', ',');
                    $printer -> text( $cantidad.'  ' );
                    $printer -> text( utf8_decode(substr($descripcion, 0, 25)) );
                    $size = 25-(strlen($descripcion));
                    for ($i=0; $i<$size ; $i++) { 
                        $printer -> text( '.' );
                    }
                    $printer -> setJustification($justification[2]);
                    $printer -> text( ' '.$precio.'  ' );
                    $printer -> text( '  '.$itemTotal );
                    $printer -> feed();
                }
                $printer -> text ( "================================================");
                $printer -> feed();
                $printer -> text ( 'SUB-TOTAL GRAVADO.....................$'.$subTotal );
                $printer -> feed();
                $printer -> text ( 'SUB-TOTAL EXENTO......................$'.$_GET["Exentos"] );
                $printer -> feed();
                $printer -> text ( 'SUB-TOTAL NO SUJETAS..................$'.'0.00' );
                $printer -> feed();
                $printer -> text ( 'TOTAL.................................$'.number_format($subTotal + $_GET["Exentos"],2) );
                $printer -> feed();
                $printer -> text ( 'PROPINA...............................$'.number_format($propina,2) );
                $printer -> feed();
                $printer -> text ( 'TOTAL A PAGAR.........................$'. number_format($total,2) );
                $printer -> feed();
                $printer -> text ( 'IMPORTE...............................$'. number_format($importe,2) );
                $printer -> feed();
                $printer -> text ( 'CAMBIO................................$'. number_format( $importe - $total,2) );
                $printer -> feed(2);
                
                if ($total > 200) {
                    $printer ->text( "Nombre:_________________________________" );
                    $printer -> feed();
                    $printer ->text( "NIT o DUI:_______________________________" );
                    $printer -> feed();
                    $printer ->text( "FIRMA:__________________________________" );
                    $printer -> feed();
                }
                
                $printer -> setJustification($justification[1]);
                $printer -> text( $Mensaje );
                $printer -> feed();
                $printer -> text( $Mensaje2 );
                $printer -> feed();
                $printer -> cut();

                

                
                /* Close printer */
                $printer -> close();
            } catch (Exception $e) {
                echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
            }


        
        }

        //IMPRIMIR COMANDA DE BAR =======================================================================================||
        if(isset($_GET["IdPedidoBar"])){

            $fecha = date("Y-m-d");
            $hora = date("H:i");
            $mesero = $_GET["mesero"];
            $mesa = $_GET["NroMesa"];
            $NumMesa =$modelSalon->verificarEstadoMesa($_GET['NroMesa']);
            
            try {
                // Enter the share name for your USB printer here
                // $connector = null;
                   $connector = new WindowsPrintConnector("POS");
            
                /* Print a "Hello world" receipt" */
                $printer = new Printer($connector);

              
                /* Font modes */
                $modes = array(
                    Printer::MODE_FONT_B,
                    Printer::MODE_EMPHASIZED,
                    Printer::MODE_DOUBLE_HEIGHT,
                    Printer::MODE_DOUBLE_WIDTH,
                    Printer::MODE_UNDERLINE);
                /* Justification */
                $justification = array(
                    Printer::JUSTIFY_LEFT,
                    Printer::JUSTIFY_CENTER,
                    Printer::JUSTIFY_RIGHT);
                    
                //$printer -> setEmphasis(3);
                //$printer -> setJustification($justification[1]);
                
                $printer -> setJustification($justification[0]);
                $printer -> text('Mesero: '.$mesero);
                $printer -> text('              Mesa: '.$NumMesa['Etiqueta']);
                $printer -> feed();
                $printer -> setJustification($justification[0]);
                $printer -> text('Fecha: '.$fecha);
                $printer -> setJustification($justification[2]);
                $printer -> text('            Hora: '.$hora);
                $printer -> feed();
                $printer -> text("==========================================");
                $printer -> feed();
                $printer -> text("|           BEBIDA                  | CANT");
                $printer -> feed();
                $printer -> text("==========================================");
                $printer -> feed();
                
                $printer -> selectPrintMode(); // Reset
                
                $respuesta =$modelSalon->idDetallePedido($_GET["IdPedidoBar"]);
                foreach($respuesta as $row => $itemPedido){
                    // estado q si quiero repetir
                    if ($itemPedido['Estado']=='B' OR $itemPedido['Estado']=='B' ){
                        $cantidad = $itemPedido["Cantidad"];
                        $comen = $itemPedido["comentario"];
                        $DescripcionTicke =$modelSalon->descripcionItem($itemPedido['IdItems']);
                        $descripcion = $DescripcionTicke["Descripcion"];
                        $printer -> text( utf8_decode(substr($descripcion, 0, 40)) );
                        $size = 40-(strlen($descripcion));
                        for ($i=0; $i<$size ; $i++) { 
                            $printer -> text( '.' );
                        }
                        $printer -> setJustification($justification[2]);
                        $printer -> text($cantidad);
                        $printer -> feed();
                        if ($comen != NULL ){
                            $printer -> text( substr($comen, 0, 40));
                            $printer -> feed();
                        }else{}
                    }
                }
                // para sacar comida en la comanda
                // $printer -> text ( "==========================================");
                // $printer -> feed();
                // $printer -> text ( "|           COMIDA                  | CANT");
                // $printer -> feed();
                // $printer -> text ( "==========================================");
                // $printer -> feed();
                // $respuesta =$modelSalon->idDetallePedido($_GET["IdPedidoBar"]);

                // foreach($respuesta as $row => $itemPedido){
                //     if ($itemPedido['Estado']=='S' )
                //     {
                //         $cantidad = $itemPedido["Cantidad"];
                //         $comen = $itemPedido["comentario"];
                //         $DescripcionTicke =$modelSalon->descripcionItem($itemPedido['IdItems']);
                //         $descripcion = $DescripcionTicke["Descripcion"];
                //         $printer -> text( utf8_decode(substr($descripcion, 0, 40)) );
                //         $size = 40-(strlen($descripcion));
                //         for ($i=0; $i<$size ; $i++) { 
                //             $printer -> text( '.' );
                //         }
                //         $printer -> setJustification($justification[2]);
                //         $printer -> text($cantidad);
                //         $printer -> feed();
                //         if ($comen != NULL ){
                //             $printer -> text( substr($comen, 0, 40));
                //             $printer -> feed();
                //         }else{}
                //     }
                // }


                $printer -> feed();
                $printer -> cut();


                      // Si en las configuraciones esta registrado que puede eliminar bebida se registrara el estado de la bebida con la letra Q si con la letra D
           $respuestaPermitirEliminarBebida =modelConfiguraciones::PermitirEliminarBebida();
           $Permitir = $respuestaPermitirEliminarBebida["bebidaEliminar"];
           if($Permitir == 'N')
           {
             modelSalon::enviarPedidoBarNoPermitirBorrar($_GET["IdPedidoBar"]);
           }
           else {
             modelSalon::enviarPedidoBarPermitirBorrar($_GET["IdPedidoBar"]);
           }
                

                
                /* Close printer */
                $printer -> close();
            } catch (Exception $e) {
                echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
            }
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


                try {
                    // Enter the share name for your USB printer here
                    // $connector = null;
                       $connector = new WindowsPrintConnector("POS");
                
                    /* Print a "Hello world" receipt" */
                    $printer = new Printer($connector);
    
                  
                    /* Font modes */
                    $modes = array(
                        Printer::MODE_FONT_B,
                        Printer::MODE_EMPHASIZED,
                        Printer::MODE_DOUBLE_HEIGHT,
                        Printer::MODE_DOUBLE_WIDTH,
                        Printer::MODE_UNDERLINE);
                    /* Justification */
                    $justification = array(
                        Printer::JUSTIFY_LEFT,
                        Printer::JUSTIFY_CENTER,
                        Printer::JUSTIFY_RIGHT);
                        
                        //$printer -> setJustification($justification[1]);
                        
                    $printer -> setEmphasis(3);
                    $printer -> setJustification($justification[1]);
                    $printer -> text( $Restaurante);
                    $printer -> feed();
                    $printer -> text( 'PRE-CUENTA');
                    $printer -> feed();
                    $printer -> selectPrintMode(); // Reset
                    $printer -> setJustification($justification[0]);
                    $printer -> text( 'ATENDIO: '.$mesero);
                    $printer -> text( '          NRO MESA: '.$NumMesa['Etiqueta']);
                    $printer -> feed();
                    $printer -> text( 'FECHA: '.$fecha);
                    $printer -> text( '        HORA: '.$hora);
                    $printer -> feed();
                    $printer -> text( 'COMENSALES: '.$_GET["comensales"]);
                    $printer -> text( '            CLIENTE: '.$cliente);
                    $printer -> feed();
                    $printer -> text( "==========================================");
                    $printer -> feed();
                    $printer -> text( "CANT|  DESCRIPCION          | P.U | TOTAL");
                    $printer -> feed();
                    $printer -> text( "==========================================");
                    $printer -> feed();

                    $vistaDetallePedidosEnCaja =$modelRV->vistaDetallePedidosEnCaja($idPedido);
                    foreach($vistaDetallePedidosEnCaja as $row => $itemPedido){
                        $descripcion = $itemPedido["descripcion"];
                        $cantidad = $itemPedido["cantidad"];
                        $precio = number_format($itemPedido["precio"], 2, '.', ',');
                        $itemTotal = number_format($itemPedido["precio"]*$itemPedido["cantidad"], 2, '.', ',');
    
                        $printer -> text( $cantidad.'  ');
                        $printer -> text( utf8_decode(substr($descripcion, 0, 30)) );
                        $size = 26-(strlen($descripcion));
                        for ($i=0; $i<$size ; $i++) { 
                            $printer -> text( '.' );
                        }
                        $printer -> text( $precio.'  ');
                        $printer -> text( $itemTotal);
                        $printer -> feed();
                    }

                    $printer -> text( "==========================================");
                    $printer -> feed();
                    
                    $printer -> text("    SUB-TOTAL......................$".$subTotal);
                    $printer -> feed();
                    $printer -> text("    PROPINA........................$".$propina);
                    $printer -> feed();
                    $printer -> text("    EXENTOS........................$".$Exento);
                    $printer -> feed();
                    $printer -> setEmphasis(3);
                    $printer -> text("    TOTAL A PAGAR..................$".$total);
                    $printer -> feed();
    
                    $printer -> cut();
    
                    
    
                    
                    /* Close printer */
                    $printer -> close();
                } catch (Exception $e) {
                    echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
                }
                
            
                

            }




    }

