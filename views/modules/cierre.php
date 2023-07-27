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


$apertura = new controllerCaja();
 $apertura -> AperturaCaja();

?>
         <div class="content-wrapper">
           <section class="content">



			<?php
				if(isset($_POST['fechai'])){
						$fechai=$_POST['fechai'];
				}else{
						$fechai=date('Y-m-d');
				}

				if((!empty($_POST['FechaI'])) && (!empty($_POST['FechaF'])) )
				{
					$FechaI=($_POST['FechaI']);
					$FechaF=($_POST['FechaF']);
				}
				else
				{
					$FechaI=date('Y-m-d');
					$FechaF=date('Y-m-d');
				}

				if (!empty($_POST['mes'])){
					$mes = ($_POST['mes']);
				}else{
					$mes = date('Y-m', strtotime('-0 month'));
				}	

			?>
			<div class="row">




						<!-- <div class="col-md-12">
							<center><button class="btn btn-primary" onclick="reporteElectronico();">Cierre de caja</button><center><br>
								
						</div> -->
			</div>
			<div hidden="true"> <input type="hidden" name="fechai" id="fechai" value="<?php echo $fechai; ?>" ></div>
			 <div hidden="true"> <!-- CON ESTA ETIQUETA OCULTO LOS REPORTES  -->
			 
			 <div class="row">
						<div class="col-md-4">
							<div class="row">
									 <div class="col-md-6">

									<?php

								 function CalcularCeros($numeroDoc)
								{
									if ($numeroDoc == "")
									{
										 $ceros = "0001";
									}
									else if ($numeroDoc >= 0 && $numeroDoc < 10 )
									{
										 $ceros = str_pad($numeroDoc, 4, "000", STR_PAD_LEFT);
									}
									else if ($numeroDoc >= 10 && $numeroDoc < 100)
									{
										$ceros = str_pad($numeroDoc, 4, "00", STR_PAD_LEFT);
									}
									else if ($numeroDoc >= 100 && $numeroDoc < 1000)
									{
										 $ceros = str_pad($numeroDoc, 4, "0", STR_PAD_LEFT);
									}
									else
									{
										$ceros = $numeroDoc;
									}
										return $ceros;
								}

									$DatosCorrelativoTickets = controllerCierre::DatosCorrelativoTickets();
												$ti = $DatosCorrelativoTickets["Menor"];
												$tf	= $DatosCorrelativoTickets["Mayor"] + 1;
												$mayorTicket = CalcularCeros($tf);
									$DatosTotalVentaTickets= controllerCierre::DatosTotalVentaTickets();
												$tTotal = $DatosTotalVentaTickets["Total"];
									$DatosFCF = controllerCierre::DatosFCF();
												$fcfi = $DatosFCF["Menor"];
												$fcff	= $DatosFCF["Mayor"];
												$fcfTtotal = $DatosFCF["Total"];
									$DatosCCF = controllerCierre::DatosCCF();
												$ccfi = $DatosCCF["Menor"];
												$ccff	= $DatosCCF["Mayor"];
												$ccfTtotal = $DatosCCF["Total"];
									$DatosDevolucion = controllerCierre::DatosDevolucion();
												$devolucion= $DatosDevolucion["Total"];
												if ($devolucion == "")
												{
													$devolucion = "0.00";
												}
												else {
													$devolucion;
												}
												$subTotal = $tTotal + $fcfTtotal + $ccfTtotal;
												$Total = ($tTotal + $fcfTtotal + $ccfTtotal) - $devolucion

									?>
								

										</div>
										
							
						</div>
						</div>
						

				</div>
			</div>

<!-- BOTONES -->
			 <br>

<div class="row">
<input type="hidden" name="corrZ" id="corrZ"  value="<?php echo $mayorTicket; ?>" autocomplete="off">


<!-- HABILITADO APERTURA -->
<div id="btn1"  onclick="ModalApertura();" class="col-lg-4 col-xs-6">
	<div id="aperturaBtnHabilitado" class="small-box bg-aqua">
		<div class="inner">
			<h3>Aperturar</h3>
			<p>Caja #<?php echo $estadoCaja["IdFcaja"] + 1;?></p>
		</div>
		<div class="icon">
			<i class="fa fa-arrow-circle-up"></i>
		</div>
		<a href="#" class="small-box-footer">
 			<i class="fa fa-arrow-circle-right"></i>
		</a>
	</div>
</div>

