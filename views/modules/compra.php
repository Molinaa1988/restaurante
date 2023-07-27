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
	if (!isset($_GET["Fecha"])) {
		$Fecha = date('Y-m-d');
	}else {
		$Fecha = $_GET["Fecha"];
	}
?>


<script>
function imprimir(){
	var objeto=document.getElementById('imprimeme');  //obtenemos el objeto a imprimir
	var ventana=window.open('','_blank');  //abrimos una ventana vacía nueva
	ventana.document.write(objeto.innerHTML);  //imprimimos el HTML del objeto en la nueva ventana
	ventana.document.close();  //cerramos el documento
	ventana.print();  //imprimimos la ventana
	ventana.close();  //cerramos la ventana
}
</script>

  <div class="content-wrapper">
    <section class="content">
      <div class="row">
           <div class="col-md-4" align="center">

           </div>
           <div class="col-md-4" align="center"><br>
              <button type="submit" class="btn btn-icon waves-effect waves-light btn-primary m-b-5" data-toggle="modal" data-target="#modalRegistrar"> Registrar &nbsp; <i class="fa fa-floppy-o"></i></button>
           </div>
           <div class="col-md-4" align="center"><br>
						 <input type="date" class="form-control" id="fechaSel" autocomplete="off" required value="<?php echo $Fecha;?>">
           </div>
       </div>
       <br>
       <!--  Modal registrar-->
                   <div class="modal fade" id="modalRegistrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                          <form name="form1" method="post" action="">

                              <div class="modal-dialog">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                          <h3 align="center" class="modal-title" id="myModalLabel">Nueva compra</h3>
                                      </div>
                                      <div class="panel-body">
                                      <div class="row">
                                          <div class="col-md-4">
                                            <div class="radio">
                                              <label><input type="radio" name="comprobanteR" value="CCF">Credito Fiscal</label>
                                            </div>
                                          </div>
                                          <div class="col-md-4">
                                            <div class="radio">
                                              <label><input type="radio" name="comprobanteR" value="FCF">Consumidor Final</label>
                                            </div>
                                          </div>
                                          <div class="col-md-4">
                                            <div class="radio">
                                              <label><input type="radio" name="comprobanteR" value="CO">Comercial</label>
                                            </div>
                                          </div>
                                          <div class="col-md-12">
                                            <input class="form-control" name="nrocomprobanteR" placeholder="Nro de comprobante" autocomplete="off" required><br>
                                          </div>
                                          <div class="col-md-6">
                                            <input class="form-control" name="duiNitR" id="duiNitR" placeholder="Ingrese DUI o NIT del proveedor" autocomplete="off" required>
                                          </div>
																					<div class="col-md-6">
                                                    <input class="form-control" name="proveedorR" id="proveedorR" placeholder="Proveedor" autocomplete="off" required ><br>
																										<input class="hidden" type="text" name="idProveedorR" id="idProveedorR" placeholder="ID del Proveedor">
																					</div>

                                          <div class="col-md-6">
                                              <div class="input-group">
                                                <span class="input-group-addon">Forma de pago</span>
                                                <select class="form-control" name="formapagoR" autocomplete="off" required>
                                                    <option value="E">Efectivo</option>
                                                    <option value="C">Cheque</option>
                                                    <option value="D">Deposito</option>
																										<option value="T">Tarjeta</option>
                                                    <option value="CR">Credito</option>
                                                  </select>
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <input type="date" class="form-control" name="fechaR" autocomplete="off" required><br>
                                          </div>

                                          <div class="col-md-9">
                                            <input class="form-control" name="descripcionR" placeholder="Descripcion" autocomplete="off" required>
                                          </div>
                                          <center>
                                          <div class="col-md-3">
                                            <input class="form-control" name="costoR" placeholder="Costo" autocomplete="off" required><br>
                                          </div>
                                        </center>
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

                                <?php
