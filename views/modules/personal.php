<?php
  session_start();
  if(!$_SESSION["validar"]){
    header("location:ingreso");
    exit();
  }

  $Usuario = new controllerUsuario();
  $Cargos = $Usuario -> Cargos();
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
                  <button type="button" class="close" data-dismiss="modal"
                    aria-hidden="true">&times;
                  </button>
                  <h3 align="center" class="modal-title" id="myModalLabel">Nuevo Empleado</h3>
              </div>
                
              <div class="panel-body">
                <div class="row">
                  
                  <div class="col-md-6">
                    <div class="input-group">
                            <span class="input-group-addon">Cargo</span>
                            <select class="form-control" name="idCargoR" autocomplete="off" required>
                              <?php 
                                foreach ($Cargos as $key => $cargo) {
                              ?>
                                <option value="<?php echo $cargo[1]  ?>"><?php echo $cargo[1]  ?></option>
                                <?php } ?>
                            </select>
                    </div>
                    <br>
                  </div>
                    
                    <div class="col-md-6">
                      <input class="form-control" name="duiR" placeholder="DUI" autocomplete="off" required>
                    </div>
                    
                    <div class="col-md-12">
                      <input class="form-control" name="apellidosR" placeholder="Apellidos" autocomplete="off" required><br>
                    </div>
                    
                    <div class="col-md-12">
                      <input class="form-control" name="nombresR" placeholder="Nombres" autocomplete="off" required><br>
                    </div>
                    
                    <div class="col-md-12">
                      <input type="date" class="form-control" name="fechaNacimientoR" autocomplete="off" required><br>
                    </div>

                    <div class="col-md-6">
                      <div class="input-group">
                        <span class="input-group-addon">Sexo</span>
                        <select class="form-control" name="sexoR" autocomplete="off" required>
                          <option value="M">Masculino</option>
                          <option value="F">Femenino</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="input-group">
                        <span class="input-group-addon">Estado civil</span>
                        <select class="form-control" name="estadoCivilR" autocomplete="off" required>
                          <option value="S">Soltero</option>
                          <option value="C">Casado</option>
                        </select>
                      </div>
                      <br>
                    </div>
                    
                    <div class="col-md-12">
                      <input class="form-control" name="direccionR" placeholder="Direccion" autocomplete="off" required><br>
                    </div>

                    <div class="col-md-6">
                      <input class="form-control" name="telefonoR" placeholder="Telefono" autocomplete="off" required>
                    </div>

                    <div class="col-md-6">
                      <div class="input-group">
                        <span class="input-group-addon">Estado</span>
                        <select class="form-control" name="estadoR" autocomplete="off" required>
                          <option value="1">Activo</option>
                          <option value="0">Inactivo</option>
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
          $registro = new controllerPersonal();
          $registro -> registroPersonal();
          $registro -> actualizarPersonal();
          $registro -> borrarPersonal();

          if(isset($_GET["action"])){
            if($_GET["action"] == "ok"){
              echo "Registro Exitoso";
            }
          }
        ?>

        <div class="box box-primary">
          <div class="box-header">
            <h3 class="box-title">Personal</h3></div>
            <div class="box-body">
              <table class="table table-bordered datatable table-striped table-hover" width="100%">
                <thead>
                <th class="hidden">ID</th>
                  <th></th>
                  <th>Cargo</th>
                  <th>Nombre</th>
                  <th>Telefono</th>
                  <th>Estado</th>
                  <th>Acciones</th>
                </thead>
                <tbody>
                  <?php
                    $respuesta = controllerPersonal::vistaPersonal();
                    foreach($respuesta as $row => $item){
                  ?>
                    <tr class="odd gradeX">
                      <td class="hidden">
                        <center><?php echo $item['IdPersonal'] ?></center>
                      </td>
                      <td style="width:30px;">
                        <a data-toggle="modal" data-target="#ModalVisualizar<?php echo $item['IdPersonal']; ?>">
                          <i class="fa fa-eye"></i>
                        </a>
                      </td>
                      <td>
                        <center> <?php echo $Cargos[$item['IdCargo'] - 1][1]; ?></center>
                      </td>
                      <td>
                        <center><?php echo $item['Nombres'] ?></center>
                      </td>
                      <td>
                        <center><?php echo $item['Telefono'] ?></center>
                      </td>
                      <td>
                        <center><?php if($item['Estado'] == '1'){echo '<span class="label label-success">Activo</span>';}
                        else {echo '<span class="label label-danger">Inactivo</span>';} ?>
                        </center>
                      </td>
                      <td>

                        <div class="btn-group">
                          <button data-toggle="dropdown"
                            class="btn btn-warning btn-sm dropdown-toggle"><i
                              class="fa fa-cog"></i> <span class="caret"></span></button>
                          <ul class="dropdown-menu">
                            <li><a href="#" data-toggle="modal"
                                data-target="#ModalActualizar<?php echo $item['IdPersonal']; ?>"><i
                                  class="fa fa-edit"></i>Editar</a></li>
                            <li class="divider"></li>
                            <li><a href="#" data-toggle="modal"
                                data-target="#ModalEliminar<?php echo $item['IdPersonal']; ?>"><i
                                  class="fa fa-times"></i> Eliminar</a></li>
                          </ul>
                        </div>

                      </td>
                    </tr>
                    
                    <!--Modal Visualizar  -->
                    <div class="modal fade" id="ModalVisualizar<?php echo $item['IdPersonal']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <form name="contado" method="post">
                        <input type="hidden" name="idProveedorE"
                          value="<?php echo $item['IdPersonal']; ?>">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal"
                                aria-hidden="true">&times;</button>
                              <h3 align="center" class="modal-title" id="myModalLabel">Informacion
                              </h3>
                            </div>
                            <div class="panel-body">
                              <div class="row">
                                <div class="col-md-6">
                                  <strong>Cargo:</strong>
                                  <?php echo $Cargos[$item['IdCargo'] - 1][1]; ?>
                                </div>
                                <div class="col-md-6">
                                  <strong>DUI:</strong> <?php echo $item['DUI']; ?> <br>
                                </div>
                                <div class="col-md-12">
                                  <strong>Apellidos:</strong> <?php echo $item['Apellidos']; ?>
                                  <br>
                                </div>
                                <div class="col-md-12">
                                  <strong>Nombres:</strong> <?php echo $item['Nombres']; ?> <br>
                                </div>
                                <div class="col-md-12">
                                  <strong>Fecha de nacimiento:</strong>
                                  <?php echo $item['FechaNacimiento']; ?> <br>
                                </div>
                                <div class="col-md-6">
                                  <strong>Sexo:</strong>
                                  <?php 
                                    if($item['Sexo'] == 'M'){
                                      echo 'Masculino';
                                    } else {
                                      echo 'Femenino';
                                    }
                                  ?>
                                </div>
                                <div class="col-md-6">
                                  <strong>Estado civil:</strong>
                                  <?php
                                    if($item['EstadoCivil'] == 'S') {
                                      echo 'Soltero';
                                    } else {
                                      echo 'Casado';
                                    }
                                  ?><br>
                                </div>
                                <div class="col-md-12">
                                  <strong>Direccion:</strong> <?php echo $item['Direccion']; ?><br>
                                </div>
                                <div class="col-md-6">
                                  <strong>Telefono:</strong> <?php echo $item['Telefono']; ?>
                                </div>
                                <div class="col-md-6">
                                  <strong>Estado:</strong> <?php if($item['Estado'] == '1'){echo 'Activo';}
                                        else {echo 'No activo';} ?> <br>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default"
                                data-dismiss="modal">Cerrar</button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>

                    <!--Modal Eliminar  -->
                    <div class="modal fade" id="ModalEliminar<?php echo $item['IdPersonal']; ?>"
                      tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                      aria-hidden="true">
                      <form name="contado" method="post">
                        <input type="hidden" name="idPersonalE"
                          value="<?php echo $item['IdPersonal']; ?>">
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
                                    una vez Eliminada la informacion de <strong>[
                                      <?php echo $item['Nombres']; ?> ]</strong> no podra ser
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
                    <div class="modal fade" id="ModalActualizar<?php echo $item['IdPersonal']; ?>" tabindex="-1" role="dialog"
                      aria-labelledby="myModalLabel" aria-hidden="true">
                      <form name="form1" method="post" action="">
                        <input type="hidden" name="idA" value="<?php echo $item['IdPersonal']; ?>">
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
                                    <span class="input-group-addon">Estado</span>
                                    <select class="form-control" name="idCargoA" autocomplete="off" required>
                                      <?php 
                                        foreach ($Cargos as $keyC => $cargo) {
                                      ?>
                                        <option value="<?php echo $cargo[0]  ?>" <?php if ($item['IdCargo'] == $cargo[0]) { echo 'selected'; } ?>><?php echo $cargo[1]  ?></option>
                                      <?php } ?>
                                    </select>
                                  </div><br>
                                </div>
                                <div class="col-md-6">
                                  <input class="form-control" name="duiA" placeholder="NIT" autocomplete="off" required
                                    value="<?php echo $item['DUI']; ?>">
                                </div>
                                <div class="col-md-12">
                                  <input class="form-control" name="apellidosA" placeholder="Proveedor" autocomplete="off" required
                                    value="<?php echo $item['Apellidos']; ?>"><br>
                                </div>
                                <div class="col-md-12">
                                  <input class="form-control" name="nombresA" placeholder="Giro" autocomplete="off" required
                                    value="<?php echo $item['Nombres']; ?>"><br>
                                </div>
                                <div class="col-md-12">
                                  <input type="date" class="form-control" name="fechaNacimientoA" placeholder="Direccion"
                                    autocomplete="off" required value="<?php echo $item['FechaNacimiento']; ?>"><br>
                                </div>
                                <div class="col-md-6">
                                  <div class="input-group">
                                    <span class="input-group-addon">Sexo</span>
                                    <select class="form-control" name="sexoA" autocomplete="off" required>
                                      <option <?php if($item['Sexo'] == 'M'){echo 'selected';} ?> value="M">Masculino</option>
                                      <option <?php if($item['Sexo'] == 'F'){echo 'selected';} ?> value="F">Femenino</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="input-group">
                                    <span class="input-group-addon">Estado civil</span>
                                    <select class="form-control" name="estadoCivilA" autocomplete="off" required>
                                      <option <?php if($item['EstadoCivil'] == 'S'){echo 'selected';} ?> value="S">Soltero</option>
                                      <option <?php if($item['EstadoCivil'] == 'C'){echo 'selected';} ?> value="C">Casado</option>
                                    </select>
                                  </div><br>
                                </div>
                                <div class="col-md-12">
                                  <input class="form-control" name="direccionA" placeholder="Emal" autocomplete="off" required
                                    value="<?php echo $item['Direccion']; ?>"><br>
                                </div>
                                <div class="col-md-6">
                                  <input class="form-control" name="telefonoA" placeholder="Emal" autocomplete="off" required
                                    value="<?php echo $item['Telefono']; ?>">
                                </div>
                                <div class="col-md-6">
                                  <div class="input-group">
                                    <span class="input-group-addon">Estado</span>
                                    <select class="form-control" name="estadoA" autocomplete="off" required>
                                      <option <?php if($item['Estado'] == '1'){echo 'selected';} ?> value="1">Activo</option>
                                      <option <?php if($item['Estado'] == '0'){echo 'selected';} ?> value="0">No Activo</option>
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
        </div>
      </section>  
    </div>
  </div>
</body>

<script type="text/javascript">
  $(document).ready(function () {
    $(".datatable").DataTable({
      "language": {
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ningún dato disponible en esta tabla",
        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix": "",
        "sSearch": "Buscar:",
        "sUrl": "",
        "sInfoThousands": ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
          "sFirst": "Primero",
          "sLast": "Último",
          "sNext": "Siguiente",
          "sPrevious": "Anterior"
        },
        "oAria": {
          "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
          "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
      }
    });
  });
</script>
