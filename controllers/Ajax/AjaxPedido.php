<?php
  date_default_timezone_set('America/El_Salvador');
  require_once "../../models/modelRealizarVenta.php";
  require_once "../../models/modelSalon.php";
  require_once "../../models/modelCaja.php";
  require_once "../../models/modelConfiguraciones.php";
  
  $modelConfig = new modelConfiguraciones();
  $modelSalon = new modelSalon();



  if (isset($_POST["AccionAjax"])) {
    $Accion = $_POST['AccionAjax'];
    if ($Accion === 'Yes') {
      $respuesta = modelRealizarVenta::vistaPedidosEnCaja();
      //$R = array($respuesta);
      //clearstatcache();
      //echo "1";
      echo json_encode($respuesta);
      //var_dump($respuesta);
    }elseif ($Accion === 'Cuentas') {
      $Mesa = $_POST['mesa'];
      $Cuentas = modelSalon::pedidosPorMesa($Mesa);
      $ListCuentas = array();
      $ult = 0;
      $i = 0;
      foreach ($Cuentas as $key => $value) {
        $Tipo = 'btn-primary';
        $Style = '';
        if ($value['IdPedido'] === $_POST['pedidoActual']) {
          $Tipo = 'btn-default disabled';
          $Style = 'style="border-style: solid;border-width: 2px;border-color: black;"';
        }
        if ($value['IdPedido'] != $_POST['pedidoActual'] && $i === 0) {
          $ult = $value['IdPedido'];
          $i++;
        }
        $ListCuentas[$key] = array(
          "IdPedido" => $value['IdPedido'],
          "Nombre" => $value['NombreCliente'],
          "Tipo" => $Tipo,
          "Style" => $Style,
          "Ult" => $ult
        );
      }
      echo json_encode($ListCuentas);
    }elseif ($Accion === 'CrearCuentas') {
      $IdPersonal = $_POST['idPersonal'];
      $R1 = modelSalon::crearPedido($IdPersonal);
      if ($R1 === 'success') {
        $IdMesa = $_POST['idMesa'];
        $IdPedido = modelSalon::ultimoIdPedido();
        $R2 = modelSalon::crearDetalleMesa($IdMesa, $IdPedido[0]);
      }
      $Json["Mensaje"] = $R1;
      echo json_encode($Json);
    }elseif ($Accion === 'Platos') {
      $Categoria = modelSalon::ListadoCategorias();
      $Json = array();

      foreach ($Categoria as $key => $value) {
        $expanded = false;
        if ($key === 0) {
          $expanded = true;
        }
        // $Nombre = utf8_encode(ucfirst(strtolower($value[1])));
        $Nombre = utf8_encode(ucfirst(strtolower($value[1])));
        $Platos = array();
        $GetPlatos = modelSalon::ListadoPlatos($value[0]);

        foreach ($GetPlatos as $keyP => $valueP) {
          $Platos[$keyP] = array(
            "IdPlato" => $valueP['IdItems'],
            "Plato" => utf8_encode($valueP['Descripcion']),
            "Precio" => $valueP['PrecioVenta'],
            "FP" => $valueP['FormaDePreparar']
          );
        }

        $Json[$key] = array(
          "IdCategoria" => $value[0],
          "Nombre" => $Nombre,
          "Lugar" => $value[2],
          "expanded" => $expanded,
          "Platos" => $Platos
        );
      }

      echo json_encode($Json);
    }elseif ($Accion === 'DetallePedido') {
      $IdPedido = $_POST['idPedido'];
      $DetallePedido = modelSalon::idDetallePedido($IdPedido);
      $Json = array();
      $FechaActual = new DateTime(date("Y-m-d H:i:s"));

      // $timer = 360000;
      foreach ($DetallePedido as $key => $value) {
        $Plato = modelSalon::descripcionItem($value['IdItems']);
        $label = '';
        $ico = '';
        if ($value['Estado'] === 'M' || $value['Estado'] === 'B') {
          $label = 'default';
        }elseif ($value['Estado'] === 'S' || $value['Estado'] === 'P') {
          $label = 'primary';
          $ico = '<i class="fa fa-spinner fa-spin" aria-hidden="true"></i>';

          $FechaBD = new DateTime($value['Cambios']);
          $Trans = $FechaBD->diff($FechaActual);

          if($Trans->i >= 5){
            $label = 'success';
            $ico = '<i class="fa fa-check" aria-hidden="true"></i>';
          }

          // if($Trans->i < 5){
          //   $mult = $Trans->i;
          //   // if($mult === 0){
          //   //   $mult = 0.5;
          //   // }
          //   $mult = 5 - $mult;
          //   $res = $mult * 60000;
          //   if ($res < $timer) {
          //     $timer = $res;
          //   }

          // }

        }elseif ($value['Estado'] === 'D' || $value['Estado'] === 'Q') {
          $label = 'success';
          $ico = '<i class="fa fa-check" aria-hidden="true"></i>';
        }elseif ($value['Estado'] === 'A') {
          $label = 'danger tachado';
          $ico = '<i class="fa fa-ban" aria-hidden="true"></i>';
          $Plato['PrecioVenta'] = 0.00;
        }

        $Btn1 = '';
        $id = $value['IdDetallePedido'];
        if ($value['Estado'] === 'A' || $value['Estado'] === 'B' || $value['Estado'] === 'M') {
          $Btn1 = '<div class="btn-group" role="group">
          <button type="button" class="btn btn-info" onclick="editMensaje(\''.$value["comentario"].'\', \''.$value["Cantidad"].'\', \''.$value["IdDetallePedido"].'\')">
          <b><i class="fa fa-commenting-o"></i></b>
          </button>
          </div>
          <div class="btn-group" role="group">
          <button type="button" class="btn btn-danger" onclick="eliminarPlatoList('.$id.')">
          <b><i class="fa fa-times"></i></b>
          </button>
          </div>';
        }elseif ($value["Estado"] === 'P' || $value["Estado"] === 'Q' || $value["Estado"] === 'S') {
          $Btn1 = '<div class="btn-group" role="group">
          <button type="button" class="btn btn-warning" onclick="CredencialUser('.$id.', \'A\', \'XPlato\')">
          <b><i class="fa fa-exclamation"> </i></b>
          </button>
          </div>';
        }
        $Btn2 = '';
        if ($value['Estado'] === 'M' || $value['Estado'] === 'B') {
          $Btn2 = '<div class="btn-group" role="group">
          <button type="button" class="btn btn-primary" onclick="getDtsEdit('.$id.')">
          <b><i class="fa fa-pencil"> </i></b>
          </button>
          </div>';
        }
        $Accion = $Btn2.$Btn1;

        $Json[$key] = array(
          "IdDetallePedido" => $value['IdDetallePedido'],
          "IdItem" => $value['IdItems'],
          "Plato" => utf8_encode($Plato['Descripcion']),
          "Cantidad" => $value['Cantidad'],
          "Precio" => $Plato['PrecioVenta'],
          "Mensaje" => $value['comentario'],
          "Estado" => $value['Estado'],
          "Label" => $label,
          "Ico" => $ico,
          "Accion" => $Accion
        );
      }
      $JsonF['ListPlato'] = $Json;
      $JsonF['Timer'] = 0;
      echo json_encode($JsonF);
    }elseif ($Accion === 'AddDetallePartida') {
	    // Modificado 27/11/20
      $Add = modelSalon::AddDetallePedido($_POST['Data']);
      $Cant = modelSalon::DetalleEnviado($_POST['Data']);
      if ($Cant['Cant'] != 0) {
        $Id =  modelSalon::UltDetalleRegistardo($_POST['Data']);
        modelSalon::UpnewAdd($Id['IdDetallePedido'], date('Y-m-d H:i:s'));
      }
      $Json['Mensaje'] = $Add;
      echo json_encode($Json);
    }elseif($Accion === 'DelDetallePartida'){
      $IdPedido = $_POST['IdPedido'];
      $Mesa = $_POST['Mesa'];
      $Json['TblDetallePedido'] = modelSalon::eliminarDetallePedido($IdPedido);
      $Json['TblDetalleMesa'] = modelSalon::eliminarDetalleMesa($IdPedido);
      // no se que hace pero esa consulta no existe
      //$Json['TblUpPedido'] = modelSalon::UpEstadoPedido($IdPedido);
      $Json['TblPedido'] = modelSalon::eliminarPedido($IdPedido);
      $Mesas = modelSalon::pedidosPorMesa($Mesa);
      if (count($Mesas) <= 0) {
        $Dts = array(
          "Estado" => 'L',
          "NroMesa" => $Mesa
        );
        $Json["TblMesa"] = modelSalon::cambioEstadoMesa($Dts);
      }
      echo json_encode($Json);
    }elseif ($Accion === 'SendDetallePartida') {
      $IdPedido = $_POST['IdPedido'];
      $getEstado = $_POST['Estado'];
      $DetallePedido = modelSalon::idDetallePedido($IdPedido);
      $Json = array();
      $Bebida = 0;
      foreach ($DetallePedido as $key => $value) {


        $Estado = $value['Estado'];
        if ($Estado === 'B') {
          $Bebida++;
        }

        if ($Estado === 'M') {
          $Estado = 'S';
        }

        // Anula todos pedidos
        if ($getEstado === 'A') {
          $Estado = 'A';
        }

        if($value['newadd'] != null){
          modelSalon::UpnewAdd($value['IdDetallePedido'], date('Y-m-d H:i:s'));
        }

        $Json[$key]= modelSalon::UpEstadoDetallePedido($value['IdDetallePedido'], $Estado);
      }
      $Json['Bebidas'] = $Bebida;
      echo json_encode($Json);

     
   


    }elseif ($Accion === 'DelPlatoList') {
      $IdPlato = $_POST['IdPlato'];
      $data = array("IdDetallePedido" => $IdPlato);
      $Json['Mensaje'] = modelSalon::borrarDetallePedido($data);
      echo json_encode($Json);
    }elseif ($Accion === 'UpEstadoDetallePlato') {
      $Id = $_POST['Id'];
      $Estado = $_POST['Estado'];
      $Json['Mensaje'] = modelSalon::UpEstadoDetallePedido($Id, $Estado);
      echo json_encode($Json);
    }elseif ($Accion === 'getDtsEdit') {
      $IdDetallePedido = $_POST['Id'];

      $DetallePedidio = modelSalon::DetallePedido($IdDetallePedido);

      $Json['IdDetallePedido'] =  $DetallePedidio['IdDetallePedido'];
      $Json['Comentario'] = $DetallePedidio['comentario'];
      $Json['Cantidad'] = $DetallePedidio['Cantidad'];


      echo json_encode($Json);
    }elseif ($Accion === 'updateDetallePedido') {
      $Json['Mensaje'] = modelSalon::ActualizarDP($_POST['Data']);
      echo json_encode($Json);
    }elseif ($Accion === 'timestamp') {
      set_time_limit(0);

      $fecha_ac = isset($_POST['timeStamp']) ? $_POST['timeStamp']:0;
      $Datos = modelSalon::cambioDetallePedido();
      $Json['timestamp'] = null;

      if ($Datos) {
        $fecha_bd = $Datos['Cambios'];
        $Cant = modelSalon::CountDetallePedido();
        $CantI = $Cant['Cant'];
        while ($fecha_bd <= $fecha_ac) {
          $Res = modelSalon::cambioDetallePedido();
          $CanN = modelSalon::CountDetallePedido();


          $cambios = isset($Res['Cambios']) ? $Res['Cambios'] : null;
          $cantbd = $CanN['Cant'] ? $CanN['Cant'] : 0;

          usleep(100000);
          clearstatcache();
          if ($fecha_bd > $cambios) {
            break;
          }
          if ($CantI != $cantbd) {
            break;
          }
          $fecha_bd = $Res['Cambios'];
        }


        $Json['timestamp'] = $Datos['Cambios'];
      }


      echo json_encode($Json);
    }elseif ($Accion === 'updateMsm') {
      $Json['Mensaje'] = modelSalon::ActualizarDP($_POST['AjaxData']);
      echo json_encode($Json);
    }elseif ($Accion === 'Trasladar') {
      $Dts = $_POST['DtsAjax'];

      // echo  json_encode($Dts['IdPedidos']);


      $Res = array();
      foreach ($Dts['IdPedidos'] as $key => $value) {
        $DtPedido = modelSalon::DetallePedido($Dts['IdDetallePedido']);

        $DtsAdd = array(
          "IdPedido" => $value,
          "IdPlato" => $DtPedido['IdItems'],
          "Cantidad" => $Dts['Cantidades'][$value],
          "Precio" => $DtPedido['Precio'],
          "Comentario" => $DtPedido['comentario'],
          "Estado" => $DtPedido['Estado']
        );


        $Id =  modelSalon::UltDetalleRegistardo($DtsAdd);
        modelSalon::UpnewAdd($Id['IdDetallePedido'], date('Y-m-d H:i:s'));

        $NewCant = $DtPedido['Cantidad'] - $Dts['Cantidades'][$value];

        $DtsUp = array(
          "IdDetallePedido" => $Dts['IdDetallePedido'],
          "Cantidad" => $NewCant,
          "Comentario" => $DtPedido['comentario']
        );
        modelSalon::AddDetallePedido($DtsAdd);

        if ($DtsUp['Cantidad'] == 0) {
          modelSalon::borrarDetallePedido($DtsUp);
        }else{
          modelSalon::ActualizarDP($DtsUp);
        }
      }
      echo 'OK';
      // echo json_encode($res);
      // $res[$key] = $DtsUp;
      // echo json_encode($DtsUp);
    }elseif ($Accion == "ListCaja") {
      $Fecha = $_POST['Fecha'];
      $Json = modelCaja::iDCajas($Fecha);
      echo json_encode($Json);
    }
  }
?>
