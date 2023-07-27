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

<script>
function imprimir(){
	var objeto=document.getElementById('imprimeme');  //obtenemos el objeto a imprimir
	var ventana=window.open('','_blank');  //abrimos una ventana vacía nueva
	ventana.document.write(objeto.innerHTML);  //imprimimos el HTML del objeto en la nueva ventana
	ventana.document.close();  //cerramos el documento
	ventana.print();  //imprimimos la ventana
	ventana.close();  //cerramos la ventana
}
</script>

  <div class="content-wrapper">
    <section class="content">

			<?php
					if(isset($_POST['fechai'])){
							$fechai=$_POST['fechai'];
					}else{
							$fechai=date('Y-m-d');
					}
			 ?>
			                     <div class="row">
			                 <div class="col-md-12">
			                     <!-- Advanced Tables -->
			                     <div class="panel panel-primary">
			                         <div class="panel-heading">
			                             Reporte compras por dia
			                         </div>
			                         <div class="panel-body">

			                          <div class="panel panel-default">
			                         <div class="panel-body">

																 <?php

							                                 if(!empty($_GET['fechai']) ){
							                                     $fechai=($_GET['fechai']);

							                                 }else{
							                                     $fechai=date('Y-m-d');

							                                 }
							                             ?>



							    <form name="gor" action="" method="get" class="form-inline">
							                             <div class="row-fluid">
							                                 <div class="col-md-4" align="center">
							                                     <strong>Fecha</strong><br>
							                                     <input type="date" class="form-control" name="fechai" autocomplete="off" required value="<?php echo $fechai; ?>">
							                                 </div>
							                                 <div class="col-md-4" align="center"><br>
							                                    <button type="submit" class="btn btn-icon waves-effect waves-light btn-primary m-b-5"><strong>Consultar</strong></button>
							                                 </div>
							                                 <div class="col-md-4" align="center"><br>
							                               <center><button onclick="imprimir();" class="btn btn-success"><i class=" fa fa-print "></i> Imprimir</button></center>
							                                 </div>
							                             </div>
							                             </form>


			                         <div style="width:100%; height:700px; overflow: auto;">
			                          <div id="imprimeme">
			                                      <br>
			                                      <div class="hidden">
			                                      	<table  width="100%" style="border: 1px solid #660000; -moz-border-radius: 13px;-webkit-border-radius: 12px;padding: 10px;">
			                                      <tr>
			                                         <td>
			                                             <center>
			                                             <img src="../../img/logo.jpg" width="75px" height="75px"><br>
			                                             </center>
			                                         </td>
			                                         <td align="center">
			                                             <div style="font-size: 25px;"><strong><em>FUEGO&BRASAS</em></strong></div>
			                                                Fecha: <?php echo $fechai; ?> <br>
			                                         </td>
			                                         <td>
			                                             <center>

			                                             </center>
			                                         </td>
			                                      </tr>
			                                     </table><br>
			                                       <hr/>
			                                           <div style="font-size: 14px;"align="center">
			                                              <strong>Reporte compras por dia</strong><br>
			                                         </div>
			                                         <hr/>
			                                     </div>
			                             <div class="table-responsive">
			                                 <table class="table table-striped table-bordered table-hover"  width="100%"  border="0">

																				                                    <thead>
																				                                        <tr>
																				                                           <th><center>Tipo de documento</center></th>
																				                                            <th><center>Nro de documento</center></th>
																				                                            <th><center>Forma de pago</center></th>
																				                                             <th><center>Total</center></th>

																				                                        </tr>
																				                                    </thead>
																				                                    <tbody>
																				                                   <?php
																				                                                $neto=0;

																																												$respuesta =  controllerReportes::ReporteCompraspordia($fechai);
																																									 										 foreach($respuesta as $row => $item){
																				                                                    $neto=$neto+$item['Total'];
																				                                            ?>
																				                                        <tr class="odd gradeX">
																				                                          <td><center><?php echo $item['TipoDoc'] ?></center></td>
																				                                            <td><center><?php echo $item['NroComprobante'] ?></center></td>
																				                                            <td><center><?php echo $item['Serie'] ?></center></td>
																				                                              <td><center>$ <?php echo $item['Total'] ?></center></td>
																				                                        </tr>
																				                                        <?php } ?>
																				                                         <tr>
																				                                                             <td colspan="3"><div align="right"><strong><h4>Total General</h4></strong></div></td>
																				                                                             <td><div align="center"><strong><h4>$ <?php echo ($neto); ?></h4></strong></div></td>
																				                                                        </tr>
																				                                    </tbody>

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
