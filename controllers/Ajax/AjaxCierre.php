<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  
  
  require "../../vendor/autoload.php";


  date_default_timezone_set('America/El_Salvador');

  require_once "../../views/src/fpdf/fpdf.php";
  require_once "../../models/modelSalon.php";
  require_once "../../models/modelCaja.php";
  require_once "../../models/modelReportes.php";
  require_once "../../models/modelRealizarVenta.php";
  
  require_once "../../models/modelCierre.php";
  require_once "../../models/modelInventario.php";
  require_once "../../controllers/controllerInventario.php";
  require_once "../../models/modelConfiguraciones.php";
  require_once "../../controllers/controllerGastoIngreso.php";
  require_once "../../models/modelGastoIngreso.php";
  
  require __DIR__ . '../../../views/autoload.php';
  
  $modelCierre = new modelCierre();

  $respuestaTicket= modelConfiguraciones::informacionTicket();
  $Restaurante = $respuestaTicket["Restaurante"];
  $Contribuyente = $respuestaTicket["Contribuyente"];
  $NroDeRegistro= $respuestaTicket["NroDeRegistro"];
  $NIT = $respuestaTicket["NIT"];
  $Giro = $respuestaTicket["Giro"];
  $Direccion = $respuestaTicket["Direccion"];
  $Resolucion = $respuestaTicket["Resolucion"];
  $Mensaje= $respuestaTicket["Mensaje"];
  $Mensaje2= $respuestaTicket["Mensaje2"];

  //include("../../views/mail/sendemail.php");//Mando a llamar la funcion que se encarga de enviar el correo electronico

  // ----------------------------------------------- ** funcion reporteElectronicoAjax();
  if(isset($_POST["mensajeAjax"])){ //Inicio del reporte electronico y de papel
    
    ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );

    $respuestaCorreo = modelConfiguraciones::configuracionesCorreo();
		$EmailEmisor = $respuestaCorreo["EmailEmisor"];
		$Contrasena = $respuestaCorreo["Contrasena"];
		$EmailReceptor = $respuestaCorreo["EmailReceptor"];
    /*Configuracion de variables para enviar el correo*/
    $mail_username=$EmailEmisor;//Correo electronico saliente ejemplo: tucorreo@gmail.com
    $mail_userpassword=$Contrasena;//Tu contraseña de gmail
    $mail_addAddress=$EmailReceptor;//correo electronico que recibira el mensaje

    $template="../../views/mail/email_template.php";//Ruta de la plantilla HTML para enviar nuestro mensaje


    if (isset($_POST["fa"])) {
      $fechai=$_POST["fa"];
      $fechar=date("Y-m-d H:i:s");
    } 

    if (isset($_POST["caa"])) {
      $id = $_POST["caa"];
      $caja = modelCaja::caja($id);
    }          
      
    //CICLOS FOR PARA CARGAR EL HTML
    $Resumen = array(
      "E" => 0,
      "T" => 0,
      "ET" => 0,
      "CH" => 0,
      "CR" => 0,
      "H"  => 0
    );

    $respuesta1 = modelCierre::correoresumenticket($fechai,$fechar);
    foreach($respuesta1 as $row => $item){
     $t .="<tr><td class='tg-0pky'>".$item['NumeroDoc']."</td>";
     if ($item['FormaPago']=="E"){
       $t .= "<td class='tg-0pky' colspan='2'>EFECTIVO</td>";
       $Resumen["E"] += $item["TotalPagar"];
         
     }elseif($item['FormaPago']=="CR"){
       $t .= "<td class='tg-0pky' colspan='2'>CRÉDITO</td>";
       $Resumen["CR"] += $item["TotalPagar"];

     }elseif($item['FormaPago']=="T"){
       $t .= "<td class='tg-0pky' colspan='2'>TARJETA</td>";
       $Resumen["T"] += $item["TotalPagar"];
         
     }elseif($item['FormaPago']=="BTC"){
       $t .= "<td class='tg-0pky' colspan='2'>BTC</td>";
       $Resumen["T"] += $item["TotalPagar"];
         
     }elseif($item['FormaPago']=="CH"){
       $t .= "<td class='tg-0pky' colspan='2'>TRANSACCIÓN</td>";
       $Resumen["CH"] += $item["TotalPagar"];
         
     }elseif($item['FormaPago']=="H"){
       $t .= "<td class='tg-0pky' colspan='2'>HUGO</td>";
       $Resumen["H"] += $item["TotalPagar"];
         
     }
    
     $t .=  "<td class='tg-0pky'>$".$item['Total']."</td></tr>";
     
     $totalTicket=$totalTicket+$item['Total'];
     $PropinaTKT += $item["Propina"];
    }
    
    $respuestaOtros = modelCierre::correoresumenotros($fechai,$fechar);
    foreach($respuestaOtros as $row => $item){
     $tOt .="<tr><td class='tg-0pky'>".$item['NumeroDoc']."</td>";
     if ($item['FormaPago']=="E"){
       $tOt .= "<td class='tg-0pky' colspan='2'>EFECTIVO</td>";
       $Resumen["E"] += $item["TotalPagar"];
         
     }elseif($item['FormaPago']=="CR"){
       $tOt .= "<td class='tg-0pky' colspan='2'>CRÉDITO</td>";
       $Resumen["CR"] += $item["TotalPagar"];

     }elseif($item['FormaPago']=="T"){
       $tOt .= "<td class='tg-0pky' colspan='2'>TARJETA</td>";
       $Resumen["T"] += $item["TotalPagar"];
         
     }elseif($item['FormaPago']=="CH"){
       $tOt .= "<td class='tg-0pky' colspan='2'>TRANSACCIÓN</td>";
       $Resumen["CH"] += $item["TotalPagar"];
         
     }elseif($item['FormaPago']=="H"){
       $tOt .= "<td class='tg-0pky' colspan='2'>HUGO</td>";
       $Resumen["H"] += $item["TotalPagar"];
         
     }
    
     $tOt .=  "<td class='tg-0pky'>$".$item['Total']."</td></tr>";
     
     $totalOt=$totalOt+$item['Total'];
     $PropinaOt += $item["Propina"];
    }


    $totalfcf;
    $respuesta2 = modelCierre::correoresumenfcf($fechai,$fechar);
    foreach($respuesta2 as $row => $item){
     $fcf .="<tr><td class='tg-0pky'>".$item['NumeroDoc']."</td>";
     if ($item['FormaPago']=="E"){
      $fcf .= "<td class='tg-0pky' colspan='2'>EFECTIVO</td>";
      $Resumen["E"] += $item["TotalPagar"];
         
    }elseif($item['FormaPago']=="CR"){
      $fcf .= "<td class='tg-0pky' colspan='2'>CREDITO</td>";
      $Resumen["CR"] += $item["TotalPagar"];
         
    }elseif($item['FormaPago']=="T"){
      $fcf .= "<td class='tg-0pky' colspan='2'>TARJETA</td>";
      $Resumen["T"] += $item["TotalPagar"];
         
    }elseif($item['FormaPago']=="BTC"){
      $fcf .= "<td class='tg-0pky' colspan='2'>BTC</td>";
      $Resumen["BTC"] += $item["TotalPagar"];
         
    }elseif($item['FormaPago']=="CH"){
      $fcf .= "<td class='tg-0pky' colspan='2'>TRANSACCION</td>";
      $Resumen["CH"] += $item["TotalPagar"];
         
    }elseif($item['FormaPago']=="H"){
      $fcf .= "<td class='tg-0pky' colspan='2'>HUGO</td>";
      $Resumen["H"] += $item["TotalPagar"];
         
    }
     $fcf .= "<td class='tg-0pky'>$".$item['Total']."</td></tr>";
     
     $totalfcf=$totalfcf+$item['Total'];
     $PropinaFCF += $item["Propina"];
    }

    $totalccf;
    $respuesta3 = modelCierre::correoresumenccf($fechai,$fechar);
     foreach($respuesta3 as $row => $item){
      $ccf .=  "<tr><td class='tg-0pky'>".$item['NumeroDoc']."</td>";
      if ($item['FormaPago']=="E"){
        $ccf .= "<td class='tg-0pky' colspan='2'>EFECTIVO</td>";
        $Resumen["E"] += $item["TotalPagar"];
                 
      }elseif($item['FormaPago']=="CR"){
        $ccf .= "<td class='tg-0pky' colspan='2'>CREDITO</td>";
        $Resumen["CR"] += $item["TotalPagar"];
         
      }elseif($item['FormaPago']=="T"){
        $ccf .= "<td class='tg-0pky' colspan='2'>TARJETA</td>";
        $Resumen["T"] += $item["TotalPagar"];
          
      }elseif($item['FormaPago']=="BTC"){
        $ccf .= "<td class='tg-0pky' colspan='2'>BTC</td>";
        $Resumen["T"] += $item["TotalPagar"];
          
      }elseif($item['FormaPago']=="CH"){
        $ccf .= "<td class='tg-0pky' colspan='2'>TRANSACCIÓN</td>";
        $Resumen["CH"] += $item["TotalPagar"];
         
      }elseif($item['FormaPago']=="H"){
        $ccf .= "<td class='tg-0pky' colspan='2'>HUGO</td>";
        $Resumen["H"] += $item["TotalPagar"];
         
      }
       $ccf .= "<td class='tg-0pky'>$".$item['Total']."</td></tr>";
       
       $totalccf=$totalccf+$item['Total'];
       $PropinaCCF += $item["Propina"];
     }

         //pa las CxC
    $respuesta13= controllerGastoIngreso::vistaCxcc($fechai);
    $TotalCxcc = 0;
      foreach ($respuesta13 as $row => $item) {
        $Cxcc .= "<tr><td class='tg-0pky' colspan='3'>".$item['NumeroDoc']."</td>";
        $Cxcc .= "<td class='tg-0pky'>$".$item['TotalPagar']."</td></tr>";
        $TotalCxcc=$TotalCxcc+$item['TotalPagar'];
      }
     
    //parra agregar los otros ingresos 
     $respuesta6= modelCierre::correoresumenIngresos($fechai);
     foreach($respuesta6 as $row => $item){
      $Ing .= "<tr><td class='tg-0pky' colspan='3'>".$item['Descripcion']."</td>";
      $Ing .= "<td class='tg-0pky'>$".$item['Monto']."</td></tr>";
      $TotalIng=$TotalIng+$item['Monto'];
     }

     $totalVentas = $totalTicket+$totalfcf+$totalccf+$totalOt;
     $totalIngresos = $totalVentas+$TotalIng+$TotalCxcc;
     $TP=$PropinaTKT+$PropinaFCF+$PropinaCCF+$PropinaOt;

     $detalles='';
     $Index = array('E', 'T', 'ET', 'BTC', 'CR', 'CH', 'H');
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
                        $F = "TRANSACCION";
                      }elseif ($Index[$i] == "CR") {
                        $F = "CREDITO";
                      }elseif($Index[$i] == "H"){
                        $F= "HUGO";
                      }
                      if ($Index[$i] != "ET") {
                        $detalles .="<tr><td colspan ='3' align='right'>".$F." </td>";
                        $detalles .="<td> $ ".$Resumen[$Index[$i]]."</td></tr>";
                        $Sum += $Resumen[$Index[$i]];
                      }
                    }

                    $totalRes="<tr><td colspan='3' align='right'> TOTAL $</td> <td>".$Sum."</td></tr>";

                      //para las cortesias
  
      $respuesta7 = modelCierre::correoresumenCor($fechai, $fechar);
      foreach($respuesta7 as $row => $item){
        $Cor .= "<tr><td colspan='3'>".$item['IdPedido']."</td>";
        $Cor .= "<td>".$item['Total']."</td></tr>";
        $TotalCor=$TotalCor+$item['Total'];
      }

      //para los créditos
    $respuesta8 = modelCierre::correoresumenCr($fechai, $fechar);
    foreach($respuesta8 as $row => $item){
      $Cre .= "<tr><td colspan='3'>".$item['IdPedido']."</td>";
      $Cre .= "<td>".$item['Total']."</td></tr>";
      $TotalCre=$TotalCre+$item['Total'];
    }
  
    //PA EL HUGO

    $respuesta9 = modelCierre::correoresumenHugo($fechai, $fechar);
    foreach($respuesta9 as $row => $item){
      $Hug .= "<tr><td colspan='3'>".$item['IdPedido']."</td>";
      $Hug .= "<td>".$item['Total']."</td></tr>";
      $TotalHug=$TotalHug+$item['Total'];
    }

    $respuesta4 = modelCierre::correoresumenCompras($fechai);
      foreach($respuesta4 as $row => $item){
      $Compras .= "<tr><td>".$item['NroComprobante']."</td>";
      $Compras .= "<td colspan='2'>".$item['TipoDoc']."</td>";
      $Compras .= "<td>".$item['Total']."</td></tr>";
      $TotalCompras=$TotalCompras+$item['Total'];
      }
        
    $respuesta5 = modelCierre::correoresumenGastos($fechai);
      foreach($respuesta5 as $row => $item){
      $Gastos .= "<tr><td colspan='3'>".$item['Descripcion']."</td>";
      $Gastos .= "<td>".$item['Monto']."</td></tr>";
      $TotalGastos=$TotalGastos+$item['Monto'];
      }

      $totalIng2 = $totalIng+$TotalCxcc;
      $totalEgresos = $TotalCompras+$TotalGastos;
      $bal = $totalIngresos-$totalEgresos;
    
    //el resumen de platos y bebidas vendidas
    $respuesta10 = modelReportes::ReportePlatosMasVendidos($fechai, $fechar);
      foreach($respuesta10 as $row => $item){
      $Pla .= "<tr><td>".$item['Descripcion']."</td>";
      $Pla .= "<td>".$item['Cantidad']."</td>";
      $Pla .= "<td>".$item['PrecioVenta']."</td>";
      $Pla .= "<td>".$item['Total']."</td></tr>";
      $TotalPla=$TotalPla+$item['Total'];
      }
    
    //bebidas
    $respuesta11 = modelReportes::ReporteBebidasMasVendidas($fechai, $fechar);
      foreach($respuesta11 as $row => $item){
      $Beb .= "<tr><td>".$item['Descripcion']."</td>";
      $Beb .= "<td>".$item['Cantidad']."</td>";
      $Beb .= "<td>".$item['PrecioVenta']."</td>";
      $Beb .= "<td>".$item['Total']."</td></tr>";
      $TotalBeb=$TotalBeb+$item['Total'];
      }
      
    //stock ingredientes
    $respuesta12 = modelReportes::ReporIng();
      foreach($respuesta12 as $row => $item){
      $Sto .= "<tr><td colspan='2'>".$item['DescripcionIng']."</td>";
      $Sto .= "<td>".$item['UnidadMedida']."</td>";
      $Sto .= "<td>".$item['Cantidad']."</td></tr>";
      }


     
  //lo mismo pero en HTML
    $txt_message="
  <table class='tg'>
    <thead>
      <tr>
        <th class='tg-0pky' colspan='4'><center>TIERRAMAR USULUTAN <br> RESUMEN DIARIO <br>".$fechai."</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class='tg-c3ow' colspan='4'><center>---------------------------------- INGRESOS ------------------------------</td>
      </tr>
      <tr>
        <td class='tg-0pky' colspan='4'>TICKETS</td>
      </tr>
      <tr>
        <td class='tg-0pky'>NUMERO # || </td>
        <td class='tg-0pky' colspan='2'>FORMA DE PAGO || </td>
        <td class='tg-0pky'>MONTO</td>
      </tr>"
      //tickets
      .$t."<tr>
        <td class='tg-c3ow' colspan ='3'><center>TOTAL</td>
        <td class='tg-0pky'>$".$totalTicket."</td>
      </tr>
      <tr>
      <tr>
        <td class='tg-0pky' colspan='4'>OTROS</td>
      </tr>
      <tr>
        <td class='tg-0pky'>NUMERO # || </td>
        <td class='tg-0pky' colspan='2'>FORMA DE PAGO || </td>
        <td class='tg-0pky'>MONTO</td>
      </tr>"
      //OTROS
      .$tOt."<tr>
        <td class='tg-c3ow' colspan ='3'><center>TOTAL</td>
        <td class='tg-0pky'>$".$totalOt."</td>
      </tr>
      <tr>
        <td class='tg-0pky' colspan='4'><br>FACTURA CONSUMIDOR FINAL</td>
      </tr>
      <tr>
        <td class='tg-0pky'>NUMERO # || </td>
        <td class='tg-0pky' colspan='2'> FORMA DE PAGO || </td>
        <td class='tg-0pky'>MONTO</td>
      </tr>"
      //fcfs
      .$fcf."<tr>
        <td class='tg-c3ow' colspan ='3'><center>TOTAL</td>
        <td class='tg-0pky'>$".$totalfcf."</td>
      </tr>
      <tr>
        <td class='tg-0pky' colspan='4'><br>COMPROBANTE CREDITO FISCAL</td>
      </tr>
      <tr>
        <td class='tg-0pky'>NUMERO # || </td>
        <td class='tg-0pky' colspan='2'>FORMA DE PAGO || </td>
        <td class='tg-0pky'>MONTO</td>
      </tr>"
      //Ccfs
      .$ccf."<tr>
        <td class='tg-c3ow' colspan ='3'><center>TOTAL</td>
        <td class='tg-0pky'>$".$totalccf."</td>
      </tr>
      <tr>
        <td class='tg-0pky' colspan='4'><br>CXC CANCELADAS</td>
      </tr>
      <tr>
        <td class='tg-0pky' colspan='3'>NUMERO # || </td>
        <td class='tg-0pky'>MONTO</td>
      </tr>"//pa las Cxcc
      .$Cxcc."
      <tr><td colspan='3' align='right'> TOTAL </td><td> $ ".$TotalCxc."</td></tr>
      <br><tr>
        <td class='tg-0pky' colspan='4'><br>OTROS INGRESOS</td>
      </tr>
      <tr>
        <td class='tg-0pky' colspan='3'>DESCRIPCION || </td>
        <td class='tg-0pky'>MONTO</td>
      </tr>"//pa los otros ing
      .$Ing."
      <tr><td colspan='3' align='right'> TOTAL </td><td> $ ".$TotalIng2."</td></tr>
      <br><br><tr>
        <td class='tg-c3ow' colspan ='3' align='right'>SUBTOTAL      </td>
        <td class='tg-0pky'>$".$totalVentas."</td>
      </tr>
      <tr>
        <td class='tg-c3ow' colspan ='3' align='right'>PROPINA      </td>
        <td class='tg-0pky'>$".$TP."</td>
      </tr>
      <tr>
        <td class='tg-c3ow' colspan ='3'align='right'>OTROS INGRESOS      </td>
        <td class='tg-0pky'>$".$TotalIng."</td>
      </tr>
      <tr>
      <td class='tg-c3ow' colspan ='3' align='right'>TOTAL INGRESOS      </td>
      <td class='tg-0pky'>$".$totalIngresos."</td>
    </tr><br>
    <tr>
        <td class='tg-0pky' colspan='4'><center>--------------------DETALLE DE FORMAS DE PAGO------------------</td>
      </tr>".
      $detalles.$totalRes
    ."<tr>
      <td class='tg-0pky' colspan='4' align='center'><br>---------------------VENTAS DE CORTESIA------------------------------</td>
    </tr>
    <tr>
      <td class='tg-0pky' colspan='3'>PEDIDO #  </td>
      <td class='tg-0pky'> || MONTO</td>
    </tr>"
    //CORTESIAS
    .$Cor."<tr>
      <td class='tg-c3ow' colspan ='3' align='right'>TOTAL</td>
      <td class='tg-0pky'>$".$TotalCor."</td>
    </tr>
    <tr>
      <td class='tg-0pky' colspan='4' align='center'><br>---------------------------VENTAS AL CREDITO---------------------------</td>
    </tr>
    <tr>
      <td class='tg-0pky' colspan='3'>PEDIDO #  </td>
      <td class='tg-0pky'> || MONTO</td>
    </tr>"
    //CREDITOS
    .$Cre."<tr>
      <td class='tg-c3ow' colspan ='3'align='right'>TOTAL</td>
      <td class='tg-0pky'>$".$TotalCre."</td>
    </tr><tr>
    <td class='tg-0pky' colspan='4' align='center'><br>---------------------------VENTAS POR HUGO-------------------------</td>
    </tr>
    <tr>
      <td class='tg-0pky' colspan='3'>PEDIDO #  </td>
      <td class='tg-0pky'> || MONTO</td>
    </tr>"
    //hUGO
    .$Hug."<tr>
      <td class='tg-c3ow' colspan ='3' align='right'>TOTAL</td>
      <td class='tg-0pky'>$".$TotalHug."</td>
    </tr><br><br>
    <tr>
      <td class='tg-c3ow' colspan='4'><center>---------------------------------- EGRESOS ------------------------------</td>
    </tr>
    <tr>
      <td class='tg-0pky' colspan='4'>COMPRAS</td>
    </tr>
    <tr>
      <td class='tg-0pky'>NÚMERO # || </td>
      <td class='tg-0pky' colspan='2'>TIPO COMPROBANTE || </td>
      <td class='tg-0pky'>MONTO</td>
    </tr>"
    //compras
    .$Compras."<tr>
      <td class='tg-c3ow' colspan ='3' align='right'>TOTAL COMPRAS</td>
      <td class='tg-0pky'>$".$TotalCompras."</td>
    </tr><br>
    <tr>
    <td class='tg-0pky' colspan='4'>GASTOS</td>
    </tr>
    <tr>
      <td class='tg-0pky' colspan='3'>DESCRIPCION </td>
      <td class='tg-0pky'> || MONTO</td>
    </tr>"
    //GASTOS
    .$Gastos."<tr>
      <td class='tg-c3ow' colspan ='3' align='right'>TOTAL GASTOS</td>
      <td class='tg-0pky'>$".$TotalGastos ."</td>
    </tr><br>
    <tr>
      <td class='tg-c3ow' colspan ='3' align='right'>TOTAL EGRESOS</td>
      <td class='tg-0pky'>$".$totalEgresos."</td>
    </tr><br>
    <tr>
      <td class='tg-c3ow' colspan='4'><center>---------------------------------- BALANCE------------------------------</td>
    </tr>
    <tr><td colspan='3' align='right'> CAJA INICIAL </td><td>$".$caja['MontoApertura']."</td></tr> 
    <tr><td colspan='3' align='right'> TOTAL INGRESOS </td><td>$".$totalIngresos."</td></tr>  
    <tr><td colspan='3' align='right'> TOTAL EGRESOS </td><td>$".$totalEgresos."</td></tr>
    <tr><td colspan='3' align='right'> BALANCE </td><td>$".$bal."</td></tr><br>  
    <tr>
      <td class='tg-c3ow' colspan='4'><center>---------------------------------- RESUMEN ------------------------------</td>
    </tr><br>  
    <tr>
      <td class='tg-0pky' colspan='4'>PLATOS VENDIDOS</td>
    </tr>
    <tr>
      <td class='tg-0pky'>NOMBRE </td>
      <td class='tg-0pky'> || C. </td>
      <td class='tg-0pky'> || P. </td>
      <td class='tg-0pky'> || MONTO</td>
    </tr>" //platos
    .$Pla."<tr>
      <td class='tg-c3ow' colspan ='3' align='right'>TOTAL EN PLATOS</td>
      <td class='tg-0pky'>$".$TotalPla."</td>
    </tr><br>
    <tr>
      <td class='tg-0pky' colspan='4'>BEBIDAS VENDIDAS</td>
    </tr>
    <tr>
      <td class='tg-0pky'>NOMBRE </td>
      <td class='tg-0pky'> || C. </td>
      <td class='tg-0pky'> || P. </td>
      <td class='tg-0pky'> || MONTO</td>
    </tr>" //bebidas
    .$Beb."<tr>
      <td class='tg-c3ow' colspan ='3'><center>TOTAL EN BEBIDAS</td>
      <td class='tg-0pky'>$".$TotalBeb."</td>
    </tr><br>        

    <tr>
      <td class='tg-c3ow' colspan='4'><center>---------------------- STOCK INGREDIENTES -------------</td>
    </tr><br>  
    <tr>
      <td class='tg-0pky' colspan ='2'>INGREDIENTE </td>
      <td class='tg-0pky'> || MEDIDA </td>
      <td class='tg-0pky'> || STOCK</td>
    </tr>" //ingredienetes
    .$Sto."<br>
   
    </tbody>
    </table>";

    $mail_subject="RESUMEN DE VENTAS DE ".$fechai.' A '.$fechar;
  
        $respuestaCorreo = modelConfiguraciones::configuracionesCorreo();
        $EmailEmisor = $respuestaCorreo["EmailEmisor"];
        $Contrasena = $respuestaCorreo["Contrasena"];
        $EmailReceptor = $respuestaCorreo["EmailReceptor"];
        /*Configuracion de variables para enviar el correo*/
        $mail_username=$EmailEmisor;//Correo electronico saliente ejemplo: tucorreo@gmail.com
        $mail_userpassword=$Contrasena;//Tu contraseña de gmail
        $mail_addAddress=$EmailReceptor;//correo electronico que recibira el mensaje
    
    //llamado a la funcion que envía el correo y hace el pdf     
      hacerPdf($apdf, $txt_message, $mail_username, $mail_userpassword, $mail_addAddress);       

  }
  
  // ----------------------------------------------- **  AQUI TERMINA LA funcion reporteElectronicoAjax();


 

    // ---------------------------------------- ACÁ COMIENZA LA FUNCION AUTODESCONTAR -------------------------
    if (isset($_POST["fechai"])) {
      $fechai=$_POST["fechai"];
      $ids = array();
      $totales = array(); 
      $idsP = array();
      //este es por si hay ingredientes repetidos
      $respuesta = modelInventario::vistaIngredientesUsadosS($fechai);
      foreach($respuesta as $row => $item){
      $ids[$row]=$item['IdIngredientes']; 
      $totales[$row]=$item['Total'];
      //y esta para los pedidos
      $respuesta2 = modelInventario::vistaIngredientesUsados($fechai);
      foreach ($respuesta2 as $row => $item2) {
        $idsP[$row]=$item2['IdPedido'];
      }
      }
      var_dump ($ids);
      var_dump ($totales);
      var_dump ($idsP);
      for($i=0;$i<count($ids); $i++){
          $r = modelInventario::descontarIngredientes($ids[$i], $totales[$i]);
          echo "for1";
      }
      for ($i=0;$i<count($idsP);$i++){
      $r1 =  modelInventario::actualizarItemsDescontados($idsP[$i]);
      echo "for2";
      }
          echo $r1;
          echo $r;
      
    }

    if(isset($_POST["IdFCajaReaperturar"])){
      modelCaja::ReAperturaCaja($_POST["IdFCajaReaperturar"]);
      $respuest = modelCaja::ultimoIdcomprobanteC();
      $IdcomprobanteC = array("IdcomprobanteC"=>$respuest["IdcomprobanteC"]);
      // $respuesta =  modelCaja::EliminarUltimoIdcomprobanteC($IdcomprobanteC); //creo que esto era para borrar el corte al reaperturar una caja
      // peros se pasa y borra pedidos
    }

        
    // y a apartir de aca los voy a distinguir por accion
    // agregar a la tabla de registros
    if (isset($_POST["accion"])) {
      $accion=$_POST["accion"];

      // cierre de caja y nada mas
      if($accion=="cierre"){
        $caja = $_POST["caja"];
        $modelCierre = new modelCierre(); 
        $modelCierre->CierreCaja($caja);

      }

      if($accion=="Z"){
        $caja = $_POST["caja"];
        $cor = $_POST["cor"];
        $y= date("Y-m-d H:i:s");
        $z =  "CORTE Z";
        $doc = $caja;
        
        $respuesta = modelCierre::registroDeCortes2($cor,$y,$z,$doc);
        
      }  
      
      if($accion=="granZ"){
        
        $cor = $_POST["cor"];
        $y = date("Y-m-d H:i:s");
        $z =  "CORTE GRAN Z";
        $doc = $_POST["mes"];
        
        $respuesta = modelCierre::registroDeCortes2($cor,$y,$z, $doc);
        
      }  
      
      if($accion=="X"){
        
        $caja = $_POST["caja"];
        $cor = $_POST["cor"];
        $y = date("Y-m-d H:i:s");
        $z =  "CORTE X";
        $doc = $caja;
      
        $respuesta = modelCierre::registroDeCortes2($cor,$y,$z, $doc);
      
      }  


    }



        
        function hacerPdf($apdf, $txt_message, $mail_username,$mail_userpassword, $mail_addAddress){
                
                  if (isset($_POST["fa"])) {
                    $fechai=$_POST["fa"];
                  $fechar=date("Y-m-d H:i:s");
                  }
                  
                  if (isset($_POST["caa"])) {
                    $id = $_POST["caa"];
                    $caja = modelCaja::caja($id);
                  }          
                     
                    $pdf = new FPDF('P','mm',array(80,297));
                    $pdf->AddPage();
                    $pdf->SetMargins(4, 2, 0);
                    $pdf->Ln(5);
                    $pdf->SetFont('Helvetica','B',14);
                    $pdf->Cell(72,4,'TIERRAMAR USULUTAN',0,1,'C');
                    $pdf->SetFont('Helvetica','B',10);
                    $pdf->Cell(72,4,'RESUMEN DIARIO',0,1,'C');
                    $pdf->Cell(72,4,$fechai,0,1,'C');
                    $pdf->Ln(5);
                    $pdf->Cell(72,4,'*************************   INGRESOS   *************************',0,1,'C');
                    $pdf->Cell(76,4,'TICKETS',0,1,'L');
                    $pdf->Cell(20,4,'Numero #',0,0,'L');
                    $pdf->Cell(4,4,'||',0,0,'R');
                    $pdf->Cell(25,4,'Forma de  pago',0,0,'C');
                    $pdf->Cell(4,4,'||',0,0,'R');
                    $pdf->Cell(19,4,'Monto',0,1,'R');
                    $TKT = modelCierre::correoresumenticket($fechai, $fechar);
                    $TotalTKT = 0;
                    $PropinaTKT = 0;
                    $ResumenTKT = array(
                      "E" => 0,
                      "T" => 0,
                      "BTC" => 0,
                      "ET" => 0,
                      "CH" => 0,
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
                      }else if ($value["FormaPago"] == "CR"){
                        $F = "CREDITO";
                        $ResumenTKT["CR"] += $value["TotalPagar"];
                        //$F = $value["FormaPago"];
                      }else if ($value["FormaPago"] == "H"){
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

                     //para los otros
                    $pdf->Ln(5);
                    $pdf->Cell(76,4,'OTROS',0,1,'L');
                    $pdf->Cell(20,4,'Numero #',0,0,'L');
                    $pdf->Cell(4,4,'||',0,0,'R');
                    $pdf->Cell(25,4,'Forma de  pago',0,0,'C');
                    $pdf->Cell(4,4,'||',0,0,'R');
                    $pdf->Cell(19,4,'Monto',0,1,'R');
                    
                    $modelCierre = new modelCierre();
                    $O = $modelCierre->correoresumenotros($caja['Fecha'], $caja['HoraCierre']);
                    $TotalO = 0;
                    $PropinaO = 0;
                    
                    foreach ($O as $key => $value) {
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
                      }
                      // else if ($value["FormaPago"] == "CR"){
                      //   $F = "CREDITO";
                      //   $ResumenO["CR"] += $value["TotalPagar"];
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
                      $TotalO += $value["Total"];
                      $PropinaO += $value["Propina"];
                    }
                    $pdf->Cell(53,4,'TOTAL $',0,0,'R');
                    $pdf->Cell(19,4,number_format($TotalO,2),0,1,'R');

                    $pdf->Ln(5);

                    $pdf->Ln(5);
                    $pdf->Cell(76,4,'FACTURAS CONSUMIDOR FINAL(FCF)',0,1,'L');
                    $pdf->Cell(20,4,'Numero #',0,0,'L');
                    $pdf->Cell(4,4,'||',0,0,'R');
                    $pdf->Cell(25,4,'Forma de Pago',0,0,'C');
                    $pdf->Cell(4,4,'||',0,0,'R');
                    $pdf->Cell(19,4,'Monto',0,1,'R');
                    $FCF = modelCierre::correoresumenfcf($fechai, $fechar);
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
                    $CCF = modelCierre::correoresumenccf($fechai, $fechar);
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
                     
                    $Cxc = controllerGastoIngreso::vistaCxcc($fechai);
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
                  
                    $Ingresos = modelCierre::correoresumenIngresos($fechai);
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



                    $TIngreso = $TG + $TP + $TotalIngresos+$TotalCxc;
                    $pdf->Cell(53,4,'TOTAL INGRESO $',0,0,'R');
                    $pdf->Cell(19,4,number_format($TIngreso,2),0,1,'R');

                    $pdf->Ln(5);
                    $pdf->Cell(72,4,'*************************   DETALLE   *************************',0,1,'C');

                    $Index = array('E', 'T', 'ET', 'BTC', 'CR', 'CH', 'H');
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


                    
                    $COR = modelCierre::correoresumenCor($fechai, $fechar);
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


                    
                    $HUG = modelCierre::correoresumenHugo($fechai, $fechar);
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
            
            
                        
                        $HUG = modelCierre::correoresumenCr($fechai, $fechar);
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
                    $Compras = modelCierre::correoresumenCompras($fechai);
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
                    $Gastos = modelCierre::correoresumenGastos($fechai);
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
                    $pdf->Cell(19,4,number_format($TIngreso - $TEgreso,2),0,1,'R');
                    
                    
                    
                    $PlatosMasVendido = modelReportes::ReportePlatosmasVendidos($fechai, $fechar);
                    
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
                      $pdf->Cell(42,4,substr(utf8_decode($plato['Descripcion']), 0, 19),0,0,'L');
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

                    $BebidasMasVendido = modelReportes::ReporteBebidasmasVendidas($fechai, $fechar);

                    
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

                    $Ingredientes = modelReportes::ReporIng();

                    foreach ($Ingredientes as $key => $ing) {
                      $pdf->Cell(30,4,substr(utf8_decode($ing['DescripcionIng']), 0, 12),0,0,'L');
                      $pdf->Cell(25,4,$ing['UnidadMedida'],0,0,'R');
                      $pdf->Cell(18,4,$ing['Cantidad'],0,1,'R');
                    }

                    $apdf = $pdf->Output('prueba','S');
                    
                  //$fechai = $_GET["fechai"];
                  $mail = new PHPMailer(true);
                  
                  //$data = ( string ) $pdf  ;
                  
                  try {
                      //Server settings
                      $mail->SMTPDebug = 2;                      //Enable verbose debug output
                      $mail->isSMTP();                                            //Send using SMTP
                      $mail->Host       = 'smtp.gmail.com';                     //mail.gpoaviles.com o smtp.gmail.com
                      $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                      $mail->Username   = $mail_username;                     //SMTP username
                      $mail->Password   = $mail_userpassword;                               //SMTP password
                      $mail->SMTPSecure = 'tls';         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                      $mail->Port       = 587;                                    //587 google 26 para gpoaviles
                  
                      //Recipients
                      $mail->setFrom($mail_username, 'GPOAVILES');
                      $mail->addAddress($mail_addAddress, 'TIERRAMAR USULUTAN');     //Add a recipient
                      $mail->addCC('rafawork01@gmail.com');
                      
                      //Attachments
                      
                      //Content
                      $mail->isHTML(true);                                  //Set email format to HTML
                      $mail->Subject = 'TIERRAMAR USULUTAN REPORTE DIARIO - '.$fechai.'';
                      $mail->Body    = $txt_message;
                      $mail->AltBody = strip_tags($txt_message);
                  
                      $mail->addStringAttachment($apdf, 'reporte - '.$fechai.'.pdf');

                      $mail->send();
                      //echo 'Message has been sent';
                  } catch (Exception $e) {
                      //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                  }   
                }

              
            
          
        
?>
