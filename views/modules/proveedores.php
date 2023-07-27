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
function imprimir(){
	var objeto=document.getElementById('imprimeme');  //obtenemos el objeto a imprimir
	var ventana=window.open('','_blank');  //abrimos una ventana vacía nueva
	ventana.document.write(objeto.innerHTML);  //imprimimos el HTML del objeto en la nueva ventana
	ventana.document.close();  //cerramos el documento
	ventana.print();  //imprimimos la ventana
	ventana.close();  //cerramos la ventana
}
function animatedshake(){
  swal({
    title: 'jQuery HTML example',
    html: $('<div>')
      .addClass('some-class')
      .text('jQuery is everywhere.'),
    animation: false,
    customClass: 'animated shake'
  })
}
function animatedbounceIn(){
  swal({
    title: 'jQuery HTML example',
    html: $('<div>')
      .addClass('some-class')
      .text('jQuery is everywhere.'),
    animation: false,
    customClass: 'animated bounceIn'
  })
}
function animatedbounceOutDown(){
  swal({
    title: 'jQuery HTML example',
    html: $('<div>')
      .addClass('some-class')
      .text('jQuery is everywhere.'),
    animation: false,
    customClass: 'animated bounceOutDown'
  })
}
function animatedflash(){
  swal({
    title: 'jQuery HTML example',
    html: $('<div>')
      .addClass('some-class')
      .text('jQuery is everywhere.'),
    animation: false,
    customClass: 'animated flash'
  })
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
             <!-- PRUEBAS DE javascript -->
            <div class="hidden">
             <button onclick="animatedshake();" class="btn btn-success"><i class="fa fa-flask"></i>&nbsp;animatedshake</button>
             &nbsp;
             <button onclick="animatedbounceIn();" class="btn btn-success"><i class="fa fa-flask"></i>&nbsp;animatedbounceIn</button>
             &nbsp;
             <button onclick="animatedbounceOutDown();" class="btn btn-success"><i class="fa fa-flask"></i>&nbsp;animatedbounceOutDown</button>
             &nbsp;
             <button onclick="animatedflash();" class="btn btn-success"><i class="fa fa-flask"></i>&nbsp;animatedflash</button>
            </div>
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
                                          <h3 align="center" class="modal-title" id="myModalLabel">Nuevo proveedor</h3>
                                      </div>
                                      <div class="panel-body">
                                      <div class="row">
                                          <div class="col-md-6">
                                            <input class="form-control" name="duiR" placeholder="DUI" autocomplete="off" required onKeyUp="this.value=this.value.toUpperCase();"><br>
                                          </div>
                                          <div class="col-md-6">
                                            <input class="form-control" name="nitR" placeholder="NIT" autocomplete="off" required onKeyUp="this.value=this.value.toUpperCase();">
                                          </div>
                                          <div class="col-md-12">
                                            <input class="form-control" name="proveedorR" placeholder="Proveedor" autocomplete="off" required onKeyUp="this.value=this.value.toUpperCase();"><br>
                                          </div>
                                          <div class="col-md-12">
                                            <input class="form-control" name="giroR" placeholder="Giro" autocomplete="off" required onKeyUp="this.value=this.value.toUpperCase();"><br>
                                          </div>
                                          <div class="col-md-12">
                                            <input class="form-control" name="direccionR" placeholder="Direccion" autocomplete="off" required onKeyUp="this.value=this.value.toUpperCase();"><br>
                                          </div>
                                          <div class="col-md-6">
                                            <input class="form-control" name="contactoR" placeholder="Contacto" autocomplete="off" required onKeyUp="this.value=this.value.toUpperCase();">
                                          </div>
                                          <div class="col-md-6">
                                            <input class="form-control" name="telefonoR" placeholder="Telefono" autocomplete="off" required onKeyUp="this.value=this.value.toUpperCase();"><br>
                                          </div>
                                          <div class="col-md-6">
                                            <input class="form-control" name="emailR" placeholder="Emal" autocomplete="off" required onKeyUp="this.value=this.value.toUpperCase();">
                                          </div>
                                          <div class="col-md-6">
                                            <div class="input-group">
                                              <span class="input-group-addon">Estado</span>
                                                <select class="form-control" name="estadoR" autocomplete="off" required>
                                                      <option value="A">Activo</option>
                                                      <option value="N">No Activo</option>
                                                </select>
                                              </div>
                                          </div>
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
$registro = new controllerProveedores();
$registro -> registroProveedor();
$registro -> borrarProveedor();
$registro -> actualizarProveedor();

if(isset($_GET["action"])){
if($_GET["action"] == "ok"){
 echo "Registro Exitoso";
}
}
?>

      <div class="box box-primary">
      <div class="box-header">
      <h3 class="box-title">Proveedores</h3></div>
      <div class="box-body">
                            			<table class="table table-bordered datatable table-striped table-hover width="100%"  border="0"">
                            			<thead>
                                  <th class="hidden">ID</th>
                                  <th></th>
                                  <th>DUI</th>
                            			<th>NIT</th>
                            			<th>Proveedor</th>
                                  <th>Contacto</th>
                            			<th>Telefono</th>
                                  <th>Estado</th>
                            			<th>Acciones</th>
                            			</thead>
                                  <tbody>
                                    <?php
                                                   $respuesta = controllerProveedores::vistaProveedores();
                                                    foreach($respuesta as $row => $item){

                                             ?>
                                         <tr class="odd gradeX">
                                             <td class="hidden"><center><?php echo $item['IdProveedor'] ?></center></td>
                                             <td style="width:30px;">
                                              <a  data-toggle="modal" data-target="#ModalVisualizar<?php echo $item['IdProveedor']; ?>"><i class="fa fa-eye"></i>
                                             </td>
                                             <td><center><?php echo $item['DNI_Proveedor'] ?></center></td>
                                             <td><center><?php echo $item['RUC_Proveedor'] ?></center></td>
                                             <td><center><?php echo $item['RazonSocial'] ?></center></td>
                                            <td><center><?php echo $item['contacto'] ?></center></td>
                                             <td><center><?php echo $item['Telefono'] ?></center></td>
                                             <td><center><?php if($item['Estado'] == 'A'){echo '<span class="label label-success">Activo</span>';}
                                             else {echo '<span class="label label-danger">No Activo</span>';} ?></center></td>
                                             <td>

                                              <div class="btn-group">
                                               <button data-toggle="dropdown" class="btn btn-warning btn-sm dropdown-toggle"><i class="fa fa-cog"></i> <span class="caret"></span></button>
                                               <ul class="dropdown-menu">
                                                 <li><a href="#" data-toggle="modal" data-target="#ModalActualizar<?php echo $item['IdProveedor']; ?>"><i class="fa fa-edit"></i>Editar</a></li>
                                                 <li class="divider"></li>
                                                 <li><a href="#" data-toggle="modal" data-target="#ModalEliminar<?php echo $item['IdProveedor']; ?>"><i class="fa fa-times"></i> Eliminar</a></li>
                                               </ul>
                                             </div>

                                             </td>
                                         </tr>
                                         <!--Modal Visualizar  -->
                                         <div class="modal fade" id="ModalVisualizar<?php echo $item['IdProveedor']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                             <form name="contado"  method="post">
                                             <input type="hidden" name="idProveedorE" value="<?php echo $item['IdProveedor']; ?>">
                                             <div class="modal-dialog">
                                                 <div class="modal-content">
                                                                 <div class="modal-header">
                                                                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                     <h3 align="center" class="modal-title" id="myModalLabel">Informacion</h3>
                                                                 </div>
                                                     <div class="panel-body">
                                                       <div class="row">
                                                           <div class="col-md-6">
                                                          <strong>DUI:</strong>     <?php echo $item['DNI_Proveedor']; ?>
                                                           </div>
                                                           <div class="col-md-6">
                                                             <strong>NIT:</strong>   <?php echo $item['RUC_Proveedor']; ?> <br>
                                                           </div>
                                                           <div class="col-md-12">
                                                             <strong>Proveedor:</strong>   <?php echo $item['RazonSocial']; ?> <br>
                                                           </div>
                                                           <div class="col-md-12">
                                                             <strong>Giro:</strong>   <?php echo $item['Rubro']; ?> <br>
                                                           </div>
                                                           <div class="col-md-12">
                                                             <strong>Direccion:</strong>   <?php echo $item['Direccion']; ?> <br>
                                                           </div>
                                                           <div class="col-md-6">
                                                             <strong>contacto:</strong>   <?php echo $item['contacto']; ?>
                                                           </div>
                                                           <div class="col-md-6">
                                                             <strong>Telefono:</strong>   <?php echo $item['Telefono']; ?> <br>
                                                           </div>
                                                           <div class="col-md-6">
                                                             <strong>Email:</strong>   <?php echo $item['Email']; ?>
                                                           </div>
                                                           <div class="col-md-6">
                                                             <strong>Estado:</strong>  <?php if($item['Estado'] == 'A'){echo 'Activo';}
                                                             else {echo 'No activo';} ?> <br>
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

                                         <!--Modal Eliminar  -->
                                         <div class="modal fade" id="ModalEliminar<?php echo $item['IdProveedor']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                             <form name="contado"  method="post">
                                             <input type="hidden" name="idProveedorE" value="<?php echo $item['IdProveedor']; ?>">
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
                                                             una vez Eliminada el proveedor <strong>[ <?php echo $item['RazonSocial']; ?> ]</strong> no podra ser Recuperada.</h4>
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
 <div class="modal fade" id="ModalActualizar<?php echo $item['IdProveedor']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form name="form1" method="post" action="">
        <input type="hidden" name="idA" value="<?php echo $item['IdProveedor']; ?>">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h3 align="center" class="modal-title" id="myModalLabel">Actualizar Categoria</h3>
                    </div>
                    <div class="panel-body">
                    <div class="row">
                      <div class="col-md-6">
                        <input class="form-control" name="duiA" placeholder="DUI" autocomplete="off" required value="<?php echo $item['DNI_Proveedor']; ?>"><br>
                      </div>
                      <div class="col-md-6">
                        <input class="form-control" name="nitA" placeholder="NIT" autocomplete="off" required value="<?php echo $item['RUC_Proveedor']; ?>">
                      </div>
                      <div class="col-md-12">
                        <input class="form-control" name="proveedorA" placeholder="Proveedor" autocomplete="off" required value="<?php echo $item['RazonSocial']; ?>"><br>
                      </div>
                      <div class="col-md-12">
                        <input class="form-control" name="giroA" placeholder="Giro" autocomplete="off" required value="<?php echo $item['Rubro']; ?>"><br>
                      </div>
                      <div class="col-md-12">
                        <input class="form-control" name="direccionA" placeholder="Direccion" autocomplete="off" required value="<?php echo $item['Direccion']; ?>"><br>
                      </div>
                      <div class="col-md-6">
                        <input class="form-control" name="contactoA" placeholder="Contacto" autocomplete="off" required value="<?php echo $item['contacto']; ?>">
                      </div>
                      <div class="col-md-6">
                        <input class="form-control" name="telefonoA" placeholder="Telefono" autocomplete="off" required value="<?php echo $item['Telefono']; ?>"><br>
                      </div>
                      <div class="col-md-6">
                        <input class="form-control" name="emailA" placeholder="Emal" autocomplete="off" required value="<?php echo $item['Email']; ?>">
                      </div>
                      <div class="col-md-6">
                        <div class="input-group">
                          <span class="input-group-addon">Estado</span>
                            <select class="form-control" name="estadoA" autocomplete="off" required>
                                  <option <?php if($item['Estado'] == 'A'){echo 'selected';} ?>  value="A">Activo</option>
                                  <option  <?php if($item['Estado'] == 'N'){echo 'selected';} ?> value="N">No Activo</option>
                            </select>
                          </div>
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
  </script>
