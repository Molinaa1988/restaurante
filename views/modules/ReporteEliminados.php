<!-- reporte para las pedidos eliminados by Rafa M. -->

<?php
    session_start();
    if(!$_SESSION["validar"]){
        header("location:ingreso");
        exit();
    }
?>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">


<script>

</script>

<?php
    include "views/modules/cabezote.php";
    include "views/modules/botonera.php";
?>

<div class="content-wrapper">
    <section class="content">
        <div class="row">
        <div class="col-md-12">
    <!-- Advanced Tables -->
    <div class="panel panel-primary">
    <div class="panel-heading">
    Reporte Eliminados
    </div>
    <div class="panel-body">
    <div class="panel panel-default">
    <div class="panel-body">

<?php

    if(!empty($_GET['fechai']) and !empty($_GET['fechaf'])){
        $fechai=($_GET['fechai']);
        $fechaf=($_GET['fechaf']);
    } else {
        $fechai=date('Y-m-d');
        $fechaf=date('Y-m-d');
    }
?>

<div class="row-fluid">


<form name="gor" action="" method="get" class="form-inline">
    <div class="row-fluid">
    <div class="col-md-3 col-sm-3" align="center">
        <strong>Fecha Inicial</strong><br>
        <input type="date" class="form-control" name="fechai" autocomplete="off" required value="<?php echo $fechai; ?>">
    </div>
    <div class="col-md-3 col-sm-3" align="center">
        <strong>Fecha Final</strong><br>
        <input type="date" class="form-control" name="fechaf" autocomplete="off" required value="<?php echo $fechaf; ?>">
    </div>
    <div class="col-md-3 col-sm-3" align="center"><br>
        <button type="submit" class="btn btn-icon waves-effect waves-light btn-primary m-b-5"><strong>Consultar</strong></button>
    </div>
    </div>
</form>
</div>

<div style="width:100%; height:700px; margin-top: 50px; overflow: auto;" > <br>
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover"  width="100%"  border="0">
    <thead>
    <tr>
        
        <th><center>Pedido</center></th>
        <th><center>Personal</<center></th>
        <th><center>Producto</center></th>
        <th><center>Cantidad</center></th>
        <th><center>Precio</center></th>
        <th><center>Fecha</center></th>
        <th><center>Eliminado por </center></th>
    </tr>
    </thead>
<tbody>



<?php

     

    $respuesta = controllerReportes::ReporteEliminados($fechai,$fechaf);
    //var_dump($respuesta);
   
    foreach($respuesta as $row => $item){

       
       // $total=$total+$item['Total'];
      
    ?>


    <tr class="odd gradeX">
		</div></td>
           
		</td>
		</td>
        
        <td><center> <?php echo $item['IdPedido']?> </center></td>
        <td><center> <?php echo $item['Nombres'] ?></center></td>
        <td><center> <?php echo $item['Descripcion'] ?></center></td>
        <td><center> <?php echo $item['Cantidad'] ?></center></td>
        <td><center>$ <?php echo $item['Precio'] ?></center></td>
        <td><center> <?php echo $item['Cambios'] ?></center></td>
        
    </tr>


    
 <?php   } ?>
 <!-- <tr>
        
        <td colspan="3"><div align="right"><strong><h4>Total General</h4></strong></div></td>
        <td><div align="center"><strong><h4>$ <?php echo ($total); ?></h4></strong></div></td>
        <td></td>
</tr> -->

<script>

</script>