<?php
session_start();
if(!$_SESSION["validar"]){
	header("location:ingreso");
	exit();
}
?>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<?php
include "views/modules/cabezote.php";
include "views/modules/botonera.php";

?>

  <div class="content-wrapper">
    <section class="content">
      <div class="row-fluid">
          <div class="col-md-4" align="center">

          </div>
          <div class="col-md-4" align="center"><br>
              <!-- <a href="ReporteVentasporDia"><i class="btn  btn-primary m-b-5">Regresar</i> </a> -->
          </div>
          <div class="col-md-4" align="center"><br>

          </div>
      </div>

			                     <div class="row">
			                 <div class="col-md-12">
			                     <!-- Advanced Tables -->
			                     <div class="panel panel-primary">
			                         <div class="panel-heading">
			                             Detalle de la venta  <?php echo $_GET['var']; ?>
			                         </div>
			                         <div class="panel-body">

			                          <div class="panel panel-default">
			                         <div class="panel-body">



			                         <div style="width:100%; height:700px; overflow: auto;">
			                          <div id="imprimeme">
			                                      <br>

			                             <div class="table-responsive">
			                                 <table class="table table-striped table-bordered table-hover"  width="100%"  border="0">
                                         <thead>
                                             <tr>

                                               <th><center>Descripcion</center></th>
																							 <th><center>Precio</center></th>
                                               <th><center>Cantidad</center></th>
																							 <th><center>Total</center></th>


                                             </tr>
                                         </thead>
                                         <tbody>
                                        <?php
                                        $total = 0;



																				$respuesta;
                                                    $nrocomprobante = $_GET['var'];
																										if($_GET['tipo'] == 'T' ){
                                                    $respuesta = controllerReportes::ReporteVentasporDiaDetalle($nrocomprobante);
																											}
																											else {
																												$respuesta = controllerReportes::ReporteVentasporDiaDetalleFactura($nrocomprobante);
																											}
     																								foreach($respuesta as $row => $item){
                                                      $total=$total+($item['Precio']*$item['Cantidad']);
     																				 ?>

                                             <tr class="odd gradeX">
                                                 <td><center><?php echo $item['Descripcion'] ?></center></td>
																								  <td><div align="center"><?php echo $item['Precio'] ?></div></td>
                                                 <td><center><?php echo $item['Cantidad'] ?></center></td>
																								 <?php $subTotal = $item['Precio']*$item['Cantidad']; ?>
                                                 <td><div align="center"><?php echo $subTotal; ?></div></td>

                                             </tr>

                                             <?php } ?>
                                              <tr>
                                                                  <td colspan="3"><div align="right"><strong><h4>Total General</h4></strong></div></td>
                                                                  <td><div align="center"><strong><h4>$ <?php echo ($total); ?></h4></strong></div></td>

                                                             </tr>
                                         </tbody>
			               		 										<!--  -->

			                                 </table>
			                      </div>
			                     </div>
			                    </div>
			                   </div>
			                  </div>
			                 </div>
			                </div>
			               </div>
			             </div>
     </section>
  </div>
