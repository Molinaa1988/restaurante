<?php

session_start();
	if(!$_SESSION["validar"]){
		header("location:ingreso");
		exit();
	}
    clearstatcache();


?>



<body class="hold-transition skin-blue sidebar-collapse sidebar-mini">
	<div class="wrapper">
		<?php
			include "views/modules/cabezote.php";
			include "views/modules/botonera.php";
		?>

		<audio id="myAudio" autoplay muted>
			<source src="views/dist/img/sonido.wav" type="audio/wav">
		</audio>
		<div class="content-wrapper">
			<br>
			<div class="row mt-5">
				<div class="col-md-2 col-md-offset-5">
					<button type="button" name="btnlistpedido" id="idbtnlistpedido" class="btn btn-primary btn-lg btn-block">Lista</button>
				</div>
			</div>
			<div id="ListPedidos" class="content"></div>
		</div>
 	</div>
</body>



<script>

	$(document).ready(function() {
		loadPedidos();
	});

	// var x = document.getElementById("myAudio");
	function playAudio() {
		$("#myAudio").get(0).load();
		$("#myAudio").prop('muted', false);
		return $("#myAudio").get(0).play().then(function() {
			$("#myAudio").get(0).play()
			// console.log('sss');
		}).catch(function(error) {
			$("#myAudio").get(0).autoplay = true;
		});
	}

	var intro = 'animate__animated animate__backInDown';
	var sonido = false;
	function ordenPreparada(idPedidoE){
		swal({
			title: 'Eliminar',
			text: "Esta seguro de Eliminar el pedido de cocina?",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			confirmButtonText: 'Eliminar',
			cancelButtonText: 'Cancelar'
		}).then((result) => {
			$.ajax({
				url:"controllers/Ajax/AjaxCocina.php",
				method:"POST",
				data:{ idPedidoEliminar:idPedidoE },
				dataType:"text",
				success:function(html){
					location.reload();
				}
			});
		});
	}

	function enviarMensaje(to, msg) {
		$.ajax({
						url:"controllers/Ajax/AjaxWasak.php",
						method:"POST",
						data: {to: to,
							   msg: msg},
						dataType: 'text',
						success:function(html)
						{
							console.log("asasasa asdas");
						}
					});
	}

	function loadPedidos() {
		$.ajax({
			url:"controllers/Ajax/AjaxCocina.php",
			method:"POST",
			data:{ AccionAjax:'Cargar' },
			dataType:"json",
			success:function(resp){
				var contenido = "";
				var row = "";
				var Panelbox  = 0;
				var NumS = 0;
				resp.forEach(data => {
					var tbody = '';
					var estado = 'P';
					data.DetallePedido.forEach(detalle => {
						console.log(detalle);
						if (detalle.Estado != estado){
							estado = detalle.Estado
							tbody += `
								<tr>
									<td colspan ="3" align ="center"  ><b>Bebida </b></td>
									
								</tr>
							`;

						}
						tbody += `
							<tr>
								<td>${ detalle.Cantidad }</td>
								<td>${ detalle.Plato }</td>
								<td>${ detalle.comentario }</td>
								
							</tr>
						`;
					});
					contenido += `
					<div id="${ data.IdPedido }" class="col-sm-6 col-md-4 col-lg-4 ${ intro }" onClick="EliminarList('${ data.IdPedido }')">
						<div class="box ${ data.Panel }">
							<div class="box-header">
								<div class="row">
									<div class="col-sm-6 col-md-6 col-lg-6">
										<span style="font-size: 18px; float: left; text-align: left;" class="label ${ data.Label }">
											Mesa:  ${ data.Mesa }
										</span>
									</div>
									<div class="col-sm-6 col-md-6 col-lg-6">
										<span style="font-size: 18px; float: right; text-align: right;" class="label ${ data.Label }">
											T:	${ data.Tiempo }
										</span>
									</div>
								</div>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-md-12">
									<table id="TablaPedidos" class="table table-bordered compact table-striped table-hover border='0'">
										<thead>
											<th>Cant.</th>
											<th>Descripcion</th>
											<th>Comentario</th>
										</thead>
										<tbody>
											${ tbody }
										</tbody>
									</table>
									</div>
								</div>
							</div>
							<div class="box-footer">
								<div class="row">
									<div class="col-md-6">
										<span style="font-size: 16px; float: left; text-align: left;" class="label ${ data.Label }">
											Mesero:  ${ data.Mesero }
										</span>
									</div>
									<div class="col-md-6">
										<span style="font-size: 16px; float: right; text-align: right;" 
											class="label ${ data.Label }">
											Tipo: ${ data.Naturaleza }
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					`;
					NumS += data.CantS;
					// if (data.Tiempo == "00:01:00") {
							 
					// 		var idp = data.IdPedido;
					// 		var mesero = data.Mesero;
					// 		//enviarMensaje("50372240493", "El pedido "+idp+" de "+mesero+" lleva 20 minutos en espera");
						
					// }
					Panelbox += 1;
					if (Panelbox === 4) {
						row += `
						<div class="row">
							${ contenido }
						</div>`;
						Panelbox = 0;
						contenido = '';
					}

				});
				row += `
				<div class="row">
					${ contenido }
				</div>`;
				if (NumS > 0) {
					playAudio()
					
					
						
				}
				$("#ListPedidos").html('');
				$("#ListPedidos").append(row);
				sonido = !sonido;
				intro = '';
				setTimeout(() => {
					loadPedidos()
				}, 1000);
			}
		});
	}

	function EliminarList(IdPedido) {

		swal({
			title: 'Eliminar',
			text: "Esta seguro de Eliminar el pedido de cocina?",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			confirmButtonText: 'Eliminar',
			cancelButtonText: 'Cancelar'
		}).then((result) => {
			$.ajax({
				url:"controllers/Ajax/AjaxCocina.php",
				method:"POST",
				data:{idPedidoEliminar:IdPedido},
				dataType:"text",
				success:function(html)
				{
					intro = 'animate__animated animate__backInRight';
				}
			});
		});
	}

</script>
