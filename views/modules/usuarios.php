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
      $Usuario = new controllerUsuario();
      $Cargos = $Usuario -> Cargos();
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
          <div class="col-md-4" align="center"></div>
          <div class="col-md-4" align="center"><br>
            <button type="submit" class="btn btn-icon waves-effect waves-light btn-primary m-b-5" data-toggle="modal" data-target="#modalRegistrar"> Registrar &nbsp; <i class="fa fa-floppy-o"></i></button>
          </div>
           <div class="col-md-4" align="center"><br></div>
        </div>
        <br>
        <!--  Modal registrar-->
        <div class="modal fade" id="modalRegistrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <form name="form1" method="post" action="">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h3 align="center" class="modal-title" id="myModalLabel">Nuevo usuario</h3>
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="input-group">
                        <span class="input-group-addon">Cargo</span>
                        <select class="form-control" name="puestoR" autocomplete="off" required>
                          <?php 
                            foreach ($Cargos as $key => $cargo) {
                          ?>
                            <option value="<?php echo $cargo[0]  ?>"><?php echo $cargo[1]  ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-6">
                      <input class="form-control" name="usuarioR" placeholder="Usuario" autocomplete="off" required>
                    </div>
                    <div class="col-md-6">
                      <input type="password" class="form-control" name="claveR" placeholder="Clave" autocomplete="off" required><br>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="input-group">
                        <span class="input-group-addon">Personal</span>
                        <select class="form-control" name="IdPersonalR" autocomplete="off" required>
                          <?php
                            $respuesta = controllerPersonal::vistaPersonal();
                            foreach($respuesta as $row => $item){
                          ?>
                            <option value="<?php echo $item['IdPersonal'] ?>"><?php echo $item['Nombres'] ?></option>
                          <?php } ?>
                        </select>
                      </div>
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
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
              </div>
            </div>
          </form>
        </div>
        <?php
          $registro = new controllerUsuario();
          $registro -> registroUsuario();
          $registro -> actualizarUsuario();
          $registro -> borrarUsuario();

          if(isset($_GET["action"])){
            if($_GET["action"] == "ok"){
              echo "Registro Exitoso";
            }
          }
        ?>

        <div class="box box-primary">
          <div class="box-header"><h3 class="box-title">Usuarios del sistema</h3></div>
          <div class="box-body">
            <table class="table table-bordered datatable table-striped table-hover width="100%"  border="0"">
              <thead>
                <th class="hidden">ID</th>
                <th>Cargo</th>
                <th>Usuario</th>
                <th>Personal</th>
                <th>Estado</th>
                <th>Acciones</th>
              </thead>
              <tbody>
                <?php
                  $respuesta = controllerUsuario::vistaUsuarios();
                  foreach($respuesta as $row => $item){
                ?>
                <tr class="odd gradeX">
                  <td class="hidden"><center><?php echo $item['IdUsuario'] ?></center></td>
                  <td><center><?php echo $Cargos[$item['Puesto'] - 1][1]; ?></center></td>
                  <td><center><?php echo $item['Usuario'] ?></center></td>
							    <td>
                    <center>
                      <?php $mesero = controllerSalon::Mesero($item['IdPersonal']); $meseroFinal = $mesero["Nombres"]; echo $meseroFinal; ?>
                    </center>
                  </td>
                  <td>
                    <center>
                      <?php 
                        if($item['estado'] == 'A'){
                          echo '<span class="label label-success">Activo</span>';
                        } else {
                          echo '<span class="label label-danger">No Activo</span>';
                        }
                      ?>
                    </center>
                  </td>
                  <td>
                    <div class="btn-group">
                      <button data-toggle="dropdown" class="btn btn-warning btn-sm dropdown-toggle"><i class="fa fa-cog"></i> <span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <li>
                          <a href="#" data-toggle="modal" data-target="#ModalActualizar<?php echo $item['IdUsuario']; ?>">
                            <i class="fa fa-edit"></i>Editar
                          </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                          <a href="#" data-toggle="modal" data-target="#ModalEliminar<?php echo $item['IdUsuario']; ?>">
                            <i class="fa fa-times"></i> Eliminar
                          </a>
                        </li>
                      </ul>
                    </div>
                  </td>
                </tr>


                <!--Modal Eliminar  -->
                <div class="modal fade" id="ModalEliminar<?php echo $item['IdUsuario']; ?>"
                  tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                  aria-hidden="true">
                  <form name="contado" method="post">
                    <input type="hidden" name="IdUsuarioE"
                      value="<?php echo $item['IdUsuario']; ?>">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                          <h3 align="center" class="modal-title" id="myModalLabel">Precaucion
                          </h3>
                        </div>
                        <div class="panel-body">
                          <div class="row" align="center">


                            <div class="alert alert-danger">
                              <h4>¿Esta Seguro de Realizar esta Acción?<br>
                                una vez Eliminada el usuario <strong>[
                                  <?php echo $item['Usuario']; ?> ]</strong> no podra ser
                                Recuperada.</h4>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default"
                            data-dismiss="modal">Cancelar</button>
                          <button type="submit" class="btn btn-primary">Eliminar</button>

                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <!--  Modals actualizar-->
                <div class="modal fade" id="ModalActualizar<?php echo $item['IdUsuario']; ?>"
                  tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                  aria-hidden="true">
                  <form name="form1" method="post" action="">
                    <input type="hidden" name="idA" value="<?php echo $item['IdUsuario']; ?>">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                          <h3 align="center" class="modal-title" id="myModalLabel">Actualizar
                            Categoria</h3>
                        </div>
                        <div class="panel-body">
                          <div class="row">
                            <div class="col-md-12">
                              <div class="input-group">
                                <span class="input-group-addon">Estado</span>
                                <select class="form-control" name="idCargoA" autocomplete="off"
                                  required>
                                  <?php 
                                        foreach ($Cargos as $keyC => $cargo) {
                                  ?>
                                    <option value="<?php echo $cargo[0]  ?>" <?php if ($item['Puesto'] == $cargo[0]) { echo 'selected'; } ?>><?php echo $cargo[1]  ?></option>
                                  <?php } ?>
                                </select>
                              </div><br>
                            </div>
                            <div class="col-md-6">
                              <input class="form-control" name="usuarioA" placeholder="Usuario"
                                autocomplete="off" required
                                value="<?php echo $item['Usuario']; ?>">
                            </div>
                            <div class="col-md-6">
                              <input type="password" class="form-control"
                                value="<?php echo $item['Clave']; ?>" name="claveA"
                                placeholder="Clave" autocomplete="off"><br>
                            </div>
                            <div class="col-md-6">
                              <div class="input-group">
                                <span class="input-group-addon">Personal</span>
                                <select class="form-control" name="IdPersonalA"
                                  autocomplete="off" required>
                                  <?php
                                    $respuestaPersonal = controllerPersonal::vistaPersonal();
                                    foreach($respuestaPersonal as $row => $itemPersonal){
                                  ?>
                                  <option
                                    <?php if($item['IdPersonal'] == $itemPersonal['IdPersonal']){echo 'selected';} ?>
                                    value="<?php echo $itemPersonal['IdPersonal'] ?>">
                                    <?php echo $itemPersonal['Nombres'] ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="input-group">
                                <span class="input-group-addon">Estado</span>
                                <select class="form-control" name="estadoA" autocomplete="off"
                                  required>
                                  <option <?php if($item['estado'] == 'A'){echo 'selected';} ?>
                                    value="A">Activo</option>
                                  <option <?php if($item['estado'] == 'N'){echo 'selected';} ?>
                                    value="N">No Activo</option>
                                </select>
                              </div>
                            </div>
                            <br>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default"
                              data-dismiss="modal">Cerrar</button>
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
  </div>
</body>




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
