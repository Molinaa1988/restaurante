<?php
session_start();
if(!$_SESSION["validar"]){
	header("location:ingreso");
	exit();
}

?>

<body class="hold-transition skin-blue sidebar-collapse sidebar-mini">
<div class="wrapper">
<?php
include "views/modules/cabezote.php";
include "views/modules/botonera.php";

?>

  <div class="content-wrapper">
    <section class="content">

      <div class="row">
            <div class="col-md-12">
               <div class="box box-primary">
                         <div class="box-header"><h3 class="box-title">Pedidos mal registrados</h3></div>
                       <div class="box-body">
                         <table id="TablaPedidos" class="table table-bordered compact table-striped table-hover border="0" ">
                           <thead>
                             <th style="width:20px;">IdPedido</th>
                             <th style="width:10px;">Fecha</th>
                             <th style="width:10px;">Total</th>
                             <th style="width:75px;">Estado</th>
                             <th style="width:5px;">Corregir</th>


                           </thead>
                           <tbody id="bodyTablaPedidos">
                             <?php
                                            $respuesta = controllerExtras::pedidosErrores();
                                             foreach($respuesta as $row => $item){
                                      ?>
                                      <tr class="odd gradeX">
                                      <td><center><?php echo $item['IdPedido'] ?></center></td>
                                      <td><center><?php echo date('Y-m-d', strtotime($item['FechaPedido'] ))?></center></td>
                                      <td><center><?php echo $item["Total"]; ?></center></td>
                                      <td><center><?php echo $item['Estado'] ?></center></td>
                                      <td><center>
                                        <button id="corregir<?php echo $item['IdPedido'] ?>" class="btn btn-success"><i class="fa fa-check"></i></button>
                                      </center>
                                      </td>
                                      </tr>
                                      <script>

      																$( "#corregir<?php echo $item['IdPedido'] ?>" ).click(function( event ) {
      																 var idPedido = <?php echo $item['IdPedido'] ?>;
      																		swal({
      																		title: 'Corregir',
      																		text: "Proceder a corregir el error",
      																		type: 'warning',
      																		showCancelButton: true,
      																		confirmButtonColor: '#3085d6',
      																		cancelButtonColor: '#d33',
      																		confirmButtonText: 'Corregir',
      																		cancelButtonText: 'Cancelar'
      																		}).then((result) => {

      																				$.ajax({
      																					url:"controllers/Ajax/AjaxExtras.php",
      																					method:"POST",
      																					data:{idPedidoCorregir:idPedido},
      																					dataType:"text",
      																					success:function(html)
      																					{
      																							location=location;
      																					}
      																				});
      																			})
      																			});

                                      </script>



                                    <?php } ?>

                            </tbody>

                         </table>
                       </div>
                     </div>
                   </div>


<!--MESAS ACTUALIZAR ESTADO  -->

