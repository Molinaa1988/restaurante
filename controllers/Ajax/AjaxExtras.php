<?php
  require_once "../../models/modelExtras.php";
  require_once "../../models/modelRealizarVenta.php";
  require_once "../../models/modelSalon.php";


//Para corregir error de estado de Pedido
if(isset($_POST["idPedidoCorregir"])){
  $respuestaa = modelExtras::corregirEstadoPedido($_POST["idPedidoCorregir"]);
}

if (isset($_POST['AccionAjax'])) {
  $Accion = $_POST['AccionAjax'];
  if ($Accion === 'Anular') {
    $Data = $_POST['AjaxData'];
    $Mesa = modelSalon::DetalleMesaxPedido($Data['IdPedido']);
    modelRealizarVenta::UpEstadoMesa($Mesa);
    modelExtras::DelComprobanteC($Data);
    modelExtras::DelComprobante($Data);
    modelExtras::UpPedido($Data);
    echo json_encode($Mesa);
  }elseif ($Accion === 'Permiso') {
    $password = $_POST['DtsAjax'];

    if ($password == '1237896') {
      echo 1;
    }else{
      echo 0;
    }
  }elseif ($Accion === 'Nombre') {
    $Id = $_POST['IdPedidoAjax'];
    $Nombre = $_POST['DtsAjax'];
    $R = modelRealizarVenta::NombreEdit($Id, $Nombre);
    echo $R;
  }elseif ($Accion === 'UpCxC') {
    $Dts = $_POST['DtsAjax'];
    $ids=explode(',',$Dts['IdPedido']);
    for ($i=0; $i<count($ids) ; $i++) { 
      if ($Dts['Estado'] == "P"){
       
        $R = modelRealizarVenta::updateCuenta($ids[$i], "C");

      }
      else{
        $R = modelRealizarVenta::updateCuenta2($ids[$i], "P");
      }
     
    }
    
    echo json_encode($R);

  } elseif ($Accion === 'Mesero') {
    $idPedido = $_POST['IdPedidoAjax'];
    $idMesero = $_POST['Mesero'];
    $R = modelRealizarVenta::MeseroEdit($idPedido, $idMesero);

    $Mesero = modelSalon::Mesero($idMesero);  
    echo json_encode($Mesero);
		
  }
}
