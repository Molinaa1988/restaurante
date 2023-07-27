<?php
session_start();
if(!$_SESSION["validar"]){
	header("location:ingreso");
	exit();
}
?>

<body class="hold-transition skin-blue sidebar-collapse sidebar-mini">
<div class="wrapper">
<?php
include "views/modules/cabezote.php";
include "views/modules/botonera.php";

?>

  <div class="content-wrapper">
    <section class="content">

      <div class="row">
        <div class="col-lg-12">
          <div class="box box-primary">
            <div class="box-header"><center><h3 class="box-title">Configuraciones de sistema</h3></center></div>
            <div class="box-body">

							<?php
$registro = new controllerConfiguraciones();
$registro -> actualizarConfiguracionImpresora();
$registro -> actualizacionConfiguracionCorreo();
$registro -> eliminarPedido();


$registro -> registrarZona();
$registro -> ActualizarZona();
$registro -> EliminarZona();

$registro -> registrarMesa();
$registro -> ActualizarMesa();
$registro -> EliminarMesa();

$registro -> actualizarEliminarBebida();

		$respuestaImpresora = controllerConfiguraciones::configuracionesImpresora();
		$ImpresoraTicket = $respuestaImpresora["ImpresoraTicket"];
		$respuestaCorreo = controllerConfiguraciones::configuracionesCorreo();
		$EmailEmisor = $respuestaCorreo["EmailEmisor"];
		$Contrasena = $respuestaCorreo["Contrasena"];
		$EmailReceptor = $respuestaCorreo["EmailReceptor"];

