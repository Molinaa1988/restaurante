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
                                          <h3 align="center" class="modal-title" id="myModalLabel">Nuevo cliente</h3>
                                      </div>
                                      <div class="panel-body">
                                      <div class="row">
                                          <div class="col-md-6">
                                            <input class="form-control" name="nrcR" placeholder="NRC" autocomplete="off" required>
                                          </div>
                                          <div class="col-md-6">
                                            <input class="form-control" name="nitR" placeholder="NIT" autocomplete="off" required><br>
                                          </div>
                                          <div class="col-md-12">
                                            <input class="form-control" name="clienteR" placeholder="Cliente" autocomplete="off" required><br>
                                          </div>
                                          <div class="col-md-12">
                                            <input class="form-control" name="direccionR" placeholder="Direccion" autocomplete="off" required><br>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="input-group">
                                              <span class="input-group-addon">Departamento</span>
                                                <select class="form-control" name="departamentoR" autocomplete="off" required>
                                                      <option value="Ahuachapan">Ahuachapán</option>
                                                      <option value="Santa Ana">Santa Ana</option>
                                                      <option value="Sonsonate">Sonsonate</option>
                                                      <option value="Usulutan">Usulutan</option>
                                                      <option value="San Miguel">San Miguel</option>
                                                      <option value="Morazan">Morazán</option>
                                                      <option value="La Union">La Unión</option>
                                                      <option value="La Libertad">La Libertad</option>
                                                      <option value="Chalatenango">Chalatenango</option>
                                                      <option value="Cuscatlan">Cuscatlán</option>
                                                      <option value="San Salvador">San Salvador</option>
                                                      <option value="La Paz">La Paz</option>
                                                      <option value="Cabanas">Cabañas</option>
                                                      <option value="San Vicente">San Vicente</option>
                                                </select>
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                            <input class="form-control" name="municipioR" placeholder="Municipio" autocomplete="off" required><br>
                                          </div>
                                          <div class="col-md-12">
                                            <input class="form-control" name="giroR"  placeholder="Giro"autocomplete="off" required><br>
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
$registro = new controllerCliente();
$registro -> registroCliente();
$registro -> actualizarCliente();
$registro -> borrarCliente();

