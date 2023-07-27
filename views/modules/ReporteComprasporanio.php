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
			                             Reporte compras por año
			                         </div>
			                         <div class="panel-body">

			                          <div class="panel panel-default">
			                         <div class="panel-body">

																 <?php
															                                  $fechai=date('Y-m-d');
															                                 if(!empty($_GET['Año'])){
															                                     $Año=($_GET['Año']);


															                                 }else{
															                                     $Año='';


															                                 }
															                             ?>



															    <form name="gor" action="" method="get" class="form-inline">
															                             <div class="row-fluid">
															                                 <div class="col-md-4" align="center">
															                                    <strong>Año</strong><br>
															                                     <select class="form-control" name="Año">
															                                         <option value="2017" <?php if($Año=='2017'){ echo 'selected'; } ?>>2017</option>
															                                         <option value="2018" <?php if($Año=='2018'){ echo 'selected'; } ?>>2018</option>
															                                         <option value="2019" <?php if($Año=='2019'){ echo 'selected'; } ?>>2019</option>
															                                         <option value="2020" <?php if($Año=='2020'){ echo 'selected'; } ?>>2020</option>
															                                         <option value="2021" <?php if($Año=='2021'){ echo 'selected'; } ?>>2021</option>
															                                         <option value="2022" <?php if($Año=='2022'){ echo 'selected'; } ?>>2022</option>
															                                         <option value="2023" <?php if($Año=='2023'){ echo 'selected'; } ?>>2023</option>
															                                         <option value="2024" <?php if($Año=='2024'){ echo 'selected'; } ?>>2024</option>
															                                     </select>
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
			                                              <strong>Reporte compras por año</strong><br>
			                                         </div>
			                                         <hr/>
			                                     </div>
			                             <div class="table-responsive">
			                                 <table class="table table-striped table-bordered table-hover"  width="100%"  border="0">

																				 <thead>
																			                                         <tr>
																			                                              <th><center>Mes</center></th>
																			                                              <th><center>Total</center></th>

																			                                         </tr>
																			                                     </thead>
																			                                     <tbody>

																			                                                         <?php
																			                                                            $_fecha1 = date("H");
																			                                                            $_fecha2 = date("H");

																			                                                         if ($Año == "2017")    /*----------2017---------*/
																			                                                         {

																			                                                             $_fecha1="2017-01-01";
																			                                                             $_fecha2="2017-12-31";
																			                                                         }
																			                                                         else if ($Año == "2018")
																			                                                         {

																			                                                             $_fecha1="2018-01-01";
																			                                                             $_fecha2="2018-12-31";
																			                                                         }
																			                                                          else if ($Año == "2019")
																			                                                         {

																			                                                             $_fecha1="2019-01-01";
																			                                                             $_fecha2="2019-12-31";
																			                                                         }
																			                                                          else if ($Año == "2020")
																			                                                         {

																			                                                             $_fecha1="2020-01-01";
																			                                                             $_fecha2="2020-12-31";
																			                                                         }
																			                                                          else if ($Año == "2021")
																			                                                         {

																			                                                             $_fecha1="2021-01-01";
																			                                                             $_fecha2="2021-12-31";
																			                                                         }
																			                                                          else if ($Año == "2022")
																			                                                         {

																			                                                             $_fecha1="2022-01-01";
																			                                                             $_fecha2="2022-12-31";
																			                                                         }
																			                                                          else if ($Año == "2023")
																			                                                         {

																			                                                             $_fecha1="2023-01-01";
																			                                                             $_fecha2="2023-12-31";
																			                                                         }
																			                                                          else if ($Año == "2024")
																			                                                         {

																			                                                             $_fecha1="2024-01-01";
																			                                                             $_fecha2="2024-12-31";
																			                                                         }
																			                                                         ?>
																			                                    <?php
																			                                                 $neto=0;

																																											 $respuesta =  controllerReportes::ReporteComprasporaño($_fecha1,$_fecha2);
																																																			 foreach($respuesta as $row => $item){
																			                                                     $neto=$neto+$item['Total'];
																			                                             ?>
																			                                         <tr class="odd gradeX">

																			                                             <td><div align="center">
																			                                             <?php
																			                                             if ($item['Mes']=="January")
																			                                                 {echo "Enero";}
																			                                               else if ($item['Mes']=="February")
																			                                                 {echo "Febrero";}
																			                                               else if ($item['Mes']=="March")
																			                                                 {echo "Marzo";}
																			                                               else if ($item['Mes']=="April")
																			                                                 {echo "Abril";}
																			                                               else if ($item['Mes']=="May")
																			                                                 {echo "Mayo";}
																			                                               else if ($item['Mes']=="June")
																			                                                 {echo "Junio";}
																			                                               else if ($item['Mes']=="July")
																			                                                 {echo "Julio";}
																			                                               else if ($item['Mes']=="August")
																			                                                 {echo "Agosto";}
																			                                               else if ($item['Mes']=="September")
																			                                                 {echo "Septiembre";}
																			                                               else if ($item['Mes']=="October")
																			                                                 {echo "Octubre";}
																			                                               else if ($item['Mes']=="November")
																			                                                 {echo "Noviembre";}
																			                                               else if ($item['Mes']=="December")
																			                                                 {echo "Diciembre";}
																			                                             ?>
																			                                             </div></td>
																			                                               <td><center>$ <?php echo $item['Total'] ?></center></td>
																			                                         </tr>
																			                                         <?php } ?>
																			                                          <tr>
																			                                                              <td><div align="right"><strong><h4>Total General</h4></strong></div></td>
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
