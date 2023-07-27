<?php

require_once "modelInventario.php";

    $datosModel=array();
    $datosModel['id']="34";
    $datosModel['columna']="DescripcionIng";
    $datosModel['valor']="Papaaaa";
    
    modelInventario::updateTableIngredientes($datosModel);

    
?>