?>

		            <div class="row">
                  <div class="col-lg-3">
                    <div class="box box-default">
                      <div class="box-header"><h3 class="box-title">Impresora de ticket</h3></div>
                      <div class="box-body">
												<form method="post">
                        <label>  Nombre </label>
                        <input class="form-control" name="ImpresoraTicket" id="ImpresoraTicket" placeholder="Nombre de impresora" autocomplete="off" value="<?php echo $ImpresoraTicket ?>"><br>
												   <center><button type="submit" class="btn btn-primary">Actualizar</button></center>
												</form>
                      </div>
                      </div>
                    </div>
                    <div class="col-lg-9">
                      <div class="box box-default">
                        <div class="box-header"><h3 class="box-title">Informe por correo</h3></div>
                        <div class="box-body">
                      <div class="row">
												<form method="post">
                        <div class="col-lg-3">
                          <label>  Correo emisor </label>
                          <input type="email" class="form-control" name="EmailEmisor" id="EmailEmisor" placeholder="Correo emisor" value="<?php echo $respuestaCorreo["EmailEmisor"]; ?>" autocomplete="off" required>
                        </div>
                        <div class="col-lg-3">
                          <label>  Contraseña (emisor) </label>
                          <input type="password" class="form-control" name="Contrasena" id="Contrasena" placeholder="Contraseña" value="<?php echo $respuestaCorreo["Contrasena"] ?>" autocomplete="off" required>
                        </div>
                        <div class="col-lg-3">
                          <label>  Comprobar contraseña </label>
												<table>
													<th><input type="password" class="form-control" name="comprobacionContrasena" id="comprobacionContrasena" placeholder="Comprobar" value="" autocomplete="off" required></th>
													<th><span id="noMatch" hidden class="text-danger"><i class="fa fa-times fa-2x"></i></span></th>
													<th><span id="Match" hidden class="text-success"><i class="fa fa-check fa-2x"></i> </th>
												</table>
                        </div>
                        <div class="col-lg-3">
                          <label>  Correo receptor </label>
                          <input type="email" class="form-control" name="EmailReceptor" id="EmailReceptor" placeholder="Correo receptor" autocomplete="off" value="<?php echo $respuestaCorreo["EmailReceptor"] ?>" required>		<br>
                        </div>
												 <center><button id="submitEmail" type="submit" class="btn btn-primary">Actualizar</button></center>
											</form>
                      </div>
                        </div>
                        </div>
                      </div>
											<div class="col-lg-3">
												<div class="box box-default">
													<div class="box-header"><h3 class="box-title">Permitir anular bebida</h3></div>
													<div class="box-body">
														<form method="post">
																<label> Estado </label>
					 				               <select class="form-control" name="EstadoEliminarBebida" autocomplete="off" required>
																	 <?php
																	 $respuesta = controllerConfiguraciones::configuracionesEliminarBebida();
																		foreach($respuesta as $row => $item){
														 				?>
					 				                          <option <?php if($item['bebidaEliminar'] == "A" ){echo 'selected';} ?> value="A">Activo</option>
					 				                          <option <?php if($item['bebidaEliminar'] == "N" ){echo 'selected';} ?> value="N">No activo</option>

																				<?php } ?>
					 				               </select><br>
																  <center><button type="submit" class="btn btn-primary">Actualizar</button></center>
														</form>
													</div>
													</div>
												</div>

												<div class="col-lg-3">
													<div class="box box-default">
														<!--Actualizar la mesa a estado L (LIBRE) y eliminar de la tabla detallemesa, detallepedido, pedido y comprobante, comprobante c por medido de idpedido -->
														<div class="box-header"><h3 class="box-title">Eliminar pedido para programador</h3></div>
														<div class="box-body">
															<label>  IdPedido </label>
															<form method="post">
															<input class="form-control" name="IdPedido" placeholder="Ingrese idPedido" autocomplete="off" value=""><br>
																 <center><button type="submit" class="btn btn-primary">Eliminar</button></center>
															</form>
														</div>
														</div>
													</div>
												<div class="col-lg-6">
													<div class="box box-default">
														<div class="box-header"><h3 class="box-title">---</h3></div>
														<div class="box-body">

															<label>  Nombre </label>
															<input disabled class="form-control" placeholder="Nombre de impresora" autocomplete="off" value=""><br>
																 <center><button disabled type="submit" class="btn btn-primary">Actualizar</button></center>
														</div>
														</div>
													</div>

											<div class="col-lg-3">
												<div class="box box-default">
													<div class="box-header"><h3 class="box-title">Zonas</h3></div>
													<div class="box-body">
														<div class="row">
											           <div class="col-md-4" align="center">

											           </div>
											           <div class="col-md-4" align="center"><br>
											              <button type="submit" class="btn btn-icon waves-effect waves-light btn-primary m-b-5" data-toggle="modal" data-target="#modalRegistrar"> Registrar &nbsp; <i class="fa fa-floppy-o"></i></button>
											           </div>
											           <div class="col-md-4" align="center"><br>

											           </div>
											       </div>
														 <div class="modal fade" id="modalRegistrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
																		<form name="form1" method="post" action="">
																				<div class="modal-dialog">
																						<div class="modal-content">
																								<div class="modal-header">
																										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																										<h3 align="center" class="modal-title" id="myModalLabel">Nueva zona</h3>
																								</div>
																								<div class="panel-body">
																								<div class="row">
																										<div class="col-md-12">
																											<input class="form-control" name="zonaR" placeholder="Zona" autocomplete="off" required>
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
																<table class="table table-bordered datatable table-striped table-hover width="100%"  border="0"">
																<thead>
																<th class="hidden">ID</th>
																<th>Zona</th>
																<th>Acciones</th>

																</thead>
																<tbody>
																	<?php
																								 $respuesta = controllerConfiguraciones::vistaZona();
																									foreach($respuesta as $row => $item){

																					 ?>
																			 <tr class="odd gradeX">
																					 <td class="hidden"><center><?php echo $item['idzona'] ?></center></td>
																					 <td><center><?php echo $item['zona'] ?></center></td>
																					 <td>

																						<div class="btn-group">
																						 <button data-toggle="dropdown" class="btn btn-warning btn-sm dropdown-toggle"><i class="fa fa-cog"></i> <span class="caret"></span></button>
																						 <ul class="dropdown-menu">
																							 <li><a href="#" data-toggle="modal" data-target="#ModalActualizar<?php echo $item['idzona']; ?>"><i class="fa fa-edit"></i>Editar</a></li>
																							 <li class="divider"></li>
																							 <li><a href="#" data-toggle="modal" data-target="#ModalEliminar<?php echo $item['idzona']; ?>"><i class="fa fa-times"></i> Eliminar</a></li>
																						 </ul>
																					 </div>

																					 </td>
																			 </tr>


																			 <!--Modal Eliminar  -->
																			 <div class="modal fade" id="ModalEliminar<?php echo $item['idzona']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
																					 <form name="contado"  method="post">
																					 <input type="hidden" name="idZonaE" value="<?php echo $item['idzona']; ?>">
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
																													 una vez Eliminada la informacion de <strong>[ <?php echo $item['zona']; ?> ]</strong> no podra ser Recuperada.</h4>
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
<div class="modal fade" id="ModalActualizar<?php echo $item['idzona']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						 <form name="form1" method="post" action="">
											 <input type="hidden" name="idZonaA" value="<?php echo $item['idzona']; ?>">
								 <div class="modal-dialog">
										 <div class="modal-content">
												 <div class="modal-header">
														 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
											<h3 align="center" class="modal-title" id="myModalLabel">Actualizar cliente</h3>
												 </div>
												 <div class="panel-body">
												 <div class="row">
														 <div class="col-md-12">
															 <input class="form-control" name="zonaA" placeholder="Zona" autocomplete="off" required value="<?php echo $item['zona']; ?>">
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
												</div>
												<div class="col-lg-9">
													<div class="box box-default">
														<div class="box-header"><h3 class="box-title">Mesas</h3></div>
														<div class="box-body">
													<div class="row">
														<div class="row">
																 <div class="col-md-4" align="center">

																 </div>
																 <div class="col-md-4" align="center"><br>
																		<button type="submit" class="btn btn-icon waves-effect waves-light btn-primary m-b-5" data-toggle="modal" data-target="#modalRegistrarMesa1"> Registrar &nbsp; <i class="fa fa-floppy-o"></i></button>
																 </div>
																 <div class="col-md-4" align="center"><br>

																 </div>
														 </div>
														 <div class="row">
																	<div class="col-md-4">
																		<div class="modal fade" id="modalRegistrarMesa1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
																					 <form name="form1" method="post" action="">
																							 <div class="modal-dialog">
																									 <div class="modal-content">
																											 <div class="modal-header">
																													 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																													 <h3 align="center" class="modal-title" id="myModalLabel">Nueva mesa</h3>
																											 </div>
																											 <div class="panel-body">
																											 <div class="row">
																													 <div class="col-md-6">
																														 <div class="input-group">
								                                               <span class="input-group-addon">Zona</span>
								                                                 <select class="form-control" name="idzonaR" autocomplete="off" required>
								                                                   <?php
								                                                                 $c= controllerConfiguraciones::vistaZona();
								                                                                   foreach($c as $row => $cd){
								                                                            ?>
								                                                       <option value="<?php echo $cd['idzona']  ?>"><?php echo $cd['zona']  ?></option>
								                                                     <?php } ?>
								                                                 </select>
								                                               </div>
																													 </div>
																													 <div class="col-md-6">
																														 <div class="input-group">
								                                               <span class="input-group-addon">Naturaleza</span>
								                                                 <select class="form-control" name="naturalezaR" autocomplete="off" required>
								                                                       <option value="M">Mesa</option>
																																			 <option value="L">Llevar</option>
																																			 <option value="A">Adomicilio</option>
								                                                 </select>
								                                               </div>
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
																		<table class="table table-bordered datatable table-striped table-hover width="100%"  border="0"">
																		<thead>
																		<th>Mesa</th>
																		<th>Zona</th>
																		<th>Naturaleza</th>
																		<th>Acciones</th>

																		</thead>
																		<tbody>
																			<?php
																										 $respuesta = controllerConfiguraciones::vistaMesas1();
																											foreach($respuesta as $row => $item){

																							 ?>
																					 <tr class="odd gradeX">
																							 <td><center><?php echo $item['NroMesa'] ?></center></td>
																							<?php  $nombreZona = controllerConfiguraciones::nombreZona($item['idzona']); ?>
																							 <td><center><?php echo $nombreZona['zona'] ?></center></td>
																							 <td><center><?php if($item['naturaleza'] == 'M')
																							 						{echo '<span class="label label-success">Mesa</span>';}
																													 else if ($item['naturaleza'] == 'A')
																													 {echo '<span class="label label-info">Adomicilio</span>';}
																													 else if ($item['naturaleza'] == 'L')
																													 {echo '<span class="label label-primary">Llevar</span>';}
																													 else {echo "ninguno";} ?>
																							</center></td>
																							 <td>

																								<div class="btn-group">
																								 <button data-toggle="dropdown" class="btn btn-warning btn-sm dropdown-toggle"><i class="fa fa-cog"></i> <span class="caret"></span></button>
																								 <ul class="dropdown-menu">
																									 <li><a href="#" data-toggle="modal" data-target="#ModalActualizarMesa1<?php echo $item['NroMesa']; ?>"><i class="fa fa-edit"></i>Editar</a></li>
																									 <li class="divider"></li>
																									 <li><a href="#" data-toggle="modal" data-target="#ModalEliminarMesa1<?php echo $item['NroMesa']; ?>"><i class="fa fa-times"></i> Eliminar</a></li>
																								 </ul>
																							 </div>

																							 </td>
																					 </tr>

																					 <!--Modal Eliminar  -->
																					 <div class="modal fade" id="ModalEliminarMesa1<?php echo $item['NroMesa']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
																							 <form name="contado"  method="post">
																							 <input type="hidden" name="NroMesaE" value="<?php echo $item['NroMesa']; ?>">
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
																															 una vez Eliminada la informacion de <strong>[ <?php echo $item['NroMesa']; ?> ]</strong> no podra ser Recuperada.</h4>
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
		<div class="modal fade" id="ModalActualizarMesa1<?php echo $item['NroMesa']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								 <form name="form1" method="post" action="">
													 <input type="hidden" name="NroMesaA" value="<?php echo $item['NroMesa']; ?>">
										 <div class="modal-dialog">
												 <div class="modal-content">
														 <div class="modal-header">
																 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													<h3 align="center" class="modal-title" id="myModalLabel">Actualizar mesa</h3>
														 </div>
														 <div class="panel-body">
														 <div class="row">
																 <div class="col-md-6">
																	 <div class="input-group">
					                           <span class="input-group-addon">Zona</span>
					                             <select class="form-control" name="idzonaA" autocomplete="off" required>
					                               <?php
					                                             $respues = controllerConfiguraciones::vistaZona();
					                                               foreach($respues as $row => $it){
					                                 ?>

					                                     <option  <?php if($item['idzona'] == $it['idzona'] ){echo 'selected';} ?>    value="<?php echo $it['idzona']  ?>"><?php echo $it['zona']  ?></option>
					                                 <?php } ?>
					                             </select>
					                           </div>
																 </div>
																 <div class="col-md-6">
																	 <div class="input-group">
					                           <span class="input-group-addon">Naturaleza</span>
					                             <select class="form-control" name="naturalezaA" autocomplete="off" required>

																									<option <?php if($item['naturaleza'] == "M" ){echo 'selected';} ?> value="M">Mesa</option>
																									<option <?php if($item['naturaleza'] == "A" ){echo 'selected';} ?> value="A">Adomicilio</option>
																									<option <?php if($item['naturaleza'] == "L" ){echo 'selected';} ?> value="L">Llevar</option>

					                             </select>
					                           </div>
																 </div>
																 <br>
																 <br>
																 <div class="row">
																			<div class="col-md-6 col-md-offset-3">
																				<input class="form-control" name="EtiquetaA" placeholder="Ingrese Etiqueta" autocomplete="off" value="<?php echo $item['Etiqueta'] ?>"><br>
																			</div>
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
																	<div class="col-md-4">
																		<div class="modal fade" id="modalRegistrarMesa1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
																					 <form name="form1" method="post" action="">
																							 <div class="modal-dialog">
																									 <div class="modal-content">
																											 <div class="modal-header">
																													 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																													 <h3 align="center" class="modal-title" id="myModalLabel">Nueva mesa</h3>
																											 </div>
																											 <div class="panel-body">
																											 <div class="row">
																													 <div class="col-md-6">
																														 <div class="input-group">
																															 <span class="input-group-addon">Zona</span>
																																 <select class="form-control" name="idzonaR" autocomplete="off" required>
																																	 <?php
																																								 $c= controllerConfiguraciones::vistaZona();
																																									 foreach($c as $row => $cd){
																																						?>
																																			 <option value="<?php echo $cd['idzona']  ?>"><?php echo $cd['zona']  ?></option>
																																		 <?php } ?>
																																 </select>
																															 </div>
																													 </div>
																													 <div class="col-md-6">
																														 <div class="input-group">
																															 <span class="input-group-addon">Naturaleza</span>
																																 <select class="form-control" name="naturalezaR" autocomplete="off" required>
																																			 <option value="M">Mesa</option>
																																			 <option value="L">Llevar</option>
																																			 <option value="A">Adomicilio</option>
																																 </select>
																															 </div>
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
																		<table class="table table-bordered datatable table-striped table-hover width="100%"  border="0"">
																		<thead>
																		<th>Mesa</th>
																		<th>Zona</th>
																		<th>Naturaleza</th>
																		<th>Acciones</th>

																		</thead>
																		<tbody>
																			<?php
																										 $respuesta = controllerConfiguraciones::vistaMesas2();
																											foreach($respuesta as $row => $item){

																							 ?>
																					 <tr class="odd gradeX">
																							 <td><center><?php echo $item['NroMesa'] ?></center></td>
																							<?php  $nombreZona = controllerConfiguraciones::nombreZona($item['idzona']); ?>
																							 <td><center><?php echo $nombreZona['zona'] ?></center></td>
																							 <td><center><?php if($item['naturaleza'] == 'M')
																							 						{echo '<span class="label label-success">Mesa</span>';}
																													 else if ($item['naturaleza'] == 'A')
																													 {echo '<span class="label label-info">Adomicilio</span>';}
																													 else if ($item['naturaleza'] == 'L')
																													 {echo '<span class="label label-primary">Llevar</span>';}
																													 else {echo "ninguno";} ?>
																							</center></td>
																							 <td>
																								<div class="btn-group">
																								 <button data-toggle="dropdown" class="btn btn-warning btn-sm dropdown-toggle"><i class="fa fa-cog"></i> <span class="caret"></span></button>
																								 <ul class="dropdown-menu">
																									 <li><a href="#" data-toggle="modal" data-target="#ModalActualizarMesa1<?php echo $item['NroMesa']; ?>"><i class="fa fa-edit"></i>Editar</a></li>
																									 <li class="divider"></li>
																									 <li><a href="#" data-toggle="modal" data-target="#ModalEliminarMesa1<?php echo $item['NroMesa']; ?>"><i class="fa fa-times"></i> Eliminar</a></li>
																								 </ul>
																							 </div>

																							 </td>
																					 </tr>

																					 <!--Modal Eliminar  -->
																					 <div class="modal fade" id="ModalEliminarMesa1<?php echo $item['NroMesa']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
																							 <form name="contado"  method="post">
																							 <input type="hidden" name="NroMesaE" value="<?php echo $item['NroMesa']; ?>">
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
																															 una vez Eliminada la informacion de <strong>[ <?php echo $item['NroMesa']; ?> ]</strong> no podra ser Recuperada.</h4>
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
																		<div class="modal fade" id="ModalActualizarMesa1<?php echo $item['NroMesa']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
																		<form name="form1" method="post" action="">
																		<input type="hidden" name="NroMesaA" value="<?php echo $item['NroMesa']; ?>">
																		<div class="modal-dialog">
																		<div class="modal-content">
																		<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																		<h3 align="center" class="modal-title" id="myModalLabel">Actualizar mesa</h3>
																		</div>
																		<div class="panel-body">
																		<div class="row">
																		<div class="col-md-6">
																		<div class="input-group">
																		 <span class="input-group-addon">Zona</span>
																			 <select class="form-control" name="idzonaA" autocomplete="off" required>
																				 <?php
																											 $respues = controllerConfiguraciones::vistaZona();
																												 foreach($respues as $row => $it){
																					 ?>

																							 <option  <?php if($item['idzona'] == $it['idzona'] ){echo 'selected';} ?>    value="<?php echo $it['idzona']  ?>"><?php echo $it['zona']  ?></option>
																					 <?php } ?>
																			 </select>
																		 </div>
																		</div>
																		<div class="col-md-6">
																		<div class="input-group">
																		 <span class="input-group-addon">Naturaleza</span>
																			 <select class="form-control" name="naturalezaA" autocomplete="off" required>

																									<option <?php if($item['naturaleza'] == "M" ){echo 'selected';} ?> value="M">Mesa</option>
																									<option <?php if($item['naturaleza'] == "A" ){echo 'selected';} ?> value="A">Adomicilio</option>
																									<option <?php if($item['naturaleza'] == "L" ){echo 'selected';} ?> value="L">Llevar</option>

																			 </select>
																		 </div>
																		</div>
																		<br>
																		<br>
																		<div class="row">
																			<div class="col-md-6 col-md-offset-3">
																				<input class="form-control" name="EtiquetaA" placeholder="Ingrese Etiqueta" autocomplete="off" value="<?php echo $item['Etiqueta'] ?>"><br>
																			</div>
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
																	<div class="col-md-4">
																		<div class="modal fade" id="modalRegistrarMesa1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
																					 <form name="form1" method="post" action="">
																							 <div class="modal-dialog">
																									 <div class="modal-content">
																											 <div class="modal-header">
																													 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																													 <h3 align="center" class="modal-title" id="myModalLabel">Nueva mesa</h3>
																											 </div>
																											 <div class="panel-body">
																											 <div class="row">
																													 <div class="col-md-6">
																														 <div class="input-group">
																															 <span class="input-group-addon">Zona</span>
																																 <select class="form-control" name="idzonaR" autocomplete="off" required>
																																	 <?php
																																								 $c= controllerConfiguraciones::vistaZona();
																																									 foreach($c as $row => $cd){
																																						?>
																																			 <option value="<?php echo $cd['idzona']  ?>"><?php echo $cd['zona']  ?></option>
																																		 <?php } ?>
																																 </select>
																															 </div>
																													 </div>
																													 <div class="col-md-6">
																														 <div class="input-group">
																															 <span class="input-group-addon">Naturaleza</span>
																																 <select class="form-control" name="naturalezaR" autocomplete="off" required>
																																			 <option value="M">Mesa</option>
																																			 <option value="L">Llevar</option>
																																			 <option value="A">Adomicilio</option>
																																 </select>
																															 </div>
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
																		<table class="table table-bordered datatable table-striped table-hover width="100%"  border="0"">
																		<thead>
																		<th>Mesa</th>
																		<th>Zona</th>
																		<th>Naturaleza</th>
																		<th>Acciones</th>

																		</thead>
																		<tbody>
																			<?php
																										 $respuesta = controllerConfiguraciones::vistaMesas3();
																											foreach($respuesta as $row => $item){

																							 ?>
																					 <tr class="odd gradeX">
																							 <td><center><?php echo $item['NroMesa'] ?></center></td>
																							<?php  $nombreZona = controllerConfiguraciones::nombreZona($item['idzona']); ?>
																							 <td><center><?php echo $nombreZona['zona'] ?></center></td>
																							 <td><center><?php if($item['naturaleza'] == 'M')
																							 						{echo '<span class="label label-success">Mesa</span>';}
																													 else if ($item['naturaleza'] == 'A')
																													 {echo '<span class="label label-info">Adomicilio</span>';}
																													 else if ($item['naturaleza'] == 'L')
																													 {echo '<span class="label label-primary">Llevar</span>';}
																													 else {echo "ninguno";} ?>
																							</center></td>
																							 <td>

																								<div class="btn-group">
																								 <button data-toggle="dropdown" class="btn btn-warning btn-sm dropdown-toggle"><i class="fa fa-cog"></i> <span class="caret"></span></button>
																								 <ul class="dropdown-menu">
																									 <li><a href="#" data-toggle="modal" data-target="#ModalActualizarMesa1<?php echo $item['NroMesa']; ?>"><i class="fa fa-edit"></i>Editar</a></li>
																									 <li class="divider"></li>
																									 <li><a href="#" data-toggle="modal" data-target="#ModalEliminarMesa1<?php echo $item['NroMesa']; ?>"><i class="fa fa-times"></i> Eliminar</a></li>
																								 </ul>
																							 </div>

																							 </td>
																					 </tr>

																					 <!--Modal Eliminar  -->
																					 <div class="modal fade" id="ModalEliminarMesa1<?php echo $item['NroMesa']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
																							 <form name="contado"  method="post">
																							 <input type="hidden" name="NroMesaE" value="<?php echo $item['NroMesa']; ?>">
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
																															 una vez Eliminada la informacion de <strong>[ <?php echo $item['NroMesa']; ?> ]</strong> no podra ser Recuperada.</h4>
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
																		<div class="modal fade" id="ModalActualizarMesa1<?php echo $item['NroMesa']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
																		<form name="form1" method="post" action="">
																		<input type="hidden" name="NroMesaA" value="<?php echo $item['NroMesa']; ?>">
																		<div class="modal-dialog">
																		<div class="modal-content">
																		<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																		<h3 align="center" class="modal-title" id="myModalLabel">Actualizar mesa</h3>
																		</div>
																		<div class="panel-body">
																		<div class="row">
																		<div class="col-md-6">
																		<div class="input-group">
																		 <span class="input-group-addon">Zona</span>
																			 <select class="form-control" name="idzonaA" autocomplete="off" required>
																				 <?php
																											 $respues = controllerConfiguraciones::vistaZona();
																												 foreach($respues as $row => $it){
																					 ?>

																							 <option  <?php if($item['idzona'] == $it['idzona'] ){echo 'selected';} ?>    value="<?php echo $it['idzona']  ?>"><?php echo $it['zona']  ?></option>
																					 <?php } ?>
																			 </select>
																		 </div>
																		</div>
																		<div class="col-md-6">
																		<div class="input-group">
																		 <span class="input-group-addon">Naturaleza</span>
																			 <select class="form-control" name="naturalezaA" autocomplete="off" required>

																									<option <?php if($item['naturaleza'] == "M" ){echo 'selected';} ?> value="M">Mesa</option>
																									<option <?php if($item['naturaleza'] == "A" ){echo 'selected';} ?> value="A">Adomicilio</option>
																									<option <?php if($item['naturaleza'] == "L" ){echo 'selected';} ?> value="L">Llevar</option>

																			 </select>
																		 </div>
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

 </div>
</body>

  <script>

	$(document).ready(function() {
$( "#submitEmail" ).prop( "disabled", true );
	});

	$( "#comprobacionContrasena" ).keyup(function() {
		$('#noMatch').removeAttr('hidden');
		var cont1 = $('#Contrasena').val();
		var cont2 = $('#comprobacionContrasena').val();
		if(cont1==cont2)
		{
		$( "#noMatch" ).hide();
		$('#Match').show();
	  $( "#submitEmail" ).prop( "disabled", false );
		}
		else
			{
			$( "#noMatch" ).show();
			$( "#Match" ).hide();
			$( "#submitEmail" ).prop( "disabled", true );
			}
	});

  </script>