?>

      <div class="box box-primary">
      <div class="box-header">
      <h3 class="box-title">Clientes con NRC</h3></div>
      <div class="box-body">
                            			<table class="table table-bordered datatable table-striped table-hover width="100%"  border="0"">
                            			<thead>
                                  <th class="hidden">ID</th>
                                  <th></th>

                                  <th>NRC</th>
                                  <th>Cliente</th>
                                  <th>Acciones</th>

                            			</thead>
                                  <tbody>
                                    <?php
                                                   $respuesta = controllerCliente::vistaCliente();
                                                    foreach($respuesta as $row => $item){

                                             ?>
                                         <tr class="odd gradeX">
                                             <td class="hidden"><center><?php echo $item['IdNRC'] ?></center></td>
                                             <td style="width:30px;">
                                              <a  data-toggle="modal" data-target="#ModalVisualizar<?php echo $item['IdNRC']; ?>"><i class="fa fa-eye"></i>
                                             </td>
                                             <td><center><?php echo $item['NRC'] ?></center></td>
                                             <td><center><?php echo $item['Cliente'] ?></center></td>
                                             <td>

                                              <div class="btn-group">
                                               <button data-toggle="dropdown" class="btn btn-warning btn-sm dropdown-toggle"><i class="fa fa-cog"></i> <span class="caret"></span></button>
                                               <ul class="dropdown-menu">
                                                 <li><a href="#" data-toggle="modal" data-target="#ModalActualizar<?php echo $item['IdNRC']; ?>"><i class="fa fa-edit"></i>Editar</a></li>
                                                 <li class="divider"></li>
                                                 <li><a href="#" data-toggle="modal" data-target="#ModalEliminar<?php echo $item['IdNRC']; ?>"><i class="fa fa-times"></i> Eliminar</a></li>
                                               </ul>
                                             </div>

                                             </td>
                                         </tr>
                                         <!--Modal Visualizar  -->
                                         <div class="modal fade" id="ModalVisualizar<?php echo $item['IdNRC']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                             <form name="contado"  method="post">
                                             <input type="hidden" name="idProveedorE" value="<?php echo $item['IdNRC']; ?>">
                                             <div class="modal-dialog">
                                                 <div class="modal-content">
                                                                 <div class="modal-header">
                                                                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                     <h3 align="center" class="modal-title" id="myModalLabel">Informacion</h3>
                                                                 </div>
                                                     <div class="panel-body">
                                                       <div class="row">
                                                           <div class="col-md-6">
                                                          <strong>NRC:</strong>    <?php echo $item['NRC']; ?>
                                                           </div>
                                                           <div class="col-md-6">
                                                             <strong>NIT:</strong>   <?php echo $item['NIT']; ?> <br>
                                                           </div>
                                                           <div class="col-md-12">
                                                             <strong>Cliente:</strong>   <?php echo $item['Cliente']; ?> <br>
                                                           </div>
                                                           <div class="col-md-12">
                                                             <strong>Direccion:</strong>   <?php echo $item['Direccion']; ?> <br>
                                                           </div>
                                                           <div class="col-md-12">
                                                             <strong>Departamento:</strong>   <?php echo $item['Departamento']; ?> <br>
                                                           </div>
                                                           <div class="col-md-6">
                                                             <strong>Municipio:</strong>     <?php echo $item['Municipio']; ?>
                                                           </div>
                                                           <div class="col-md-6">
                                                             <strong>Giro:</strong> <?php echo $item['Giro']; ?>  <br>
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
                                         <div class="modal fade" id="ModalEliminar<?php echo $item['IdNRC']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                             <form name="contado"  method="post">
                                             <input type="hidden" name="IdNRE" value="<?php echo $item['IdNRC']; ?>">
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
                                                             una vez Eliminada la informacion de <strong>[ <?php echo $item['Cliente']; ?> ]</strong> no podra ser Recuperada.</h4>
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
 <div class="modal fade" id="ModalActualizar<?php echo $item['IdNRC']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
               <form name="form1" method="post" action="">
                         <input type="hidden" name="idA" value="<?php echo $item['IdNRC']; ?>">
                   <div class="modal-dialog">
                       <div class="modal-content">
                           <div class="modal-header">
                               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 align="center" class="modal-title" id="myModalLabel">Actualizar cliente</h3>
                           </div>
                           <div class="panel-body">
                           <div class="row">
                               <div class="col-md-6">
                                 <input class="form-control" name="nrcA" placeholder="NRC" autocomplete="off" required value="<?php echo $item['NRC']; ?>">
                               </div>
                               <div class="col-md-6">
                                 <input class="form-control" name="nitA" placeholder="NIT" autocomplete="off" required value="<?php echo $item['NIT']; ?>"><br>
                               </div>
                               <div class="col-md-12">
                                 <input class="form-control" name="clienteA" placeholder="Cliente" autocomplete="off" required value="<?php echo $item['Cliente']; ?>"><br>
                               </div>
                               <div class="col-md-12">
                                 <input class="form-control" name="direccionA" placeholder="Direccion" autocomplete="off" required value="<?php echo $item['Direccion']; ?>"><br>
                               </div>
                               <div class="col-md-6">
                                 <div class="input-group">
                                   <span class="input-group-addon">Departamento</span>
                                     <select class="form-control" name="departamentoA" autocomplete="off" required>
                                           <option <?php if($item['Departamento'] == 'Ahuachapán'){echo 'selected';} ?> value="Ahuachapán">Ahuachapán</option>
                                           <option <?php if($item['Departamento'] == 'Santa Ana'){echo 'selected';} ?> value="Santa Ana">Santa Ana</option>
                                           <option <?php if($item['Departamento'] == 'Sonsonate'){echo 'selected';} ?> value="Sonsonate">Sonsonate</option>
                                           <option <?php if($item['Departamento'] == 'Usulután'){echo 'selected';} ?> value="Usulután">Usulután</option>
                                           <option <?php if($item['Departamento'] == 'San Miguel'){echo 'selected';} ?> value="San Miguel">San Miguel</option>
                                           <option <?php if($item['Departamento'] == 'Morazán'){echo 'selected';} ?> value="Morazán">Morazán</option>
                                           <option <?php if($item['Departamento'] == 'La Unión'){echo 'selected';} ?> value="La Unión">La Unión</option>
                                           <option <?php if($item['Departamento'] == 'La Libertad'){echo 'selected';} ?> value="La Libertad">La Libertad</option>
                                           <option <?php if($item['Departamento'] == 'Chalatenango'){echo 'selected';} ?> value="Chalatenango">Chalatenango</option>
                                           <option <?php if($item['Departamento'] == 'Cuscatlán'){echo 'selected';} ?> value="Cuscatlán">Cuscatlán</option>
                                           <option <?php if($item['Departamento'] == 'San Salvador'){echo 'selected';} ?> value="San Salvador">San Salvador</option>
                                           <option <?php if($item['Departamento'] == 'La Paz'){echo 'selected';} ?> value="La Paz">La Paz</option>
                                           <option <?php if($item['Departamento'] == 'Cabañas'){echo 'selected';} ?> value="Cabañas">Cabañas</option>
                                           <option <?php if($item['Departamento'] == 'San Vicente'){echo 'selected';} ?> value="San Vicente">San Vicente</option>
                                     </select>
                                   </div>
                               </div>
                               <div class="col-md-6">
                                 <input class="form-control" name="municipioA" placeholder="Municipio" autocomplete="off" required value="<?php echo $item['Municipio']; ?>"><br>
                               </div>
                               <div class="col-md-12">
                                 <input class="form-control" name="giroA"  placeholder="Giro" autocomplete="off" required value="<?php echo $item['Giro']; ?>"><br>
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