$registro = new controllerCompra();
$registro -> registroCompra();
$registro -> actualizarCompra();
$registro -> borrarCompra();
?>

      <div class="box box-primary">
      <div class="box-header">
      <h3 class="box-title">Compras</h3></div>
      <div class="box-body">
                            			<table class="table table-bordered datatable table-striped table-hover width="100%"  border="0"">
                            			<thead>
                                  <th class="hidden">ID</th>
                                  <th>Factura</th>
                                  <th>Comprobante</th>
																  <th>Fecha</th>
                                  <th>Proveedor</th>
																	<th>Descripcion</th>
                                  <th>Pago</th><!--Como pago  -->
                                  <th>Subtotal</th>
																	<th>Iva</th>
																	<th>Total</th>
                            			<th>Acciones</th>
                            			</thead>
                                  <tbody>
                                    <?php
                                                   $respuesta = controllerCompra::vistaCompra($Fecha);
                                                    foreach($respuesta as $row => $item){
																											  $idProveedor = $item['IdProveedor'];
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
																						 <td style="width:60px;">
                                              <div class="btn-group">
                                               <button data-toggle="dropdown" class="btn btn-warning btn-sm dropdown-toggle"><i class="fa fa-cog"></i> <span class="caret"></span></button>
                                               <ul class="dropdown-menu">
                                                 <li><a href="#" data-toggle="modal" data-target="#ModalActualizar<?php echo $item['IdCompra']; ?>"><i class="fa fa-edit"></i>Editar</a></li>
                                                 <li class="divider"></li>
                                                 <li><a href="#" data-toggle="modal" data-target="#ModalEliminar<?php echo $item['IdCompra']; ?>"><i class="fa fa-times"></i> Eliminar</a></li>
                                               </ul>
                                             </div>
                                             </td>
                                         </tr>

                                         <!--Modal Eliminar  -->
                                         <div class="modal fade" id="ModalEliminar<?php echo $item['IdCompra']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                             <form name="contado"  method="post">
                                             <input type="hidden" name="idCompraE" value="<?php echo $item['IdCompra']; ?>">
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
                                                             una vez Eliminada la informacion no podra ser recuperada.</h4>
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
 <div class="modal fade" id="ModalActualizar<?php echo $item['IdCompra']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form name="form1" method="post" action="">
        <input type="hidden" name="idA" value="<?php echo $item['IdCompra']; ?>">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h3 align="center" class="modal-title" id="myModalLabel">Actualizar compra</h3>
                    </div>
                    <div class="panel-body">
											<div class="row">
													<div class="col-md-4">
														<div class="radio">
															<label><input type="radio" name="comprobanteA" value="CCF" <?php if($item['TipoDoc'] =="CCF") echo "checked" ?> >Credito Fiscal</label>
														</div>
													</div>
													<div class="col-md-4">
														<div class="radio">
															<label><input type="radio" name="comprobanteA" value="FCF" <?php if($item['TipoDoc'] =="FCF") echo "checked" ?>>Consumidor Final</label>
														</div>
													</div>
													<div class="col-md-4">
														<div class="radio">
															<label><input type="radio" name="comprobanteA" value="CO" <?php if($item['TipoDoc'] =="CO") echo "checked" ?>>Comercial</label>
														</div>
													</div>
													<div class="col-md-12">
														<input class="form-control" name="nrocomprobanteA" placeholder="Nro de comprobante" autocomplete="off" value="<?php echo $item['NroComprobante'] ?>" required><br>
													</div>
													<div class="col-md-12">
		                        <div class="input-group">
		                          <span class="input-group-addon">Proveedor</span>
		                            <select class="form-control" name="idProveedorA" autocomplete="off" required>
		                              <?php
		                                            $respues = modelProveedores::vistaProveedores();
		                                              foreach($respues as $row => $it){
		                                ?>
		                                    <option  <?php if($item['IdProveedor'] == $it['IdProveedor'] ){echo 'selected';} ?>    value="<?php echo $it['IdProveedor']  ?>"><?php echo $it['RazonSocial']  ?></option>
		                                <?php } ?>
		                            </select>
		                          </div><br>
		                      </div>
													<div class="col-md-6">
															<div class="input-group">
																<span class="input-group-addon">Forma de pago</span>
																<select class="form-control" name="formapagoA" autocomplete="off" required>
																		<option <?php if($item['Serie'] == 'E'){echo 'selected';} ?>  value="E">Efectivo</option>
																		<option <?php if($item['Serie'] == 'C'){echo 'selected';} ?> value="C">Cheque</option>
																		<option <?php if($item['Serie'] == 'D'){echo 'selected';} ?> value="D">Deposito</option>
																		<option <?php if($item['Serie'] == 'CR'){echo 'selected';} ?> value="CR">Credito</option>
																	</select>
														</div>
													</div>
													<div class="col-md-6">
														<input type="date" class="form-control" name="fechaA" autocomplete="off"  value="<?php echo $item['Fecha'] ?>" required><br>
													</div>

													<div class="col-md-9">
														<input class="form-control" name="descripcionA" placeholder="Descripcion" autocomplete="off" required value="<?php echo $item['Descripcion'] ?>">
													</div>
													<center>
													<div class="col-md-3">
														<input class="form-control" name="costoA" placeholder="Costo" autocomplete="off" required  value="<?php echo $item['Total'] ?>"><br>
													</div>
												</center>
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


                                         <?php } ?>

                                    </tbdody>
                            			</table>

                            			</div>
                            		</div>

     </section>
  </div>




  <script type="text/javascript">





    $(document).ready(function(){
      $(".datatable").DataTable({
        "language": {
      "sProcessing":    "Procesando...",
      "sLengthMenu":    "Mostrar _MENU_ registros",
      "sZeroRecords":   "No se encontraron resultados",
      "sEmptyTable":    "Ningún dato disponible en esta tabla",
      "sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
      "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix":   "",
      "sSearch":        "Buscar:",
      "sUrl":           "",
      "sInfoThousands":  ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
          "sFirst":    "Primero",
          "sLast":    "Último",
          "sNext":    "Siguiente",
          "sPrevious": "Anterior"
      },
      "oAria": {
          "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
          "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }
  }
      });
    });

    // $(document).ready(function(){
    //     $('#duiNitR').change(function(){
    //         alert("The text has been changed.");
    //     });
    // });


//  // Busca proveedores para registrar compra
    $(document).ready(function() {
      $("#duiNitR").keyup(function(){
        var duiNitR = $(this).val();
        $.ajax({
          url:"controllers/Ajax.php",
          method:"POST",
          data:{duiNitAjax:duiNitR},
          dataType:"text",
          success:function(html)
          {
            $("#proveedorR").html(html);
          }
        });
      });
    });




		$('#proveedorR').keydown(function() {
  //code to not allow any changes to be made to input field
  return false;
});
	$("#fechaSel").change(function() {
		var Fecha = $("#fechaSel").val();
		window.location = 'compra?Fecha='+Fecha;
	});


  </script>
