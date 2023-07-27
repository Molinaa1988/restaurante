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

$modelComp = new modelComprobantes();

?>



  <div class="content-wrapper">
    <section class="content">

			                     <div class="row">
			                 <div class="col-md-12">
			                     <!-- Advanced Tables -->
			                     <div class="panel panel-primary">
			                         <div class="panel-heading">
			                             Reporte de tickets emitidos
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

                                    <div class="row-fluid">
                                            <form name="gor" action="" method="post" class="form-inline">
                                            <div class="col-xs-6 col-sm-3" align="center">
                                                                                <strong>Fecha inicial</strong><br>
                                                                                <input type="date" class="form-control" name="fechai" autocomplete="off" required value="<?php echo $fechai; ?>">
                                            </div>
                                            <div class="col-xs-6 col-sm-3" align="center">
                                                                                <strong>Fecha final</strong><br>
                                                                                <input type="date" class="form-control" name="fechaf" autocomplete="off" required value="<?php echo $fechaf; ?>">
                                            </div>
                                            <div class="col-xs-12 col-sm-3" align="center"><br>
                                                <button type="submit" class="btn btn-icon waves-effect waves-light btn-primary m-b-5"><strong>Consultar</strong></button>
                                            </div>
                                        </form>
                                        <!-- <div class="col-xs-12 col-sm-3" align="center"><br>
                                        <button onclick="cambiarTaO();" class="btn btn-icon waves-effect waves-light btn-primary m-b-5">
                                            Ajustar
                                        </button> -->

                                        <div class="col-xs-12 col-sm-3" align="center"><br>
                                            <button  class="btn btn-icon waves-effect waves-light btn-primary m-b-5" onclick="pagarVarios();"> <strong>Cambiar</strong></button>
							            </div>
                                    </div>
                                </div><br>

			                         <div style="width:100%; height:700px; overflow: auto;">
			                                      <br>

			                             <div class="table-responsive">
			                                 <table class="table table-striped table-bordered table-hover"  width="100%"  border="0" id="tbl-buys">
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
                                                    <th><center><input type="checkbox" id="ch1" ></center></th>

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

                                            $respuesta = controllerReportes::ReporteVentasporDia1($fechai,$fechaf);
                                            //var_dump($respuesta);
                                            foreach($respuesta as $row => $item){

                                                if($item['TipoComprobante'] == "O")
                                                {
                                                    $netoTarjeta=$netoTarjeta+$item['TotalPagar'];
                                                        $totalTarjeta=$totalTarjeta+$item['Total'];
                                                        $propinaTarjeta=$propinaTarjeta+$item['Propina'];
                                                }
                                                else if ($item['TipoComprobante'] == "T")
                                                {
                                                    $netoEfectivo=$netoEfectivo+$item['TotalPagar'];
                                                        $totalEfectivo=$totalEfectivo+$item['Total'];
                                                        $propinaEfectivo=$propinaEfectivo+$item['Propina'];
                                                }
                                                

                                                $neto=$neto+$item['TotalPagar'];
                                                    $total=$total+$item['Total'];
                                                    $propina=$propina+$item['Propina'];
                                                    $Ruta = "#";
                                                    if ($item['TipoComprobante'] == "T") {
                                                    $DtsComprobante = $modelComp->ComprobanteUnico($item['IdPedido']);

                                                    $Ruta = "controllers/Ajax/AjaxImprimirPDF.php?tipo=t&totalA=".$item["Total"];
                                                    $Ruta .= "&propinaA=".$item['Propina'];
                                                    $Ruta .= "&totalpagarA=".$item['TotalPagar'];
                                                    $Ruta .= "&idPedidoA=".$item['IdPedido'];
                                                    $Ruta .= "&nrocomprobanteCA=".$item['NumeroDoc'];
                                                    $Ruta .= "&meseroA=".$item['Nombres'];
                                                    $Ruta .= "&Exentos=-".round($DtsComprobante["Exentos"], 2);

                                                }
                                                if ($item['TipoComprobante'] == "O") {
                                                    $DtsComprobante = $modelComp->ComprobanteUnico($item['IdPedido']);

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
                                                    echo "Credito";
                                                    }


                                                        ?></center></td>
                                                    <td><div align="center"><?php
                                                if($item['TipoComprobante'] == "T")
                                                {echo "Ticket";}
                                                else if($item['TipoComprobante'] == "O")
                                                {echo "Otro";}
                                                else { echo$item['TipoComprobante']; }
                                                    ?></div></td>

                                                    <?php if ($item['TipoComprobante'] == "T") { ?>

                                                        <td><center><a href="ReporteVentasporDiaDetalle?var=<?php echo $item['NumeroDoc']?>&tipo=T" target="_blank" ><?php echo $item['NumeroDoc']?>  </a></center></td>
                                                    
                                                    <?php } elseif ($item['TipoComprobante'] == "O") { ?>
                                                    
                                                        <td><center><a href="ReporteVentasporDiaDetalle?var=<?php echo $item['NumeroDoc']?>&tipo=O"  target="_blank"><?php echo $item['NumeroDoc']?> </a></center></td>
                                                        
                                                    <?php } ?>
                                                    
                                                    <td><center><?php echo $item['Total'] ?></center></td>
                                                    <td><center><?php echo $item['Propina'] ?></center></td>
                                                    <td><center>$ <?php echo $item['TotalPagar'] ?></center></td>
                                                    <td><center><input type="checkbox"  name="tableid[]" value="<?php echo ($item['IdPedido']); ?>"> </center> </td>
                                                </tr>

                                                    <?php }
                                                     ?>
																			<tr>
																													<td colspan="7"><div align="right"><strong><h4>Total Ticket</h4></strong></div></td>
																													<td><div align="center"><strong><h4>$ <?php echo ($totalEfectivo); ?></h4></strong></div></td>
																													<td><div align="center"><strong><h4>$ <?php echo ($propinaEfectivo); ?></h4></strong></div></td>
																													<td><div align="center"><strong><h4>$ <?php echo ($netoEfectivo); ?></h4></strong></div></td>
																		 </tr>
																		 <tr>
																												 <td colspan="7"><div align="right"><strong><h4>Total Otros</h4></strong></div></td>
																												 <td><div align="center"><strong><h4>$ <?php echo ($totalTarjeta); ?></h4></strong></div></td>
																												 <td><div align="center"><strong><h4>$ <?php echo ($propinaTarjeta); ?></h4></strong></div></td>
																												 <td><div align="center"><strong><h4>$ <?php echo ($netoTarjeta); ?></h4></strong></div></td>
																		</tr>
																
																		<!-- <tr>
																												<td colspan="7"><div align="right"><strong><h4>Total Seleccionados</h4></strong></div></td>
																												<td><div align="center"><strong><h4>$ <?php echo ($total); ?></h4></strong></div></td>
																												<td><div align="center"><strong><h4>$ <?php echo ($propina); ?></h4></strong></div></td>
																												<td><div align="center"><strong><h4>$ <?php echo ($neto); ?></h4></strong></div></td>
																	 </tr> -->
																		<tr>
																												<td colspan="7"><div align="right"><strong><h4>Total General</h4></strong></div></td>
																												<td><div align="center"><strong><h4>$ <?php echo ($total); ?></h4></strong></div></td>
																												<td><div align="center"><strong><h4>$ <?php echo ($propina); ?></h4></strong></div></td>
																												<td><div align="center"><strong><h4>$ <?php echo ($neto); ?></h4></strong></div></td>
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

        // let buys = document.getElementById('tbl-buys');
        // let cboxAll = buys.querySelector('thead input[type="checkbox"]');
        // let cboxes = buys.querySelectorAll('tbody input[type="checkbox"]');
        // let totalOutput = document.getElementById('total');
        // let total = 0;

        // [].forEach.call(cboxes, function (cbox) {
        // cbox.addEventListener('change', handleRowSelect);
        // });

        // cboxAll.addEventListener('change', function () {
        // [].forEach.call(cboxes, function (cbox) {
        //     //cbox.checked = cboxAll.checked;
        //     cbox.click();
        // });
        // });

        // function handleRowSelect (e) {
        // let row = e.target.parentNode.parentNode;
        // console.log(row);
        // let price = row.querySelector('td:nth-child(3)').textContent;
        // console.log(price);
        // let cost = Number(price);
        
        // if (e.target.checked) {
        //     total += cost;
        // } else {
        //     total -= cost;
        // }
        
        // total = Number(total.toFixed(2));
        // totalOutput.value = total;

        // console.log(total);
        // }



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

        function cambiarTaO(){

            swal({
				title: "Mover tickets",
				text: "¿Desea hacer los cambios?",
				type: "question",
				confirmButtonColor: "#0C71e0",
				confirmButtonText: "Emitir",
				showCancelButton: true,
				cancelButtonColor: "#d33",
				reverseButtons: true
			}).then(function () {
				
                var fechai = '<?php echo $fechai ?>';
                var fechaf = '<?php echo $fechaf ?>';
				$.ajax({
					url:"controllers/Ajax/AjaxAjustar.php",
					method: "POST",
					data:{fechai: fechai, fechaf: fechaf},
						dataType: 'text',
						success:function(html){
							swal("Realizado exitosamente");
							//openpdf(caja, cor, accion);
						}
				});
			});


        }

    // Evento que se ejecuta al pulsar en un checkbox
	$("input[type=checkbox]").change(function(){
 
        // Cogemos el elemento actual
        var elemento=this;
        var contador=0;

        // Recorremos todos los checkbox para contar los que estan seleccionados
        $("input[type=checkbox]").each(function(){
            if($(this).is(":checked"))
                contador++;
        });

        console.log(contador);

    });



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

        console.log(arr);
		PasarTaO( str ); 
        
	}

	function PasarTaO( IdPedido ) {
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
					url:"controllers/Ajax/AjaxAjustar.php",
				  	method:"POST",
				  	data:{AccionAjax:'TaO', 
						Id: IdPedido },
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