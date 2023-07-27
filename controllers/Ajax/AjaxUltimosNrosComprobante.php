<?php

  require_once "../../models/modelRealizarVenta.php";
  
  $modelRV = new modelRealizarVenta();

  if(isset($_POST["ticket"])){
    $Res = array();
    $respuesta = $modelRV->UltimoComprobanteTicket1(); //Para tabla comprobante
    $respuestaC = $modelRV->UltimoComprobanteTicket2(); //Para tabla comprobantec
    
    if ($respuestaC > $respuesta) { //por los cortes que no se guardan en la tabla de comprobantes
       
      $ceros= CalcularCeros($respuesta["NumeroDoc"]);
      $ceros= CalcularCeros($respuestaC["NumeroDoc"]);
      
      $Res['Comprobante'] = $ceros.$respuestaC["NumeroDoc"];
      $Res['ComprobanteC'] = $ceros.$respuestaC["NumeroDoc"];

   } else {
      
      $ceros= CalcularCeros($respuesta["NumeroDoc"]);
      $ceros= CalcularCeros($respuestaC["NumeroDoc"]);
      
      $Res['Comprobante'] = $ceros.$respuesta["NumeroDoc"];
      $Res['ComprobanteC'] = $ceros.$respuestaC["NumeroDoc"];
      
   }
      echo json_encode($Res);
  }

  if(isset($_POST["otro"])){
   $Res = array();
   $respuesta = $modelRV->UltimoComprobanteOtro(); //Para tabla comprobante otros
   $respuestaC = $modelRV->UltimoComprobanteOtro1(); //Para tabla comprobantec otros
   
   if ($respuestaC > $respuesta) { //por los cortes que no se guardan en la tabla de comprobantes
       
      $ceros= CalcularCeros($respuesta["NumeroDoc"]);
      $ceros= CalcularCeros($respuestaC["NumeroDoc"]);
      
      $Res['Comprobante'] = $ceros.$respuestaC["NumeroDoc"];
      $Res['ComprobanteC'] = $ceros.$respuestaC["NumeroDoc"];

   } else {
      
      $ceros= CalcularCeros($respuesta["NumeroDoc"]);
      $ceros= CalcularCeros($respuestaC["NumeroDoc"]);
      
      $Res['Comprobante'] = $ceros.$respuesta["NumeroDoc"];
      $Res['ComprobanteC'] = $ceros.$respuestaC["NumeroDoc"];
   
   }   

   echo json_encode($Res);
 }
  
  // if(isset($_POST["ticket2"])){
  //   // echo $ceros.$respuesta["NumeroDoc"];
  //   echo json_encode($ceros.$respuesta["NumeroDoc"]);

  // }

  if(isset($_POST["fcf"])){
  // $respuesta = $modelRV->UltimoComprobanteFCF();
  // $ceros= CalcularCeros($respuesta["NumeroDoc"]);
  // echo $ceros.$respuesta["NumeroDoc"];

  }

  if(isset($_POST["ccf"])){
    // $respuesta = $modelRV->UltimoComprobanteCFF();
    // $ceros= CalcularCeros($respuesta["NumeroDoc"]);
    // echo $ceros.$respuesta["NumeroDoc"];

  }

  function CalcularCeros($numeroDoc)
{
  $ceros = 0;
  if ($numeroDoc == "")
  {
     $ceros = "0001";
  }
  else if ($numeroDoc >= 0 && $numeroDoc < 10 )
  {
     $ceros = "000";
  }

  else if ($numeroDoc >= 10 && $numeroDoc < 100)
  {
     $ceros = "00";
  }
  else if ($numeroDoc >= 100 && $numeroDoc < 1000)
  {
     $ceros = "0";
  }
  else if ($numeroDoc > 1000)
  {
     $ceros = "";
  }
    return $ceros;
}

?>
