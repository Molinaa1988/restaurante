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
	var Ruta = 'controllers/Ajax/AjaxImprimirPDF.php?tipo='+Accion+'&FechaI='+Fecha;
	window.open(Ruta, '_blank');
}

function OpenFact(Ruta){
	window.open(Ruta, '_blank');
}

</script>

<style>
::-webkit-scrollbar {
    display: none;
}

</style>
<?php
include "views/modules/cabezote.php";
include "views/modules/botonera.php";
?>
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

			                              <?php
			                                 if(!empty($_POST['fechai']) ){
			                                     $fechai=($_POST['fechai']);
			                                 }else{
			                                     $fechai=date('Y-m-d');
			                                 }
			                             ?>

			    										 	<form name="gor" action="" method="post" class="form-inline">
			                            <div class="row-fluid">
			                                 <div class="col-md-4" align="center">
			                                     <strong>Fecha</strong><br>
			                                     <input type="date" class="form-control" name="fechai" autocomplete="off" required value="<?php echo $fechai; ?>">
			                                 </div>
			                                 <div class="col-md-2" align="center"><br>
			                                    <button type="submit" class="btn btn-icon waves-effect waves-light btn-primary m-b-5 btn-block"><strong>Consultar</strong></button>
			                                 </div>
			                                 <div class="col-md-2" align="center"><br>
			                                     <center><button onclick="OpenPdf('PxEmpleado');" class="btn btn-primary btn-block"><i class=" fa fa-file-pdf-o "></i> Propina x Empleado</button></center>

																			 </div>
																			 <div class="col-md-2"><br>
			                                     <button onclick="OpenPdf('RSD');" class="btn btn-primary btn-block"><i class=" fa fa-file-pdf-o "></i>  PDF</button>
																			 </div>
																			 <div class="col-md-2"><br>
			                                     <button onclick="OpenPdf('CorteZ');" class="btn btn-primary btn-block"><i class=" fa fa-file-pdf-o "></i>  Corte Z</button>
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
			                                              <strong>Reporte ventas por dia</strong><br>
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
																			 		<th></th>
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

																							 $respuesta = controllerReportes::ReporteVentasporDia($fechai);
																							 //var_dump($respuesta);
																								foreach($respuesta as $row => $item){

																									if($item['FormaPago'] == "T")
																									{
																										$netoTarjeta=$netoTarjeta+$item['TotalPagar'];
																										 $totalTarjeta=$totalTarjeta+$item['Total'];
																										 $propinaTarjeta=$propinaTarjeta+$item['Propina'];
																									}
																									else if ($item['FormaPago'] == "E")
																									{
																										$netoEfectivo=$netoEfectivo+$item['TotalPagar'];
																					           $totalEfectivo=$totalEfectivo+$item['Total'];
																					           $propinaEfectivo=$propinaEfectivo+$item['Propina'];
																									}
																									else if ($item['FormaPago'] == "CH")
																									{
																										$netoCheque=$netoCheque+$item['TotalPagar'];
																										 $totalCheque=$totalCheque+$item['Total'];
																										 $propinaCheque=$propinaCheque+$item['Propina'];
																									}elseif ($item['FormaPago'] == "CR") {
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
																				 ?>
																		 <tr class="odd gradeX">
																			 	 <td>
																						<button onclick="OpenFact('<?php echo $Ruta ?>');" class="btn btn-primary" title="Imprimir"><i class=" fa fa-print"></i></button>
																					</td>
																				 <td><center><?php echo $item['Nombres'] ?></center></td>
																				 <?php
																				  $cajero = controllerReportes::cajero($item['IdUsuario']);
																					?>
																				 <td><center><?php echo $cajero['Usuario'] ?></center></td>
																				 <td><center><?php if($item['FormaPago'] == "T")
																				 {echo "Tarjeta";}
																				 else if($item['FormaPago'] == "E")
																				 {echo "Efectivo";}
																				 else if($item['FormaPago'] == "CH")
																				 {echo "Transaccion";}
																				 elseif ($item['FormaPago'] == "CR") {
																				 	echo "Credito";
																				 }


																				   ?></center></td>
																				 <td><div align="center"><?php
																				if($item['TipoComprobante'] == "T")
																				{echo "Ticket";}
																				else { echo$item['TipoComprobante']; }
																				 ?></div></td>

																				 <td><center><a href="ReporteVentasporDiaDetalle?var=<?php echo $item['NumeroDoc']?>&tipo=T"><?php echo $item['NumeroDoc']?> </a></center></td>

																				 <td><center><?php echo $item['Total'] ?></center></td>
																				 <td><center><?php echo $item['Propina'] ?></center></td>
																				 <td><center>$ <?php echo $item['TotalPagar'] ?></center></td>
																		 </tr>

																		 <?php }
																		 $respuesta = controllerReportes::ReporteVentasporDiaFacturas($fechai);
																			foreach($respuesta as $row => $item){

																				if($item['FormaPago'] == "T")
																				{
																					$netoTarjeta=$netoTarjeta+$item['TotalPagar'];
																					 $totalTarjeta=$totalTarjeta+$item['Total'];
																					 $propinaTarjeta=$propinaTarjeta+$item['Propina'];
																				}
																				else if ($item['FormaPago'] == "E")
																				{
																					$netoEfectivo=$netoEfectivo+$item['TotalPagar'];
																					 $totalEfectivo=$totalEfectivo+$item['Total'];
																					 $propinaEfectivo=$propinaEfectivo+$item['Propina'];
																				}
																				else if ($item['FormaPago'] == "CH")
																				{
																					$netoCheque=$netoCheque+$item['TotalPagar'];
																					 $totalCheque=$totalCheque+$item['Total'];
																					 $propinaCheque=$propinaCheque+$item['Propina'];
																				}elseif ($item["FormaPago"] == "CR") {
																					$netoET=$netoET+$item['TotalPagar'];
																					$totalET=$totalET+$item['Total'];
																					$propinaET=$propinaET+$item['Propina'];
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
																	<button onclick="OpenFact('<?php echo $Ruta ?>');" class="btn btn-primary" title="Imprimir"><i class=" fa fa-print"></i></button>
																	<button class="btn btn-warning" title="Editar Correlativo" onClick="EditCorrelativo('<?php echo $item['IdComprobante'] ?>','<?php echo $item['NumeroDoc'] ?>')"><i class=" fa fa-edit"></i></button>
																</td>
															 <td><center><?php echo $item['Nombres'] ?></center></td>
															 <?php
																$cajero = controllerReportes::cajero($item['IdUsuario']);
																?>
															 <td><center><?php echo $cajero['Usuario'] ?></center></td>
															 <td><center><?php if($item['FormaPago'] == "T")
															 {echo "Tarjeta";}
															 else if($item['FormaPago'] == "E")
															 {echo "Efectivo";}
															 else if($item['FormaPago'] == "CH")
															 {echo "Transaccion";}
															 elseif ($item['FormaPago'] == "CR") {
																echo "Credito";
															 }


																 ?></center></td>
															 <td><div align="center"><?php
															if($item['TipoComprobante'] == "T")
															{echo "Ticket";}
															else { echo $item['TipoComprobante']; }
															 ?></div></td>

															 <td><center><a href="ReporteVentasporDiaDetalle?var=<?php echo $item['NumeroDoc']?>&tipo=<?php echo $item['TipoComprobante'] ?>"><?php echo $item['NumeroDoc']?> </a></center></td>

															 <td><center><?php echo $item['Total'] ?></center></td>
															 <td><center><?php echo $item['Propina'] ?></center></td>
															 <td><center>$ <?php echo $item['TotalPagar'] ?></center></td>
													 </tr>

													 <?php } ?>
																			<tr>
																													<td colspan="6"><div align="right"><strong><h4>Total Efectivo</h4></strong></div></td>
																													<td><div align="center"><strong><h4>$ <?php echo ($totalEfectivo); ?></h4></strong></div></td>
																													<td><div align="center"><strong><h4>$ <?php echo ($propinaEfectivo); ?></h4></strong></div></td>
																													<td><div align="center"><strong><h4>$ <?php echo ($netoEfectivo); ?></h4></strong></div></td>
																		 </tr>
																		 <tr>
																												 <td colspan="6"><div align="right"><strong><h4>Total Tarjeta</h4></strong></div></td>
																												 <td><div align="center"><strong><h4>$ <?php echo ($totalTarjeta); ?></h4></strong></div></td>
																												 <td><div align="center"><strong><h4>$ <?php echo ($propinaTarjeta); ?></h4></strong></div></td>
																												 <td><div align="center"><strong><h4>$ <?php echo ($netoTarjeta); ?></h4></strong></div></td>
																		</tr>
																		<tr>
																												<td colspan="6"><div align="right"><strong><h4>Total Cheque</h4></strong></div></td>
																												<td><div align="center"><strong><h4>$ <?php echo ($totalCheque); ?></h4></strong></div></td>
																												<td><div align="center"><strong><h4>$ <?php echo ($propinaCheque); ?></h4></strong></div></td>
																												<td><div align="center"><strong><h4>$ <?php echo ($netoCheque); ?></h4></strong></div></td>
																	 </tr>
																	 <tr>
																											 <td colspan="6"><div align="right"><strong><h4>Total Efectivo / Tarjeta</h4></strong></div></td>
																											 <td><div align="center"><strong><h4>$ <?php echo ($totalET); ?></h4></strong></div></td>
																											 <td><div align="center"><strong><h4>$ <?php echo ($propinaET); ?></h4></strong></div></td>
																											 <td><div align="center"><strong><h4>$ <?php echo ($netoET); ?></h4></strong></div></td>
																	</tr>
																		<tr>
																												<td colspan="6"><div align="right"><strong><h4>Total General</h4></strong></div></td>
																												<td><div align="center"><strong><h4>$ <?php echo ($total); ?></h4></strong></div></td>
																												<td><div align="center"><strong><h4>$ <?php echo ($propina); ?></h4></strong></div></td>
																												<td><div align="center"><strong><h4>$ <?php echo ($neto); ?></h4></strong></div></td>
																	 </tr>
																 </tbody>

			                                 </table>
			                      </div>
														<div class="callout callout-success">
															<h4>Ingresos otros</h4>
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
																					 if($item['Serie'] == "E")
																					 {
																						 $SubtotalEfectivoCompra=$SubtotalEfectivoCompra+$item['Subtotal'];
																							$IvaEfectivoCompra=$IvaEfectivoCompra+$item['Iva'];
																							$TotalEfectivoCompra=$TotalEfectivoCompra+$item['Total'];
																					 }
																					 else if ($item['Serie'] == "C")
																					 {
																						 $SubtotalChequeCompra=$SubtotalChequeCompra+$item['Subtotal'];
																							$IvaChequeCompra=$IvaChequeCompra+$item['Iva'];
																							$TotalChequeCompra=$TotalChequeCompra+$item['Total'];
																					 }
																					 else if ($item['Serie'] == "D")
																					 {
																						 $SubtotalDepositoCompra=$SubtotalDepositoCompra+$item['Subtotal'];
																							$IvaDepositoCompra=$IvaDepositoCompra+$item['Iva'];
																							$TotalDepositoCompra=$TotalDepositoCompra+$item['Total'];
																					 }
																					 else if ($item['Serie'] == "T")
																					 {
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
																		<td><center>
																					 <?php
																					$respuest = controllerCompra::vistaProveedor($idProveedor);
																							echo($respuest["RazonSocial"]);
																				 ?></center></td>
																		<td><center><?php echo $item['Descripcion'] ?></center></td>
																		<td style="width:60px;"><center><?php if($item['Serie'] == 'E')
																																					{echo 'Efectivo';}
																																		 elseif ($item['Serie'] == 'C')
																																					 {echo 'Cheque';}
																																		 elseif ($item['Serie'] == 'D')
																																					 {echo 'Deposito';}
																																		elseif ($item['Serie'] == 'T')
																																						{echo 'Tarjeta';}
																																		 elseif ($item['Serie'] == 'CR')
																																					 {echo 'Credito';}
																																					?></center></td>
																		<td style="width:60px;"><center><?php echo $item['Subtotal'] ?></center></td>
																		<td style="width:60px;"><center><?php echo $item['Iva'] ?></center></td>
																		<td style="width:60px;"><center><?php echo $item['Total'] ?></center></td>
															</tr>

															<?php } ?>
															 <tr>
																									 <td colspan="6"><div align="right"><strong><h4>Total Compra Efectivo</h4></strong></div></td>
																									 <td><div align="center"><strong><h4>$ <?php echo ($SubtotalEfectivoCompra); ?></h4></strong></div></td>
																									 <td><div align="center"><strong><h4>$ <?php echo ($IvaEfectivoCompra); ?></h4></strong></div></td>
																									 <td><div align="center"><strong><h4>$ <?php echo ($TotalEfectivoCompra); ?></h4></strong></div></td>
															</tr>
															<tr>
																									<td colspan="6"><div align="right"><strong><h4>Total Compra Cheque</h4></strong></div></td>
																									<td><div align="center"><strong><h4>$ <?php echo ($SubtotalChequeCompra); ?></h4></strong></div></td>
																									<td><div align="center"><strong><h4>$ <?php echo ($IvaChequeCompra); ?></h4></strong></div></td>
																									<td><div align="center"><strong><h4>$ <?php echo ($TotalChequeCompra); ?></h4></strong></div></td>
														 </tr>
														 <tr>
																								 <td colspan="6"><div align="right"><strong><h4>Total Compra Deposito</h4></strong></div></td>
																								 <td><div align="center"><strong><h4>$ <?php echo ($SubtotalDepositoCompra); ?></h4></strong></div></td>
																								 <td><div align="center"><strong><h4>$ <?php echo ($IvaDepositoCompra); ?></h4></strong></div></td>
																								 <td><div align="center"><strong><h4>$ <?php echo ($TotalDepositoCompra); ?></h4></strong></div></td>
														</tr>
														<tr>
																								<td colspan="6"><div align="right"><strong><h4>Total Compra Tarjeta</h4></strong></div></td>
																								<td><div align="center"><strong><h4>$ <?php echo ($SubtotalTarjetaCompra); ?></h4></strong></div></td>
																								<td><div align="center"><strong><h4>$ <?php echo ($IvaTarjetaCompra); ?></h4></strong></div></td>
																								<td><div align="center"><strong><h4>$ <?php echo ($TotalTarjetaCompra); ?></h4></strong></div></td>
													 </tr>
														 <tr>
																								 <td colspan="6"><div align="right"><strong><h4>Total Compra General</h4></strong></div></td>
																								 <td><div align="center"><strong><h4>$ <?php echo ($SubtotalCompra); ?></h4></strong></div></td>
																								 <td><div align="center"><strong><h4>$ <?php echo ($IvaCompra); ?></h4></strong></div></td>
																								 <td><div align="center"><strong><h4>$ <?php echo ($TotalCompra); ?></h4></strong></div></td>
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
															 <td><center><?php echo $item['Descripcion'] ?></center></td>
															 <td><center><?php echo $item['Monto'] ?></center></td>
													 </tr>

											 <?php } ?>
												<tr>
																						<td colspan="1"><div align="right"><strong><h4>Total Gasto</h4></strong></div></td>
																						<td><div align="center"><strong><h4>$ <?php echo ($TotalGasto); ?></h4></strong></div></td>

											 </tr>
									 </tbody>

												 </table>
							</div>
							<div class="callout callout-info">
								<div align="center"><h4>Balance: $ <?php echo $neto+$TotalIngreso-$TotalCompra-$TotalGasto; ?></h4></div>
							</div>
			                     </div>
			                    </div>


			               </div>
			             </div>
     </section>
  </div>
  <script>
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
  </script>