<!-- DESABILITADO APERTURA -->
<div id="btn1D" hidden class="col-lg-4 col-xs-6">
	<div id="aperturaBtnDesabilitado" class="small-box bg-gray">
		<div class="inner">
			<h3>Aperturar</h3>
			<p>Caja</p>
		</div>
		<div class="icon">
			<i class="fa fa-arrow-circle-up"></i>
		</div>
		<a href="#" class="small-box-footer">
 			<i class="fa fa-arrow-circle-right"></i>
		</a>
	</div>
</div>


<!-- HABILITADO REAPERTURA -->
<div id="btn2"  onclick="CredencialUser('DEL')" class="col-lg-4 col-xs-6">
	<div id="reaperturaBtnHabilitado" class="small-box bg-green">
		<div class="inner">
			<h3>Reaperturar</h3>
			<p>Caja #<?php echo $estadoCaja["IdFcaja"];?></p>
		</div>
		<div class="icon">
			<i class="fa fa-refresh"></i>
		</div>
		<a href="#" class="small-box-footer">
 			<i class="fa fa-arrow-circle-right"></i>
		</a>
	</div>
</div>

<!-- DESABILITADO REAPERTURA -->
<div id="btn2D" hidden  class="col-lg-4 col-xs-6">
	<div id="reaperturaBtnDesabilitado" class="small-box bg-gray">
		<div class="inner">
			<h3>Reaperturar</h3>
			<p>Caja</p>
		</div>
		<div class="icon">
			<i class="fa fa-refresh"></i>
		</div>
		<a href="#" class="small-box-footer">
 			<i class="fa fa-arrow-circle-right"></i>
		</a>
	</div>
</div>

<!-- HABILITADO CERRAR CAJA -->
<div id="btn3" onclick="ModalCierre();" class="col-lg-4 col-xs-6">
<input type="hidden" name="message" id="message" value="x" autocomplete="off" required>
	<div class="small-box bg-yellow">
		<div class="inner">
			<h3>Cerrar</h3>
			<p>Caja</p>
		</div>
		<div class="icon">
			<i class="fa fa fa-lock"></i>
		</div>
		<a href="#" class="small-box-footer">
 			<i class="fa fa-arrow-circle-right"></i>
		</a>
	</div>
</div>

<!-- DESABILITADO CERRAR CAJA -->
<div id="btn3D" hidden class="col-lg-4 col-xs-6">
	<div class="small-box bg-gray">
		<div class="inner">
			<h3>Cerrar</h3>
			<p>Caja</p>
		</div>
		<div class="icon">
			<i class="fa fa fa-lock"></i>
		</div>
		<a href="#" class="small-box-footer">
 			<i class="fa fa-arrow-circle-right"></i>
		</a>
	</div>
</div>

		</div>

		<?php
		   $estadoCaja = controllerCaja::ultimoIdCajaCajaChica();
			 $IdFcaja =  $estadoCaja["IdFcaja"];
				$date = new DateTime($estadoCaja["Fecha"]);

				$date2 = new DateTime($estadoCaja["HoraCierre"]);
			 $estadoCaja["MontoApertura"];
			 $estado =  $estadoCaja["Estado"];
			?>

		<div class="callout callout-<?php if($estadoCaja["Estado"] == "A"){echo 'info';}else{echo 'warning';}?> ">
		        <h1><?php if($estadoCaja["Estado"] == "A"){echo 'La caja se encuentra abierta';}else{echo 'La caja se encuentra cerrada';}?></h1>
		        <h3><?php if($estadoCaja["Estado"] == "A"){echo 'Fecha de apertura '.date_format($date, 'd-m-Y H:i'). ' || Numero de caja: '.$estadoCaja["IdFcaja"];}else{echo 'Fecha apertura: '.date_format($date, 'd-m-Y H:i').' || Fecha de cierre: '.date_format($date2, 'd-m-Y H:i') ;}?></h3>
				<input type ="hidden"  name="fa" id="fa" value="<?php echo substr($estadoCaja["Fecha"],0,10)?>" >
				<input type ="hidden"  name="caa" id="caa" value="<?php echo $estadoCaja["IdFcaja"]?>" >
											
		 </div>
<!-- FIN DE BOTONES  -->


<!-- otros botones para los otros cortes -->

<!-- BOTONES -->
<br>

<div class="row">

<!-- corte X -->
<div id="btn7"  onclick="SwalCorteX();" class="col-lg-3 col-xs-6">
	<div id="BtnZ" class="small-box bg-blue">
		<div class="inner">
			<h3>Corte X</h3>
			<p>Emitir corte parcial</p>
		</div>
		<div class="icon">
			<i class="fa fa-times"></i>
		</div>
		<a href="#" class="small-box-footer">
 			<i class="fa fa-arrow-circle-right"></i>
		</a>
	</div>
