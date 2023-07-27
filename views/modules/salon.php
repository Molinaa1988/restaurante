<?php
	session_start();
	if(!$_SESSION["validar"]){
		header("location:ingreso");
		exit();
	}
?>
<style>
	.selectpicker{
  		font-size: 20px;
	}
	.filter-option {
    	font-size: 20px;
	}
	.dropdown-header{
		font-size: 20px;
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
				<?php
       				$estadoCaja = controllerCaja::vereficarAperturaCaja();
       		if($estadoCaja['Estado'] != 'A'){
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
                                 	<h4>CAJA CERRADA</h4>
                               	</div>
                            </div>
                        </div>
                    </div>
                </div>
				<?php
					}else{
				?>
				<div class="row" id="mesas">
					<div class="row">
						<div class="col-md-4 col-md-offset-4" align="center">
							<button type="submit" class="btn btn-primary btn-block btn-lg" data-toggle="modal" data-target="#cambioMesa"> Cambio de mesa &nbsp; <i class="fa fa-exchange"></i></button><br><br>
						</div>
					</div>
				</div>
				<?php
					$registro = new controllerSalon();
					$registro -> cambioMesa();
					$registro -> reApertura();
				?>
				<div class="row">
					<div class="col-xs">
						<div id="Mesas"></div>
					</div>
				</div>
				<?php
					}
				?>
			</section>
		</div>
	</div>
</body>

<div class="modal fade" id="cambioMesa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<form name="form1" method="post" action="">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3 align="center" class="modal-title" id="myModalLabel">Cambio de mesa</h3>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-6 col-xs-6">
							<table>
								<tr class="odd gradeX">
									<td style="width:90%;">
										<!-- <input id='mesaCambiar' type="number" class="form-control" name="mesa1" placeholder="Mesa a cambiar" autocomplete="off" required> -->
										<label>Origen</label>
										<select id="mesaCambiar" name="mesa1" class="form-control selectpicker" style="font-size: 20px;" data-style="btn-default" data-size="15">

										</select>

									</td>
									<td>
										<img id="mesaCambiar-opener" class="tooltip-tipsy" src="views/dist/img/cambio.png" width="30" height="30">
									</td>
								</tr>
							</table>
						</div>
						<div class="col-md-6 col-xs-6">
							<table>
								<tr class="odd gradeX">
									<td style="width:90%;">
										<label>Destino</label>
										<!-- <input id="mesaDestino" type="number" class="form-control" name="mesa2" placeholder="Mesa destino" autocomplete="off" required> -->
										<select id="mesaDestino" name="mesa2" class="form-control selectpicker" data-style="btn-default" data-size="15">

										</select>
									</td>
									<td>
										<img id="mesaDestino-opener" class="tooltip-tipsy" src="views/dist/img/ubicacion.png" width="30" height="30">
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-primary">Guardar</button>
				</div>
			</div>
		</div>
	</form>
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
								<a href="#" onClick="crearPedido('<?php echo $itemMeseros["IdPersonal"] ?>')" class="btn btn-sq-lg btn-primary">
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
<div class="modal" name="reApertura" id="reApertura" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<form name="form1" method="post" action="">
		<input type="hidden" id="ididA" name="idA" value="">
		<input type="hidden" id="idmesaReapertura" name="mesaReapertura" value="">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h3 align="center" class="modal-title" id="myModalLabel">Desea Reaperturar la cuenta?</h3>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<center>
								<button type="submit" class="btn btn-sq-lg btn-warning"><i class="fa fa-folder-open-o fa-5x"></i><br>Reaperturar</button>
							</center>
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
<script>

	$(document).ready(function() {
		// actualizarMesas();            // Las mesas no se veran si esto esta comentariado si nunca se a echo una venta asi que la primera venta hay que desactivarlo
		iniScript();
		dataOption();
	});

	$('#mesaCambiar').keyboard({
		openOn : null,
  		stayOpen : true,
		layout: 'custom',
		customLayout: {
			'normal' : [
				'7 8 9',
				'4 5 6',
				'1 2 3',
				'  0  ',
				'{bksp} {a} {c}'
			]
		},
		maxLength : 6,
		restrictInput : true,
		useCombos : false,
		acceptValid : true,
	}).addTyping();

	$('#mesaCambiar-opener').click(function(){
		var kb = $('#mesaCambiar').getkeyboard();
		// close the keyboard if the keyboard is visible and the button is clicked a second time
		if ( kb.isOpen ) {
			kb.close();
		} else {
			kb.reveal();
		}
	});

	$('#mesaDestino').keyboard({
		openOn : null,
  		stayOpen : true,
		layout: 'custom',
		customLayout: {
			'normal' : [
				'7 8 9',
				'4 5 6',
				'1 2 3',
				'  0  ',
				'{bksp} {a} {c}'
			]
		},
		maxLength : 6,
		restrictInput : true,
		useCombos : false,
		acceptValid : true,
	}).addTyping();

	$('#mesaDestino-opener').click(function(){
		var kb = $('#mesaDestino').getkeyboard();
		// close the keyboard if the keyboard is visible and the button is clicked a second time
		if ( kb.isOpen ) {
			kb.close();
		} else {
			kb.reveal();
		}
	});

	function dataOption() {
		$.ajax({
    		url : 'controllers/Ajax/AjaxSalon.php', // la URL para la petición
			data: {"AccionAjax": "actualizarMesas"},
			type: 'POST',
			dataType : 'json', // el tipo de información que se espera de respuesta
			success : function(json) {
				var option = '';
				json.forEach(data => {
					option += `<optgroup label="${data.nombre}">`;
					data.Mesas.forEach(mesa => {
						option += `<option style="font-size: 20px;" value="${mesa.idMesa}">${mesa.Etiqueta}</option>`;
					});
					option += `</optgroup>`;
				});
				$('#mesaCambiar').html(option).selectpicker('refresh');
				$('#mesaDestino').html(option).selectpicker('refresh');

			}
		});
	}

	function actualizarMesas() {
		$.ajax({
    		url : 'controllers/Ajax/AjaxSalon.php', // la URL para la petición
			data: {"AccionAjax": "actualizarMesas"},
			type: 'POST',
			dataType : 'json', // el tipo de información que se espera de respuesta
			success : function(json) {
				var estructura = '';
				json.forEach(data => {
					estructura += `<div class="row">
						<div class="col-xs">
							<div class="callout callout-success">
								<center> <h4>${data.nombre}</h4><center>
							</div>
						</div>
					</div>`;
					estructura += `<div class="row" style="margin-bottom: 25px;">`;
					data.Mesas.forEach(mesa => {
						estructura += `
							<div class="col-md-1 col-sm-2 col-xs-2">
								<a href="#" ${mesa.accion}>
									<center>
										<img src="views/dist/img/${mesa.img}" class="img-circle" alt="User Image" width="100%">
										<h4><span class="label label-primary">M # ${mesa.Etiqueta}</span></h4>
									</center>
								</a>
							</div>
						`;
					});
					estructura += `</div>`;

				});
				$('#Mesas').html(estructura);
			},
			error : function(xhr, status) {
				console.log('Disculpe, existió un problema');
			},
			complete : function(xhr, status) {
				console.log('Petición realizada');
			}
		});
	}

	function asignarIdMesa(idMesa) {
		//console.log(idMesa);
		$("#idMesa").val(idMesa);
	}

	function crearPedido(IdPersonal) {
		var idMesa = $("#idMesa").val();
		$.ajax({
    		url : 'controllers/Ajax/AjaxSalon.php', // la URL para la petición
			data: {"AccionAjax": "crearPedido", "idPersonal": IdPersonal, "idMesa": idMesa},
			type: 'POST',
			dataType : 'json', // el tipo de información que se espera de respuesta
			success : function(json) {
				console.log(json.Mensaje);
				$("#IdModalMeseros").modal('hide');
			},
			error : function(xhr, status) {
				console.log('Disculpe, existió un problema');
			},
			complete : function(xhr, status) {
				console.log('Petición realizada');
				//console.log(xhr);
				idPedido = xhr.responseJSON.IdPedidoF[0];
				window.location=`menuPedido?IdPedido=${idPedido}`;
			}
		});
	}
	var timestamp = null;
	function iniScript() {
// 		$.ajax({
// 			async: true,
//     		url : 'controllers/Ajax/AjaxSalon.php', // la URL para la petición
// 			data: {"AccionAjax": "timestamp", "timeStamp": timestamp},
// 			type: 'POST',
// 			dataType : 'json', // el tipo de información que se espera de respuesta
// 			success : function(json) {
				actualizarMesas();
				// timestamp = json.timestamp;
				setTimeout(() => {
					iniScript()
				}, 1000);
// 			},
// 			error : function(xhr, status) {
// 				console.log('Disculpe, existió un problema');
// 			},
// 			complete : function(xhr, status) {
// 				console.log('Petición realizada');
// 			}
// 		});
        // console.log(':c')
	}

	function reaperturaMesa(Mesa, Personal) {
		$('#ididA').val(Personal);
		$('#idmesaReapertura').val(Mesa);
	}
</script>
