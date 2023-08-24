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
			function imprimir(){
				var objeto=document.getElementById('imprimeme');  //obtenemos el objeto a imprimir
				var ventana=window.open('','_blank');  //abrimos una ventana vacía nueva
				ventana.document.write(objeto.innerHTML);  //imprimimos el HTML del objeto en la nueva ventana
				ventana.document.close();  //cerramos el documento
				ventana.print();  //imprimimos la ventana
				ventana.close();  //cerramos la ventana
			}

			function OpenPdf(Accion){
				var Fecha = $("input[name='fechai']").val();
				var caja = $( "#IdCajas" ).val()
				if (Accion == 'Z'){
					var Ruta = 'controllers/Ajax/AjaxFactura.php?Accion='+Accion+'&Caja='+caja+'&Tic=';
				}else{
					var Ruta = 'controllers/Ajax/AjaxImprimirPDF.php?tipo='+Accion+'&FechaI='+Fecha+'&caja='+caja;
				}
				window.open(Ruta, '_blank');
			}
			function OpenFact(Ruta){
				window.open(Ruta, '_blank');
			}

		</script>

		<?php
			include "views/modules/cabezote.php";
			include "views/modules/botonera.php";
		?>
  		<div class="content-wrapper">
    		<section class="content">
				<?php
					if(isset($_POST['fechai'])){
						$fechai=$_POST['fechai'];
						$idCaja = $_POST['cajas'];
					}else{
						$fechai=date('Y-m-d');
						$idCaja = 0;
					}
			 	?>
			    <div class="row">
			    	<div class="col-md-12">
			        	<!-- Advanced Tables -->

			            <?php
							if(!empty($_POST['fechai']) ){
								$fechai=($_POST['fechai']);
							}else{
								$fechai=date('Y-m-d');
							}
			            ?>
			            <div class="row-fluid">
							<form name="gor" action="" method="post" class="form-inline">
								<div class="col-xs-6 col-sm-3" align="center">
                                    
                                    <strong>Fecha</strong><br>
									<input type="date" class="form-control" name="fechai" autocomplete="off" required value="<?php echo $fechai; ?>">
										
								</div>
								
								<div class="col-xs-6 col-sm-3" align="center">
									
									<strong>Caja</strong><br>
									<select class="form-control" id="IdCajas" name="cajas" autocomplete="off" required></select>
									
								</div>
								
								<div  class="col-xs-6 col-sm-2" align="center"><br>
									<button type="submit" class="btn btn-icon waves-effect waves-light btn-primary m-b-5 btn-block">
										<strong>Consultar</strong>
									</button>
								</div>

								<div class="col-xs-6 col-sm-2" align="center"><br>
			                    	<button onclick="OpenPdf('RSD');" class="btn btn-primary btn-block">
										<i class=" fa fa-file-pdf-o "></i>  PDF
									</button>
								</div>
					
								<div class="col-xs-6 col-sm-2" align="center"><br>
			                    	 <button onclick="OpenPdf('Z');" class="btn btn-icon waves-effect waves-light btn-primary m-b-5 btn-block">
										<i class=" fa fa-file-pdf-o "></i>  Corte Z
									</button> 
								</div>
								
			            	</form>
			            </div><br>
			            
						<div style="width:100%; height:700px; margin-top: 50px; overflow: auto;" >
			            	<div id="imprimeme">
			                    <div class="hidden">
									<div style="font-size: 14px; text-align: center;">
										<strong>Reporte ventas por dia</strong>
									</div>
			                        <hr/>
			                    </div>
								<div class="callout callout-success">
									<h4>Ingreso por venta</h4>
								</div>
			                    <div class="table-responsive">
			                    	<table class="table table-striped table-bordered table-hover"  width="100%"  border="0">

										<thead>
											<tr>
												<th>Accion</th>
												<th><center>Atendio</center></th>
												<th><center>Cobro</center></th>
												<th><center>Forma de Pago</center></th>
												<th><center>Tipo de Comprobante</center></th>
												<th><center>Nro de Comprobante</center></th>
												<th><center>Total</center></th>
												<th><center>Propina</center></th>
												<th><center>Total+Propina</center></th>
											</tr>
										</thead>
										<tbody>
											<?php

												$total=0;
												$propina=0;
												$neto=0;

												$totalTarjeta=0;
												$propinaTarjeta=0;
												$netoTarjeta=0;

												$totalEfectivo=0;
												$propinaEfectivo=0;
												$netoEfectivo=0;

												$totalCheque=0;
												$propinaCheque=0;
												$netoCheque=0;

												$totalET=0;
												$propinaET=0;
												$netoET=0;
												
												$totalBTC=0;
												$propinaBTC=0;
												$netoBTC=0;

												$respuesta = controllerReportes::ReporteVentasporDia($idCaja);
												//var_dump($respuesta);
												foreach($respuesta as $row => $item){

													if($item['FormaPago'] == "T"){
														$netoTarjeta=$netoTarjeta+$item['TotalPagar'];
														$totalTarjeta=$totalTarjeta+$item['Total'];
														$propinaTarjeta=$propinaTarjeta+$item['Propina'];
													} else if ($item['FormaPago'] == "E") {
														$netoEfectivo=$netoEfectivo+$item['TotalPagar'];
														$totalEfectivo=$totalEfectivo+$item['Total'];
														$propinaEfectivo=$propinaEfectivo+$item['Propina'];
													} else if ($item['FormaPago'] == "CH") {
														$netoCheque=$netoCheque+$item['TotalPagar'];
														$totalCheque=$totalCheque+$item['Total'];
														$propinaCheque=$propinaCheque+$item['Propina'];
													} else if ($item['FormaPago'] == "BTC") {
														$netoBTC=$netoBTC+$item['TotalPagar'];
														$totalBTC=$totalBTC+$item['Total'];
														$propinaBTC=$propinaBTC+$item['Propina'];
													}
													// elseif ($item['FormaPago'] == "CR" ) {
													// 	$netoET=$netoET+$item['TotalPagar'];
													// 	$totalET=$totalET+$item['Total'];
													// 	$propinaET=$propinaET+$item['Propina'];
													// }
													elseif ($item['FormaPago'] == "H" ) {
														$netoET=$netoET+$item['TotalPagar'];
														$totalET=$totalET+$item['Total'];
														$propinaET=$propinaET+$item['Propina'];
													}

													$neto=$neto+$item['TotalPagar'];
													$total=$total+$item['Total'];
													$propina=$propina+$item['Propina'];
													$Ruta = "#";
													if ($item['TipoComprobante'] == "T") {
														$DtsComprobante = modelComprobantes::ComprobanteUnico($item['IdPedido']);

														$Ruta = "controllers/Ajax/AjaxImprimirPDF.php?tipo=t&totalA=".$item["Total"];
														$Ruta .= "&propinaA=".$item['Propina'];
														$Ruta .= "&totalpagarA=".$item['TotalPagar'];
														$Ruta .= "&idPedidoA=".$item['IdPedido'];
														$Ruta .= "&nrocomprobanteCA=".$item['NumeroDoc'];
														$Ruta .= "&meseroA=".$item['Nombres'];
														$Ruta .= "&Exentos=-".round($DtsComprobante["Exentos"], 2);
													}
													
													if ($item['TipoComprobante'] == "O") {
														$DtsComprobante = modelComprobantes::ComprobanteUnico($item['IdPedido']);

														$Ruta = "controllers/Ajax/AjaxImprimirPDF.php?tipo=O&totalA=".$item["Total"];
														$Ruta .= "&propinaA=".$item['Propina'];
														$Ruta .= "&totalpagarA=".$item['TotalPagar'];
														$Ruta .= "&idPedidoA=".$item['IdPedido'];
														$Ruta .= "&nrocomprobanteCA=".$item['NumeroDoc'];
														$Ruta .= "&meseroA=".$item['Nombres'];
														$Ruta .= "&Exentos=-".round($DtsComprobante["Exentos"], 2);
													}


											?>
													<tr class="odd gradeX">
														<td>
															<button onclick="OpenFact('<?php echo $Ruta ?>');" class="btn btn-primary" title="Imprimir">
																<i class=" fa fa-print"></i>
															</button>
														</td>
														<td><center><?php echo $item['Nombres'] ?></center></td>
														<?php
															$cajero = controllerReportes::cajero($item['IdUsuario']);
														?>
														<td><center><?php echo $cajero['Usuario'] ?></center></td>
														<td><center>
															<?php
																if($item['FormaPago'] == "T") {
																	echo "Tarjeta";
																} else if($item['FormaPago'] == "E") {
																	echo "Efectivo";
																} else if($item['FormaPago'] == "CH") {
																	echo "Transaccion";
																} else if($item['FormaPago'] == "BTC") {
																	echo "BTC";
																} elseif ($item['FormaPago'] == "CR") {
																	echo "Credito";
																} elseif ($item['FormaPago'] == "H") {
																	echo "Hugo";
																}
															?></center>
														</td>
														<td>
															<div align="center">
																<?php
																	if($item['TipoComprobante'] == "T") {
																		echo "Ticket";
																	} else if($item['TipoComprobante'] == "O") {
																		echo "Otro";
																	} else {
																		echo$item['TipoComprobante'];
																	}
																?>
															</div>
														</td>
														<td>
															<center>
																<a href="ReporteVentasporDiaDetalle?var=<?php echo $item['NumeroDoc']?>&tipo=T"><?php echo $item['NumeroDoc']?> </a>
															</center>
														</td>
														<td><center><?php echo $item['Total'] ?></center></td>
														<td><center><?php echo $item['Propina'] ?></center></td>
														<td><center>$ <?php echo $item['TotalPagar'] ?></center></td>
													</tr>

											<?php
												}
												$respuesta = controllerReportes::ReporteVentasporDiaFacturas($fechai);
												foreach($respuesta as $row => $item){

													if($item['FormaPago'] == "T"){
														$netoTarjeta=$netoTarjeta+$item['TotalPagar'];
														$totalTarjeta=$totalTarjeta+$item['Total'];
														$propinaTarjeta=$propinaTarjeta+$item['Propina'];
													} else if ($item['FormaPago'] == "E") {
														$netoEfectivo=$netoEfectivo+$item['TotalPagar'];
														$totalEfectivo=$totalEfectivo+$item['Total'];
														$propinaEfectivo=$propinaEfectivo+$item['Propina'];
													} else if ($item['FormaPago'] == "CH") {
														$netoCheque=$netoCheque+$item['TotalPagar'];
														$totalCheque=$totalCheque+$item['Total'];
														$propinaCheque=$propinaCheque+$item['Propina'];
													}elseif ($item["FormaPago"] == "CR") {
														$netoET=$netoET+$item['TotalPagar'];
														$totalET=$totalET+$item['Total'];
														$propinaET=$propinaET+$item['Propina'];
													}else if ($item['FormaPago'] == "BTC") {
														$netoBTC=$netoBTC+$item['TotalPagar'];
														$totalBTC=$totalBTC+$item['Total'];
														$propinaBTC=$propinaBTC+$item['Propina'];
													}

													$neto=$neto+$item['TotalPagar'];
													$total=$total+$item['Total'];
													$propina=$propina+$item['Propina'];
													$Ruta = "#";
													if ($item['TipoComprobante'] == "FCF") {
														$DtsComprobante = modelComprobantes::ComprobanteUnico($item['IdPedido']);
														$Ruta = "controllers/Ajax/AjaxImprimirPDF.php?tipo=fcf&totalA=".$item["Total"];
														$Ruta .= "&propinaA=".$item['Propina'];
														$Ruta .= "&totalpagarA=".$item['TotalPagar'];
														$Ruta .= "&idPedidoA=".$item['IdPedido'];
														$Ruta .= "&nrocomprobanteCA=".$item['NumeroDoc'];
														$Ruta .= "&meseroA=".$item['Nombres'];
														$Ruta .= "&Acliente=".$DtsComprobante["NombreCliente"];
														$Ruta .= "&Exentos=-".round($DtsComprobante["Exentos"], 2);
														$Ruta .= "&Retencion=".$DtsComprobante['Retencion'];
														$Ruta .= "&Tarjeta=".$DtsComprobante['Tarjeta'];
														$Ruta .= "&Consumo=".$DtsComprobante['consumo'];

													}elseif ($item['TipoComprobante'] == "CCF") {
														$DtsComprobante = modelComprobantes::ComprobanteUnico($item['IdPedido']);
														$Ruta = "controllers/Ajax/AjaxImprimirPDF.php?tipo=ccf&totalA=".$item["Total"];
														$Ruta .= "&propinaA=".$item['Propina'];
														$Ruta .= "&totalpagarA=".$item['TotalPagar'];
														$Ruta .= "&idPedidoA=".$item['IdPedido'];
														$Ruta .= "&nrocomprobanteCA=".$item['NumeroDoc'];
														$Ruta .= "&meseroA=".$item['Nombres'];
														$Ruta .= "&Acliente=".$DtsComprobante["NombreCliente"];
														$Ruta .= '&Anrc='.$item['Documento'];
														$Ruta .= "&Exentos=-".round($DtsComprobante["Exentos"], 2);
														$Ruta .= "&Retencion=".$DtsComprobante['Retencion'];
														$Ruta .= "&Consumo=".$DtsComprobante['consumo'];
													}
											?>
													<tr class="odd gradeX">
														<td>
															<button onclick="OpenFact('<?php echo $Ruta ?>');" class="btn btn-primary" title="Imprimir">
																<i class=" fa fa-print"></i>
															</button>
															<button class="btn btn-warning" title="Editar Correlativo" onClick="EditCorrelativo('<?php echo $item['IdComprobante'] ?>','<?php echo $item['NumeroDoc'] ?>')">
																<i class=" fa fa-edit"></i>
															</button>
														</td>
														<td><center><?php echo $item['Nombres'] ?></center></td>
														<?php
															$cajero = controllerReportes::cajero($item['IdUsuario']);
														?>
														<td><center><?php echo $cajero['Usuario'] ?></center></td>
														<td>
															<center>
																<?php
																	if($item['FormaPago'] == "T") {
																		echo "Tarjeta";
																	} else if($item['FormaPago'] == "E") {
																		echo "Efectivo";
																	} else if($item['FormaPago'] == "CH") {
																		echo "Transaccion";
																	} else if($item['FormaPago'] == "BTC") {
																		echo "BTC";
																	} elseif ($item['FormaPago'] == "CR") {
																		echo "Credito";
																	}
																?>
															</center>
														</td>
														<td>
															<div align="center">
																<?php
																	if($item['TipoComprobante'] == "T"){
																		echo "Ticket";
																	} else {
																		echo $item['TipoComprobante'];
																	}
															 	?>
															</div>
														</td>

														<td>
															<center>
																<a href="ReporteVentasporDiaDetalle?var=<?php echo $item['NumeroDoc']?>&tipo=<?php echo $item['TipoComprobante'] ?>"><?php echo $item['NumeroDoc']?></a>
															</center>
														</td>

														<td><center><?php echo $item['Total'] ?></center></td>
														<td><center><?php echo $item['Propina'] ?></center></td>
														<td><center>$ <?php echo $item['TotalPagar'] ?></center></td>
													</tr>
											<?php } ?>
											<tr>
												<td colspan="6"><div align="right"><strong>Total Efectivo</strong></div></td>
												<td><div align="center"><strong>$ <?php echo ($totalEfectivo); ?></strong></div></td>
												<td><div align="center"><strong>$ <?php echo ($propinaEfectivo); ?></strong></div></td>
												<td><div align="center"><strong>$ <?php echo ($netoEfectivo); ?></strong></div></td>
											</tr>
											<tr>
												<td colspan="6"><div align="right"><strong>Total Tarjeta</strong></div></td>
												<td><div align="center"><strong>$ <?php echo ($totalTarjeta); ?></strong></div></td>
												<td><div align="center"><strong>$ <?php echo ($propinaTarjeta); ?></strong></div></td>
												<td><div align="center"><strong>$ <?php echo ($netoTarjeta); ?></strong></div></td>
											</tr>
											<tr>
												<td colspan="6"><div align="right"><strong>Total Transaccion</strong></div></td>
												<td><div align="center"><strong>$ <?php echo ($totalCheque); ?></strong></div></td>
												<td><div align="center"><strong>$ <?php echo ($propinaCheque); ?></strong></div></td>
												<td><div align="center"><strong>$ <?php echo ($netoCheque); ?></strong></div></td>
											</tr>
											<tr>
												<td colspan="6"><div align="right"><strong>Total BTC</strong></div></td>
												<td><div align="center"><strong>$ <?php echo ($totalBTC); ?></h4></strong></div></td>
												<td><div align="center"><strong>$ <?php echo ($propinaBTC); ?></h4></strong></div></td>
												<td><div align="center"><strong>$ <?php echo ($netoBTC); ?></h4></strong></div></td>
											</tr>
											<tr>
												<td colspan="6"><div align="right"><strong>Total Créditos</strong></div></td>
												<td><div align="center"><strong>$ <?php echo ($totalET); ?></h4></strong></div></td>
												<td><div align="center"><strong>$ <?php echo ($propinaET); ?></h4></strong></div></td>
												<td><div align="center"><strong>$ <?php echo ($netoET); ?></h4></strong></div></td>
											</tr>
											<tr>
												<td colspan="6"><div align="right"><strong>Total General</strong></div></td>
												<td><div align="center"><strong>$ <?php echo ($total); ?></strong></div></td>
												<td><div align="center"><strong>$ <?php echo ($propina); ?></strong></div></td>
												<td><div align="center"><strong>$ <?php echo ($neto); ?></strong></div></td>
											</tr>
										</tbody>
			                        </table>
			                    </div>
								<div class="callout callout-success">
									<h4>Ingresos otros</h4>
								</div>
								<h4>Cuentas por cobrar canceladas</h4>
								<div class="table-responsive">
																	
									<table class="table table-striped table-bordered table-hover"  width="100%"  border="0">
										<thead>
											<tr>
												<th><center>IdPedido</center></th>
												<th><center>Cliente</center></th>
												<th><center>Fecha otorgado</center></th>
												<th><center>Total</center></th>
											</tr>
										</thead>
										<tbody>
											<?php

												$Totalcxcc=0;

												$respuesta = controllerGastoIngreso::vistaCxcc($fechai);
													foreach($respuesta as $row => $item){
														$Totalcxcc=$Totalcxcc+$item['TotalPagar'];
											?>
														<tr class="odd gradeX">
															<td><center><?php echo $item['NumeroDoc'] ?></center></td>
															<td><center><?php echo $item['Nombre'] ?></center></td>
															<td><center><?php echo $item['FechaPedido'] ?></center></td>
															<td><center><?php echo $item['TotalPagar'] ?></center></td>
														</tr>

											<?php } ?>
											<tr>
												<td colspan="3"><div align="right"><strong>Total</strong></div></td>
												<td><div align="center"><strong>$ <?php echo ($Totalcxcc); ?></strong></div></td>
											</tr>
										</tbody>
									</table>

								</div><br>
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover"  width="100%"  border="0">
										<thead>
											<tr>
												<th>Descripcion</th>
												<th>Monto</th>
											</tr>
										</thead>
										<tbody>
											<?php

												$TotalIngreso=0;

												$respuesta = controllerGastoIngreso::vistaIngresoConFecha($fechai);
													foreach($respuesta as $row => $item){
														$TotalIngreso=$TotalIngreso+$item['Monto'];
											?>
														<tr class="odd gradeX">
															<td><center><?php echo $item['Descripcion'] ?></center></td>
															<td><center><?php echo $item['Monto'] ?></center></td>
														</tr>

											<?php } ?>
											<tr>
												<td colspan="1"><div align="right"><strong><h4>Total Ingreso</h4></strong></div></td>
												<td><div align="center"><strong><h4>$ <?php echo ($TotalIngreso); ?></h4></strong></div></td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="callout callout-warning">
									<h4>Compras</h4>
								</div>
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover"  width="100%"  border="0">
										<thead>
											<tr>
												<th>Factura</th>
												<th>Comprobante</th>
												<th>Fecha</th>
												<th>Proveedor</th>
												<th>Descripcion</th>
												<th>Pago</th><!--Como pago  -->
												<th>Subtotal</th>
												<th>Iva</th>
												<th>Total</th>

											</tr>
										</thead>
										<tbody>
											<?php

												$SubtotalEfectivoCompra=0;
												$IvaEfectivoCompra=0;
												$TotalEfectivoCompra=0;

												$SubtotalChequeCompra=0;
												$IvaChequeCompra=0;
												$TotalChequeCompra=0;

												$SubtotalDepositoCompra=0;
												$IvaDepositoCompra=0;
												$TotalDepositoCompra=0;

												$SubtotalTarjetaCompra=0;
												$IvaTarjetaCompra=0;
												$TotalTarjetaCompra=0;

												$SubtotalCompra=0;
												$IvaCompra=0;
												$TotalCompra=0;

												$respuesta = controllerCompra::vistaCompraConFecha($fechai);
												foreach($respuesta as $row => $item){
													$idProveedor = $item['IdProveedor'];
													if($item['Serie'] == "E") {
														$SubtotalEfectivoCompra=$SubtotalEfectivoCompra+$item['Subtotal'];
														$IvaEfectivoCompra=$IvaEfectivoCompra+$item['Iva'];
														$TotalEfectivoCompra=$TotalEfectivoCompra+$item['Total'];
													} else if ($item['Serie'] == "C") {
														$SubtotalChequeCompra=$SubtotalChequeCompra+$item['Subtotal'];
														$IvaChequeCompra=$IvaChequeCompra+$item['Iva'];
														$TotalChequeCompra=$TotalChequeCompra+$item['Total'];
													} else if ($item['Serie'] == "D") {
														$SubtotalDepositoCompra=$SubtotalDepositoCompra+$item['Subtotal'];
														$IvaDepositoCompra=$IvaDepositoCompra+$item['Iva'];
														$TotalDepositoCompra=$TotalDepositoCompra+$item['Total'];
													} else if ($item['Serie'] == "T") {
														$SubtotalTarjetaCompra=$SubtotalTarjetaCompra+$item['Subtotal'];
														$IvaTarjetaCompra=$IvaTarjetaCompra+$item['Iva'];
														$TotalTarjetaCompra=$TotalTarjetaCompra+$item['Total'];
													}

													$SubtotalCompra=$SubtotalCompra+$item['Subtotal'];
													$IvaCompra=$IvaCompra+$item['Iva'];
													$TotalCompra=$TotalCompra+$item['Total'];
												?>
												<tr class="odd gradeX">
													<td class="hidden"><center><?php echo $item['IdCompra'] ?></center></td>
													<td style="width:60px;"><center><?php echo $item['TipoDoc'] ?></center></td>
													<td style="width:60px;"><center><?php echo $item['NroComprobante'] ?></center></td>
													<td style="width:80px;"><center><?php echo $item['Fecha'] ?></center></td>
													<td>
														<center>
															<?php
																$respuest = controllerCompra::vistaProveedor($idProveedor);
																echo($respuest["RazonSocial"]);
															?>
														</center>
													</td>
													<td><center><?php echo $item['Descripcion'] ?></center></td>
													<td style="width:60px;">
														<center>
															<?php
																if($item['Serie'] == 'E') {
																	echo 'Efectivo';
																} elseif ($item['Serie'] == 'C') {
																	echo 'Cheque';
																} elseif ($item['Serie'] == 'D') {
																	echo 'Deposito';
																} elseif ($item['Serie'] == 'T') {
																	echo 'Tarjeta';
																} elseif ($item['Serie'] == 'CR') {
																	echo 'Credito';
																}
															?>
														</center>
													</td>
													<td style="width:60px;"><center><?php echo $item['Subtotal'] ?></center></td>
													<td style="width:60px;"><center><?php echo $item['Iva'] ?></center></td>
													<td style="width:60px;"><center><?php echo $item['Total'] ?></center></td>
												</tr>
											<?php } ?>
											<tr>
												<td colspan="6"><div align="right"><strong>Total Compra Efectivo</strong></div></td>
												<td><div align="center"><strong>$ <?php echo ($SubtotalEfectivoCompra);?></strong></div></td>
												<td><div align="center"><strong>$ <?php echo ($IvaEfectivoCompra); ?></strong></div></td>
												<td><div align="center"><strong>$ <?php echo ($TotalEfectivoCompra); ?></strong></div></td>
											</tr>
											<tr>
												<td colspan="6"><div align="right"><strong>Total Compra Cheque</strong></div></td>
												<td><div align="center"><strong>$ <?php echo ($SubtotalChequeCompra); ?></strong></div></td>
												<td><div align="center"><strong>$ <?php echo ($IvaChequeCompra); ?></strong></div></td>
												<td><div align="center"><strong>$ <?php echo ($TotalChequeCompra); ?></strong></div></td>
											</tr>
											<tr>
												<td colspan="6"><div align="right"><strong>Total Compra Deposito</strong></div></td>
												<td><div align="center"><strong>$ <?php echo ($SubtotalDepositoCompra); ?><</strong></div></td>
												<td><div align="center"><strong>$ <?php echo ($IvaDepositoCompra); ?></strong></div></td>
												<td><div align="center"><strong>$ <?php echo ($TotalDepositoCompra); ?></strong></div></td>
											</tr>
											<tr>
												<td colspan="6"><div align="right"><strong>Total Compra Tarjeta</strong></div></td>
												<td><div align="center"><strong>$ <?php echo ($SubtotalTarjetaCompra); ?></strong></div></td>
												<td><div align="center"><strong>$ <?php echo ($IvaTarjetaCompra); ?></strong></div></td>
												<td><div align="center"><strong>$ <?php echo ($TotalTarjetaCompra); ?></strong></div></td>
											</tr>
											<tr>
												<td colspan="6"><div align="right"><strong>Total Compra General</strong></div></td>
												<td><div align="center"><strong>$ <?php echo ($SubtotalCompra); ?></strong></div></td>
												<td><div align="center"><strong>$ <?php echo ($IvaCompra); ?></strong></div></td>
												<td><div align="center"><strong>$ <?php echo ($TotalCompra); ?></strong></div></td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="callout callout-warning">
									<h4>Gastos</h4>
								</div>

								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover"  width="100%"  border="0">
										<thead>
											<tr>
											<th>Descripcion</th>
											<th>Monto</th>
											</tr>
										</thead>
										<tbody>
											<?php

												$TotalGasto=0;
												$respuesta = controllerGastoIngreso::vistaGastoConFecha($fechai);
													foreach($respuesta as $row => $item){
														$TotalGasto=$TotalGasto+$item['Monto'];
											?>
														<tr class="odd gradeX">
															<td align="center"><?php echo $item['Descripcion'] ?></center></td>
															<td><center><?php echo $item['Monto'] ?></center></td>
														</tr>
											<?php } ?>
											<tr>
												<td colspan="1"><div align="right"><strong>Total Gasto</strong></div></td>
												<td><div align="center"><strong>$ <?php echo ($TotalGasto); ?></strong></div></td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="callout callout-info">
									<div align="center"><h4>Balance: $ <?php echo $neto+$TotalIngreso+$Totalcxcc-$TotalCompra-$TotalGasto; ?></h4></div>
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
		cajas()
	})
    function EditCorrelativo(Id, Corre){
    	swal({
			title:'Nuevo Correlativo',
			showCancelButton: true,
			html: '<input id="IniFolio" class="swal2-input" value="'+Corre+'" autofocus>',
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			allowOutsideClick: false,
			confirmButtonText: 'Continuar &rarr;',
			cancelButtonText: 'Cancelar',
			reverseButtons: true
		}).then((result) => {
			var IniFolio = $("#IniFolio").val();
			var Accion = "EditCorrelativo";
			$.ajax({
    			url:"controllers/Ajax/AjaxComprobantes.php",
    			method:"POST",
    			data:{AccionAjax:Accion, IdComprobanteAjax:Id, CorreAjax:IniFolio},
    			dataType:"text"
    		}).done(function(html){
    			console.log(html)
    			location.reload();
    		});
		}, function(dismiss) {});
    }

	$('input[name=fechai]').change(function(){
		cajas();
	});

	function cajas(){
		var fecha = $('input[name=fechai]').val();
		$.ajax({
			async: true,
    		url : 'controllers/Ajax/AjaxPedido.php', // la URL para la petición
			data: {"AccionAjax": "ListCaja", "Fecha": fecha},
			type: 'POST',
			dataType : 'json', // el tipo de información que se espera de respuesta
			success : function(json) {
				var option  = '<option value="0">Seleccione Caja</option>';
				json.forEach(data => {
					option += `<option value="${data.IdFcaja}">${data.IdFcaja}</option>`;
				});

				$('select[name=cajas]').html(option);

				$( "#IdCajas" ).val('<?php echo $idCaja ?>');

			},
			error : function(xhr, status) {
				console.log('Disculpe, existió un problema');
			},
			complete : function(xhr, status) {
				console.log('Petición realizada');
			}
		});
	}
</script>
