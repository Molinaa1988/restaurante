<?php
    session_start();
    require_once '../../models/modelRealizarVenta.php';

    if (isset($_POST['AccionAjax'])) {
        $Accion = $_POST['AccionAjax'];
        if ($Accion === 'RealizarVenta') {
            // Registrar en Tabla Comprobante C
            $Dts = $_POST['DtsAjax'];


            if ($Dts["formaPago"] == "Cor") {
                modelRealizarVenta::registrarCortesias($Dts);
                
                
                $Mesa = modelRealizarVenta::nroMesa($Dts["idPedido"]);
                $datosMesaActualizar = array( "id" => $Mesa["NroMesa"]);
 
                if($Mesa["naturaleza"] == "L"){
                    $R = modelRealizarVenta::actualizarEstadoMesa($datosMesaActualizar);
                }else{
                    $cantidadCuentas = 0;
                    $respuesta = modelRealizarVenta::pedidosPorMesaCaja($Mesa["NroMesa"]);
                    foreach($respuesta as $row => $item){
                        $cantidadCuentas++;
                    }
    
                    if($cantidadCuentas == 1){
                      $R = modelRealizarVenta::actualizarEstadoMesa($datosMesaActualizar);
                    }
                }
                
                
                modelRealizarVenta::actualizarEstadoPedido(array("id" => $Dts['idPedido']));
                echo json_encode(array(
                    "status" => true,
                    "resp" => 0
                ));
 
                
     
 
 
                exit();
            }





            $valueUnique = 0;
            $getLastValue = modelRealizarVenta::evitarDuplicacionC();

            if ($getLastValue['evitarDuplicacion']) {
                $valueUnique = $getLastValue['evitarDuplicacion'];
            }else{
                $valueUnique = 0;
            }
            
            // if (!$Dts['Buscar']) {
            //     $
            // }
            $SubTotal = ($Dts['TotalPagar'] - $Dts['Propina']) + $Dts['Exentos'] + $Dts['Retencion'];
            $dtsSave = array(
                "idpedido"=>$Dts["idPedido"],
                "nrocomprobante"=>$Dts["nrocomprobanteC"],
                "total"=> $SubTotal,
                "formapago"=>$Dts["formaPago"],
                "comprobante"=>$Dts["comprobante"],
                "propina"=>$Dts['Propina'],
                "importe"=>$Dts['Importe'],
                "totalpagar"=>$Dts['TotalPagar'],
                "evitarDuplicacion"=>$valueUnique,
                "cliente"=>$Dts["Cliente"],
                "nrc" => $Dts['Buscar'],
                "idCliente" => $Dts['BuscarN']
                
            );
            
            $DtsPedido = modelRealizarVenta::getPedido($dtsSave['idpedido']);
            $dtsSave["Fecha"] = $DtsPedido['FechaPedido'];
            $dtsSave["FechaFact"] = date('Y-m-d H:i:s');
            
            $cont = 0;

            if ($Dts["comprobante"] == "T" OR $Dts["comprobante"] == "O" ) {
                $Existe = modelRealizarVenta::ComprobanteC($dtsSave['idpedido']);
                $DtsPedido = modelRealizarVenta::getPedido($dtsSave['idpedido']);
                $dtsSave["Fecha"] = $DtsPedido['FechaPedido'];
                $dtsSave["FechaFact"] = date('Y-m-d H:i:s');
                $respuesta = '';
                $respuesta = '';
                
                if ($Existe) {
                    var_dump($dtsSave);
                    $respuesta =  modelRealizarVenta::UPregistroCompra($dtsSave, $Existe['IdcomprobanteC']);
                    if ($Dts["formaPago"] == "CR"){
                        modelRealizarVenta::Resgistrarcuentasporcobrar($dtsSave);
                    }
                    else if ($Dts["formaPago"] == "H"){
                        modelRealizarVenta::RegistrarCxcHugo($dtsSave);
                    }        
                    
                }else{
                    $respuesta = modelRealizarVenta::registroCompra($dtsSave);
                    if ($Dts["formaPago"] == "CR"){
                        modelRealizarVenta::Resgistrarcuentasporcobrar($dtsSave);
                    }
                    else if ($Dts["formaPago"] == "H"){
                            modelRealizarVenta::RegistrarCxcHugo($dtsSave);
                        } 
                    }
                
    
                if($respuesta == "success"){
                    $cont++;
                }
            }

            $datosControllerCajero = array(
                "idpedido"=>$dtsSave["idpedido"],
                "IdUsuario"=>$_SESSION["idusuario"]
            );
            modelRealizarVenta::cajeroQueRealizoVenta($datosControllerCajero);
            $Mesa = modelRealizarVenta::nroMesa($Dts["idPedido"]);
            $datosMesaActualizar = array( "id" => $Mesa["NroMesa"]);

            if($Mesa["naturaleza"] == "L"){
                $R = modelRealizarVenta::actualizarEstadoMesa($datosMesaActualizar);
            }else{
                $cantidadCuentas = 0;
                $respuesta = modelRealizarVenta::pedidosPorMesaCaja($Mesa["NroMesa"]);
                foreach($respuesta as $row => $item){
                    $cantidadCuentas++;
                }
  
                if($cantidadCuentas == 1){
                  $R = modelRealizarVenta::actualizarEstadoMesa($datosMesaActualizar);
                }
            }

            //para cuando son fcf o ccf

            $numeroComprobante;
            if($Dts["comprobante"] == 'FCF' || $Dts["comprobante"] == 'CCF'){
                $numeroComprobante = $Dts["nrocomprobanteC"];
            } else {
                $numeroComprobante = $Dts["nrocomprobante"];
            }
            $evitarDuplicacion = 0;
            $Duplicacion =  modelRealizarVenta::evitarDuplicacion();
            if($Duplicacion['evitarDuplicacion'] == "" ){
                $evitarDuplicacion = 1;
            }else{
                $evitarDuplicacion = $Duplicacion['evitarDuplicacion'];
            }

            $dtsSave["nrocomprobante"] = $numeroComprobante;
            $dtsSave["evitarDuplicacion"] = $evitarDuplicacion;

            $Existe = modelRealizarVenta::Comprobante($dtsSave['idpedido']);
            $respuesta = '';
            if ($Existe) {
                $respuesta =  modelRealizarVenta::UPregistroCompraOriginal($dtsSave, $Existe['IdComprobante']);
            }else{
                $respuesta = modelRealizarVenta::registroCompraOriginal($dtsSave);
            }


            if($respuesta == "success"){
                $cont++;
            }


            // if ($cont++) {
            $datosPedidoActualizar = array("id" => $dtsSave["idpedido"]);
            modelRealizarVenta::actualizarEstadoPedido($datosPedidoActualizar);
            // }



            echo json_encode(array(
                "status" => true, 
                "resp" => $cont
            ));
        }elseif ($Accion == "DescuentoCargo") {
            $Dts = $_POST["DtsAjax"];
            $Dts['porcentaje'] = $Dts['porcentaje'] / 100;

            $Respuesta = modelRealizarVenta::ExisteDescuentoOCargo($Dts);
            $Pedido = modelRealizarVenta::getPedido($Dts['idPedido']);
            $LOL = "0";
            if ($Respuesta) {
                $info = array(
                    "idpedido" => $Dts['idPedido'],
                    "idItem" => $Dts['idItem']
                );

                if ($Dts['accion'] == "AD" || $Dts['accion'] == "DD") {
                    $info['total'] = ROUND($Pedido['Total'] + $Respuesta['Precio'], 2);
                }

                if ($Dts['accion'] == "AC" || $Dts['accion'] == "DC") {
                    $info['total'] = ROUND($Pedido['Total'] - $Respuesta['Precio'], 2);
                }




                if($Pedido['Propina'] != "0.00"){
                    $info['propina'] = ROUND($info['total'] * 0.10, 2);
                }else{
                    $info['propina'] = 0.00;
                }

                if ($Pedido['Retencion'] != "0.00") {
                    $info['retencion'] = ROUND($info['total'] * 0.01, 2);
                }else{
                    $info['retencion'] = 0.00;
                }

                if ($Pedido['Exentos'] != "0.00") {
                    $info['exentos'] = ROUND(($info['total'] / 1.13) * 0.13, 2);
                }else{
                    $info['exentos'] = 0.00;   
                }
                modelRealizarVenta::ActualizarMontoPedido($info);
                modelRealizarVenta::EliminarDescuentoCargo($info);
                $Dts['Infototal'] = $info['total'];


            }

            if ($Dts['accion'] == "AD" || $Dts['accion'] == "AC") {
                $Pedido = modelRealizarVenta::getPedido($Dts['idPedido']);

                $info = array(
                    "idpedido" => $Dts['idPedido'],
                    "Estado" => 'D',
                    "idItem" => $Dts['idItem'],
                    "Cantidad" => '1'
                );
                
                $NewTotal = $Pedido['Total'] * $Dts['porcentaje'];
                $info['porcentaje'] = ROUND($NewTotal, 2);
                if ($Dts['accion'] == "AD") {
                    $info['total'] = ROUND($Pedido['Total'] - $NewTotal, 2); 
                }else{
                    $info['total'] = ROUND($Pedido['Total'] + $NewTotal, 2);
                }

                if($Pedido['Propina'] != "0.00"){
                    $info['propina'] = ROUND($info['total'] * 0.10, 2);
                }else{
                    $info['propina'] = 0.00;
                }

                // $info['propina'] = ROUND($info['total'] * 0.10, 2);
                // echo $Pedio['Retencion']
                if ($Pedido['Retencion'] != "0.00") {
                    $info['retencion'] = ROUND($info['total'] * 0.01, 2);
                }else{
                    $info['retencion'] = 0.00;
                }

                if ($Pedido['Exentos'] != "0.00") {
                    $info['exentos'] = ROUND(($info['total'] / 1.13) * 0.13, 2);
                }else{
                    $info['exentos'] = 0.00;
                }

                modelRealizarVenta::RegistroDetallePedido($info);
                modelRealizarVenta::ActualizarMontoPedido($info);
                $Dts['Infototal'] = $info['total'];
            }

            echo json_encode($Dts);
        }

        
    }

?>