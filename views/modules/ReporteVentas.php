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

</script>

  <div class="content-wrapper">
    <section class="content">

			                     <div class="row">
			                 <div class="col-md-12">
			                     <!-- Advanced Tables -->
			                     <div class="panel panel-primary">
			                         <div class="panel-heading">
			                             Reporte ventas
			                         </div>
			                         <div class="panel-body">

			                          <div class="panel panel-default">
			                         <div class="panel-body">

																               <?php
												                                  $fechai=date('Y-m-d');
																													$fechaf=date('Y-m-d');

																													if(!empty($_POST['fechai']) and  !empty($_POST['fechaf'])){
																															$fechai=($_POST['fechai']);
																															$fechaf=($_POST['fechaf']);
																													}else{
																														$fechai=date('Y-m-d');
																														$fechaf=date('Y-m-d');
																													}

												                             ?>

																	<form name="gor" action="" method="post" class="form-inline">
																	                            <div class="row-fluid">
																	                                <div class="col-xs-6 col-sm-3" align="center">
																																		<strong>Fecha inicial</strong><br>
																														 			 <input type="date" class="form-control" name="fechai" autocomplete="off" required value="<?php echo $fechai; ?>">
																	                                </div>
																	                                <div class="col-xs-6 col-sm-3" align="center">
																																		<strong>Fecha final</strong><br>
																																		<input type="date" class="form-control" name="fechaf" autocomplete="off" required value="<?php echo $fechaf; ?>">
																	                                </div>
																	                                <div class="col-xs-12 col-sm-6" align="center"><br>
																	                                 <button type="submit" class="btn btn-icon waves-effect waves-light btn-primary m-b-5"><strong>Consultar</strong></button>
																	                                </div>
																	                            </div><br>
																  	</form>

			                         <div style="width:100%; height:700px; overflow: auto;">
			                                      <br>

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
																
																$totalBTC=0;
																$propinaBTC=0;
																$netoBTC=0;

																	$respuesta = controllerReportes::ReporteVentasporDia1($fechai,$fechaf);
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
																		else if ($item['FormaPago'] == "BTC")
																		{
																			$netoBTC=$netoBTC+$item['TotalPagar'];
																				$totalBTC=$totalBTC+$item['Total'];
																				$propinaBTC=$propinaBTC+$item['Propina'];
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
																					echo "Credito";}
																				 elseif ($item['FormaPago'] == "BTC") {
																					echo "BTC";
																				 }


																					 ?></center></td>
																				 <td><div align="center"><?php
																				if($item['TipoComprobante'] == "T")
																				{echo "Ticket";}
																				else if($item['TipoComprobante'] == "O")
																				{echo "Otro";}
																				else { echo$item['TipoComprobante']; }
																				 ?></div></td>

																				 <td><center><a href="ReporteVentasporDiaDetalle?var=<?php echo $item['NumeroDoc']?>&tipo=T"><?php echo $item['NumeroDoc']?> </a></center></td>

																				 <td><center><?php echo $item['Total'] ?></center></td>
																				 <td><center><?php echo $item['Propina'] ?></center></td>
																				 <td><center>$ <?php echo $item['TotalPagar'] ?></center></td>
																		 </tr>

																		 <?php }
																		 $respuesta = controllerReportes::ReporteVentasporDiaFacturas1($fechai,$fechaf);
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
																				else if ($item['FormaPago'] == "BTC")
																				{
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
															 else if($item['FormaPago'] == "BTC")
															 {echo "BTC";}
															 elseif ($item['FormaPago'] == "CR") {
																echo "Credito";
															 }


																 ?></center></td>
															 <td><div align="center"><?php
															if($item['TipoComprobante'] == "T")
															{echo "Ticket";}
															else if($item['TipoComprobante'] == "O")
															{echo "Otro";}
															else { echo $item['TipoComprobante']; }
															 ?></div></td>

															 <td><center><a href="ReporteVentasporDiaDetalle?var=<?php echo $item['NumeroDoc']?>&tipo=<?php echo $item['TipoComprobante'] ?>"><?php echo $item['NumeroDoc']?> </a></center></td>

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
																				<td colspan="6"><div align="right"><strong>Total BTC</strong></div></td>
																				<td><div align="center"><strong>$ <?php echo ($totalBTC); ?></strong></div></td>
																				<td><div align="center"><strong>$ <?php echo ($propinaBTC); ?></strong></div></td>
																				<td><div align="center"><strong>$ <?php echo ($netoBTC); ?></strong></div></td>
																		</tr>
																		<tr>
																				<td colspan="6"><div align="right"><strong>Total Transaccion</strong></div></td>
																				<td><div align="center"><strong>$ <?php echo ($totalCheque); ?></strong></div></td>
																				<td><div align="center"><strong>$ <?php echo ($propinaCheque); ?></strong></div></td>
																				<td><div align="center"><strong>$ <?php echo ($netoCheque); ?></strong></div></td>
																	 </tr>
																	 <tr>
																				<td colspan="6"><div align="right"><strong>Total Credito</strong></div></td>
																				<td><div align="center"><strong>$ <?php echo ($totalET); ?></strong></div></td>
																				<td><div align="center"><strong>$ <?php echo ($propinaET); ?></strong></div></td>
																				<td><div align="center"><strong>$ <?php echo ($netoET); ?></strong></div></td>
																	</tr>
																		<tr>
																				<td colspan="6"><div align="right"><strong>Total General</strong></div></td>
																				<td><div align="center"><strong>$ <?php echo ($total); ?></strong></div></td>
																				<td><div align="center"><st   rong>$ <?php echo ($propina); ?></strong></div></td>
																				<td><div align="center"><strong>$ <?php echo ($neto); ?></strong></div></td>
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
     </section>
  </div>

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
			var Ruta = 'controllers/Ajax/AjaxImprimirPDF.php?tipo='+Accion+'&FechaI='+Fecha+'&caja='+caja;
			window.open(Ruta, '_blank');
		}

		function OpenFact(Ruta){
			window.open(Ruta, '_blank');
		}

</script>