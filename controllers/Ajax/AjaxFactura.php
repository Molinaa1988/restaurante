<?php
  date_default_timezone_set('America/El_Salvador');
  setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

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
  
  
    function CalcularCeros($numeroDoc){
        if ($numeroDoc == "")
        {
              $ceros = "0001";
        }
        else if ($numeroDoc >= 0 && $numeroDoc < 10 )
        {
              $ceros = str_pad($numeroDoc, 4, "000", STR_PAD_LEFT);
        }
        else if ($numeroDoc >= 10 && $numeroDoc < 100)
        {
            $ceros = str_pad($numeroDoc, 4, "00", STR_PAD_LEFT);
        }
        else if ($numeroDoc >= 100 && $numeroDoc < 1000)
        {
              $ceros = str_pad($numeroDoc, 4, "0", STR_PAD_LEFT);
        }
        else
        {
            $ceros = $numeroDoc;
        }
            return $ceros;
    }

  if (isset($_GET['Accion'])) {
    $Accion = $_GET["Accion"];

    // pa los cortes Z 
    if ($Accion == "Z") {
        //Accion='+Accion+'&Caja='+Caja+'&Tic='+Cor
        // sscamos los valores de la URL
        $FCaja = $_GET['Caja'];
        $correlativo = $_GET['Tic'];
        $modelCierre = new modelCierre();

        if ($correlativo == ""){
          $existe = $modelCierre -> corte2($FCaja);
          $correlativo = $existe['NumeroDoc'];
        }

     
        // sacamos los valores de la caja
        $modelCaja = new modelCaja(); 
        $DtsCaja = $modelCaja->caja($FCaja);
        
        //sacar los valores del corte de comprobantec
        $r = $modelCierre -> corte($correlativo);
        
        $fechaActual = date("d/m/Y H:i", strtotime($r['Fecha']));
        $fechaA = date("d/m/Y H:i", strtotime($DtsCaja['Fecha']));
        
        $fechaC = date("d/m/Y H:i", strtotime($r['Fecha']));
        
        $modelPersonal = new modelPersonal();
        $DtsPersonal = $modelPersonal->Personal($DtsCaja['IdPersonal']);
        

        $modelCierre = new modelCierre();
        
        $DatosCorrelativoTickets = $modelCierre->DatosCorrelativoTickets2($DtsCaja['Fecha'],$r['Fecha']);
        $ti = $DatosCorrelativoTickets["Menor"];
        $tf	= $DatosCorrelativoTickets["Mayor"];
        $mayorTicket = CalcularCeros($tf);
        $DatosTotalVentaTickets= $modelCierre->DatosTotalVentaTickets2($DtsCaja['Fecha'],$r['Fecha']);
        $tTotal = $DatosTotalVentaTickets["Total"];
      
        $DatosFCF = $modelCierre->DatosFCF2($DtsCaja['Fecha'],$r['Fecha']);
        $fcfi = $DatosFCF["Menor"];
        $fcff	= $DatosFCF["Mayor"];
        $fcfTtotal = $DatosFCF["Total"];

        $DatosCCF = $modelCierre->DatosCCF2($DtsCaja['Fecha'],$r['Fecha']);
        $ccfi = $DatosCCF["Menor"];
        $ccff	= $DatosCCF["Mayor"];
        $ccfTtotal = $DatosCCF["Total"];



        class PDF extends FPDF {
          public function MyCell($w, $h, $x, $t, $cant, $aling){
            $height = $h/5;
            $first = $height + 2;
            $second = $height + $height + $height + 3;
            $third = $height + $height + $height + $height + $height + 4;
            $len = strlen($t);
  
            if ($len>$cant) {
              $txt = str_split($t,$cant);
              $this->SetX($x);
              $this->Cell($w, $first, $txt[0],'0','',$aling);
              $this->SetX($x);
              $this->Cell($w, $second, $txt[1],'0','',$aling);
              if (isset($txt[2])) {
                $this->SetX($x);
                $this->Cell($w, $third, $txt[2],'0','',$aling);
              }
              $this->SetX($x);
              $this->Cell($w, $h,'',0,1,'L',0);
            }else{
              $this->SetX($x);
              $this->Cell($w, $h,$t,0,1,$aling,0);
  
            }
          }
        }

        //acá comienza el doc
        $respuestaTicket = modelConfiguraciones::informacionTicket();
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

        //   $pdf = new FPDF();
        $pdf = new PDF('P','mm', array(80,297));
        $pdf->SetMargins(2, 2 , 2);
        $pdf->AddPage();

        $pdf->SetFont('Courier','B',12);
        $pdf->Image('../../views/dist/img/logo/'.$logo.'.jpg',15,0,50);
        $pdf->Ln(28);
        $pdf->Cell(0,5,$Restaurante,0,1,'C');
        $pdf->Ln(1);
        
        $pdf->SetFont('Courier','B',10);
        $pdf->Cell(0,5,$Contribuyente,0,1,'C');
        // $pdf->Cell(0,5,'NRC: '.$NroDeRegistro.' NIT: '.$NIT,0,1,'C');
        // $pdf->Cell(0,5,'GIRO: '.$Giro,0,1,'C');
        $pdf->SetFont('Courier','B',10);
        $pdf->Cell(0,5,$DireccionPrimeraParte,0,1,'C');
        $pdf->Cell(0,5,$DireccionSegundaParte,0,1,'C');
        
        $pdf->Cell(0,5,strtoupper("==========================================="),0,1,'C');
        $pdf->SetFont('Courier','B',14);
        $pdf->Cell(0,5,strtoupper("CORTE Z"),0,1,'C');
        $pdf->SetFont('Courier','B',10);
        $pdf->Cell(0,5,strtoupper("==========================================="),0,1,'C');
        
        $pdf->Cell(0,5,strtoupper("CAJA # 1"),0,0,'L');
        $pdf->Cell(0,5,strtoupper("Ticket: ".$correlativo),0,1,'R');
        $pdf->Cell(0,5,strtoupper("Responsable: "),0,0,'L');
        $pdf->Cell(0,5,strtoupper($DtsPersonal["Nombres"]." ".$DtsPersonal["Apellidos"]),0,1,'R');
        $pdf->Cell(0,5,strtoupper("Fecha emision:"),0,0,'L');
        $pdf->Cell(0,5,strtoupper($fechaActual),0,1,'R');
        $pdf->Cell(0,5,strtoupper("Fecha apertura:"),0,0,'L');
        $pdf->Cell(0,5,strtoupper($fechaA),0,1,'R');
        $pdf->Cell(0,5,strtoupper("Fecha cierre:"),0,0,'L');
        $pdf->Cell(0,5,strtoupper($fechaC),0,1,'R');
        $pdf->Ln(5);
        $Total = 0;

           
        $pdf->Cell(0,5,strtoupper("Ticket (TKT)"),0,1,'L');
        $pdf->Cell(5,5,strtoupper(""),0,0,'L');
        $pdf->Cell(40,5,strtoupper("Inicial"),0,0,'L');
        $pdf->Cell(15,5,strtoupper($ti),0,1,'R');
        $pdf->Cell(5,5,strtoupper(""),0,0,'L');
        $pdf->Cell(40,5,strtoupper("Final"),0,0,'L');
        $pdf->Cell(15,5,strtoupper($tf),0,1,'R');
        
        $pdf->Cell(5,5,strtoupper(""),0,0,'L');
        $pdf->Cell(40,5,'SUB TOTAL',0,0,'L');
        $pdf->Cell(15,5,'$ '.number_format($tTotal, 2),0,1,'R');
        $pdf->Ln(2);
        
        $pdf->Cell(0,5,strtoupper("Factura Consumidor Final (FCF)"),0,1,'L');
        $pdf->Cell(5,5,strtoupper(""),0,0,'L');
        $pdf->Cell(40,5,strtoupper("Inicial"),0,0,'L');
        $pdf->Cell(15,5,strtoupper($fcfi),0,1,'R');
        $pdf->Cell(5,5,strtoupper(""),0,0,'L');
        $pdf->Cell(40,5,strtoupper("Final"),0,0,'L');
        $pdf->Cell(15,5,strtoupper($fcff),0,1,'R');
        
        $pdf->Cell(5,5,strtoupper(""),0,0,'L');
        $pdf->Cell(40,5,'SUB TOTAL',0,0,'L');
        $pdf->Cell(15,5,'$ '.number_format($fcfTtotal, 2),0,1,'R');
        $pdf->Ln(2);
        
        $pdf->Cell(0,5,strtoupper("Comprobante Credito Fiscal (CCF)"),0,1,'L');
        $pdf->Cell(5,5,strtoupper(""),0,0,'L');
        $pdf->Cell(40,5,strtoupper("Inicial"),0,0,'L');
        $pdf->Cell(15,5,strtoupper($ccfi),0,1,'R');
        $pdf->Cell(5,5,strtoupper(""),0,0,'L');
        $pdf->Cell(40,5,strtoupper("Final"),0,0,'L');
        $pdf->Cell(15,5,strtoupper($ccff),0,1,'R');
        
        $pdf->Cell(5,5,strtoupper(""),0,0,'L');
        $pdf->Cell(40,5,'SUB TOTAL',0,0,'L');
        $pdf->Cell(15,5,'$ '.number_format($ccfTtotal, 2),0,1,'R');
        $pdf->Ln(2);
        

        $pdf->Cell(0,2.5,strtoupper("======================================="),0,1,'C');

        $Total=$tTotal+$ccfTtotal+$fcfTtotal;
        $pdf->Cell(26,5,'Sub Total',0,0,'L');
        $pdf->Cell(26,5,'$',0,0,'R');
        $pdf->Cell(20,5,number_format($Total, 2),0,1,'R');

        $pdf->Cell(26,5,'Venta Gravada',0,0,'L');
        $pdf->Cell(26,5,'$',0,0,'R');
        $pdf->Cell(20,5,number_format($Total, 2),0,1,'R');

        $pdf->Cell(26,5,'Venta Exenta',0,0,'L');
        $pdf->Cell(26,5,'$',0,0,'R');
        $pdf->Cell(20,5,number_format(0, 2),0,1,'R');

        $pdf->Cell(26,5,'Venta No Sujetas',0,0,'L');
        $pdf->Cell(26,5,'$',0,0,'R');
        $pdf->Cell(20,5,number_format(0, 2),0,1,'R');

        $pdf->Cell(26,5,'Menos Devolucion',0,0,'L');
        $pdf->Cell(26,5,'$',0,0,'R');
        $pdf->Cell(20,5,number_format(0, 2),0,1,'R');

        $pdf->Cell(26,5,'Venta Total',0,0,'L');
        $pdf->Cell(26,5,'$',0,0,'R');
        $pdf->Cell(20,5,number_format($Total, 2),0,1,'R');

        $pdf->Cell(26,5,'Venta Contado',0,0,'L');
        $pdf->Cell(26,5,'$',0,0,'R');
        $pdf->Cell(20,5,number_format($Total, 2),0,1,'R');

        $pdf->Cell(26,5,'Venta Credito',0,0,'L');
        $pdf->Cell(26,5,'$',0,0,'R');
        $pdf->Cell(20,5,number_format(0, 2),0,1,'R');

        


        $pdf->Output();

      
    }
    //
    elseif ($Accion == "X") {
        //Accion='+Accion+'&Caja='+Caja+'&Tic='+Cor
        // sscamos los valores de la URL
        $IdSucursal = '1';
        $FCaja = $_GET['Caja'];
        $correlativo = $_GET['Tic'];

        //sacar los valores del corte de comprobantec
        $modelCierre = new modelCierre();
        $r = $modelCierre -> corte($correlativo);
     
        // sacamos los valores de la caja
        $modelCaja = new modelCaja(); 
        $DtsCaja = $modelCaja->caja($FCaja);
        $fechaActual = date("d/m/Y H:i", strtotime($r['Fecha']));
        $fechaA = date("d/m/Y H:i", strtotime($DtsCaja['Fecha']));
        $fechaC = date("d/m/Y H:i", strtotime($r['Fecha']));
        
        $modelPersonal = new modelPersonal();
        $DtsPersonal = $modelPersonal->Personal($DtsCaja['IdPersonal']);
        
        
        $DatosCorrelativoTickets = $modelCierre->DatosCorrelativoTickets2($DtsCaja['Fecha'],$r['Fecha']);
        $ti = $DatosCorrelativoTickets["Menor"];
        $tf	= $DatosCorrelativoTickets["Mayor"];
        $mayorTicket = CalcularCeros($tf);
        $DatosTotalVentaTickets= $modelCierre->DatosTotalVentaTickets2($DtsCaja['Fecha'],$r['Fecha']);
        $tTotal = $DatosTotalVentaTickets["Total"];
      
        $DatosFCF = $modelCierre->DatosFCF2($DtsCaja['Fecha'],$r['Fecha']);
        $fcfi = $DatosFCF["Menor"];
        $fcff	= $DatosFCF["Mayor"];
        $fcfTtotal = $DatosFCF["Total"];

        $DatosCCF = $modelCierre->DatosCCF2($DtsCaja['Fecha'],$r['Fecha']);
        $ccfi = $DatosCCF["Menor"];
        $ccff	= $DatosCCF["Mayor"];
        $ccfTtotal = $DatosCCF["Total"];



        class PDF extends FPDF {
          public function MyCell($w, $h, $x, $t, $cant, $aling){
            $height = $h/5;
            $first = $height + 2;
            $second = $height + $height + $height + 3;
            $third = $height + $height + $height + $height + $height + 4;
            $len = strlen($t);
  
            if ($len>$cant) {
              $txt = str_split($t,$cant);
              $this->SetX($x);
              $this->Cell($w, $first, $txt[0],'0','',$aling);
              $this->SetX($x);
              $this->Cell($w, $second, $txt[1],'0','',$aling);
              if (isset($txt[2])) {
                $this->SetX($x);
                $this->Cell($w, $third, $txt[2],'0','',$aling);
              }
              $this->SetX($x);
              $this->Cell($w, $h,'',0,1,'L',0);
            }else{
              $this->SetX($x);
              $this->Cell($w, $h,$t,0,1,$aling,0);
  
            }
          }
        }

        //acá comienza el doc
        $respuestaTicket = modelConfiguraciones::informacionTicket();
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

        //   $pdf = new FPDF();
        $pdf = new PDF('P','mm', array(80,297));
        $pdf->SetMargins(2, 2 , 2);
        $pdf->AddPage();

        $pdf->SetFont('Courier','B',12);
        $pdf->Image('../../views/dist/img/logo/'.$logo.'.jpg',15,0,50);
        $pdf->Ln(28);
        $pdf->Cell(0,5,$Restaurante,0,1,'C');
        $pdf->Ln(1);
        
        $pdf->SetFont('Courier','B',10);
        $pdf->Cell(0,5,$Contribuyente,0,1,'C');
        // $pdf->Cell(0,5,'NRC: '.$NroDeRegistro.' NIT: '.$NIT,0,1,'C');
        // $pdf->Cell(0,5,'GIRO: '.$Giro,0,1,'C');
        $pdf->SetFont('Courier','B',10);
        $pdf->Cell(0,5,$DireccionPrimeraParte,0,1,'C');
        $pdf->Cell(0,5,$DireccionSegundaParte,0,1,'C');
        
        $pdf->Cell(0,5,strtoupper("==========================================="),0,1,'C');
        $pdf->SetFont('Courier','B',14);
        $pdf->Cell(0,5,strtoupper("CORTE X"),0,1,'C');
        $pdf->SetFont('Courier','B',10);
        $pdf->Cell(0,5,strtoupper("==========================================="),0,1,'C');
        
        $pdf->Cell(0,5,strtoupper("CAJA # 1"),0,0,'L');
        $pdf->Cell(0,5,strtoupper("Ticket: ".$correlativo),0,1,'R');
        $pdf->Cell(0,5,strtoupper("Responsable: "),0,0,'L');
        $pdf->Cell(0,5,strtoupper($DtsPersonal["Nombres"]." ".$DtsPersonal["Apellidos"]),0,1,'R');
        $pdf->Cell(0,5,strtoupper("Fecha emision:"),0,0,'L');
        $pdf->Cell(0,5,strtoupper($fechaActual),0,1,'R');
        $pdf->Cell(0,5,strtoupper("Fecha apertura:"),0,0,'L');
        $pdf->Cell(0,5,strtoupper($fechaA),0,1,'R');
        $pdf->Cell(0,5,strtoupper("Fecha cierre:"),0,0,'L');
        $pdf->Cell(0,5,strtoupper($fechaC),0,1,'R');
        $pdf->Ln(5);
        $Total = 0;

           
        $pdf->Cell(0,5,strtoupper("Ticket (TKT)"),0,1,'L');
        $pdf->Cell(5,5,strtoupper(""),0,0,'L');
        $pdf->Cell(40,5,strtoupper("Inicial"),0,0,'L');
        $pdf->Cell(15,5,strtoupper($ti),0,1,'R');
        $pdf->Cell(5,5,strtoupper(""),0,0,'L');
        $pdf->Cell(40,5,strtoupper("Final"),0,0,'L');
        $pdf->Cell(15,5,strtoupper($tf),0,1,'R');
        
        $pdf->Cell(5,5,strtoupper(""),0,0,'L');
        $pdf->Cell(40,5,'SUB TOTAL',0,0,'L');
        $pdf->Cell(15,5,'$ '.number_format($tTotal, 2),0,1,'R');
        $pdf->Ln(2);
        
        $pdf->Cell(0,5,strtoupper("Factura Consumidor Final (FCF)"),0,1,'L');
        $pdf->Cell(5,5,strtoupper(""),0,0,'L');
        $pdf->Cell(40,5,strtoupper("Inicial"),0,0,'L');
        $pdf->Cell(15,5,strtoupper($fcfi),0,1,'R');
        $pdf->Cell(5,5,strtoupper(""),0,0,'L');
        $pdf->Cell(40,5,strtoupper("Final"),0,0,'L');
        $pdf->Cell(15,5,strtoupper($fcff),0,1,'R');
        
        $pdf->Cell(5,5,strtoupper(""),0,0,'L');
        $pdf->Cell(40,5,'SUB TOTAL',0,0,'L');
        $pdf->Cell(15,5,'$ '.number_format($fcfTtotal, 2),0,1,'R');
        $pdf->Ln(2);
        
        $pdf->Cell(0,5,strtoupper("Comprobante Credito Fiscal (CCF)"),0,1,'L');
        $pdf->Cell(5,5,strtoupper(""),0,0,'L');
        $pdf->Cell(40,5,strtoupper("Inicial"),0,0,'L');
        $pdf->Cell(15,5,strtoupper($ccfi),0,1,'R');
        $pdf->Cell(5,5,strtoupper(""),0,0,'L');
        $pdf->Cell(40,5,strtoupper("Final"),0,0,'L');
        $pdf->Cell(15,5,strtoupper($ccff),0,1,'R');
        
        $pdf->Cell(5,5,strtoupper(""),0,0,'L');
        $pdf->Cell(40,5,'SUB TOTAL',0,0,'L');
        $pdf->Cell(15,5,'$ '.number_format($ccfTtotal, 2),0,1,'R');
        $pdf->Ln(2);
        

        $pdf->Cell(0,2.5,strtoupper("======================================="),0,1,'C');

        $Total=$tTotal+$ccfTtotal+$fcfTtotal;
        $pdf->Cell(26,5,'Sub Total',0,0,'L');
        $pdf->Cell(26,5,'$',0,0,'R');
        $pdf->Cell(20,5,number_format($Total, 2),0,1,'R');

        $pdf->Cell(26,5,'Venta Gravada',0,0,'L');
        $pdf->Cell(26,5,'$',0,0,'R');
        $pdf->Cell(20,5,number_format($Total, 2),0,1,'R');

        $pdf->Cell(26,5,'Venta Exenta',0,0,'L');
        $pdf->Cell(26,5,'$',0,0,'R');
        $pdf->Cell(20,5,number_format(0, 2),0,1,'R');

        $pdf->Cell(26,5,'Venta No Sujetas',0,0,'L');
        $pdf->Cell(26,5,'$',0,0,'R');
        $pdf->Cell(20,5,number_format(0, 2),0,1,'R');

        $pdf->Cell(26,5,'Menos Devolucion',0,0,'L');
        $pdf->Cell(26,5,'$',0,0,'R');
        $pdf->Cell(20,5,number_format(0, 2),0,1,'R');

        $pdf->Cell(26,5,'Venta Total',0,0,'L');
        $pdf->Cell(26,5,'$',0,0,'R');
        $pdf->Cell(20,5,number_format($Total, 2),0,1,'R');

        $pdf->Cell(26,5,'Venta Contado',0,0,'L');
        $pdf->Cell(26,5,'$',0,0,'R');
        $pdf->Cell(20,5,number_format($Total, 2),0,1,'R');

        $pdf->Cell(26,5,'Venta Credito',0,0,'L');
        $pdf->Cell(26,5,'$',0,0,'R');
        $pdf->Cell(20,5,number_format(0, 2),0,1,'R');

        $pdf->Output();

      
    }

    // para los cortes gran z
    elseif ($Accion == "granZ") {
        //Accion='+Accion+'&Mes='+Mes+'&Cor='+Cor
        // sscamos los valores de la URL
        $mes = $_GET['Mes'];
        $correlativo = $_GET['Cor'];
        
        $modelCierre = new modelCierre();
        $r= $modelCierre->corte($correlativo);
     
        $fechaActual = date("d/m/Y H:i", strtotime($r["Fecha"]));
        
        $mes1 = new DateTime($mes);
        $mes1->modify('first day of this month');
        $mes1 = $mes1->format('Y-m-d');
        
        $mes2 = new DateTime($mes);
        $mes2->modify('last day of this month');
        $mes2 = $mes2->format('Y-m-d');
        
        $mesA = date("m/Y", strtotime($mes));
        

        
        $DatosCorrelativoTickets = $modelCierre->DatosCorrelativoTickets2($mes1,$mes2);
        $ti = $DatosCorrelativoTickets["Menor"];
        $tf	= $DatosCorrelativoTickets["Mayor"];
        $mayorTicket = CalcularCeros($tf);
        $DatosTotalVentaTickets= $modelCierre->DatosTotalVentaTickets2($mes1,$mes2);
        $tTotal = $DatosTotalVentaTickets["Total"];
      
        $DatosFCF = $modelCierre->DatosFCF2($mes1,$mes2);
        $fcfi = $DatosFCF["Menor"];
        $fcff	= $DatosFCF["Mayor"];
        $fcfTtotal = $DatosFCF["Total"];

        $DatosCCF = $modelCierre->DatosCCF2($mes1,$mes2);
        $ccfi = $DatosCCF["Menor"];
        $ccff	= $DatosCCF["Mayor"];
        $ccfTtotal = $DatosCCF["Total"];



        class PDF extends FPDF {
          public function MyCell($w, $h, $x, $t, $cant, $aling){
            $height = $h/5;
            $first = $height + 2;
            $second = $height + $height + $height + 3;
            $third = $height + $height + $height + $height + $height + 4;
            $len = strlen($t);
  
            if ($len>$cant) {
              $txt = str_split($t,$cant);
              $this->SetX($x);
              $this->Cell($w, $first, $txt[0],'0','',$aling);
              $this->SetX($x);
              $this->Cell($w, $second, $txt[1],'0','',$aling);
              if (isset($txt[2])) {
                $this->SetX($x);
                $this->Cell($w, $third, $txt[2],'0','',$aling);
              }
              $this->SetX($x);
              $this->Cell($w, $h,'',0,1,'L',0);
            }else{
              $this->SetX($x);
              $this->Cell($w, $h,$t,0,1,$aling,0);
  
            }
          }
        }

        //acá comienza el doc
        $respuestaTicket = modelConfiguraciones::informacionTicket();
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

        //   $pdf = new FPDF();
        $pdf = new PDF('P','mm', array(80,297));
        $pdf->SetMargins(2, 2 , 2);
        $pdf->AddPage();

        $pdf->SetFont('Courier','B',12);
        $pdf->Image('../../views/dist/img/logo/'.$logo.'.jpg',15,0,50);
        $pdf->Ln(28);
        $pdf->Cell(0,5,$Restaurante,0,1,'C');
        $pdf->Ln(1);
        
        $pdf->SetFont('Courier','B',10);
        $pdf->Cell(0,5,$Contribuyente,0,1,'C');
        // $pdf->Cell(0,5,'NRC: '.$NroDeRegistro.' NIT: '.$NIT,0,1,'C');
        // $pdf->Cell(0,5,'GIRO: '.$Giro,0,1,'C');
        $pdf->SetFont('Courier','B',10);
        $pdf->Cell(0,5,$DireccionPrimeraParte,0,1,'C');
        $pdf->Cell(0,5,$DireccionSegundaParte,0,1,'C');
        
        $pdf->Cell(0,5,strtoupper("==========================================="),0,1,'C');
        $pdf->SetFont('Courier','B',14);
        $pdf->Cell(0,5,strtoupper("CORTE GRAN Z"),0,1,'C');
        $pdf->SetFont('Courier','B',10);
        $pdf->Cell(0,5,strtoupper("==========================================="),0,1,'C');
        
        $pdf->Cell(0,5,strtoupper("CAJA # 1"),0,0,'L');
        $pdf->Cell(0,5,strtoupper("Ticket: ".$correlativo),0,1,'R');
        $pdf->Cell(0,5,strtoupper("Fecha emision:"),0,0,'L');
        $pdf->Cell(0,5,strtoupper($fechaActual),0,1,'R');
        $pdf->Cell(0,5,strtoupper("Mes auditado: "),0,0,'L');
        $pdf->Cell(0,5,strtoupper(strftime('%B del %Y',strtotime($mes))),0,1,'R');
        $pdf->Ln(5);
        $Total = 0;

           
        $pdf->Cell(0,5,strtoupper("Ticket (TKT)"),0,1,'L');
        $pdf->Cell(5,5,strtoupper(""),0,0,'L');
        $pdf->Cell(40,5,strtoupper("Inicial"),0,0,'L');
        $pdf->Cell(15,5,strtoupper($ti),0,1,'R');
        $pdf->Cell(5,5,strtoupper(""),0,0,'L');
        $pdf->Cell(40,5,strtoupper("Final"),0,0,'L');
        $pdf->Cell(15,5,strtoupper($tf),0,1,'R');
        
        $pdf->Cell(5,5,strtoupper(""),0,0,'L');
        $pdf->Cell(40,5,'SUB TOTAL',0,0,'L');
        $pdf->Cell(15,5,'$ '.number_format($tTotal, 2),0,1,'R');
        $pdf->Ln(2);
        
        $pdf->Cell(0,5,strtoupper("Factura Consumidor Final (FCF)"),0,1,'L');
        $pdf->Cell(5,5,strtoupper(""),0,0,'L');
        $pdf->Cell(40,5,strtoupper("Inicial"),0,0,'L');
        $pdf->Cell(15,5,strtoupper($fcfi),0,1,'R');
        $pdf->Cell(5,5,strtoupper(""),0,0,'L');
        $pdf->Cell(40,5,strtoupper("Final"),0,0,'L');
        $pdf->Cell(15,5,strtoupper($fcff),0,1,'R');
        
        $pdf->Cell(5,5,strtoupper(""),0,0,'L');
        $pdf->Cell(40,5,'SUB TOTAL',0,0,'L');
        $pdf->Cell(15,5,'$ '.number_format($fcfTtotal, 2),0,1,'R');
        $pdf->Ln(2);
        
        $pdf->Cell(0,5,strtoupper("Comprobante Credito Fiscal (CCF)"),0,1,'L');
        $pdf->Cell(5,5,strtoupper(""),0,0,'L');
        $pdf->Cell(40,5,strtoupper("Inicial"),0,0,'L');
        $pdf->Cell(15,5,strtoupper($ccfi),0,1,'R');
        $pdf->Cell(5,5,strtoupper(""),0,0,'L');
        $pdf->Cell(40,5,strtoupper("Final"),0,0,'L');
        $pdf->Cell(15,5,strtoupper($ccff),0,1,'R');
        
        $pdf->Cell(5,5,strtoupper(""),0,0,'L');
        $pdf->Cell(40,5,'SUB TOTAL',0,0,'L');
        $pdf->Cell(15,5,'$ '.number_format($ccfTtotal, 2),0,1,'R');
        $pdf->Ln(2);
        

        $pdf->Cell(0,2.5,strtoupper("======================================="),0,1,'C');

        $Total=$tTotal+$ccfTtotal+$fcfTtotal;
        $pdf->Cell(26,5,'Sub Total',0,0,'L');
        $pdf->Cell(26,5,'$',0,0,'R');
        $pdf->Cell(20,5,number_format($Total, 2),0,1,'R');

        $pdf->Cell(26,5,'Venta Gravada',0,0,'L');
        $pdf->Cell(26,5,'$',0,0,'R');
        $pdf->Cell(20,5,number_format($Total, 2),0,1,'R');

        $pdf->Cell(26,5,'Venta Exenta',0,0,'L');
        $pdf->Cell(26,5,'$',0,0,'R');
        $pdf->Cell(20,5,number_format(0, 2),0,1,'R');

        $pdf->Cell(26,5,'Venta No Sujetas',0,0,'L');
        $pdf->Cell(26,5,'$',0,0,'R');
        $pdf->Cell(20,5,number_format(0, 2),0,1,'R');

        $pdf->Cell(26,5,'Menos Devolucion',0,0,'L');
        $pdf->Cell(26,5,'$',0,0,'R');
        $pdf->Cell(20,5,number_format(0, 2),0,1,'R');

        $pdf->Cell(26,5,'Venta Total',0,0,'L');
        $pdf->Cell(26,5,'$',0,0,'R');
        $pdf->Cell(20,5,number_format($Total, 2),0,1,'R');

        $pdf->Cell(26,5,'Venta Contado',0,0,'L');
        $pdf->Cell(26,5,'$',0,0,'R');
        $pdf->Cell(20,5,number_format($Total, 2),0,1,'R');

        $pdf->Cell(26,5,'Venta Credito',0,0,'L');
        $pdf->Cell(26,5,'$',0,0,'R');
        $pdf->Cell(20,5,number_format(0, 2),0,1,'R');

        


        $pdf->Output();

      
    }elseif ($Accion == "cinta") {
      $FechaI = $_GET['FechaI'];
      $FechaF = $_GET['FechaF'];

      $modelReportes = new modelReportes();
      $ids = $modelReportes -> ReporteVentasporDia1($FechaI, $FechaF); //trae las ventas

      $idsC = $modelReportes -> ReporteVentasporDia2($FechaI, $FechaF); // trae los cortes

      $size = (count($ids)*300) +(count($idsC)*300);

      $pdf = new FPDF('P','mm', array(80,$size));
      $pdf->SetMargins(2, 4 , 2);
      $pdf->AddPage();

      foreach ($ids as $key => $item) {

          // DATOS
          $idPedido = $item['IdPedido'];

          $Info = modelRealizarVenta::Pedido1($idPedido);

          if (!$Info) {
            $Info["Fecha"] = date('Y-m-d');
            $Info["Hora"] = date('H:i:s');
          }

          $fecha = $Info["Fecha"];
          $hora = substr($Info["Hora"], 0, -3);
          
          $mesero = $Info['Nombres'];
          $nrocomprobanteC = sprintf("%04d",$Info['Nro']);
          $propina = $Info['Propina'];
          $subTotal = $Info['Total'];
          $total = $Info['Total'];
          $cliente = $Info['NombreCliente'];
          $respuestaTicket = modelConfiguraciones::informacionTicket();
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


          $pdf->SetFont('arial','B',12);
          // $pdf->Image('../../views/dist/img/logo/'.$logo.'.jpeg',15,0,50);
          $pdf->Ln(2);
          $pdf->Cell(0,5,$Restaurante,0,1,'C');
          $pdf->SetFont('arial','',10);
          $pdf->Cell(0,5,$Contribuyente,0,1,'C');
          // $pdf->Cell(0,5,'NRC: '.$NroDeRegistro.' NIT: '.$NIT,0,1,'C');
          // $pdf->Cell(0,5,'GIRO: '.$Giro,0,1,'C');
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
          $vistaDetallePedidosEnCaja = modelRealizarVenta::vistaDetallePedidosEnCaja($idPedido);
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
          $pdf->Cell(13,5,0.00,0,1,'R');
          $pdf->Cell(60,5,'SUB-TOTAL NO SUJETAS...$',0,0,'R');
          $pdf->Cell(13,5,'0.00',0,1,'R');
          $pdf->Cell(60,5,'TOTAL...................................$',0,0,'R');
          $pdf->Cell(13,5,number_format($subTotal,2),0,1,'R');
          $pdf->Cell(60,5,'PROPINA..............................$',0,0,'R');
          $pdf->Cell(13,5,number_format($propina,2),0,1,'R');
          $pdf->Cell(60,5,'TOTAL A PAGAR..................$',0,0,'R');
          $pdf->Cell(13,5,number_format($total+$propina,2),0,1,'R');
          // $pdf->Cell(0,5,"G = ART. GRAVADO E = ART.EXENTO",0,1,'C');
          // $pdf->Cell(0,5,"N = NO SUJ",0,1,'C');
          if ($total > 200) {
            $pdf->Cell(0,5,"Nombre:_________________________________",0,1,'L');
            $pdf->Cell(0,5,"NIT o DUI:_______________________________",0,1,'L');
            $pdf->Cell(0,5,"FIRMA:__________________________________",0,1,'L');
          }
          // $pdf->Cell(0,5,$ResolucionPrimeraParte,0,1,'C');
          // $pdf->Cell(0,5,$ResolucionSegundaParte,0,1,'C');
          $pdf->SetFont('arial','B',9);
          $pdf->Cell(0,5,$Mensaje,0,1,'C');
          $pdf->Cell(0,5,$Mensaje2,0,1,'C');
          $pdf ->Ln(5);
      }

        foreach ($idsC as $key => $value) {
         # Code...
          if ($value['FormaPago'] == "CORTE Z") { //aca va todo de nuevo para el corte Z
            //Accion='+Accion+'&Caja='+Caja+'&Tic='+Cor
            // sscamos los valores de la URL
            $FCaja = $value['Documento'];
            $correlativo = $value['NumeroDoc'];
            
            //sacar los valores del corte de comprobantec
            $modelCierre = new modelCierre();
            $r = $modelCierre -> corte($correlativo);
        
            // sacamos los valores de la caja
            $modelCaja = new modelCaja(); 
            $DtsCaja = $modelCaja->caja($FCaja);

            $fechaActual = date("d/m/Y H:i", strtotime($value['Fecha']));
            $fechaA = date("d/m/Y H:i", strtotime($DtsCaja['Fecha']));
            $fechaC = date("d/m/Y H:i", strtotime($value['Fecha']));
            
            $modelPersonal = new modelPersonal();
            $DtsPersonal = $modelPersonal->Personal($DtsCaja['IdPersonal']);
            
            $DatosCorrelativoTickets = $modelCierre->DatosCorrelativoTickets2($DtsCaja['Fecha'],$value['Fecha']);
            $ti = $DatosCorrelativoTickets["Menor"];
            $tf	= $DatosCorrelativoTickets["Mayor"];
            $mayorTicket = CalcularCeros($tf);
            $DatosTotalVentaTickets= $modelCierre->DatosTotalVentaTickets2($DtsCaja['Fecha'],$value['Fecha']);
            $tTotal = $DatosTotalVentaTickets["Total"];
          
            $DatosFCF = $modelCierre->DatosFCF2($DtsCaja['Fecha'],$value['Fecha']);
            $fcfi = $DatosFCF["Menor"];
            $fcff	= $DatosFCF["Mayor"];
            $fcfTtotal = $DatosFCF["Total"];

            $DatosCCF = $modelCierre->DatosCCF2($DtsCaja['Fecha'],$value['Fecha']);
            $ccfi = $DatosCCF["Menor"];
            $ccff	= $DatosCCF["Mayor"];
            $ccfTtotal = $DatosCCF["Total"];

            //acá comienza el doc
            $respuestaTicket = modelConfiguraciones::informacionTicket();
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

            $pdf->SetFont('Courier','B',14);
            $pdf->Cell(0,5,$Restaurante,0,1,'C');
            $pdf->Ln(1);
            
            $pdf->SetFont('Courier','B',10);
            $pdf->Cell(0,5,$Contribuyente,0,1,'C');
            // $pdf->Cell(0,5,'NRC: '.$NroDeRegistro.' NIT: '.$NIT,0,1,'C');
            // $pdf->Cell(0,5,'GIRO: '.$Giro,0,1,'C');
            $pdf->SetFont('Courier','B',10);
            $pdf->Cell(0,5,$DireccionPrimeraParte,0,1,'C');
            $pdf->Cell(0,5,$DireccionSegundaParte,0,1,'C');
            
            $pdf->Cell(0,5,strtoupper("==========================================="),0,1,'C');
            $pdf->SetFont('Courier','B',14);
            $pdf->Cell(0,5,strtoupper("CORTE Z"),0,1,'C');
            $pdf->SetFont('Courier','B',10);
            $pdf->Cell(0,5,strtoupper("==========================================="),0,1,'C');
            
            $pdf->Cell(0,5,strtoupper("CAJA # 1"),0,0,'L');
            $pdf->Cell(0,5,strtoupper("Ticket: ".$correlativo),0,1,'R');
            $pdf->Cell(0,5,strtoupper("Responsable: "),0,0,'L');
            $pdf->Cell(0,5,strtoupper($DtsPersonal["Nombres"]." ".$DtsPersonal["Apellidos"]),0,1,'R');
            $pdf->Cell(0,5,strtoupper("Fecha emision:"),0,0,'L');
            $pdf->Cell(0,5,strtoupper($fechaActual),0,1,'R');
            $pdf->Cell(0,5,strtoupper("Fecha apertura:"),0,0,'L');
            $pdf->Cell(0,5,strtoupper($fechaA),0,1,'R');
            $pdf->Cell(0,5,strtoupper("Fecha cierre:"),0,0,'L');
            $pdf->Cell(0,5,strtoupper($fechaC),0,1,'R');
            $pdf->Ln(5);
            $Total = 0;

              
            $pdf->Cell(0,5,strtoupper("Ticket (TKT)"),0,1,'L');
            $pdf->Cell(5,5,strtoupper(""),0,0,'L');
            $pdf->Cell(40,5,strtoupper("Inicial"),0,0,'L');
            $pdf->Cell(15,5,strtoupper($ti),0,1,'R');
            $pdf->Cell(5,5,strtoupper(""),0,0,'L');
            $pdf->Cell(40,5,strtoupper("Final"),0,0,'L');
            $pdf->Cell(15,5,strtoupper($tf),0,1,'R');
            
            $pdf->Cell(5,5,strtoupper(""),0,0,'L');
            $pdf->Cell(40,5,'SUB TOTAL',0,0,'L');
            $pdf->Cell(15,5,'$ '.number_format($tTotal, 2),0,1,'R');
            $pdf->Ln(2);
            
            $pdf->Cell(0,5,strtoupper("Factura Consumidor Final (FCF)"),0,1,'L');
            $pdf->Cell(5,5,strtoupper(""),0,0,'L');
            $pdf->Cell(40,5,strtoupper("Inicial"),0,0,'L');
            $pdf->Cell(15,5,strtoupper($fcfi),0,1,'R');
            $pdf->Cell(5,5,strtoupper(""),0,0,'L');
            $pdf->Cell(40,5,strtoupper("Final"),0,0,'L');
            $pdf->Cell(15,5,strtoupper($fcff),0,1,'R');
            
            $pdf->Cell(5,5,strtoupper(""),0,0,'L');
            $pdf->Cell(40,5,'SUB TOTAL',0,0,'L');
            $pdf->Cell(15,5,'$ '.number_format($fcfTtotal, 2),0,1,'R');
            $pdf->Ln(2);
            
            $pdf->Cell(0,5,strtoupper("Comprobante Credito Fiscal (CCF)"),0,1,'L');
            $pdf->Cell(5,5,strtoupper(""),0,0,'L');
            $pdf->Cell(40,5,strtoupper("Inicial"),0,0,'L');
            $pdf->Cell(15,5,strtoupper($ccfi),0,1,'R');
            $pdf->Cell(5,5,strtoupper(""),0,0,'L');
            $pdf->Cell(40,5,strtoupper("Final"),0,0,'L');
            $pdf->Cell(15,5,strtoupper($ccff),0,1,'R');
            
            $pdf->Cell(5,5,strtoupper(""),0,0,'L');
            $pdf->Cell(40,5,'SUB TOTAL',0,0,'L');
            $pdf->Cell(15,5,'$ '.number_format($ccfTtotal, 2),0,1,'R');
            $pdf->Ln(2);
            

            $pdf->Cell(0,2.5,strtoupper("======================================="),0,1,'C');

            $Total=$tTotal+$ccfTtotal+$fcfTtotal;
            $pdf->Cell(26,5,'Sub Total',0,0,'L');
            $pdf->Cell(26,5,'$',0,0,'R');
            $pdf->Cell(20,5,number_format($Total, 2),0,1,'R');

            $pdf->Cell(26,5,'Venta Gravada',0,0,'L');
            $pdf->Cell(26,5,'$',0,0,'R');
            $pdf->Cell(20,5,number_format($Total, 2),0,1,'R');

            $pdf->Cell(26,5,'Venta Exenta',0,0,'L');
            $pdf->Cell(26,5,'$',0,0,'R');
            $pdf->Cell(20,5,number_format(0, 2),0,1,'R');

            $pdf->Cell(26,5,'Venta No Sujetas',0,0,'L');
            $pdf->Cell(26,5,'$',0,0,'R');
            $pdf->Cell(20,5,number_format(0, 2),0,1,'R');

            $pdf->Cell(26,5,'Menos Devolucion',0,0,'L');
            $pdf->Cell(26,5,'$',0,0,'R');
            $pdf->Cell(20,5,number_format(0, 2),0,1,'R');

            $pdf->Cell(26,5,'Venta Total',0,0,'L');
            $pdf->Cell(26,5,'$',0,0,'R');
            $pdf->Cell(20,5,number_format($Total, 2),0,1,'R');

            $pdf->Cell(26,5,'Venta Contado',0,0,'L');
            $pdf->Cell(26,5,'$',0,0,'R');
            $pdf->Cell(20,5,number_format($Total, 2),0,1,'R');

            $pdf->Cell(26,5,'Venta Credito',0,0,'L');
            $pdf->Cell(26,5,'$',0,0,'R');
            $pdf->Cell(20,5,number_format(0, 2),0,1,'R');

            $pdf -> Ln(5);

            
          }elseif ($value['FormaPago'] == "CORTE X") {

            //sacar los valores del corte de comprobantec
            $modelCierre = new modelCierre();
            
            // sscamos los valores de la URL
            $FCaja = $value['Documento'];
            $correlativo = $value['NumeroDoc'];
        
            //sacar los valores del corte de comprobantec
            $modelCierre = new modelCierre();
            $r = $modelCierre -> corte($correlativo);
          
            // sacamos los valores de la caja
            $modelCaja = new modelCaja(); 
            $DtsCaja = $modelCaja->caja($FCaja);
            $fechaActual = date("d/m/Y H:i", strtotime($r['Fecha']));
            $fechaA = date("d/m/Y H:i", strtotime($DtsCaja['Fecha']));
            $fechaC = date("d/m/Y H:i", strtotime($r['Fecha']));
            
            $modelPersonal = new modelPersonal();
            $DtsPersonal = $modelPersonal->Personal($DtsCaja['IdPersonal']);
            
            
            $DatosCorrelativoTickets = $modelCierre->DatosCorrelativoTickets2($DtsCaja['Fecha'],$r['Fecha']);
            $ti = $DatosCorrelativoTickets["Menor"];
            $tf	= $DatosCorrelativoTickets["Mayor"];
            $mayorTicket = CalcularCeros($tf);
            $DatosTotalVentaTickets= $modelCierre->DatosTotalVentaTickets2($DtsCaja['Fecha'],$r['Fecha']);
            $tTotal = $DatosTotalVentaTickets["Total"];
          
            $DatosFCF = $modelCierre->DatosFCF2($DtsCaja['Fecha'],$r['Fecha']);
            $fcfi = $DatosFCF["Menor"];
            $fcff	= $DatosFCF["Mayor"];
            $fcfTtotal = $DatosFCF["Total"];

            $DatosCCF = $modelCierre->DatosCCF2($DtsCaja['Fecha'],$r['Fecha']);
            $ccfi = $DatosCCF["Menor"];
            $ccff	= $DatosCCF["Mayor"];
            $ccfTtotal = $DatosCCF["Total"];


            //acá comienza el doc
            $respuestaTicket = modelConfiguraciones::informacionTicket();
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

            
            $pdf->SetFont('Courier','B',14);
            $pdf->Ln(5);
            $pdf->Cell(0,5,$Restaurante,0,1,'C');
            $pdf->Ln(1);
            
            $pdf->SetFont('Courier','B',10);
            $pdf->Cell(0,5,$Contribuyente,0,1,'C');
            // $pdf->Cell(0,5,'NRC: '.$NroDeRegistro.' NIT: '.$NIT,0,1,'C');
            // $pdf->Cell(0,5,'GIRO: '.$Giro,0,1,'C');
            $pdf->SetFont('Courier','B',10);
            $pdf->Cell(0,5,$DireccionPrimeraParte,0,1,'C');
            $pdf->Cell(0,5,$DireccionSegundaParte,0,1,'C');
            
            $pdf->Cell(0,5,strtoupper("==========================================="),0,1,'C');
            $pdf->SetFont('Courier','B',14);
            $pdf->Cell(0,5,strtoupper("CORTE X"),0,1,'C');
            $pdf->SetFont('Courier','B',10);
            $pdf->Cell(0,5,strtoupper("==========================================="),0,1,'C');
            
            $pdf->Cell(0,5,strtoupper("CAJA # 1"),0,0,'L');
            $pdf->Cell(0,5,strtoupper("Ticket: ".$correlativo),0,1,'R');
            $pdf->Cell(0,5,strtoupper("Responsable: "),0,0,'L');
            $pdf->Cell(0,5,strtoupper($DtsPersonal["Nombres"]." ".$DtsPersonal["Apellidos"]),0,1,'R');
            $pdf->Cell(0,5,strtoupper("Fecha emision:"),0,0,'L');
            $pdf->Cell(0,5,strtoupper($fechaActual),0,1,'R');
            $pdf->Cell(0,5,strtoupper("Fecha apertura:"),0,0,'L');
            $pdf->Cell(0,5,strtoupper($fechaA),0,1,'R');
            $pdf->Cell(0,5,strtoupper("Fecha cierre:"),0,0,'L');
            $pdf->Cell(0,5,strtoupper($fechaC),0,1,'R');
            $pdf->Ln(5);
            $Total = 0;

              
            $pdf->Cell(0,5,strtoupper("Ticket (TKT)"),0,1,'L');
            $pdf->Cell(5,5,strtoupper(""),0,0,'L');
            $pdf->Cell(40,5,strtoupper("Inicial"),0,0,'L');
            $pdf->Cell(15,5,strtoupper($ti),0,1,'R');
            $pdf->Cell(5,5,strtoupper(""),0,0,'L');
            $pdf->Cell(40,5,strtoupper("Final"),0,0,'L');
            $pdf->Cell(15,5,strtoupper($tf),0,1,'R');
            
            $pdf->Cell(5,5,strtoupper(""),0,0,'L');
            $pdf->Cell(40,5,'SUB TOTAL',0,0,'L');
            $pdf->Cell(15,5,'$ '.number_format($tTotal, 2),0,1,'R');
            $pdf->Ln(2);
            
            $pdf->Cell(0,5,strtoupper("Factura Consumidor Final (FCF)"),0,1,'L');
            $pdf->Cell(5,5,strtoupper(""),0,0,'L');
            $pdf->Cell(40,5,strtoupper("Inicial"),0,0,'L');
            $pdf->Cell(15,5,strtoupper($fcfi),0,1,'R');
            $pdf->Cell(5,5,strtoupper(""),0,0,'L');
            $pdf->Cell(40,5,strtoupper("Final"),0,0,'L');
            $pdf->Cell(15,5,strtoupper($fcff),0,1,'R');
            
            $pdf->Cell(5,5,strtoupper(""),0,0,'L');
            $pdf->Cell(40,5,'SUB TOTAL',0,0,'L');
            $pdf->Cell(15,5,'$ '.number_format($fcfTtotal, 2),0,1,'R');
            $pdf->Ln(2);
            
            $pdf->Cell(0,5,strtoupper("Comprobante Credito Fiscal (CCF)"),0,1,'L');
            $pdf->Cell(5,5,strtoupper(""),0,0,'L');
            $pdf->Cell(40,5,strtoupper("Inicial"),0,0,'L');
            $pdf->Cell(15,5,strtoupper($ccfi),0,1,'R');
            $pdf->Cell(5,5,strtoupper(""),0,0,'L');
            $pdf->Cell(40,5,strtoupper("Final"),0,0,'L');
            $pdf->Cell(15,5,strtoupper($ccff),0,1,'R');
            
            $pdf->Cell(5,5,strtoupper(""),0,0,'L');
            $pdf->Cell(40,5,'SUB TOTAL',0,0,'L');
            $pdf->Cell(15,5,'$ '.number_format($ccfTtotal, 2),0,1,'R');
            $pdf->Ln(2);
            

            $pdf->Cell(0,2.5,strtoupper("======================================="),0,1,'C');

            $Total=$tTotal+$ccfTtotal+$fcfTtotal;
            $pdf->Cell(26,5,'Sub Total',0,0,'L');
            $pdf->Cell(26,5,'$',0,0,'R');
            $pdf->Cell(20,5,number_format($Total, 2),0,1,'R');

            $pdf->Cell(26,5,'Venta Gravada',0,0,'L');
            $pdf->Cell(26,5,'$',0,0,'R');
            $pdf->Cell(20,5,number_format($Total, 2),0,1,'R');

            $pdf->Cell(26,5,'Venta Exenta',0,0,'L');
            $pdf->Cell(26,5,'$',0,0,'R');
            $pdf->Cell(20,5,number_format(0, 2),0,1,'R');

            $pdf->Cell(26,5,'Venta No Sujetas',0,0,'L');
            $pdf->Cell(26,5,'$',0,0,'R');
            $pdf->Cell(20,5,number_format(0, 2),0,1,'R');

            $pdf->Cell(26,5,'Menos Devolucion',0,0,'L');
            $pdf->Cell(26,5,'$',0,0,'R');
            $pdf->Cell(20,5,number_format(0, 2),0,1,'R');

            $pdf->Cell(26,5,'Venta Total',0,0,'L');
            $pdf->Cell(26,5,'$',0,0,'R');
            $pdf->Cell(20,5,number_format($Total, 2),0,1,'R');

            $pdf->Cell(26,5,'Venta Contado',0,0,'L');
            $pdf->Cell(26,5,'$',0,0,'R');
            $pdf->Cell(20,5,number_format($Total, 2),0,1,'R');

            $pdf->Cell(26,5,'Venta Credito',0,0,'L');
            $pdf->Cell(26,5,'$',0,0,'R');
            $pdf->Cell(20,5,number_format(0, 2),0,1,'R');  
            $pdf->Ln(5);


          }else if ($value['FormaPago'] == "CORTE GRAN Z") {

            // sscamos los valores de la URL
            $mes = $value['Documento'];
            $correlativo = $value['NumeroDoc'];

            $fechaActual = date("d/m/Y H:i", strtotime($value['Fecha']));
            
            $mes1 = new DateTime($mes);
            $mes1->modify('first day of this month');
            $mes1 = $mes1->format('Y-m-d');
            
            $mes2 = new DateTime($mes);
            $mes2->modify('last day of this month');
            $mes2 = $mes2->format('Y-m-d');
            
            $mesA = date("m/Y", strtotime($mes));
            

            $modelCierre = new modelCierre();
            
            $DatosCorrelativoTickets = $modelCierre->DatosCorrelativoTickets2($mes1,$mes2);
            $ti = $DatosCorrelativoTickets["Menor"];
            $tf	= $DatosCorrelativoTickets["Mayor"];
            $mayorTicket = CalcularCeros($tf);
            $DatosTotalVentaTickets= $modelCierre->DatosTotalVentaTickets2($mes1,$mes2);
            $tTotal = $DatosTotalVentaTickets["Total"];
          
            $DatosFCF = $modelCierre->DatosFCF2($mes1,$mes2);
            $fcfi = $DatosFCF["Menor"];
            $fcff	= $DatosFCF["Mayor"];
            $fcfTtotal = $DatosFCF["Total"];

            $DatosCCF = $modelCierre->DatosCCF2($mes1,$mes2);
            $ccfi = $DatosCCF["Menor"];
            $ccff	= $DatosCCF["Mayor"];
            $ccfTtotal = $DatosCCF["Total"];

            //acá comienza el doc
            $respuestaTicket = modelConfiguraciones::informacionTicket();
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

            $pdf->SetFont('Courier','B',12);
            $pdf->Ln(5);
            $pdf->Cell(0,5,$Restaurante,0,1,'C');
            $pdf->Ln(1);
            
            $pdf->SetFont('Courier','B',10);
            $pdf->Cell(0,5,$Contribuyente,0,1,'C');
            // $pdf->Cell(0,5,'NRC: '.$NroDeRegistro.' NIT: '.$NIT,0,1,'C');
            // $pdf->Cell(0,5,'GIRO: '.$Giro,0,1,'C');
            $pdf->SetFont('Courier','B',10);
            $pdf->Cell(0,5,$DireccionPrimeraParte,0,1,'C');
            $pdf->Cell(0,5,$DireccionSegundaParte,0,1,'C');
            
            $pdf->Cell(0,5,strtoupper("==========================================="),0,1,'C');
            $pdf->SetFont('Courier','B',14);
            $pdf->Cell(0,5,strtoupper("CORTE GRAN Z"),0,1,'C');
            $pdf->SetFont('Courier','B',10);
            $pdf->Cell(0,5,strtoupper("==========================================="),0,1,'C');
            
            $pdf->Cell(0,5,strtoupper("CAJA # 1"),0,0,'L');
            $pdf->Cell(0,5,strtoupper("Ticket: ".$correlativo),0,1,'R');
            $pdf->Cell(0,5,strtoupper("Fecha emision:"),0,0,'L');
            $pdf->Cell(0,5,strtoupper($fechaActual),0,1,'R');
            $pdf->Cell(0,5,strtoupper("Mes auditado: "),0,0,'L');
            $pdf->Cell(0,5,strtoupper(strftime('%B del %Y',strtotime($mes))),0,1,'R');
            $pdf->Ln(5);
            $Total = 0;

              
            $pdf->Cell(0,5,strtoupper("Ticket (TKT)"),0,1,'L');
            $pdf->Cell(5,5,strtoupper(""),0,0,'L');
            $pdf->Cell(40,5,strtoupper("Inicial"),0,0,'L');
            $pdf->Cell(15,5,strtoupper($ti),0,1,'R');
            $pdf->Cell(5,5,strtoupper(""),0,0,'L');
            $pdf->Cell(40,5,strtoupper("Final"),0,0,'L');
            $pdf->Cell(15,5,strtoupper($tf),0,1,'R');
            
            $pdf->Cell(5,5,strtoupper(""),0,0,'L');
            $pdf->Cell(40,5,'SUB TOTAL',0,0,'L');
            $pdf->Cell(15,5,'$ '.number_format($tTotal, 2),0,1,'R');
            $pdf->Ln(2);
            
            $pdf->Cell(0,5,strtoupper("Factura Consumidor Final (FCF)"),0,1,'L');
            $pdf->Cell(5,5,strtoupper(""),0,0,'L');
            $pdf->Cell(40,5,strtoupper("Inicial"),0,0,'L');
            $pdf->Cell(15,5,strtoupper($fcfi),0,1,'R');
            $pdf->Cell(5,5,strtoupper(""),0,0,'L');
            $pdf->Cell(40,5,strtoupper("Final"),0,0,'L');
            $pdf->Cell(15,5,strtoupper($fcff),0,1,'R');
            
            $pdf->Cell(5,5,strtoupper(""),0,0,'L');
            $pdf->Cell(40,5,'SUB TOTAL',0,0,'L');
            $pdf->Cell(15,5,'$ '.number_format($fcfTtotal, 2),0,1,'R');
            $pdf->Ln(2);
            
            $pdf->Cell(0,5,strtoupper("Comprobante Credito Fiscal (CCF)"),0,1,'L');
            $pdf->Cell(5,5,strtoupper(""),0,0,'L');
            $pdf->Cell(40,5,strtoupper("Inicial"),0,0,'L');
            $pdf->Cell(15,5,strtoupper($ccfi),0,1,'R');
            $pdf->Cell(5,5,strtoupper(""),0,0,'L');
            $pdf->Cell(40,5,strtoupper("Final"),0,0,'L');
            $pdf->Cell(15,5,strtoupper($ccff),0,1,'R');
            
            $pdf->Cell(5,5,strtoupper(""),0,0,'L');
            $pdf->Cell(40,5,'SUB TOTAL',0,0,'L');
            $pdf->Cell(15,5,'$ '.number_format($ccfTtotal, 2),0,1,'R');
            $pdf->Ln(2);
            

            $pdf->Cell(0,2.5,strtoupper("======================================="),0,1,'C');

            $Total=$tTotal+$ccfTtotal+$fcfTtotal;
            $pdf->Cell(26,5,'Sub Total',0,0,'L');
            $pdf->Cell(26,5,'$',0,0,'R');
            $pdf->Cell(20,5,number_format($Total, 2),0,1,'R');

            $pdf->Cell(26,5,'Venta Gravada',0,0,'L');
            $pdf->Cell(26,5,'$',0,0,'R');
            $pdf->Cell(20,5,number_format($Total, 2),0,1,'R');

            $pdf->Cell(26,5,'Venta Exenta',0,0,'L');
            $pdf->Cell(26,5,'$',0,0,'R');
            $pdf->Cell(20,5,number_format(0, 2),0,1,'R');

            $pdf->Cell(26,5,'Venta No Sujetas',0,0,'L');
            $pdf->Cell(26,5,'$',0,0,'R');
            $pdf->Cell(20,5,number_format(0, 2),0,1,'R');

            $pdf->Cell(26,5,'Menos Devolucion',0,0,'L');
            $pdf->Cell(26,5,'$',0,0,'R');
            $pdf->Cell(20,5,number_format(0, 2),0,1,'R');

            $pdf->Cell(26,5,'Venta Total',0,0,'L');
            $pdf->Cell(26,5,'$',0,0,'R');
            $pdf->Cell(20,5,number_format($Total, 2),0,1,'R');

            $pdf->Cell(26,5,'Venta Contado',0,0,'L');
            $pdf->Cell(26,5,'$',0,0,'R');
            $pdf->Cell(20,5,number_format($Total, 2),0,1,'R');

            $pdf->Cell(26,5,'Venta Credito',0,0,'L');
            $pdf->Cell(26,5,'$',0,0,'R');
            $pdf->Cell(20,5,number_format(0, 2),0,1,'R');

            $pdf->Ln(5);


          }
        }  
          
        $pdf->Output();

    }        

      
}
?>