<div class="col-lg-12">
  <div class="box box-default">
    <div class="box-header"><h3 class="box-title">Mesas</h3></div>
    <div class="box-body">


     <div class="row">
          <div class="col-md-4">

            <table class="table table-bordered datatable table-striped table-hover width="100%"  border="0"">
            <thead>
            <th>Mesa</th>
            <th>Zona</th>
            <th>Estado</th>
            <th>Actualizar</th>

            </thead>
            <tbody>
              <?php
              $apertura = new controllerExtras();
    					$apertura -> cambiarEstadoMesa();


                             $respuesta = controllerConfiguraciones::vistaMesas1();
                              foreach($respuesta as $row => $item){

                       ?>
                   <tr class="odd gradeX">
                       <td><center><?php echo $item['NroMesa'] ?></center></td>
                      <?php  $nombreZona = controllerConfiguraciones::nombreZona($item['idzona']); ?>
                       <td><center><?php echo $nombreZona['zona'] ?></center></td>
                       <td><center><?php if($item['Estado'] == 'L')
                                  {echo '<span class="label label-success">Libre</span>';}
                                   else if ($item['Estado'] == 'O')
                                   {echo '<span class="label label-primary">Ocupada</span>';}
                                   else if ($item['Estado'] == 'P')
                                   {echo '<span class="label label-default">Por salir</span>';}
                                   else {echo "ninguno";} ?>
                      </center></td>
                       <td>
                           <center><button data-toggle="modal" data-target="#ModalActualizarMesa1<?php echo $item['NroMesa']; ?>" class="btn btn-success"><i class="fa fa-pencil"></i></button></center>
                         </i></a>
                       </td>
                   </tr>
                   <!--  Modals actualizar-->
<div class="modal fade" id="ModalActualizarMesa1<?php echo $item['NroMesa']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form name="form1" method="post" action="">
   <input type="hidden" name="NroMesaA" value="<?php echo $item['NroMesa']; ?>">
<div class="modal-dialog">
 <div class="modal-content">
     <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h3 align="center" class="modal-title" id="myModalLabel">Actualizar estado mesa # <?php echo $item['NroMesa']; ?></h3>
     </div>
     <div class="panel-body">
     <div class="row">
         <div class="col-md-12">
           <div class="input-group">
             <span class="input-group-addon">Estado</span>
               <select class="form-control" name="EstadoA" autocomplete="off" required>
                          <option <?php if($item['Estado'] == "L" ){echo 'selected';} ?> value="L">Libre</option>
                          <option <?php if($item['Estado'] == "O" ){echo 'selected';} ?> value="O">Ocupada</option>
                          <option <?php if($item['Estado'] == "P" ){echo 'selected';} ?> value="P">Por Salir</option>
               </select>
             </div>
         </div>

     </div>
     <div class="modal-footer">
         <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
         <button type="submit" class="btn btn-primary">Actualizar</button>
     </div>
 </div>
</div>
</div>
</form>
</div>


                   <?php } ?>

              </tbdody>
            </table>
          </div>
          <div class="col-md-4">

            <table class="table table-bordered datatable table-striped table-hover width="100%"  border="0"">
            <thead>
            <th>Mesa</th>
            <th>Zona</th>
            <th>Estado</th>
            <th>Acciones</th>

            </thead>
            <tbody>
              <?php
                             $respuesta = controllerConfiguraciones::vistaMesas2();
                              foreach($respuesta as $row => $item){

                       ?>
                       <tr class="odd gradeX">
                           <td><center><?php echo $item['NroMesa'] ?></center></td>
                          <?php  $nombreZona = controllerConfiguraciones::nombreZona($item['idzona']); ?>
                           <td><center><?php echo $nombreZona['zona'] ?></center></td>
                           <td><center><?php if($item['Estado'] == 'L')
                                      {echo '<span class="label label-success">Libre</span>';}
                                       else if ($item['Estado'] == 'O')
                                       {echo '<span class="label label-primary">Ocupada</span>';}
                                       else if ($item['Estado'] == 'P')
                                       {echo '<span class="label label-default">Por salir</span>';}
                                       else {echo "ninguno";} ?>
                          </center></td>
                           <td>
                               <center><button data-toggle="modal" data-target="#ModalActualizarMesa1<?php echo $item['NroMesa']; ?>" class="btn btn-success"><i class="fa fa-pencil"></i></button></center>
                             </i></a>
                           </td>
                       </tr>
                       <!--  Modals actualizar-->
        <div class="modal fade" id="ModalActualizarMesa1<?php echo $item['NroMesa']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form name="form1" method="post" action="">
        <input type="hidden" name="NroMesaA" value="<?php echo $item['NroMesa']; ?>">
        <div class="modal-dialog">
        <div class="modal-content">
         <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 align="center" class="modal-title" id="myModalLabel">Actualizar estado mesa # <?php echo $item['NroMesa']; ?></h3>
         </div>
         <div class="panel-body">
         <div class="row">
             <div class="col-md-12">
               <div class="input-group">
                 <span class="input-group-addon">Estado</span>
                   <select class="form-control" name="EstadoA" autocomplete="off" required>
                              <option <?php if($item['Estado'] == "L" ){echo 'selected';} ?> value="L">Libre</option>
                              <option <?php if($item['Estado'] == "O" ){echo 'selected';} ?> value="O">Ocupada</option>
                              <option <?php if($item['Estado'] == "P" ){echo 'selected';} ?> value="P">Por Salir</option>
                   </select>
                 </div>
             </div>

         </div>
         <div class="modal-footer">
             <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
             <button type="submit" class="btn btn-primary">Actualizar</button>
         </div>
        </div>
        </div>
        </div>
        </form>
        </div>


                   <?php } ?>

              </tbdody>
            </table>
          </div>
          <div class="col-md-4">

            <table class="table table-bordered datatable table-striped table-hover width="100%"  border="0"">
            <thead>
            <th>Mesa</th>
            <th>Zona</th>
            <th>Estado</th>
            <th>Acciones</th>

            </thead>
            <tbody>
              <?php
                             $respuesta = controllerConfiguraciones::vistaMesas3();
                              foreach($respuesta as $row => $item){

                       ?>
                       <tr class="odd gradeX">
                           <td><center><?php echo $item['NroMesa'] ?></center></td>
                          <?php  $nombreZona = controllerConfiguraciones::nombreZona($item['idzona']); ?>
                           <td><center><?php echo $nombreZona['zona'] ?></center></td>
                           <td><center><?php if($item['Estado'] == 'L')
                                      {echo '<span class="label label-success">Libre</span>';}
                                       else if ($item['Estado'] == 'O')
                                       {echo '<span class="label label-primary">Ocupada</span>';}
                                       else if ($item['Estado'] == 'P')
                                       {echo '<span class="label label-default">Por salir</span>';}
                                       else {echo "ninguno";} ?>
                          </center></td>
                           <td>
                               <center><button data-toggle="modal" data-target="#ModalActualizarMesa1<?php echo $item['NroMesa']; ?>" class="btn btn-success"><i class="fa fa-pencil"></i></button></center>
                             </i></a>
                           </td>
                       </tr>
                       <!--  Modals actualizar-->
    <div class="modal fade" id="ModalActualizarMesa1<?php echo $item['NroMesa']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form name="form1" method="post" action="">
       <input type="hidden" name="NroMesaA" value="<?php echo $item['NroMesa']; ?>">
    <div class="modal-dialog">
     <div class="modal-content">
         <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h3 align="center" class="modal-title" id="myModalLabel">Actualizar estado mesa # <?php echo $item['NroMesa']; ?></h3>
         </div>
         <div class="panel-body">
         <div class="row">
             <div class="col-md-12">
               <div class="input-group">
                 <span class="input-group-addon">Estado</span>
                   <select class="form-control" name="EstadoA" autocomplete="off" required>
                              <option <?php if($item['Estado'] == "L" ){echo 'selected';} ?> value="L">Libre</option>
                              <option <?php if($item['Estado'] == "O" ){echo 'selected';} ?> value="O">Ocupada</option>
                              <option <?php if($item['Estado'] == "P" ){echo 'selected';} ?> value="P">Por Salir</option>
                   </select>
                 </div>
             </div>

         </div>
         <div class="modal-footer">
             <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
             <button type="submit" class="btn btn-primary">Actualizar</button>
         </div>
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
    </div>
  </div>
  </div>
  <!--MESAS ACTUALIZAR ESTADO  -->

                 </div>


     </section>
   </div>

 </div>
</body>

  <script>

	$(document).ready(function() {

	} );


  </script>