</div>

<!-- corte z -->
<div id="btn4"  onclick="SwalCorteZ();" class="col-lg-3 col-xs-6">
	<div id="BtnZ" class="small-box bg-blue">
		<div class="inner">
			<h3>Corte Z</h3>
			<p>Corte de la Caja #<?php echo $estadoCaja["IdFcaja"];?></p>
		</div>
		<div class="icon">
			<i class="fa fa-times-circle-o"></i>
		</div>
		<a href="#" class="small-box-footer">
 			<i class="fa fa-arrow-circle-right"></i>
		</a>
	</div>
</div>


<!-- gran z -->
<div id="btn5"  onclick="modalGranZ()" class="col-lg-3 col-xs-6">
	<div id="BtnGranZ" class="small-box bg-blue">
		<div class="inner">
			<h3>Gran Z</h3>
			<p>Corte Z mensual</p>
		</div>
		<div class="icon">
			<i class="fa fa-calendar-times-o"></i>
		</div>
		<a href="#" class="small-box-footer">
 			<i class="fa fa-arrow-circle-right"></i>
		</a>
	</div>
</div>


<!-- cinta auditoria -->
<div id="btn6" onclick="modalCinta();" class="col-lg-3 col-xs-6">
<input type="hidden" name="message" id="message" value="y" autocomplete="off" required>
	<div class="small-box bg-blue">
		<div class="inner">
			<h3>Cinta </h3>
			<p>Generar Cinta de auditoría</p>
		</div>
		<div class="icon">
			<i class="fa fa fa-file-o"></i>
		</div>
		<a href="#" class="small-box-footer">
 			<i class="fa fa-arrow-circle-right"></i>
		</a>
	</div>
</div>


		</div>


        </section>
      </div>
		</div>

		<div class="modal fade" id="modalAperturar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<form name="aperturar" method="post" action="">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h3 align="center" class="modal-title" id="myModalLabel">¿DESEA APERTURAR NUEVA CAJA?</h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-4 col-md-offset-4">
									<input class="form-control" name="montoaperturarR" placeholder="Monto" autocomplete="off" required>
									<br>
								</div>
							</div>
							<input type="hidden" name="IdPersonal" value="<?php echo $_SESSION['IdPersonal'] ?>">
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
							<button type="submit" class="btn btn-primary">Aperturar</button>
						</div>
					</div>
				</div>
			</form>
		</div>

		<!-- MODAL PARA EL GRAN Z -->
		<div class="modal fade" id="modalGranZ" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<form name="granZ" method="post" action="">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h3 align="center" class="modal-title" id="myModalLabel">Seleccione el mes a auditar</h3>
						</div>
						<div class="panel-body">
						<div class="row">
								<div class="col-md-6 col-xs-12 col-md-offset-3 form-group has-feedback">
									<input id="mes" type="month" class="form-control has-feedback-left" name="mes" autocomplete="off" 
									value="<?php echo $mes ?>" required>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
							<button type= "button" class="btn btn-primary" onclick="granCorteZ()">Imprimir</button>
							<!-- <button type="submit" class="btn btn-primary">Imprimnir</button> -->
						</div>
					</div>
				</div>
			</form>
		</div>
		
		<!-- MODAL CINTA DE AUDITORIA -->
		<div class="modal fade" id="modalCinta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<form name="cinta" method="post" action="">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h3 align="center" class="modal-title" id="myModalLabel">Seleccione el periodo a auditar</h3>
						</div>
						<div class="panel-body">
						<div class="row">
								<div class="col-md-5 col-xs-12 col-md-offset-1 form-group has-feedback">
									<label>Fecha Inicial </label>
									<input id="FechaI" type="date" class="form-control has-feedback-left" name="FechaI" autocomplete="off" 
									value="<?php echo $FechaI ?>" required>
								</div>
								<div class="col-md-5 col-xs-12 form-group has-feedback">
									<label>Fecha Final </label>
									<input id="FechaF" type="date" class="form-control has-feedback-left" name="FechaF" autocomplete="off" 
									value="<?php echo $FechaF ?>" required>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
							<button class="btn btn-primary" onclick="imprimirCinta('cinta')">Imprimir</button>
							<!-- <button type="submit" class="btn btn-primary">Imprimnir</button> -->
						</div>
					</div>
				</div>
			</form>
		</div>

												




