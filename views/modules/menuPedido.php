<?php
	session_start();
	if(!$_SESSION["validar"]){
		header("location:ingreso");
		exit();
	}
	if (!isset($_GET['IdPedido'])) {
		header('Location:salon');
		exit();
	}



	$idPedido = $_GET['IdPedido'];
	$Pedido = modelSalon::Pedido($idPedido);
	if (!$Pedido) {
		header('Location:salon');
		exit();
	}
	$Mesero = modelSalon::Mesero($Pedido['IdPersonal']);
	$Mesa = modelSalon::DetalleMesaxPedido($idPedido);
	$DMesa = modelSalon::verificarEstadoMesa($Mesa['NroMesa']);
?>

<style>
	.selectpicker{
  		font-size: 50px !important;
	}
	.filter-option {
    	font-size: 20px;
	}

	.tachado {
    	text-decoration: line-through;
	}
</style>

<body class="hold-transition skin-blue sidebar-collapse sidebar-mini">
	<div class="wrapper">
		<?php
			include "views/modules/cabezote.php";
			include "views/modules/botonera.php";

		?>
  		<div class="content-wrapper">
    		<section class="content">



				<div class="row">
           			<div class="col-md-12" align="center">
						<div class="callout callout-success">
							<div class="row">
								<div class="col-md-1">
									<button type="button" class="btn btn-success btn-lg btn-block" onClick="window.location.href='salon'"><b><i class="fa fa-arrow-left"></i></b></button>
								</div>
								<div class="col-md-2 col-md-offset-2" style="margin-top: 10px;"><h4 id="NomMesero">Mesero: <?php echo $Mesero['Nombres']; ?></h4></div>
								<div class="col-md-2" style="margin-top: 10px;"><h4>Mesa: # <?php echo $DMesa["Etiqueta"]; ?></h4></div>
								<div class="col-md-2" style="margin-top: 10px;"><h4 id="NombreCli">Cliente: <?php echo $Pedido['NombreCliente']; ?></h4></div>
								<div class="col-md-1 col-md-offset-1">
									<button type="button" class="btn btn-success btn-lg btn-block" onClick="CambiarNombre()">
										<b><i class="fa fa-edit"></i></b>
									</button>
									</div>
								<div class="col-md-1">
									<button type="button" class="btn btn-success btn-lg btn-block" onClick="ModalMeseros()">
										<b><i class="fa fa-user"></i></b>
									</button>
									</div>
							</div>
						</div>
           			</div>
				</div>



				<div class="row">
			 		<div class="col-md-12">
						<div class="box box-primary">
			 				<div class="box-header">
								<h3 class="box-title">Cuentas</h3>
							</div>
							<div class="box-body">
								<span id="Cuentas"></span>
							  	<button data-toggle="modal" onClick="crearCuenta()" class="btn btn-info btn-lg">
									<i class="fa fa-plus"></i> <b>Agregar Cuenta </b>
								</button>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<div class="box box-primary">
							<div class="box-header">
								<h3 class="box-title">Platos</h3>
							</div>
							<div class="box-body" >
								<div class="contenedorPlatos">
									<spam id="Platos"></spam>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="box box-primary">
							<div class="box-header">
								<h3 class="box-title">Detalle de Pedido</h3>
							</div>
							<div class="box-body" >
								<div class="contenedorPlatos" style="height: 450px;">
									<table id="TablaPedidos" class="table table-condensed compact table-striped table-hover border='0' ">
										<thead>
											<th style="width:10px;">Acciones</th>
											<th style="width:75px;">Descripcion</th>
											<th style="width:20px;">Cant</th>
											<th style="width:20px;" id='pu'>P.U</th>
											<th style="width:20px;">P.T</th>
											<th style="width:20px;">Msj</th>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
								<div class="contenedorPlatos" style="height: 7px;">
								</div>
								<div class="contenedorPlatos" style="height: 90px;">
									<div class="btn-group btn-group-justified" role="group" aria-label="...">
										<div class="btn-group" role="group">
											<button type="button" data-toggle="modal" data-target="#CantidaPerson" id="Precuenta" class="btn btn-success btn-lg" onClick="$('#getCantidadComensales').val(1)" style="font-size: 20px;">
												<b><i class="fa fa-money fa-2x"></i><br>Pre-Cuenta</b>
											</button>
										</div>
										<div class="btn-group" role="group">
											<button type="button" id="EnviarCocina" class="btn btn-primary btn-lg" style="font-size: 20px;" onclick="actualizarDetallePedido(<?php echo $idPedido; ?>, '')">
												<b><i class="fa fa-cutlery fa-2x"></i><br>Enviar a Cocina</b>
											</button>
										</div>
										<?php if($_SESSION["puesto"] == 2) { ?>
											<div class="btn-group" role="group">
												<button type="button" id="Anular" class="btn btn-warning btn-lg" style="font-size: 20px;" onclick="CredencialUser(<?php echo $idPedido; ?>, 'A', 'AN')">
													<b><i class="fa fa-exclamation fa-2x"></i><br>Anular</b>
												</button>
											</div>
											<div class="btn-group" role="group">
												<button type="button" id="BtnEliminar" class="btn btn-danger btn-lg" style="font-size: 20px;" data-permiso="1" onclick="CredencialUser(<?php echo $idPedido; ?>, <?php echo $Mesa['NroMesa']; ?>, 'DEL')">
													<b><i class="fa fa-trash fa-2x"></i><br>Eliminar Pedido</b>
												</button>
											</div>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="box box-primary">
							<div class="box-header">
								<h3 class="box-title">Detalle de Comprobante</h3>
							</div>
							<div class="box-body" >
								<div class="contenedorPlatos">
									<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
										<div class="panel panel-default">
											<div class="panel-heading" style="cursor: pointer" role="tab" id="headingConfig" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseConfig" aria-expanded="true" aria-controls="collapseConfig">
												<h4 class="panel-title">
													<b><i class="fa fa-gear fa-spin"></i> Configuraciones</b>
												</h4>
											</div>
											<div id="collapseConfig" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingConfig">
												<div class="panel-body">
													<div class="btn-group" data-toggle="buttons">
														<label id="lblPropina" class="btn btn-md btn-default active">
															<input type="checkbox" id="PropinaId" onChange="getDetalleFactura()"> Propina
														</label>
														<label id="lblExento" class="btn btn-md btn-primary">
															<input type="checkbox" id="ExentosId" onChange="getDetalleFactura()"> Exentos
														</label>
														<label id="lblRetencion" class="btn btn-md btn-primary">
															<input type="checkbox" id="RetencionId" onChange="getDetalleFactura()"> Retencion
														</label>
													</div>
												</div>
											</div>
										</div>
										<br>
										<label>  Subtotal </label>
										<div class="input-group">
											<span class="input-group-addon">$</span>
											<input style="text-align: right;" class="form-control" name="SubTotal" id="SubTotal" placeholder="0.00" autocomplete="off" disabled required>
										</div>
										<br>
										<label>  Propina </label>
										<div class="input-group">
											<span class="input-group-addon">+$</span>
											<input style="text-align: right;" class="form-control" name="Propina" id="Propina" placeholder="0.00" autocomplete="off" disabled required>
										</div>
										<br>
										<label>  Exento </label>
										<div class="input-group">
											<span class="input-group-addon"> -$</span>
											<input style="text-align: right;" class="form-control" name="Exento" id="Exento" placeholder="0.00" autocomplete="off" disabled required>
										</div>
										<br>
										<label>  Retencion </label>
										<div class="input-group">
											<span class="input-group-addon"> -$</span>
											<input style="text-align: right;" class="form-control" name="Retencion" id="Retencion" placeholder="0.00" autocomplete="off" disabled required>
										</div>
										<br>
										<label>  Total </label>
										<div class="input-group">
											<span class="input-group-addon">$</span>
											<input style="text-align: right;" class="form-control" name="Total" id="Total" placeholder="0.00" autocomplete="off" disabled required>
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
</body>

<div class="modal fade" id="CantidaItems" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="CantidaItems">
  	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="gridSystemModalLabel"><span id="IdTitle">Cantidad</span></h4>
			</div>
			<div class="modal-body">
				<div id='Step1' class="container-fluid">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group form-group-lg">
								<input type="text" class="form-control" style="font-size: 40px;text-align: right;" id="getCantidad"  placeholder="Cantidad">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="btn-group btn-group-justified" role="group" aria-label="...">
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-lg" style="font-size: 40px;" onclick="numPad('1', '#getCantidad')"><b>1</b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-lg" style="font-size: 40px;" onclick="numPad('2', '#getCantidad')"><b>2</b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-lg" style="font-size: 40px;" onclick="numPad('3', '#getCantidad')"><b>3</b></button>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="btn-group btn-group-justified" role="group" aria-label="...">
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-lg" style="font-size: 40px;" onclick="numPad('4', '#getCantidad')"><b>4</b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-lg" style="font-size: 40px;" onclick="numPad('5', '#getCantidad')"><b>5</b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-lg" style="font-size: 40px;" onclick="numPad('6', '#getCantidad')"><b>6</b></button>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="btn-group btn-group-justified" role="group" aria-label="...">
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-lg" style="font-size: 40px;" onclick="numPad('7', '#getCantidad')"><b>7</b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-lg" style="font-size: 40px;" onclick="numPad('8', '#getCantidad')"><b>8</b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-lg" style="font-size: 40px;" onclick="numPad('9', '#getCantidad')"><b>9</b></button>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="btn-group btn-group-justified" role="group" aria-label="...">
							<div class="btn-group" role="group">
									<button type="button" id="idFinalizado" class="btn btn-success btn-lg" style="font-size: 40px;" onclick="guarnicion_termino()"><b><i class="fa fa-check" aria-hidden="true"></i></b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-lg" style="font-size: 40px;" onclick="numPad('0', '#getCantidad')"><b>0</b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-danger btn-lg" style="font-size: 40px;" onclick="numPad('del', '#getCantidad')"><b><i class="fa fa-long-arrow-left" aria-hidden="true"></i></b></button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="Step2" class="container-fluid">
					<div class="row">
						<div class="col-md-12 text-center">
							<div class="btn-group" data-toggle="buttons">
								<label class="btn btn-primary btn-lg">
									<input type="radio" name="termino" value="Azul" id="option1"> <b style="font-size: 35px;">Azul</b>
								</label>
								<label class="btn btn-danger btn-lg">
									<input type="radio" name="termino" value="Rojo" id="option2"> <b style="font-size: 35px;">Rojo</b>
								</label>
								<label class="btn btn-info btn-lg">
									<input type="radio" name="termino" value="1/2" id="option3"> <b style="font-size: 35px;">1/2</b>
								</label>
								<label class="btn btn-info btn-lg">
									<input type="radio" name="termino" value="3/4" id="option3"> <b style="font-size: 35px;">3/4</b>
								</label>
								<label class="btn btn-info btn-lg">
									<input type="radio" name="termino" value="B/C" id="option3"> <b style="font-size: 35px;">B/C</b>
								</label>
							</div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-10 col-md-offset-1">
							<div class="form-group">
								<select id="idguarnicion" class=" form-control input-lg selectpicker" data-style="input-lg btn-default" multiple data-max-options="2">
									<option style="font-size: 20px;" value="Papas Fritas">Papas Fritas</option>
									<option style="font-size: 20px;" value="Veg. Asado">Veg. Asado</option>
									<option style="font-size: 20px;" value="Veg. Vapor">Veg. Vapor</option>
									<option style="font-size: 20px;" value="Veg. Salteados">Veg. Salteados</option>
									<!-- <option style="font-size: 20px;" value="Frijoles">Frijoles</option>
									<option style="font-size: 20px;" value="Arroz">Arroz</option>
									<option style="font-size: 20px;" value="Chorizo">Chorizo</option> -->
									<option style="font-size: 20px;" value="Papa al horno">Papa al horno</option>
									<option style="font-size: 20px;" value="Papa salteada">Papa salteada</option>
									<!-- <option style="font-size: 20px;" value="Pure de papa">Pure de papa</option>
									<option style="font-size: 20px;" value="Ensalda de papa">Ensalda de papa</option>
									<option style="font-size: 20px;" value="Aguacate">Aguacate</option>
									<option style="font-size: 20px;" value="Queso">Queso</option>
									<option style="font-size: 20px;" value="Crema">Crema</option>
									<option style="font-size: 20px;" value="Contorno tipico">Contorno tipico</option>
									<option style="font-size: 20px;" value="Chimichurri">Chimichurri</option>
									<option style="font-size: 20px;" value="Chile toreado">Chile toreado</option> -->
									<option style="font-size: 20px;" value="Tortilla frita">Tortilla frita</option>
									<option style="font-size: 20px;" value="Tortilla">Tortilla</option>
									<!-- <option style="font-size: 20px;" value="Enredo">Enredo</option> -->
									<option style="font-size: 20px;" value="Pan con Ajo">Pan con Ajo</option>
									<option style="font-size: 20px;" value="Pan sin Ajo">Pan sin Ajo</option>
									<!-- <option style="font-size: 20px;" value="Leche">Leche</option>
									<option style="font-size: 20px;" value="Chimol">Chimol</option>
									<option style="font-size: 20px;" value="Salsa Rosada">Salsa Rosada</option>
									<option style="font-size: 20px;" value="Limon">Limon</option>
									<option style="font-size: 20px;" value="Cebolla Curtida">Cebolla Curtida</option>
									<option style="font-size: 20px;" value="Ensalada Fresca">Ensalada Fresca</option>
									<option style="font-size: 20px;" value="Salsa jalapeña">Salsa jalapeña</option>
									<option style="font-size: 20px;" value="Tocino">Tocino</option>
									<option style="font-size: 20px;" value="Camaron  Jumbo Unidad">Camaron  Jumbo Unidad</option>
									<option style="font-size: 20px;" value="Langosta 1/2 Plato Super">Langosta 1/2 Plato Super</option> -->
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-10 col-md-offset-1">
							<div class="form-group form-group-lg">
								<input type="text" class="form-control" style="font-size: 15px;text-align: left;" id="getMsmPlatoGuar" placeholder="Mensaje">
							</div>
						</div>
					</div>
					<div id="IdAdd" class="row">
						<div class="col-md-10 col-md-offset-1">
							<button type="button" class="btn btn-success btn-lg btn-block" onClick="finalizarRegistro()"><b><i class="fa fa-plus"></i> Agregar Plato</b></button>
						</div>
					</div>
					<div id="IdUp" class="row">
						<div class="col-md-10 col-md-offset-1">
							<button type="button" class="btn btn-success btn-lg btn-block" onClick="updateDetallePedido()"><b><i class="fa fa-floppy-o"></i> Actualizar</b></button>
						</div>
					</div>
				</div>
			</div>
		</div>
  	</div>
</div>

<div class="modal fade" id="CantidaPerson" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="CantidaPerson">
  	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="gridSystemModalLabel"><span >Cantidad de Comensales</span></h4>
			</div>
			<div class="modal-body">
				<div id='Step1' class="container-fluid">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group form-group-lg">
								<input type="text" class="form-control" style="font-size: 40px;text-align: right;" id="getCantidadComensales" placeholder="Cantidad">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="btn-group btn-group-justified" role="group" aria-label="...">
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-lg" style="font-size: 40px;" onclick="numPad('1', '#getCantidadComensales')"><b>1</b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-lg" style="font-size: 40px;" onclick="numPad('2', '#getCantidadComensales')"><b>2</b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-lg" style="font-size: 40px;" onclick="numPad('3', '#getCantidadComensales')"><b>3</b></button>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="btn-group btn-group-justified" role="group" aria-label="...">
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-lg" style="font-size: 40px;" onclick="numPad('4', '#getCantidadComensales')"><b>4</b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-lg" style="font-size: 40px;" onclick="numPad('5', '#getCantidadComensales')"><b>5</b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-lg" style="font-size: 40px;" onclick="numPad('6', '#getCantidadComensales')"><b>6</b></button>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="btn-group btn-group-justified" role="group" aria-label="...">
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-lg" style="font-size: 40px;" onclick="numPad('7', '#getCantidadComensales')"><b>7</b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-lg" style="font-size: 40px;" onclick="numPad('8', '#getCantidadComensales')"><b>8</b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-lg" style="font-size: 40px;" onclick="numPad('9', '#getCantidadComensales')"><b>9</b></button>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="btn-group btn-group-justified" role="group" aria-label="...">
							<div class="btn-group" role="group">
									<button type="button" id="IdSaveC" class="btn btn-success btn-lg" onclick="precuenta()" style="font-size: 40px;"><b><i class="fa fa-check" aria-hidden="true"></i></b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-lg" style="font-size: 40px;" onclick="numPad('0', '#getCantidadComensales')"><b>0</b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-danger btn-lg" style="font-size: 40px;" onclick="numPad('del', '#getCantidadComensales')"><b><i class="fa fa-long-arrow-left" aria-hidden="true"></i></b></button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="msmModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="msmModal">
  	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="gridSystemModalLabel"><span>Mensaje</span></h4>
			</div>
			<div class="modal-body">
				<div id='Step1' class="container-fluid">
					<input type="hidden" id="msmIdDetallePedido">
					<input type="hidden" id="msmCant">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group form-group-lg">
								<input type="text" class="form-control" style="font-size: 15px;text-align: left;" id="getMsmPlato" placeholder="Mensaje">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="btn-group btn-group-justified" role="group" aria-label="...">
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-md" style="font-size: 25px;" onClick="abcPad('Q')"><b>Q</b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-md" style="font-size: 25px;" onClick="abcPad('W')"><b>W</b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-md" style="font-size: 25px;" onClick="abcPad('E')"><b>E</b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-md" style="font-size: 25px;" onClick="abcPad('R')"><b>R</b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-md" style="font-size: 25px;" onClick="abcPad('T')"><b>T</b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-md" style="font-size: 25px;" onClick="abcPad('Y')"><b>Y</b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-md" style="font-size: 25px;" onClick="abcPad('U')"><b>U</b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-md" style="font-size: 25px;" onClick="abcPad('I')"><b>I</b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-md" style="font-size: 25px;" onClick="abcPad('O')"><b>O</b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-md" style="font-size: 25px;" onClick="abcPad('P')"><b>P</b></button>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="btn-group btn-group-justified" role="group" aria-label="...">
									<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-md" style="font-size: 25px;" onClick="abcPad('A')"><b>A</b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-md" style="font-size: 25px;" onClick="abcPad('S')"><b>S</b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-md" style="font-size: 25px;" onClick="abcPad('D')"><b>D</b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-md" style="font-size: 25px;" onClick="abcPad('F')"><b>F</b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-md" style="font-size: 25px;" onClick="abcPad('G')"><b>G</b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-md" style="font-size: 25px;" onClick="abcPad('H')"><b>H</b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-md" style="font-size: 25px;" onClick="abcPad('J')"><b>J</b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-md" style="font-size: 25px;" onClick="abcPad('K')"><b>K</b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-md" style="font-size: 25px;" onClick="abcPad('L')"><b>L</b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-md" style="font-size: 25px;" onClick="abcPad('Ñ')"><b>Ñ</b></button>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="btn-group btn-group-justified" role="group" aria-label="...">
								<div class="btn-group" data-toggle="buttons">
									<label id="lblMayus" class="btn btn-md btn-info" style="font-size: 25px;">
										<input type="checkbox" id="MayusId" > <i class="fa fa-long-arrow-up" aria-hidden="true"></i>
									</label>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-md" style="font-size: 25px;" onClick="abcPad('Z')"><b>Z</b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-md" style="font-size: 25px;" onClick="abcPad('X')"><b>X</b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-md" style="font-size: 25px;" onClick="abcPad('C')"><b>C</b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-md" style="font-size: 25px;" onClick="abcPad('V')"><b>V</b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-md" style="font-size: 25px;" onClick="abcPad('B')"><b>B</b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-md" style="font-size: 25px;" onClick="abcPad('N')"><b>N</b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-md" style="font-size: 25px;" onClick="abcPad('M')"><b>M</b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-danger btn-md" style="font-size: 25px;" onClick="abcPad('del')"><b><i class="fa fa-long-arrow-left" aria-hidden="true"></i></b></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-success btn-md" style="font-size: 25px;" onClick="UpdateMensaje()"><b><i class="fa fa-check-circle-o" aria-hidden="true"></i></b></button>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="btn-group btn-group-justified" role="group" aria-label="...">
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary btn-md" style="font-size: 25px;" onClick="abcPad(' ')"><b>Espacio</b></button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="SepCuentaModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="SepCuentaModal">
  	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="gridSystemModalLabel"><span>Separa Cuenta</span></h4>
			</div>
			<div class="modal-body">
				<!-- <div class="container"> -->
					<div class="row">
						<div class="col-md-8 col-md-offset-1">
							<b><span style="font-size: 40px;" data-DtPedido="0" id="IdItems"></span></b>
						</div>
						<div class="col-md-2">
							<b><span style="font-size: 40px;" id="CantItems" data-cantidad="0"></span></b>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-10 col-md-offset-1">
							<div class="form-group">
								<select id="IdPedidos" class="form-control input-lg selectpicker" data-style="input-md btn-default" multiple title="Selecione la Cuenta...">
								</select>
							</div>
						</div>
					</div>
					<span id="IdInputs" data-validation="0"></span>
					<div class="row">
						<div class="col-md-6 col-md-offset-3">
							<button type="button" id="BtnSaveTrasladado" onClick="trasladar()" class="btn btn-primary btn-lg btn-block" style="font-size: 30px;" disabled><b><i class="fa fa-exchange" aria-hidden="true"></i> Trasladar</b></button>
						</div>
					</div>
				<!-- </div> -->
			</div>
		</div>
	</div>
</div>



<div class="modal" name="ModalMeseros" id="IdModalMeseros" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<form name="form1" method="post" action="">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h3 align="center" class="modal-title" id="myModalLabel">Meseros</h3>
				</div>
				<div class="panel-body">
					<div class="row text-center">
						<div class="col-md-12">
							<input class="form-control" type="hidden" id="idMesa">
							<?php
								$respuesta = controllerSalon::ListadoMeseros();
								foreach($respuesta as $row => $itemMeseros){
							?>
								<a href="#" onClick="CambiarMesero('<?php echo $itemMeseros["IdPersonal"] ?>')" class="btn btn-sq-lg btn-primary">
									<i class="fa fa-user fa-5x"></i><br/>
									<?php echo $itemMeseros['Nombres'] ?>
								</a>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</form>
</div>


<script charset="UTF-8">

	$(document).ready(function() {
		<?php if ($DMesa['naturaleza'] === 'L') { ?>
			$('#PropinaId').attr('checked', false);
		<?php } ?>
		cuentas();
		getPlatos();
		getDetallePedido();
// 		iniScript();
		$('.selectpicker').selectpicker({
   			size: '15'
		});
	});

	// para el modal de cinta de auditoria
	function ModalMeseros() {
		$("#IdModalMeseros").modal("show");
	}
	

	function crearCuenta() {
		idPersonal = <?php echo $Pedido['IdPersonal'];  ?>;
		idMesa = <?php echo $Mesa['NroMesa'] ?>;
		$.ajax({
			async: true,
    		url : 'controllers/Ajax/AjaxPedido.php', // la URL para la petición
			data: {"AccionAjax": "CrearCuentas", "idPersonal": idPersonal, "idMesa": idMesa},
			type: 'POST',
			dataType : 'json', // el tipo de información que se espera de respuesta
			success : function(json) {
				// console.log(json);
				getDetallePedido();
			},
			error : function(xhr, status) {
				console.log('Disculpe, existió un problema');
			},
			complete : function(xhr, status) {
				console.log('Petición realizada');
				cuentas();
			}
		});
	}

	var NumeroCuentas = 0;
	var idCuentaSc = 0;
	function cuentas() {
		NoMesa = <?php echo $Mesa['NroMesa'] ?>;
		Pedido = <?php echo $idPedido ?>;
		$.ajax({
			async: true,
    		url : 'controllers/Ajax/AjaxPedido.php', // la URL para la petición
			data: {"AccionAjax": "Cuentas", "mesa": NoMesa, "pedidoActual": Pedido},
			type: 'POST',
			dataType : 'json', // el tipo de información que se espera de respuesta
			success : function(json) {
				Btn = '';
				var option = '';
				json.forEach(data => {
					var nombreSle = '';
					if (data.Nombre != '------') {
						nombreSle = `[${data.Nombre}]`;
					}
					Btn +=`
					<a class="btn ${data.Tipo} btn-lg" ${data.Style} href="menuPedido?IdPedido=${data.IdPedido}">
						<i class="fa fa-file-text"></i>  <b>Pedido # ${data.IdPedido} ${nombreSle} </b>
					</a>
					`;
					idCuentaSc = data.Ult;
					if (data.IdPedido != Pedido) {
						option += `<option style="font-size: 20px;" data-icon="fa fa-file-text" value="${data.IdPedido}">Pedido # ${data.IdPedido} ${nombreSle}</option>`;
					}

				});
				$('#IdPedidos').html(option).selectpicker('refresh');
				NumeroCuentas = json.length;
				$('#Cuentas').html(Btn);
			},
			error : function(xhr, status) {
				console.log('Disculpe, existió un problema');
			},
			complete : function(xhr, status) {
				console.log('Petición realizada');
			}
		});
	}

	function getPlatos() {
		$.ajax({
			async: true,
    		url : 'controllers/Ajax/AjaxPedido.php', // la URL para la petición
			data: {"AccionAjax": "Platos"},
			type: 'POST',
			dataType : 'json', // el tipo de información que se espera de respuesta
			success : function(json) {
				// console.log(json);
				Categoria = '<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
				json.forEach(data => {
					Btn = '<div class="list-group">';
					data.Platos.forEach(Plato => {
						Estado = '';
						if (Plato.FP === 'Bar') {
							Estado = 'B';
						}else if(Plato.FP === 'Cocina'){
							Estado = 'M';
						}
						Btn += `
  						<a href="#" data-toggle="modal" data-target="#CantidaItems"	 onClick="addDetallePartida(${Plato.IdPlato}, ${Plato.Precio}, '${Estado}')" class="list-group-item">
						  ${Plato.Plato.toUpperCase()}
							<span class="badge">$ ${Plato.Precio}</span>
  						</a>
						`;
					});
					Btn += '</div>';
					Categoria +=`
					<div class="panel panel-default">
						<div class="panel-heading" style="cursor: pointer" role="tab" id="heading${data.IdCategoria}" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse${data.IdCategoria}" aria-expanded="${data.expanded}" aria-controls="collapse${data.IdCategoria}">
							<h4 class="panel-title">
								<b>${data.Nombre}</b>
							</h4>
						</div>
						<div id="collapse${data.IdCategoria}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading${data.IdCategoria}">
							<div class="panel-body">
								${Btn}
							</div>
						</div>
					</div>
					`;
				});
				Categoria += '</div>';
				$('#Platos').html(Categoria);
			},
			error : function(xhr, status) {
				console.log('Disculpe, existió un problema');
			},
			complete : function(xhr, status) {
				console.log('Petición realizada');
			}
		});
	}

	//var timer = 360000;
	function getDetallePedido() {
		idPedido = <?php echo $idPedido ?>;
		$.ajax({
			async: true,
    		url : 'controllers/Ajax/AjaxPedido.php', // la URL para la petición
			data: {"AccionAjax": "DetallePedido", "idPedido": idPedido},
			type: 'POST',
			dataType : 'json', // el tipo de información que se espera de respuesta
			success : function(json) {
				//console.log(json);
				$('#TablaPedidos tbody').empty();
				Subtotal = 0.00;
				//console.log(NumeroCuentas);

				json.ListPlato.forEach(data => {
					var SepCuentas = '';
					if (NumeroCuentas > 1) {
						SepCuentas = `
							<div class="btn-group" role="group">
								<button type="button" class="btn btn-info" onclick="SepararCuenta(${ data.IdDetallePedido }, '${ data.Plato }', ${ data.Cantidad })">
									<b><i class="fa fa-code"></i></b>
								</button>
							</div>
						`;
					}
					Pt = (data.Precio * data.Cantidad);
					Subtotal += Pt;
					Row = `
					<tr>
						<td>
							<div class="btn-group btn-group" role="group" aria-label="...">
								${SepCuentas}
								${data.Accion}
							</div>
						</td>
						<td><span class="text-${data.Label}">${data.Ico} ${data.Plato}</span></td>
						<td style="text-align: right;">${data.Cantidad}</td>
						<td style="text-align: right;">$ ${parseFloat(data.Precio).toFixed(2)}</td>
						<td style="text-align: right;">$ ${ Pt.toFixed(2) }</td>
						<td>${ data.Mensaje }</td>
					</tr>
					`;
					$('#TablaPedidos tbody').append(Row);
				});
				Row = `
					<tr>
						<td colspan="4" style="text-align: right;"><b>SUBTOTAL...</b></td>
						<td style="text-align: right;"><spam id="SubtotalTbl" data-subtotal="${ Subtotal.toFixed(2) }">$ ${ Subtotal.toFixed(2) }</spam></td>
						<td></td>
					</tr>
				`;

				$("#Precuenta").attr('disabled', true);
				$("#Anular").attr('disabled', true);
				$("#EnviarCocina").attr('disabled', true);
				$("#BtnEliminar").data('permiso', 1);
				if (json.ListPlato.length > 0) {

					$("#Precuenta").attr('disabled', false);
					$("#Anular").attr('disabled', false);
					$("#EnviarCocina").attr('disabled', false);
					$("#BtnEliminar").data('permiso', 0);

				}

				$('#TablaPedidos tbody').append(Row);
				// if (json.Timer > 0) {
				// 	//timer = json.Timer;
				// 	timedCount(timer);
				// }elseif(json.Timer === 0){

				// }
				getDetalleFactura();
			},
			error : function(xhr, status) {
				console.log('Disculpe, existió un problema');
			},
			complete : function(xhr, status) {
				console.log('Petición realizada');
			}
		});
	}

	function getDetalleFactura(){
		Subtotal = parseFloat($('#SubtotalTbl').data('subtotal'));
		$('#SubTotal').val(Subtotal.toFixed(2));

		// Propina
		Propina = 0.00;
		if ($("#PropinaId").prop('checked')) {
			Propina = (Subtotal * 0.10);
			$('#lblPropina').removeClass('btn-primary');
			$('#lblPropina').addClass('btn-default');

		}else{
			$('#lblPropina').removeClass('btn-default');
			$('#lblPropina').addClass('btn-primary');
		}
		$('#Propina').val(Propina.toFixed(2));

		//Exento
		Exento = 0.00;
		if ($("#ExentosId").prop('checked')) {
			Exento = ((Subtotal / 1.13) * 0.13);
			$('#lblExento').removeClass('btn-primary');
			$('#lblExento').addClass('btn-default');

		}else{
			$('#lblExento').removeClass('btn-default');
			$('#lblExento').addClass('btn-primary');
		}
		$('#Exento').val(Exento.toFixed(2));

		//Retencion
		Retencion = 0.00;
		if ($("#RetencionId").prop('checked')) {
			Retencion = Subtotal * 0.01;
			$('#lblRetencion').removeClass('btn-primary');
			$('#lblRetencion').addClass('btn-default');
		}else{
			$('#lblRetencion').removeClass('btn-default');
			$('#lblRetencion').addClass('btn-primary');
		}
		$("#Retencion").val(Retencion.toFixed(2));



		//Total
		Total = (Subtotal + Propina) - Exento - Retencion;
		$("#Total").val(Total.toFixed(2))
	}

	function addDetallePartida(IdPlato, Precio, Estado) {
		$("#IdTitle").html('Cantidad');

		$("#Step2").removeClass('container-fluid');
		$("#Step2").addClass('hidden');

		$("#Step1").removeClass('hidden');
		$("#Step1").addClass('container-fluid');

		$("#IdAdd").removeClass('hidden');
		$("#IdAdd").addClass('row');

		$("#IdUp").removeClass('row');
		$("#IdUp").addClass('hidden');

		$("#getCantidad").val(1);
		$('#idFinalizado').attr('disabled', false);
		Data = {
			"IdPedido": <?php echo $idPedido ?>,
			"IdPlato": IdPlato,
			"Cantidad": 1,
			"Precio": Precio,
			"Comentario": '',
			"Estado": Estado,
		};
		localStorage.setItem('AddCantidad', JSON.stringify(Data));
	}

	// function onKeyUP(event) {
	// 	var codigo = event.keyCode;
	// 	if(codigo >= 96 && codigo <= 105){
	// 		numPad(String.fromCharCode(codigo), '#getCantidad')
	// 	}
	// }

	function numPad(valor, input){
		var oldValor = $(input).val();
		var newValor = '';
		if (valor === 'del') {
			newValor = oldValor.slice(0, -1);
		}else{
			newValor = oldValor+valor;
		}

		button = '#IdSaveC';
		if (input === '#getCantidad') {
			button = '#idFinalizado';
		}

		if (newValor === '' || newValor <= 0) {
			$(button).attr('disabled', true);
		}else{
			$(button).attr('disabled', false);
		}
		$(input).val(newValor);
		if (input === '#getCantidad') {
			var userID = JSON.parse(localStorage.getItem('AddCantidad'));
			userID["Cantidad"] = parseInt(newValor);
			localStorage.setItem('AddCantidad', JSON.stringify(userID));
		}
	}

	function guarnicion_termino() {
		var Data = JSON.parse(localStorage.getItem('AddCantidad'));
		if (Data.Estado === 'B') {
			finalizarRegistro();
			$("#CantidaItems").modal('hide')
			return;
		}
		$("#IdTitle").html('Termino & Guarnicion');
		$("#Step1").removeClass('container-fluid');
		$("#Step1").addClass('hidden');

		$("#Step2").removeClass('hidden');
		$("#Step2").addClass('container-fluid');
	}

	$("input[type=radio][name='termino']").change(function(){
		getComentario();
	});

	$("#idguarnicion").change(function(){
		getComentario();
	});

	function getComentario()
	{
		var termino = $("input[name='termino']:checked").val();
		if (termino === undefined) {
			termino = '';
		}else{
			termino = 'Termino: '+termino;
		}

		var guarnicion = $("#idguarnicion").val();
		if (guarnicion === null) {
			guarnicion = '';
		}else{
			guarnicion = 'Guarnicion: '+guarnicion;
		}
		var userID = JSON.parse(localStorage.getItem('AddCantidad'));
		userID["Comentario"] = `${termino} ${guarnicion}`;
		$("#getMsmPlatoGuar").val(userID["Comentario"]);
		localStorage.setItem('AddCantidad', JSON.stringify(userID));
	}

	$('#getMsmPlatoGuar').keyup(()=>{
		var Data = JSON.parse(localStorage.getItem('AddCantidad'));
		Data["Comentario"] = $("#getMsmPlatoGuar").val();
		localStorage.setItem('AddCantidad', JSON.stringify(Data));
	});

	function finalizarRegistro(){
		var Data = JSON.parse(localStorage.getItem('AddCantidad'));

		$.ajax({
			async: true,
    		url : 'controllers/Ajax/AjaxPedido.php', // la URL para la petición
			data: {"AccionAjax": "AddDetallePartida", "Data": Data},
			type: 'POST',
			dataType : 'json', // el tipo de información que se espera de respuesta
			success : function(json) {
				// console.log(json);
			},
			error : function(xhr, status) {
				console.log('Disculpe, existió un problema');
			},
			complete : function(xhr, status) {
				console.log('Petición realizada');
				$("#CantidaItems").modal('hide');
				$("#idguarnicion").val('');
				$("#idguarnicion").selectpicker("refresh");
				getDetallePedido();
			}
		});
	}

	function eliminarPedido(IdPedido, Mesa) {
		$.ajax({
			async: true,
    		url : 'controllers/Ajax/AjaxPedido.php', // la URL para la petición
			data: {"AccionAjax": "DelDetallePartida", "IdPedido": IdPedido, "Mesa":Mesa},
			type: 'POST',
			dataType : 'json', // el tipo de información que se espera de respuesta
			success : function(json) {
				// console.log(json);
			},
			error : function(xhr, status) {
				console.log('Disculpe, existió un problema');
			},
			complete : function(xhr, status) {
				console.log('Petición realizada');
				if (NumeroCuentas == 1) {
					window.location.href='salon';
				}else{
					window.location.href="menuPedido?IdPedido="+idCuentaSc;
				}
			}
		});
	}

	function actualizarDetallePedido(IdPedido, Estado) {
		$.ajax({
			async: true,
    		url : 'controllers/Ajax/AjaxPedido.php', // la URL para la petición
			data: {"AccionAjax": "SendDetallePartida", "IdPedido": IdPedido, "Estado": Estado},
			type: 'POST',
			dataType : 'json', // el tipo de información que se espera de respuesta
			success : function(json) {
				// console.log(json);
				if(json.Bebidas >= 0  ){
					printer(<?php echo $idPedido ?> , '<?php echo  $Mesero['Nombres'];  ?>' , <?php echo $Mesa["NroMesa"]; ?>);
					window.open('controllers/Ajax/AjaxImprimirPDF.php?IdPedidoBar=<?php echo $idPedido ?>&mesero=<?php echo  $Mesero['Nombres'];  ?>&NroMesa=<?php echo $Mesa["NroMesa"]; ?>','_blank');

				}
			},
			error : function(xhr, status) {
				console.log('Disculpe, existió un problema');
			},
			complete : function(xhr, status) {
				console.log('Petición realizada');
				getDetallePedido();
			}
		});
	}

	function printer(id, mesero, nro ){
		$.ajax({
        url:"controllers/Ajax/AjaxPrinter.php",
        method:"GET",
        data:{tipo: 'IdPedidoBar', IdPedidoBar: id, mesero: mesero, NroMesa: nro},
        dataType: 'text',
        success:function(resp){
          console.log(resp);
        }
      })
	}

	function eliminarPlatoList(id){
		$.ajax({
			async: true,
    		url : 'controllers/Ajax/AjaxPedido.php', // la URL para la petición
			data: {"AccionAjax": "DelPlatoList", "IdPlato": id},
			type: 'POST',
			dataType : 'json', // el tipo de información que se espera de respuesta
			success : function(json) {
				// console.log(json);
			},
			error : function(xhr, status) {
				console.log('Disculpe, existió un problema');
			},
			complete : function(xhr, status) {
				console.log('Petición realizada');
				getDetallePedido();
			}
		});
	}

	function upEstadoDetallePedido(id, Estado) {
		$.ajax({
			async: true,
    		url : 'controllers/Ajax/AjaxPedido.php', // la URL para la petición
			data: {"AccionAjax": "UpEstadoDetallePlato", "Id": id, "Estado": Estado},
			type: 'POST',
			dataType : 'json', // el tipo de información que se espera de respuesta
			success : function(json) {
				// console.log(json);
			},
			error : function(xhr, status) {
				console.log('Disculpe, existió un problema');
			},
			complete : function(xhr, status) {
				console.log('Petición realizada');
				getDetallePedido();
			}
		});
	}

	function getDtsEdit(id){
		$.ajax({
			async: true,
    		url : 'controllers/Ajax/AjaxPedido.php', // la URL para la petición
			data: {"AccionAjax": "getDtsEdit", "Id": id},
			type: 'POST',
			dataType : 'json', // el tipo de información que se espera de respuesta
			success : function(json) {
				// console.log(json);
				$("#getCantidad").val(json.Cantidad);
				localStorage.setItem('AddCantidad', JSON.stringify(json));

			},
			error : function(xhr, status) {
				console.log('Disculpe, existió un problema');
			},
			complete : function(xhr, status) {
				console.log('Petición realizada');
				$("#IdTitle").html('Cantidad');

				$("#Step2").removeClass('container-fluid');
				$("#Step2").addClass('hidden');

				$("#Step1").removeClass('hidden');
				$("#Step1").addClass('container-fluid');

				$("#IdUp").removeClass('hidden');
				$("#IdUp").addClass('row');

				$("#IdAdd").removeClass('row');
				$("#IdAdd").addClass('hidden');

				$("#CantidaItems").modal('show');
			}
		});
	}

	function updateDetallePedido(){
		var Data = JSON.parse(localStorage.getItem('AddCantidad'));
		$.ajax({
			async: true,
    		url : 'controllers/Ajax/AjaxPedido.php', // la URL para la petición
			data: {"AccionAjax": "updateDetallePedido", "Data": Data},
			type: 'POST',
			dataType : 'json', // el tipo de información que se espera de respuesta
			success : function(json) {
				// console.log(json);
			},
			error : function(xhr, status) {
				console.log('Disculpe, existió un problema');
			},
			complete : function(xhr, status) {
				console.log('Petición realizada');
				$("#CantidaItems").modal('hide');
				$("#idguarnicion").val('');
				$("#idguarnicion").selectpicker("refresh");
				getDetallePedido();
			}
		});
	}


// 	var timestamp = null;
// 	function iniScript() {
// 		$.ajax({
// 			async: true,
//     		url : 'controllers/Ajax/AjaxPedido.php', // la URL para la petición
// 			data: {"AccionAjax": "timestamp", "timeStamp": timestamp},
// 			type: 'POST',
// 			dataType : 'json', // el tipo de información que se espera de respuesta
// 			success : function(json) {
// 				getDetallePedido();
// 				timestamp = json.timestamp;
// 				setTimeout(() => {
// 					iniScript()
// 				}, 1000);
// 			},
// 			error : function(xhr, status) {
// 				console.log('Disculpe, existió un problema');
// 			},
// 			complete : function(xhr, status) {
// 				console.log('Petición realizada');
// 			}
// 		});
// 	}


	function precuenta() {
		var idPedido = <?php echo $idPedido ?>;
		var Mesa = <?php echo $Mesa['NroMesa'] ?>;
		var Mesero = "<?php echo $Mesero['Nombres']; ?>";
		var Naturaleza = "<?php echo $DMesa['naturaleza'] ?>";
		var Cliente = "<?php echo $Pedido['NombreCliente']; ?>";
		var Subtotal = $('#SubTotal').val();
		var Propina = $('#Propina').val();
		var Exento =  $('#Exento').val();
		var Retencion =  $('#Retencion').val();
		var Total = $('#Total').val();
		var Comensales = $('#getCantidadComensales').val();

		var url = 'controllers/Ajax/AjaxImprimirPDF.php?';
		url += 'idPedidoPC='+idPedido;
		url += '&SubTotalPC='+Subtotal;
		url += '&TotalPagarPC='+Total;
		url += '&PropinaPC='+Propina;
		url += '&ExentoPagar='+Exento;
		url += '&RetencionPagar='+Retencion;
		url += '&mesaPC='+Mesa;
		url += '&meseroPC='+Mesero;
		url += '&naturalezaPC='+Naturaleza;
		url += '&cantidadCuentasPC='+NumeroCuentas;
		url += '&clientePC='+Cliente;
		url += '&comensales='+Comensales;

		printerPC(Subtotal, idPedido, Total, Propina, Exento, Retencion, Mesa, Mesero, Naturaleza, NumeroCuentas, Cliente, Comensales);
		window.open(url, '_blank');

		if(NumeroCuentas == 1){
			window.location.assign("salon")
		}else {
			window.location.assign("menuPedido?IdPedido="+idCuentaSc);
		}
	}

	function printerPC(Subtotal, idPedido, Total, Propina, Exento, Retencion, Mesa, Mesero, Naturaleza, NumeroCuentas, Cliente, Comensales){
		$.ajax({
        url:"controllers/Ajax/AjaxPrinter.php",
        method:"GET",
        data:{tipo: 'PC', idPedidoPC: idPedido, SubTotalPC: Subtotal, TotalPagarPC: Total, PropinaPC: Propina, ExentoPagar: Exento, RetencionPagar: Retencion,
		mesaPC: Mesa, meseroPC: Mesero, naturalezaPC: Naturaleza, cantidadCuentasPC: NumeroCuentas, clientePC: Cliente, comensales: Comensales  },
        dataType: 'text',
        success:function(resp){
          console.log(resp);
        }
      })
	}

	function editMensaje(mensaje, Cant, Id) {
		// console.log(mensaje);
		$("#getMsmPlato").val(mensaje);
		$('#msmCant').val(Cant);
		$('#msmIdDetallePedido').val(Id);
		$("#msmModal").modal('show');
	}

	function SepararCuenta(IdDetallePedido, Plato, Cantidad){
		$("#SepCuentaModal").modal('show');
		$("#IdItems").html(Plato);
		$("#CantItems").html(Cantidad);
		$("#CantItems").attr('data-cantidad', Cantidad);
		$("#IdItems").attr('data-DtPedido', IdDetallePedido);
	}

	$("#getCantidadTrasladar").keyup(() => {
		var CantDigi = parseInt($("#getCantidadTrasladar").val())
		var CantMax = parseInt($("#CantItems").attr('data-cantidad'));
		// console.log(CantMax);
		if (isNaN(CantDigi) === false && CantDigi != '' && CantDigi != 0  && CantDigi <= CantMax) {
			$("#getCantidadTrasladar").val(CantDigi);

			$("#IdDivSepCantidad").removeClass('has-error');
			$("#IdDivSepCantidad").addClass('has-success');
			$("#getCantidadTrasladar").attr('data-validation', 1);
		}else{

			if(CantDigi.length > 0){
				CantDigi = CantDigi.slice(0, -1);
			}
			if (isNaN(CantDigi)) {
				$("#getCantidadTrasladar").val('');
			}else{
				$("#getCantidadTrasladar").val(CantDigi);
			}
			$("#IdDivSepCantidad").removeClass('has-success');
			$("#IdDivSepCantidad").addClass('has-error');
			$("#getCantidadTrasladar").attr('data-validation', 0);
		}
		disabledButtton();
	});

	// $("#IdPedidos").change(()=> {
	// 	disabledButtton();
	// });

	function disabledButtton(){
		var BtnDisable = parseInt($("#IdInputs").attr('data-validation'));
		if (BtnDisable === 1) {
			$("#BtnSaveTrasladado").attr('disabled', false);
		} else {
			$("#BtnSaveTrasladado").attr('disabled', true);
		}
	}

	function trasladar(){
		var Dts = {
			"IdDetallePedido": $("#IdItems").attr('data-DtPedido'),
			"IdPedidos": $("#IdPedidos").val(),
			"Cantidades": JSON.parse(localStorage.getItem('TokenValueTras'))
		}

		$.ajax({
			async: true,
    		url : 'controllers/Ajax/AjaxPedido.php', // la URL para la petición
			data: {"AccionAjax": "Trasladar", "DtsAjax": Dts},
			type: 'POST',
			dataType : 'text', // el tipo de información que se espera de respuesta
			success : function(json) {
				console.log(json);
				// $("#getCantidadTrasladar").val('')
				$("#SepCuentaModal").modal('hide');
				$("#IdInputs").html('');
				$('#IdPedidos').val('').selectpicker('refresh');

			},
			error : function(xhr, status) {
				console.log('Disculpe, existió un problema');
			},
			complete : function(xhr, status) {
				console.log('Petición realizada');
				getDetallePedido();
			}
		});
	}

	function abcPad(valor) {
		var oldValor = $("#getMsmPlato").val();
		var newValor = '';
		if (valor === 'del') {
			newValor = oldValor.slice(0, -1);
		}else{
			if ($("#MayusId").prop("checked") && valor != " ") {
				valor = valor.toUpperCase();
			}else{
				valor = valor.toLowerCase();
			}
			$("#MayusId").prop("checked", false)
			$("#lblMayus").removeClass("active")
			newValor = oldValor+valor;
		}
		$("#getMsmPlato").val(newValor);
	}

	function UpdateMensaje() {
		var data = {
			"Comentario": $('#getMsmPlato').val(),
			"Cantidad": $('#msmCant').val(),
			"IdDetallePedido": $('#msmIdDetallePedido').val()
		}
		// console.log(data);
		$.ajax({
			async: true,
    		url : 'controllers/Ajax/AjaxPedido.php', // la URL para la petición
			data: {"AccionAjax": "updateMsm", "AjaxData": data},
			type: 'POST',
			dataType : 'json', // el tipo de información que se espera de respuesta
			success : function(json) {
				console.log(json);
			},
			error : function(xhr, status) {
				console.log('Disculpe, existió un problema');
			},
			complete : function(xhr, status) {
				console.log('Petición realizada');
				$("#msmModal").modal('hide');
				getDetallePedido();
			}
		});
	}

	$("#IdPedidos").change(()=>{
		var inputs = $("#IdPedidos").val();

		var res = '';
		var tokenvalue  = {};
		if (inputs != null) {

			inputs.forEach(input => {
				res += `
					<div class="row">
						<div class="col-md-10 col-md-offset-1">
							<div id="IdDiv${input}" class="form-group form-group-lg">
								<input id="Id_${input}" type="text" onKeyUp="CantidadTrasladar(${input})" class="form-control is-valid" style="font-size: 40px;text-align: right;" placeholder="Cantidad Trasladar a # ${input}" autocomplete>
							</div>
						</div>
					</div>
				`;
				tokenvalue[input] = 0;
			});


		}else{
			$('#IdInputs').attr('data-validation', 0);
		}
		$("#IdInputs").html(res);
		$('#CantItems').html($('#CantItems').attr('data-cantidad'));
		$("#CantItems").css("color","black");
		localStorage.setItem('TokenValueTras', JSON.stringify(tokenvalue));

		disabledButtton()
	});

	function CantidadTrasladar(id){
		// variable de Validacion
		var Validador = $('#IdInputs');

		// Obtiene los valores
		var inputs = $("#IdPedidos").val();
		TokenValueTras = JSON.parse(localStorage.getItem('TokenValueTras'));

		var IdInput = '#Id_'+id;

		// Valida si el valor ingresado es un numero
		var valor = 0;
		if ($(IdInput).val() > 0 ) {
			valor = parseInt($(IdInput).val());
			$(IdInput).val(valor);
		}else{
			Validador.attr('data-validation', 0);
			$(IdInput).val(0);
		}

		TokenValueTras[id] = valor
		var Suma = 0;
		var inputValorZero = 0 ;
		for (key in TokenValueTras){
			Suma += parseInt(TokenValueTras[key]);
			if (parseInt(TokenValueTras[key]) == 0) {
				inputValorZero += 1;
			}
		}

		var CantMax = parseInt($("#CantItems").attr('data-cantidad'));
		if (inputValorZero > 0) {
			Validador.attr('data-validation', 0);
			$("#CantItems").css("color","black");
		}else if(Suma > CantMax){
			Validador.attr('data-validation', 0);
			$("#CantItems").css("color","red");
		}else{
			Validador.attr('data-validation', 1);
			$("#CantItems").css("color","black");
		}

		$("#CantItems").html(CantMax - Suma);



		localStorage.setItem('TokenValueTras', JSON.stringify(TokenValueTras))
		disabledButtton();
	}

	function CredencialUser(idPedido, status, React) {
		if(React == "DEL"){
			if ($("#BtnEliminar").data('permiso') != 0) {
				eliminarPedido(idPedido, status);

				return;
			}

		}
		swal.setDefaults({
			confirmButtonText: 'Continuar &rarr;',
			showCancelButton: true,
			reverseButtons: true,
			allowOutsideClick: false,
			allowEscapeKey: false,
			cancelButtonText: 'Cancelar',
			progressSteps: ['1']
		})

		var steps = [
			{
				input: 'password',
				title: 'Ingrese Contraseña  de [Caja]',
				html: '<i class="fa fa-unlock fa-3x"></i>',
				inputPlaceholder: '******',
				inputAttributes: {
					autocomplete: 'off'
				}
			}
		]

		swal.queue(steps).then(function (password) {
			swal.resetDefaults();
			if (password[0] == "") {
				CredencialUser(idPedido, status);
			}else{
				$.ajax({
					url:"controllers/Ajax/AjaxExtras.php",
				  	method:"POST",
				  	data:{AccionAjax:'Permiso', DtsAjax:password[0]},
				  	dataType:"text",
					beforeSend:function() {
						swal({
							title: '<strong>Menu Pedido</strong>',
							html: 'Verificando Permiso...',
							allowOutsideClick: false,
							onBeforeOpen: () => {
								swal.showLoading();
							}
						}, 1000);
					},success: function (hmtl) {
						setTimeout(() => {
			        		swal.close();
							if (hmtl == "1") {
								if (React == "AN") {
									actualizarDetallePedido(idPedido, status);
								}else if(React == "XPlato"){
									upEstadoDetallePedido(idPedido, status);
								}else{
									eliminarPedido(idPedido, status);
								}
							}
						}, 3000);
						console.log('OK')
					}
				});
			}
		}).then((result) => {
			// console.log(result);
		}).catch((err) => {
			if(err != 'cancel'){
				console.error(err);
			}
		});
	}

	function CambiarNombre(){
		swal.setDefaults({
			confirmButtonText: 'Continuar &rarr;',
			showCancelButton: true,
			reverseButtons: true,
			allowOutsideClick: false,
			allowEscapeKey: false,
			cancelButtonText: 'Cancelar',
			progressSteps: ['1']
		})

		var steps = [
			{
				input: 'text',
				title: 'Ingrese Nuevo Nombre',
				html: '<i class="fa fa-edit fa-3x"></i>',
				inputPlaceholder: '--------',
				inputAttributes: {
					autocomplete: 'off'
				}
			}
		]

		swal.queue(steps).then(function (nombre) {
			swal.resetDefaults();
			if (nombre[0] == "") {
				CambiarNombre();
			}else{
				var Id = "<?php echo $idPedido ?>"
				$.ajax({
					url:"controllers/Ajax/AjaxExtras.php",
				  	method:"POST",
				  	data:{AccionAjax:'Nombre', DtsAjax:nombre[0], IdPedidoAjax:Id},
				  	dataType:"text",
					success: function (html) {
						$('#NombreCli').html('Cliente: '+nombre[0]);
						cuentas()
					}
				});
			}
		}).then((result) => {
			// console.log(result);
		}).catch((err) => {
			if(err != 'cancel'){
				console.error(err);
			}
		});
	}

	function CambiarMesero(IdPersonal){
			
		var Id = "<?php echo $idPedido ?>"
		$.ajax({
			url:"controllers/Ajax/AjaxExtras.php",
			method:"POST",
			data:{AccionAjax:'Mesero', 
					Mesero: IdPersonal, 
					IdPedidoAjax:Id},
			dataType:"json",
			success: function (html) {
				$("#IdModalMeseros").modal("hide");
				$('#NomMesero').html('Mesero: '+html[4]);
				cuentas();
			}
		});
	}
		
	

</script>
