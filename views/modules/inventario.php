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
              <button type="submit" class="btn btn-icon waves-effect waves-light btn-primary m-b-5" data-toggle="modal" data-target="#modalRegistrar"> Registrar Platos &nbsp; <i class="fa fa-floppy-o"></i></button>
              <a href="ingredientes" class="btn btn-icon waves-effect waves-light btn-primary m-b-5" role ="button"> Ver Ingredientes &nbsp; <i class="fa fa-eye"></i></a>
           </div>
           <div class="col-md-4" align="center"><br>

           </div>
       </div>
       <br>


       <!--  Modal registrar-->
                   <div class="modal fade" id="modalRegistrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                          <form name="form1" method="post" action="">
                            <input type="hidden" name="tipoitemR" value="2">
                            <input type="hidden" name="familiaR" value="1">
                              <div class="modal-dialog">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                          <h3 align="center" class="modal-title" id="myModalLabel">Nuevo producto</h3>
                                      </div>
                                      <div class="panel-body">

                                      <div class="row">
                                          <div class="col-md-6">
                                            <div class="input-group">
                                              <span class="input-group-addon">Categoria</span>
                                                <select class="form-control" name="idcategoriaR" autocomplete="off" required>
                                                  <?php
                                                                $c= controllerCategoria::vistaCategoria();
                                                                  foreach($c as $row => $cd){
                                                           ?>
                                                      <option value="<?php echo $cd['IdCategoria']  ?>"><?php echo $cd['Nombre']  ?></option>

                                                    <?php } ?>
                                                </select>
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <input class="form-control" name="descripcionR" placeholder="Descripcion" autocomplete="off" required><br>
                                          </div>
                                          <div class="col-md-6">
                                            <input class="form-control" name="stockR" placeholder="Stock" autocomplete="off" required><br>
                                          </div>
                                          <div class="col-md-6">
                                            <input class="form-control" name="precioR" placeholder="Precio" autocomplete="off" required>
                                          </div><br>
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


      


      <div class="box box-primary">
      <div class="box-header">
      <h3 class="box-title">Inventario</h3></div>
      <div class="box-body">
      
      <table class="table table-bordered datatable table-striped table-hover width="100%"  border="0"">
      <thead>
      <th class="hidden">ID</th>
      <th>Categoria</th>
      <th>Descripcion</th>
      <th>Precio</th>
      <th>Stock</th>
      <th>Acciones</th>
      </thead>
      <tbody>
      <?php
                    $respuesta = controllerInventario::vistaInventario();
                    foreach($respuesta as $row => $item){
                      $idCategoria = $item['IdCategoria'] ? $item['IdCategoria'] : '';
              ?>
          <tr class="odd gradeX">
              <td class="hidden"><center><?php echo $item['IdItems'] ?></center></td>
              <td><center>
                <?php
                              $respuest = controllerInventario::vistaCategoria($idCategoria);
                              print_r ($respuest['Nombre']);
                        ?>
               
              </center></td>

              <!-- href para cargar los ingredintes de cada plato -->
              
              <td><center><a href="ReporteIngredientes?var=<?php echo $item['IdItems'] ?>"> <?php echo $item['Descripcion']?> </a></center></td>
              
              <td><center><?php echo $item['PrecioVenta'] ?></center></td>
              <td><center><?php echo $item['Stock'] ?></center></td>
              <td>

              <div class="btn-group">
                <button data-toggle="dropdown" class="btn btn-warning btn-sm dropdown-toggle"><i class="fa fa-cog"></i> <span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <li><a href="#" data-toggle="modal" data-target="#ModalActualizar<?php echo $item['IdItems']; ?>"><i class="fa fa-edit"></i>Editar</a></li>
                  <li class="divider"></li>
                  <li><a href="#" data-toggle="modal" data-target="#ModalEliminar<?php echo $item['IdItems']; ?>"><i class="fa fa-times"></i> Eliminar</a></li>
                </ul>
              </div>

              </td>
          </tr>




            <!--Modal Eliminar  -->
            <div class="modal fade" id="ModalEliminar<?php echo $item['IdItems']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <form name="contado"  method="post">
                <input type="hidden" name="idPersonalE" value="<?php echo $item['IdItems']; ?>">
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
                                una vez Eliminada la informacion de <strong>[ <?php echo $item['Descripcion']; ?> ]</strong> no podra ser Recuperada.</h4>
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
         <div class="modal fade" id="ModalActualizar<?php echo $item['IdItems']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form name="form1" method="post" action="">
        <input type="hidden" name="idA" value="<?php echo $item['IdItems']; ?>">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h3 align="center" class="modal-title" id="myModalLabel">Actualizar Categoria</h3>
                    </div>
                    <div class="panel-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="input-group">
                          <span class="input-group-addon">Categoria</span>
                            <select class="form-control" name="idcategoriaA" autocomplete="off" required>
                              <?php
                                            $respues = controllerCategoria::vistaCategoria();
                                              foreach($respues as $row => $it){
                                ?>

                                    <option  <?php if($item['IdCategoria'] == $it['IdCategoria'] ){echo 'selected';} ?>    value="<?php echo $it['IdCategoria']  ?>"><?php echo $it['Nombre']  ?></option>
                                <?php } ?>
                            </select>
                          </div>
                      </div>
                      <div class="col-md-6">
                        <input class="form-control" name="descripcionA" placeholder="descripcionA" autocomplete="off" required value="<?php echo $item['Descripcion']; ?>"><br>
                      </div>
                      <div class="col-md-6">
                        <input class="form-control" name="precioA" placeholder="precioA" autocomplete="off" required value="<?php echo $item['PrecioVenta']; ?>">
                      </div>
                      <div class="col-md-6">
                        <input class="form-control" name="stockA" placeholder="stockA" autocomplete="off" required value="<?php echo $item['Stock']; ?>"><br>
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

  <?php 
         $registro = new controllerInventario();
         $registro -> registroInventario();
         $registro -> borrarInventario();
         $registro -> actualizarInventario();
         
         
         if(isset($_GET["action"])){
         if($_GET["action"] == "ok"){
         echo "Registro Exitoso";
         }
         }
         ?>




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
