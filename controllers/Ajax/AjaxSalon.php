<?php
    require_once '../../models/modelConfiguraciones.php';
    require_once '../../models/modelSalon.php';

    if ($_POST['AccionAjax'] === 'actualizarMesas') {
        $Zonas = modelConfiguraciones::vistaZona();
        $Json = array();
        foreach ($Zonas as $key => $value) {
            
            $Mesas = modelSalon::MesaxZona($value['idzona']);

            $ListMesas = array();
            foreach ($Mesas as $Mkey => $Mvalue) {
                $img = '';
                $ruta = '';
                if ($Mvalue['naturaleza'] === 'M') {
                    if ($Mvalue['Estado'] === 'L') {
                        $img = 'MesaLibre.png';
                        $ruta = 'data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#IdModalMeseros" onClick="asignarIdMesa(\''.$Mvalue['NroMesa'].'\')"';
                    }elseif ($Mvalue['Estado'] === 'P') {
                        $MesaPendiente = modelSalon::MesaPediente($Mvalue['NroMesa']);
                        $ruta = 'data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#reApertura" onClick="reaperturaMesa(\''.$Mvalue['NroMesa'].'\', \''.$MesaPendiente["IdPersonal"].'\')"';
                        $img = 'MesaPagar.png';
                    }elseif ($Mvalue['Estado'] === 'O') {
                        $img = 'MesaOcupada.png';
                        $IdPedido = modelSalon::idPedido($Mvalue['NroMesa']);
                        if ($IdPedido) {
                            $ruta = 'onClick="window.location=`menuPedido?IdPedido='.$IdPedido["Pedido"].'`"';
                        }else{
                            $Dts = array(
                                "Estado" => 'L',
                                "NroMesa" => $Mvalue['NroMesa']
                            );
                            modelSalon::cambioEstadoMesa($Dts);  
                        }
                    }
                }elseif ($Mvalue['naturaleza'] === 'L') {
                    if ($Mvalue['Estado'] === 'L') {
                        $img = 'llevar.png';
                        $ruta = 'data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#IdModalMeseros" onClick="asignarIdMesa(\''.$Mvalue['NroMesa'].'\')"';
                    }elseif ($Mvalue['Estado'] === 'P') {
                        $MesaPendiente = modelSalon::MesaPediente($Mvalue['NroMesa']);
                        $ruta = 'data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#reApertura" onClick="reaperturaMesa(\''.$Mvalue['NroMesa'].'\', \''.$MesaPendiente["IdPersonal"].'\')"';
                        $img = 'MesaPagar.png';
                    }elseif ($Mvalue['Estado'] === 'O') {
                        $img = 'MesaOcupada.png';
                        $IdPedido = modelSalon::idPedido($Mvalue['NroMesa']);
                        $ruta = 'onClick="window.location=`menuPedido?IdPedido='.$IdPedido["Pedido"].'`"';
                    }
                }
                
                $ListMesas[$Mkey] = array(
                    "idMesa" => $Mvalue['NroMesa'],
                    "estado" => $Mvalue['Estado'],
                    "Etiqueta" => $Mvalue['Etiqueta'],
                    "naturaleza" => $Mvalue['naturaleza'],
                    "img" => $img,
                    "accion" => $ruta
                );  
            }

            $Json[$key] = array(
                "zondaId" => $value['idzona'],
                "nombre" => $value['zona'],
                "Mesas" => $ListMesas
            );
        }
        echo json_encode($Json);
    }elseif ($_POST['AccionAjax'] === 'crearPedido') {
        $IdPersonal = $_POST['idPersonal'];
        $IdPedido = '';
        $R1 = modelSalon::crearPedido($IdPersonal);
        if ($R1 === 'success') {
            $IdMesa = $_POST['idMesa'];
            $IdPedido = modelSalon::ultimoIdPedido();
            $R2 = modelSalon::crearDetalleMesa($IdMesa, $IdPedido[0]);
            if ($R2 === 'success') {
                $Data = array(
                    "NroMesa" => $IdMesa,
                    "Estado" => "O"
                );

                modelSalon::cambioEstadoMesa($Data);
            }
        }

        $Json = array(
            "Mensaje" => $R1,
            "IdPedidoF" => $IdPedido
        );
        echo json_encode($Json);
    }elseif ($_POST['AccionAjax'] === 'timestamp') {
        
        set_time_limit(0);

        $fecha_ac = isset($_POST['timeStamp']) ? $_POST['timeStamp']:0;
        $Datos = modelSalon::cambioPedido();
        $fecha_bd = $Datos['Cambios'];
        
        while ($fecha_bd <= $fecha_ac) {
            $Res = modelSalon::cambioPedido();

            usleep(100000);
            clearstatcache();
            if ($fecha_bd > $Res['Cambios']) {
                break;
            }
            $fecha_bd = $Res['Cambios'];
        }

        
        $Json['timestamp'] = $Datos['Cambios'];
        

        echo json_encode($Json);
    }
    
?>