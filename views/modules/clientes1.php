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
                                <div class="col-md-12">
                                <input class="form-control" name="nombreR" placeholder="Nombre" autocomplete="off" required><br>
                                </div>
                                <div class="col-md-12">
                                <input class="form-control" name="direccionR" placeholder="Direccion" autocomplete="off"><br>
                                </div>
                                <div class="col-md-12">
                                <input class="form-control" name="celularR" placeholder="Celular" autocomplete="off"><br>
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
$registro -> registroClientes1();
$registro -> actualizarClientes1();
$registro -> borrarClientes1();

?>

      <div class="box box-primary">
      <div class="box-header">
      <h3 class="box-title">Clientes</h3></div>
      <div class="box-body">
                            			<table class="table table-bordered datatable table-striped table-hover width="100%"  border="0"">
                            			<thead>
                                  <th class="hidden">ID</th>
                                  <th></th>

                                  <th>Nombre</th>
                                  <th>Direccion</th>
                                  <th>Celular</th>
                                  <th>Acciones</th>

                            			</thead>
                                  <tbody>
                                    <?php
                                                   $respuesta = controllerCliente::vistaClientes1();
                                                    foreach($respuesta as $row => $item){

                                             ?>
                                         <tr class="odd gradeX">
                                             <td class="hidden"><center><?php echo $item['IdCliente'] ?></center></td>
                                             <td style="width:30px;">
                                              <a  data-toggle="modal" data-target="#ModalVisualizar<?php echo $item['IdCliente']; ?>"><i class="fa fa-eye"></i>
                                             </td>
                                             <td><center><?php echo $item['Nombre'] ?></center></td>
                                             <td><center><?php echo $item['Direccion'] ?></center></td>
                                             <td><center><?php echo $item['Celular'] ?></center></td>
                                             <td>

                                              <div class="btn-group">
                                               <button data-toggle="dropdown" class="btn btn-warning btn-sm dropdown-toggle"><i class="fa fa-cog"></i> <span class="caret"></span></button>
                                               <ul class="dropdown-menu">
                                                 <li><a href="#" data-toggle="modal" data-target="#ModalActualizar<?php echo $item['IdCliente']; ?>"><i class="fa fa-edit"></i>Editar</a></li>
                                                 <li class="divider"></li>
                                                 <li><a href="#" data-toggle="modal" data-target="#ModalEliminar<?php echo $item['IdCliente']; ?>"><i class="fa fa-times"></i> Eliminar</a></li>
                                               </ul>
                                             </div>

                                             </td>
                                         </tr>
                                         <!--Modal Visualizar  -->
                                         <div class="modal fade" id="ModalVisualizar<?php echo $item['IdCliente']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                             <form name="contado"  method="post">
                                             <input type="hidden" name="idProveedorE" value="<?php echo $item['IdCliente']; ?>">
                                             <div class="modal-dialog">
                                                 <div class="modal-content">
                                                                 <div class="modal-header">
                                                                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                     <h3 align="center" class="modal-title" id="myModalLabel">Informacion</h3>
                                                                 </div>
                                                     <div class="panel-body">
                                                       <div class="row">
                                                           <div class="col-md-12">
                                                             <strong>Cliente:</strong>   <?php echo $item['Nombre']; ?> <br>
                                                           </div>
                                                           <div class="col-md-12">
                                                             <strong>Direccion:</strong>   <?php echo $item['Direccion']; ?> <br>
                                                           </div>
                                                           <div class="col-md-6">
                                                             <strong>Celular:</strong> <?php echo $item['Celular']; ?>  <br>
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
                                         <div class="modal fade" id="ModalEliminar<?php echo $item['IdCliente']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                             <form name="contado"  method="post">
                                             <input type="hidden" name="idE" value="<?php echo $item['IdCliente']; ?>">
                                             <div class="modal-dialog">
                                                 <div class="modal-content">
                                                                 <div class="modal-header">
                                                                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                     <h3 align="center" class="modal-title" id="myModalLabel">Precaucion</h3>
                                                                 </div>
                                                     <div class="panel-body">
                                                     <div class="row" align="center">


                                                         <div class="alert alert-danger">
                                                             <h4>¿Está seguro de Realizar esta acción?<br>
                                                             Una vez eliminada la informacion de <strong> <?php echo $item['Nombre']; ?>, </strong> no podrá ser recuperada.</h4>
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
 <div class="modal fade" id="ModalActualizar<?php echo $item['IdCliente']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
               <form name="form1" method="post" action="">
                         <input type="hidden" name="idA" value="<?php echo $item['IdCliente']; ?>">
                   <div class="modal-dialog">
                       <div class="modal-content">
                           <div class="modal-header">
                               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 align="center" class="modal-title" id="myModalLabel">Actualizar cliente</h3>
                           </div>
                           <div class="panel-body">
                           <div class="row">
                               <div class="col-md-12">
                                 <input class="form-control" name="nombreA" placeholder="Nombre" autocomplete="off" required value="<?php echo $item['Nombre']; ?>"><br>
                               </div>
                               <div class="col-md-12">
                                 <input class="form-control" name="direccionA" placeholder="Direccion" autocomplete="off"  value="<?php echo $item['Direccion']; ?>"><br>
                               </div>
                               <div class="col-md-12">
                                 <input class="form-control" name="celularA"  placeholder="Celular" autocomplete="off"  value="<?php echo $item['Celular']; ?>"><br>
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
