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
												Reporte cuentas por cobrar
										</div>
										<div class="panel-body">

										 <div class="panel panel-default">
										<div class="panel-body">


											<?php

												 if(!empty($_GET['fechai']) and !empty($_GET['fechaf']))
												 {
														 $fechai=($_GET['fechai']);
														 $fechaf=($_GET['fechaf']);
														 $Estado=($_GET['Estado']);
														 $Tipo=($_GET['Tipo']);
												 }
												 else
												 {
														 $fechai=date('Y-m-d');
														 $fechaf=date('Y-m-d');
														 $Estado='P';
														 $Tipo='H';
												 }
													 ?>

			            <div class="row-fluid">


	<form name="gor" action="" method="get" class="form-inline">
						<div class="row-fluid">
							<div class="col-md-2 col-sm-3" align="center">
								<strong>Fecha Inicial</strong><br>
								<input type="date" class="form-control" name="fechai" autocomplete="off" required value="<?php echo $fechai; ?>">
							</div>
							<div class="col-md-2 col-sm-3" align="center">
								<strong>Fecha Final</strong><br>
								<input type="date" class="form-control" name="fechaf" autocomplete="off" required value="<?php echo $fechaf; ?>">
							</div>
							<div class="col-md-2 col-sm-3" align="center">
								<center><strong>Tipo</strong></center>
								<select class="form-control" id="Tipo" name="Tipo" autocomplete="off" required>
									<option value="H" selected>Hugo</option>
									<option value="C">Crédito</option>
								</select>
							</div>
							<div class="col-md-2 col-sm-3" align="center">
								<center><strong>Estado</strong></center>
								<select class="form-control" id="Estado" name="Estado" autocomplete="off" required>
									<option value="P" selected>Pendientes</option>
									<option value="C">Cancelados</option>
								</select>
							</div>
							<div class="col-md-3 col-sm-3" align="center"><br>
								<button type="submit" class="btn btn-icon waves-effect waves-light btn-primary m-b-5"><strong>Consultar</strong></button>
								<button type="button" class="btn btn-icon waves-effect waves-ligth btn-<?php if ($Estado=="P"){ echo "success";}else {echo "danger";} ?> m-b-5" onclick="pagarVarios();"><strong>Cambiar</strong></button>

							</div>
									
						</div>
		</form>

			            </div>
						<div style="width:100%; height:700px; margin-top: 50px; overflow: auto;" >
<br>
	<div class="table-responsive">

		<table class="table table-striped table-bordered table-hover"  width="100%"  border="0">

			<thead>
				<tr>
					
					<th><center><input type="checkbox" id="ch1" ></center></th>
					<th><center>Acciones</center></th>
					<!--<th><center>Atendió</center></th>-->
					<th><center>Cliente</<center></th>
					<th><center>Tipo de Comprobante</center></th>
					<th><center>Nro de Comprobante</center></th>
					<th><center>Estado</center></th>
					<th><center>Fecha otorgado</center></th>
					<th><center>Fecha cancelado</center></th>
					<!-- <th><center>Total</center></th>
					<th><center>Propina</center></th> -->
					<th><center>Total</center></th>

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

			$respuesta = controllerReportes::ReporteCuentrasPorCobrar($fechai,$fechaf,$Estado, $Tipo);
			
			//var_dump($respuesta
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
					$Ruta .= "&cliente=".$item['Nombre'];
					$Ruta .= "&Exentos=-".round($DtsComprobante["Exentos"], 2);
				}
				?>
		<tr class="odd gradeX">
		<td><center><input type="checkbox"  name="tableid[]" value="<?php echo ($item['IdPedido']); ?>"></center>
</div></td>
			<td><center>
				<button onclick="OpenFact('<?php echo $Ruta ?>');" class="btn btn-primary" title="Imprimir">
					<i class=" fa fa-print"></i>
				</button>
				<button onclick="Pagar('<?php echo ($item['IdPedido']); ?>', '<?php echo $Estado ?>')" class=" btn btn-primary btn-<?php if ($Estado=="P"){ echo "success";}else {echo "danger";} ?>" title="Cancelar">
					<i class=" fa fa-check-circle-o"></i>
				</button>

			</td>
			
			</td>
			<!--<td><center><?php echo $item['Nombres'] ?></center></td> -->
				
				<td><center><?php echo $item['Nombre']?></center></td>
				<!--<td><center><?php echo $item['Tipo'] ?></center></td>-->
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
					<a href="ReporteVentasporDiaDetalle?var=<?php echo $item['NumeroDoc']?>&tipo=T"><?php echo $item['NumeroDoc']?> </a>
				</center>
			</td>
			
			<td><center><?php if ($Estado=="P"){ echo "Pendiente";}else {echo "Cancelado";}?></center></td>
			<td><center> <?php echo $item['FechaFact'] ?></center></td>
			<td><center> <?php echo $item['FechaC'] ?></center></td>
			<!-- <td><center>$ <?php echo $item['TotalPagar'] ?></center></td> -->
			<!-- <td><center><?php echo $item['Total'] ?></center></td>
			<td><center><?php echo $item['Propina'] ?></center></td> -->
			<td><center>$ <?php echo $item['TotalPagar'] ?></center></td>
		</tr>

		<?php } 
			$respuesta = modelReportes::ReporteCuentrasPorCobrarFacturas($fechai,$fechaf,$Estado);
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
				}

				$neto=$neto+$item['TotalPagar'];
				$total=$total+$item['Total'];
				$propina=$propina+$item['Propina'];
				$Ruta = "#";

		?>
																		
											<?php } ?>

											<tr>
												<td colspan="8"><div align="right"><strong><h4>Total General</h4></strong></div></td>
												<td><div align="center"><strong><h4>$ <?php echo ($total); ?></h4></strong></div></td>
												<!--<td><div align="center"><strong><h4>$ <?php echo ($propina); ?></h4></strong></div></td>
												<td><div align="center"><strong><h4>$ <?php echo ($neto); ?></h4></strong></div></td>-->
												
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
     		</section>
  		</div>
	</div>
</body>
<script>




$("#ch1").change(function() {
	$("input[name='tableid[]']").prop('checked', this.checked);
})

	function pagarVarios(){		
		var ids = $('input[name="tableid[]"]:checked').map(function(){
			return this.value;
		}).get();
		var str = ids.join(',');
		var msgForIn = '';
		arr = str.split(',');
		Pagar( str, "<?php echo $Estado ?>"); 
			
	
	}



	function Pagar(IdPedido, Estado) {
		swal({
			title: '¿Desea cambiar el estado?',
			text: "De las cuentas seleccionadas",
			type: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Sí, cambiar',
			cancelButtonText: 'No',
			reverseButtons: true
		}).then((result) => {
  			if (result) {
				/*swal(
				'Pagar la cuenta',
				'La cuenta ha sido pagada exitosamente.',
				'success'
				)*/

				$.ajax({
					url:"controllers/Ajax/AjaxExtras.php",
				  	method:"POST",
				  	data:{AccionAjax:'UpCxC', 
						DtsAjax: { IdPedido, Estado,}},
				  	dataType:"json",
					success: function (resp) {
					//console.log(resp);	
					location.reload();
					}
		
				})
				
  			}
		}, (err) => {
			swal(
				'Cancelado',
				'No se han realizado cambios',
				'error'
			)
		})
	}
</script>
