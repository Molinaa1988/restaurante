<?php


  require_once "../../models/modelInventario.php";

  $datosModel=array();
  $datosModel['id']=$_POST["IdIngredientes"];
  $datosModel['columna']=$_POST["column"];
  $datosModel['valor']= $_POST["value"];
    
    modelInventario::updateTableIngredientes($datosModel);
  
?>