<script>

			window.onload = function() {
			var Estado = "<?php echo $estado ?>";
			if(Estado=="C")
			{
				$('#btn3D').removeAttr('hidden');
				$("#btn3").attr("hidden",true);
			}else{
				$('#btn1D').removeAttr('hidden');
				$('#btn2D').removeAttr('hidden');

				$("#btn1").attr("hidden",true);
				$("#btn2").attr("hidden",true);
			}

			};




			document.getElementById("btn1").style.cursor = "pointer";
			document.getElementById("btn2").style.cursor = "pointer";
			document.getElementById("btn3").style.cursor = "pointer";
			document.getElementById("btn4").style.cursor = "pointer";
			document.getElementById("btn5").style.cursor = "pointer";
			document.getElementById("btn6").style.cursor = "pointer";

			document.getElementById("btn1D").style.cursor = "not-allowed";
			document.getElementById("btn2D").style.cursor = "not-allowed";
			document.getElementById("btn3D").style.cursor = "not-allowed";



			function prueba() {
				// $('#btn3D').removeAttr('hidden');
				$("#btn3D").attr("hidden",true);
		}

		function ModalApertura() {
				$("#modalAperturar").modal("show");
		}
		
		
		function modalGranZ() {
				$("#modalGranZ").modal("show");
		}
		
		function modalCinta() {
				$("#modalCinta").modal("show");
		}

		function SwalCorteZ() {
		
		swal({
				title: "Corte Z",
				text: "¿Desea emitir el corte Z?",
				type: "question",
				confirmButtonColor: "#0C71e0",
				confirmButtonText: "Emitir",
				showCancelButton: true,
				cancelButtonColor: "#d33",
				reverseButtons: true
				}).then(function () {
						corteZd();
				});	
		

		}
		
		//pedir contraseña para reaperturar
		
		function CredencialUser(React) {

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
									ModalReapertura();
									
								}else{
									swal('Caja', 'Acceso Denegado', 'error',)
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

				

			function ModalReapertura() {
			swal({
				title: "Reapertura de caja",
				text: "¿Desea reaperturar caja?",
				type: "question",
				showCancelButton: true,
				confirmButtonColor: "#0C71e0",
				cancelButtonColor: "#d33",
				confirmButtonText: "Reaperturar",
				reverseButtons: true,
			}).then(function () {
				var IdFCajaReaperturar = <?php echo $IdFcaja ?>;
				$.ajax({
					method:"POST",
					data:{IdFCajaReaperturar:IdFCajaReaperturar},
					url:"controllers/Ajax/AjaxCierre.php",
					dataType:"text",
					success:function(html)
					{
						swal({
							title: "Aperturada",
							text: "La caja se reaperturo exitosamente",
							type: "success",
							showCancelButton: false,
							confirmButtonColor: "#0C71e0",
							cancelButtonColor: "#d33",
							confirmButtonText: "Ok"
						}).then(function () {
						location = location;
						});
					}
				});
			});
		}

		//intento 001 de desconnatar ingredientes al cierre
		function ModalCierre() {
			reporteElectronico();
			autoDescontar();
		}

		var conn = true;
		$(document).ready(function() {
			checkConnection();

			function checkConnection() {
				if(navigator.onLine){
					conn = true;
					// alert('Online');
				} else {
					conn = false;
					// alert('Offline');
				}
				}
		})

			// para revisar si hay cuentas abiertas
			function reporteElectronico() {
				<?php
				$cantidadCuentas = 0;
				$respuesta = modelRealizarVenta::vistaPedidosEnCaja();
				foreach($respuesta as $row => $item){
						$cantidadCuentas++;
					}
				?>
				var cantidadCuentas = <?php echo $cantidadCuentas ?>;
				swal({
				title: "Cierre de caja",
				text: "¿Desea cerrar la caja?",
				type: "question",
				showCancelButton: true,
				confirmButtonColor: "#0C71e0",
				cancelButtonColor: "#d33",
				confirmButtonText: "Cerrar",
				reverseButtons: true
				}).then(function () {
					if(cantidadCuentas == 0){
						cierreCaja();
					
					}
					else {
						swal(
							'Error',
							'No se puede cerrar caja hay cuentas abiertas',
							'error'
						);
					}
			});
		}

		function reporteElectronicoAjax() {
				var mensaje = $("#message").val();
				var fa =$("#fa").val();
				var caa=$("#caa").val();
				console.log(mensaje,fa,caa);
			$.ajax({
				method:"POST",
				data:{mensajeAjax:mensaje,
						fa:fa,
					caa:caa},
			url:"controllers/Ajax/AjaxCierre.php",
			dataType:"text",
			success:function(html)
			{
				if(conn)
				{
					swal(
						'Enviado',
						'Se envio el reporte exitosamente',
						'success'
					).then(function () {
						location = location;
					});
				}
				else {
					swal(
						'Error',
						'No se pudo enviar el reporte por falta de internet',
						'error'
					).then(function () {
						location = location;
					});

				}
			}
			});
		}

		//pa los ingredientes
		function autoDescontar() {
			var fechai =$("#fechai").val();
			var fa =$("#fa").val();
			$.ajax({
				url:"controllers/Ajax/AjaxCierre.php",
				method: "POST",
				data:{fechai: fa},
				dataType: 'text',
				success:function(html){
					
				}
			});
			
		}
		
		// para solo hacer el cierre, es decir solo en fcaja
		function cierreCaja(){
			var caja = <?php echo $estadoCaja["IdFcaja"];?>;
			var accion = "cierre"
			$.ajax({
				url:"controllers/Ajax/AjaxCierre.php",
				method: "POST",
				data:{caja: caja,
					  accion: accion},
				dataType: 'text',
				success:function(html){
					swal(
						'Caja cerrada',
						'Se realizo el cierre exitosamente',
						'success'
					).then(function () {
						reporteElectronicoAjax();
						
					});
					//	location = location;
				}
			});
			
		}


		// para agregar el corte Z a los comprobantes C
		function corteZd(){
			var caja = <?php echo $estadoCaja["IdFcaja"];?>;
			var accion = "Z";
			let cor = '<?php echo $mayorTicket; ?>';
			console.log(cor);
			$.ajax({
				url:"controllers/Ajax/AjaxCierre.php",
				method: "POST",
				data:{caja: caja,
					accion: accion,
					cor: cor},
					dataType: 'text',
					success:function(html){
						swal("Corte Z realizado exitosamente");
						openpdf(caja, cor, accion);
					}
				});
				
			}	
			
			// para agregar el corte Z a los comprobantes C
		function SwalCorteX(){
			swal({
				title: "Corte X",
				text: "¿Desea emitir el corte parcial?",
				type: "question",
				confirmButtonColor: "#0C71e0",
				confirmButtonText: "Emitir",
				showCancelButton: true,
				cancelButtonColor: "#d33",
				reverseButtons: true
			}).then(function () {
				var caja = <?php echo $estadoCaja["IdFcaja"];?>;
				var accion = "X";
				var cor = '<?php echo $mayorTicket; ?>';
				$.ajax({
					url:"controllers/Ajax/AjaxCierre.php",
					method: "POST",
					data:{caja: caja,
						accion: accion,
						cor: cor},
						dataType: 'text',
						success:function(html){
							swal("Corte  X realizado exitosamente");
							openpdf(caja, cor, accion);
						}
				});
			});

		}	
		
		function openpdf(Caja, Cor, Accion){
			var url = 'controllers/Ajax/AjaxFactura.php?Accion='+Accion+'&Caja='+Caja+'&Tic='+Cor
			var params  = 'width='+screen.width;
			params += ', height='+screen.height;
			params += ', top=0, left=0'
			params += ', fullscreen=yes'
			params += ', status=no, toolbar=no, menubar=no, resizable= No';
			window.open(url, 'Cortez', params);
			return false;

		}


		function granCorteZ(){
			var accion = "granZ";
			var cor = '<?php echo $mayorTicket; ?>';
			var mes = document.getElementById("mes").value;
			$.ajax({
				url:"controllers/Ajax/AjaxCierre.php",
				method: "POST",
				data:{mes: mes,
					accion: accion,
					cor: cor},
				dataType: 'text',
				success:function(html){
						swal("Corte realizado exitosamente");
						openpdfZ(mes, cor, accion);
				}
			});

		}

		function openpdfZ(Mes, Cor, Accion){
			var url = 'controllers/Ajax/AjaxFactura.php?Accion='+Accion+'&Mes='+Mes+'&Cor='+Cor
			var params  = 'width='+screen.width;
			params += ', height='+screen.height;
			params += ', top=0, left=0'
			params += ', fullscreen=yes'
			params += ', status=no, toolbar=no, menubar=no, resizable= No';
			window.open(url, 'Corte Gran Z', params);
			return false;

		}
		
		function imprimirCinta(Accion){
			var fechaC = document.getElementById("FechaI").value
			var fechaC2 = document.getElementById("FechaF").value
			var url = 'controllers/Ajax/AjaxFactura.php?Accion='+Accion+'&FechaI='+fechaC+'&FechaF='+fechaC2
			var params  = 'width='+screen.width;
			params += ', height='+screen.height;
			params += ', top=0, left=0'
			params += ', fullscreen=yes'
			params += ', status=no, toolbar=no, menubar=no, resizable= No';
			window.open(url, 'Corte Gran Z', params);
			return false;

		}
		

</script>
