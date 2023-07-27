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



		if(isset($_POST['fechai'])){
				$fechai=$_POST['fechai'];
		}else{
				$fechai=date('Y-m-d');
		}

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
       $estadoCaja = controllerCaja::vereficarAperturaCaja();
       if(!isset($estadoCaja['Estado']))
       {
         ?>

               <div class="row">
                 <div class="col-md-12">
                           <div class="box box-default">
                             <div class="box-header with-border">
                               <i class="fa fa-bullhorn"></i>
                               <h3 class="box-title">Mensaje</h3>
                             </div>
                             <div class="box-body">
                               <div class="callout callout-info">
                                 <h4>La caja no se ha aperturado el dia de hoy</h4>

                               </div>
                             </div>
                           </div>
                         </div>
                 </div>

                 <div class="modal fade" id="modalAperturar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <form name="aperturar" method="post" action="">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h3 align="center" class="modal-title" id="myModalLabel">Aperturar caja</h3>
                                    </div>
                                    <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                        </div>
                                        <div class="col-md-4">
                                          <input class="form-control" name="montoaperturarR" placeholder="Monto" autocomplete="off" required>
                                          <br>
                                        </div>
                                        <div class="col-md-4">
                                        </div>
                                        <br>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Aperturar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                            </form>
                              </div>

                              <?php
                              $apertura = new controllerCaja();
                              $apertura -> AperturaCaja();
       }
       elseif($estadoCaja['Estado'] == 'C')
       {
         ?>
               <div class="row">
                 <div class="col-md-12">
                           <div class="box box-default">
                             <div class="box-header with-border">
                               <i class="fa fa-bullhorn"></i>
                               <h3 class="box-title">Mensaje</h3>
                             </div>
                             <div class="box-body">
                               <div class="callout callout-warning">
                                 <h4>La caja ya ha sido cerrada el dia de hoy</h4>
                               </div>
                             </div>
                           </div>
                         </div>
                 </div>
                 <?php
                 $apertura = new controllerCaja();
                 $apertura -> ReAperturaCaja();
       }
       else
       {


       ?>
      <div class="row">
        <?php
        $UltimoIdCaja = controllerCaja::ultimoIdCaja();
        // echo $UltimoIdCaja['IdFcaja'];
        ?>
           <div class="col-md-4" align="center">
           </div>
           <div class="col-md-4" align="center"><br>
              <button type="submit" class="btn btn-icon waves-effect waves-light btn-primary m-b-5" data-toggle="modal" data-target="#modalRegistrarGasto"> Registrar &nbsp; <i class="fa fa-floppy-o"></i></button>
           </div>
           <div class="col-md-4" align="center"><br>

           </div>
       </div>
       <br>
       <!--  Modal registrar-->
                   <div class="modal fade" id="modalRegistrarGasto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                          <form name="form1" method="post" action="">
                              <div class="modal-dialog">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                          <h3 align="center" class="modal-title" id="myModalLabel">Nuevo gasto</h3>
                                      </div>
                                      <div class="panel-body">
                                      <div class="row">
                                          <div class="col-md-12">
                                            <input class="hidden" name="idFcaja" value="<?php echo $UltimoIdCaja['IdFcaja']  ?>" autocomplete="off" required>
                                            <input class="form-control" name="descripcionR" placeholder="Descripcion" autocomplete="off" required>
                                            <br>
                                          </div>
                                          <div class="col-md-4">
                                          </div>
                                          <div class="col-md-4">
                                            <input class="form-control" name="montoR" placeholder="Monto" autocomplete="off" required><br>
                                          </div>
                                          <div class="col-md-4">
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                          <button type="submit" class="btn btn-primary">Guardar</button>
                                      </div>
                                  </div>
                              </div>
                          </div>
                              </form>
                                </div>
                                <?php
$registro = new controllerGastoIngreso();
$registro -> registroGasto();
$registro -> actualizarGasto();
$registro -> borrarGasto();
$registro -> registroIngreso();
$registro -> actualizarIngreso();
$registro -> borrarIngreso();

?>

      <div class="box box-primary">
      <div class="box-header">
      <h3 class="box-title">Gastos</h3></div>
      <div class="box-body">
                            			<table class="table table-bordered datatable table-striped table-hover width="100%"  border="0"">
                            			<thead>
                                  <th class="hidden">ID</th>
                                  <th>Monto</th>
                            			<th>Descripcion</th>
                                  <th>Fecha</th>
                            			<th>Acciones</th>
                            			</thead>
                                  <tbody>
                                    <?php
                                                   $respuesta = controllerGastoIngreso::vistaGastoConFecha($fechai);
                                                    foreach($respuesta as $row => $item){

                                             ?>
                                         <tr class="odd gradeX">
                                             <td class="hidden"><center><?php echo $item['IdDetalleCaja'] ?></center></td>
                                             <td><center><?php echo $item['Monto'] ?></center></td>
                                             <td><center><?php echo $item['Descripcion'] ?></center></td>
                                             <td><center><?php echo $item['Fecha'] ?></center></td>
                                             <td>
                                              <div class="btn-group">
                                               <button data-toggle="dropdown" class="btn btn-warning btn-sm dropdown-toggle"><i class="fa fa-cog"></i> <span class="caret"></span></button>
                                               <ul class="dropdown-menu">
                                                 <li><a href="#" data-toggle="modal" data-target="#ModalActualizar<?php echo $item['IdDetalleCaja']; ?>"><i class="fa fa-edit"></i>Editar</a></li>
                                                 <li class="divider"></li>
                                                 <li><a href="#" data-toggle="modal" data-target="#ModalEliminar<?php echo $item['IdDetalleCaja']; ?>"><i class="fa fa-times"></i> Eliminar</a></li>
                                               </ul>
                                             </div>

                                             </td>
                                         </tr>


                                         <!--Modal Eliminar  -->
                                         <div class="modal fade" id="ModalEliminar<?php echo $item['IdDetalleCaja']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                             <form name="contado"  method="post">
                                             <input type="hidden" name="IdGastoE" value="<?php echo $item['IdDetalleCaja']; ?>">
                                             <div class="modal-dialog">
                                                 <div class="modal-content">
                                                                 <div class="modal-header">
                                                                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                     <h3 align="center" class="modal-title" id="myModalLabel">Precaucion</h3>
                                                                 </div>
                                                     <div class="panel-body">
                                                     <div class="row" align="center">


                                                         <div class="alert alert-danger">
                                                             <h4>¿Esta Seguro de Realizar esta Acción?<br>
                                                             una vez Eliminada la informacion no podra ser Recuperada.</h4>
                                                         </div>
                                                     </div>
                                                     </div>
                                                     <div class="modal-footer">
                                                         <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                                         <button type="submit" class="btn btn-primary">Eliminar</button>

                                                     </div>
                                                 </div>
                                             </div>
                                             </form>
                                         </div>
                                            <!--  Modals actualizar-->
                                         <div class="modal fade" id="ModalActualizar<?php echo $item['IdDetalleCaja']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <form name="form1" method="post" action="">
                                                    <input type="hidden" name="idA" value="<?php echo $item['IdDetalleCaja']; ?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                      <h3 align="center" class="modal-title" id="myModalLabel">Actualizar Categoria</h3>
                                                            </div>
                                                            <div class="panel-body">
                                                            <div class="row">
                                                              <div class="col-md-12">
                                                                <input class="form-control" name="descripcionA" placeholder="Descripcion" autocomplete="off" value="<?php echo $item['Descripcion'] ?>" required>
                                                                <br>
                                                              </div>
                                                              <div class="col-md-4">
                                                              </div>
                                                              <div class="col-md-4">
                                                                <input class="form-control" name="montoA" placeholder="Monto" autocomplete="off" value="<?php echo $item['Monto'] ?>" required><br>
                                                              </div>
                                                              <div class="col-md-4">
                                                              </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                                <button type="submit" class="btn btn-primary">Guardar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                    </form>
                                                      </div>


                                         <?php } ?>

                                    </tbdody>
                            			</table>

                            			</div>
                            		</div>





																<div class="row">
																	<?php
																	$UltimoIdCaja = controllerCaja::ultimoIdCaja();
																	// echo $UltimoIdCaja['IdFcaja'];
																	?>
																		 <div class="col-md-4" align="center">
																		 </div>
																		 <div class="col-md-4" align="center"><br>
																				<button type="submit" class="btn btn-icon waves-effect waves-light btn-primary m-b-5" data-toggle="modal" data-target="#modalRegistrarIngreso"> Registrar &nbsp; <i class="fa fa-floppy-o"></i></button>
																		 </div>
																		 <div class="col-md-4" align="center"><br>

																		 </div>
																 </div>
																 <br>
																 <!--  Modal registrar-->
																						 <div class="modal fade" id="modalRegistrarIngreso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
																										<form name="form1" method="post" action="">
																												<div class="modal-dialog">
																														<div class="modal-content">
																																<div class="modal-header">
																																		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																																		<h3 align="center" class="modal-title" id="myModalLabel">Nuevo ingreso</h3>
																																</div>
																																<div class="panel-body">
																																<div class="row">
																																		<div class="col-md-12">
																																			<input class="hidden" name="idfcajaIngreso" value="<?php echo $UltimoIdCaja['IdFcaja']  ?>" autocomplete="off" required>
																																			<input class="form-control" name="descripcionRIngreso" placeholder="Descripcion" autocomplete="off" required>
																																			<br>
																																		</div>
																																		<div class="col-md-4">
																																		</div>
																																		<div class="col-md-4">
																																			<input class="form-control" name="montoingresoR" placeholder="Monto" autocomplete="off" required><br>
																																		</div>
																																		<div class="col-md-4">
																																		</div>
																																</div>
																																<div class="modal-footer">
																																		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
																																		<button type="submit" class="btn btn-primary">Guardar</button>
																																</div>
																														</div>
																												</div>
																										</div>
																												</form>
																													</div>


																<div class="box box-primary">
																<div class="box-header">
																<h3 class="box-title">Ingresos</h3></div>
																<div class="box-body">
																														<table class="table table-bordered datatable table-striped table-hover width="100%"  border="0"">
																														<thead>
																														<th class="hidden">ID</th>
																														<th>Monto</th>
																														<th>Descripcion</th>
																														<th>Fecha</th>
																														<th>Acciones</th>
																														</thead>
																														<tbody>
																															<?php
																																	$respuesta = controllerGastoIngreso::vistaIngresoConFecha($fechai);
																																							foreach($respuesta as $row => $item){

																																			 ?>
																																	 <tr class="odd gradeX">
																																			 <td class="hidden"><center><?php echo $item['IdDetalleCaja'] ?></center></td>
																																			 <td><center><?php echo $item['Monto'] ?></center></td>
																																			 <td><center><?php echo $item['Descripcion'] ?></center></td>
																																			 <td><center><?php echo $item['Fecha'] ?></center></td>
																																			 <td>
																																				<div class="btn-group">
																																				 <button data-toggle="dropdown" class="btn btn-warning btn-sm dropdown-toggle"><i class="fa fa-cog"></i> <span class="caret"></span></button>
																																				 <ul class="dropdown-menu">
																																					 <li><a href="#" data-toggle="modal" data-target="#ModalActualizar<?php echo $item['IdDetalleCaja']; ?>"><i class="fa fa-edit"></i>Editar</a></li>
																																					 <li class="divider"></li>
																																					 <li><a href="#" data-toggle="modal" data-target="#ModalEliminar<?php echo $item['IdDetalleCaja']; ?>"><i class="fa fa-times"></i> Eliminar</a></li>
																																				 </ul>
																																			 </div>

																																			 </td>
																																	 </tr>


																																	 <!--Modal Eliminar  -->
																																	 <div class="modal fade" id="ModalEliminar<?php echo $item['IdDetalleCaja']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
																																			 <form name="contado"  method="post">
																																			 <input type="hidden" name="IdIngresoE" value="<?php echo $item['IdDetalleCaja']; ?>">
																																			 <div class="modal-dialog">
																																					 <div class="modal-content">
																																													 <div class="modal-header">
																																															 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																																															 <h3 align="center" class="modal-title" id="myModalLabel">Precaucion</h3>
																																													 </div>
																																							 <div class="panel-body">
																																							 <div class="row" align="center">


																																									 <div class="alert alert-danger">
																																											 <h4>¿Esta Seguro de Realizar esta Acción?<br>
																																											 una vez Eliminada la informacion no podra ser Recuperada.</h4>
																																									 </div>
																																							 </div>
																																							 </div>
																																							 <div class="modal-footer">
																																									 <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
																																									 <button type="submit" class="btn btn-primary">Eliminar</button>

																																							 </div>
																																					 </div>
																																			 </div>
																																			 </form>
																																	 </div>
																																			<!--  Modals actualizar-->
																																	 <div class="modal fade" id="ModalActualizar<?php echo $item['IdDetalleCaja']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
																																					<form name="form1" method="post" action="">
																																							<input type="hidden" name="idIngresoA" value="<?php echo $item['IdDetalleCaja']; ?>">
																																							<div class="modal-dialog">
																																									<div class="modal-content">
																																											<div class="modal-header">
																																													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																																								<h3 align="center" class="modal-title" id="myModalLabel">Actualizar Categoria</h3>
																																											</div>
																																											<div class="panel-body">
																																											<div class="row">
																																												<div class="col-md-12">
																																													<input class="form-control" name="descripcionAIngreso" placeholder="Descripcion" autocomplete="off" value="<?php echo $item['Descripcion'] ?>" required>
																																													<br>
																																												</div>
																																												<div class="col-md-4">
																																												</div>
																																												<div class="col-md-4">
																																													<input class="form-control" name="montoAIngreso" placeholder="Monto" autocomplete="off" value="<?php echo $item['Monto'] ?>" required><br>
																																												</div>
																																												<div class="col-md-4">
																																												</div>
																																											</div>
																																											<div class="modal-footer">
																																													<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
																																													<button type="submit" class="btn btn-primary">Guardar</button>
																																											</div>
																																									</div>
																																							</div>
																																					</div>
																																							</form>
																																								</div>


																																	 <?php } ?>

																															</tbdody>
																														</table>

																														</div>
																													</div>
                                <?php
                                 }
                                 ?>





     </section>
  </div>




  <script type="text/javascript">
    $(document).ready(function(){
      $(".datatable").DataTable({
        "language": {
      "sProcessing":    "Procesando...",
      "sLengthMenu":    "Mostrar _MENU_ registros",
      "sZeroRecords":   "No se encontraron resultados",
      "sEmptyTable":    "Ningún dato disponible en esta tabla",
      "sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
      "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix":   "",
      "sSearch":        "Buscar:",
      "sUrl":           "",
      "sInfoThousands":  ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
          "sFirst":    "Primero",
          "sLast":    "Último",
          "sNext":    "Siguiente",
          "sPrevious": "Anterior"
      },
      "oAria": {
          "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
          "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }
  }
      });
    });
  </script>
