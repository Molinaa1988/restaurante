<?php

session_start();
if(!$_SESSION["validar"]){
	header("location:ingreso");
	exit();
}
?>
<!--
<script type="text/javascript" src="views/plugins/jQuery/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="views/plugins/bootstrap/css/bootstrap.min.css"/>
-->
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
           <div class="col-md-12" align="center">
                <button type="submit" class="btn btn-icon waves-effect waves-light btn-primary m-b-5" data-toggle="modal" data-target="#modalRegistrarI"> Registrar Ingredientes &nbsp; <i class="fa fa-floppy-o"></i></button>
              
                </div>
           <div class="col-md-4" align="center"><br>

           </div>
       </div>
       <br>



<!-- 
    
    pa ver los ingredientes

    -->


    <div class="box box-primary">
      <div class="box-header">
      <h3 class="box-title">Inventario</h3></div>
      <div class="box-body">
      
      <table class="table table-bordered datatable table-striped table-hover width="100%"  border="0"">
      <thead>
      <th class="hidden">ID</th>
      <th>Descripcion</th>
        <th>Unidad</th>
        <th>Cantidad</th>
        <th>Estado</th>
        <th>Acciones</th>
        </thead>
        
        <tbody>
        
          <?php
                $respuesta = controllerInventario::vistaIngredientes();
                foreach($respuesta as $row => $item){
                  
          ?>
        
          <tr class="odd gradeX">

              
          <td class="hidden"><center><?php echo $item['IdIngredientes'] ?></center></td>
              
              <td contenteditable="true" data-old_value="<?php echo $item['DescripcionIng'] ?>" 
              align='center' onBlur="saveInlineEdit(this,'DescripcionIng','<?php echo $item['IdIngredientes'] ?>')"
              onClick="highlightEdit(this);"><?php echo $item['DescripcionIng'] ?> </td>
              
              <td contenteditable="true" data-old_value="<?php echo $item['UnidadMedida'] ?>" 
              align='center' onBlur="saveInlineEdit(this,'UnidadMedida','<?php echo $item['IdIngredientes'] ?>')"
              onClick="highlightEdit(this);"> <?php echo $item['UnidadMedida'] ?> </td>
              
              <td contenteditable="true" data-old_value="<?php echo $item['Cantidad'] ?>" 
              align='center' onBlur="saveInlineEdit(this,'Cantidad','<?php echo $item['IdIngredientes'] ?>')"
              onClick="highlightEdit(this);"><?php echo $item['Cantidad'] ?> </td>
              
              <td>
                <div class="btn-group">
                  <button data-toggle="dropdown" class="btn btn-warning btn-sm dropdown-toggle"><i class="fa fa-cog"></i> <span class="caret"></span></button>
                  <ul class="dropdown-menu">
                    <li><a href="#" data-toggle="modal" data-target="#ModalActualizarIng<?php echo $item['IdIngredientes']; ?>"><i class="fa fa-edit"></i>Editar</a></li>
                    <li class="divider"></li>
                    <li><a href="#" data-toggle="modal" data-target="#ModalEliminarIng<?php echo $item['IdIngredientes']; ?>"><i class="fa fa-times"></i> Eliminar</a></li>
                  </ul>
                </div>
              </td>
              
              <td>
                <center>
                      <?php 
                        if($item['Estado'] == 1){
                          echo '<span class="label label-success">Activo</span>';
                        } else {
                          echo '<span class="label label-danger">No Activo</span>';
                        }
                      ?>
                    </center>
              </td>
          </tr>

<!--  Modals actualizar pa los ingredientes-->


  <div class="modal fade" id="ModalActualizarIng<?php echo $item['IdIngredientes']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <form name="form1" method="post" action="">
          
          <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h3 align="center" class="modal-title" id="myModalLabel">Actualizar Ingrediente</h3>
                      </div>
                      
                      <div class="panel-body">
                      <div class="row">
                      
                      <input type="hidden" name="idIA" value="<?php echo $item['IdIngredientes']; ?>"> 
                        
                        <div class="col-md-6">
                            <input class="form-control" name="descripcionIA" placeholder="Descripcion" autocomplete="off" required value="<?php echo $item['DescripcionIng']; ?>"><br>
                        </div>
                        
                        <div class="col-md-6">
                          <input class="form-control" name="cantidadIA" placeholder="Cantidad" autocomplete="off" required value="<?php echo $item['Cantidad']; ?>"><br>
                        </div>

                        <div class="col-md-6">
                          <input class="form-control" name="unidadIA" placeholder="Unidad o medida" autocomplete="off" required value="<?php echo $item['UnidadMedida']; ?>">
                        </div> </break><br>

                      

                        
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



         <!--Modal Eliminar los ingredientess  -->
         <div class="modal fade" id="ModalEliminarIng<?php echo $item['IdIngredientes']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <form name="form3"  method="post">
                <input type="hidden" name="idIngE" value="<?php echo $item['IdIngredientes']; ?>">
                <div class="modal-dialog">
                    <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h3 align="center" class="modal-title" id="myModalLabel">Precaucion</h3>
                                    </div>
                        <div class="panel-body">
                        <div class="row" align="center">


                            <div class="alert alert-danger">
                                <h4>¿Está seguro de realizar esta acción?<br>
                                una vez eliminada la informacion de <strong> <?php echo $item['DescripcionIng']; ?>, </strong> no podrá ser recuperada.</h4>
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
     

          <?php } ?>

                                    </tbdody>
                            			</table>

                            			</div>
                            		</div>

     </section>
  </div>


<!-- Modal para registrar ingredientes 270421 RM-->


<div class="modal fade" id="modalRegistrarI" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form name="form1" method="post" action="">
    <input type="hidden" name="tipoitemR" value="2">
    <input type="hidden" name="familiaR" value="1">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h3 align="center" class="modal-title" id="myModalLabel">Nuevo ingrediente</h3>
              </div>
              <div class="panel-body">

              <div class="row">
                  <div class="col-md-6">
                      <input class="form-control" name="descripcionI" placeholder="Descripcion" autocomplete="off" required><br>
                  </div>
                  <div class="col-md-6">
                    <input class="form-control" name="unidadI" placeholder="Unidad de medida" autocomplete="off" required><br>
                  </div>
                  <div class="col-md-6">
                    <input class="form-control" name="cantidadI" placeholder="Cantidad" autocomplete="off" required>
                  </div>
                  <div class="col-md-6">
                  <center>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button> 
                  <button type="submit" class="btn btn-primary">Guardar</button>
                  </center>
                  </div>
                  <br>
                </div>

     
            <?php
      
      ?>
  
  
  
  
  
           
  




      <?php 
           $registro = new controllerInventario();
           $registro -> registroIngrediente();
           $registro -> borrarIngrediente();
           $registro -> actualizarIngredientes();
  
           
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



    //funciuones para hacer el inline editing
    /*function highlightEdit(editableObj) {
      $(editableObj).css("background", "#FFF");
    }*/

    /*function saveInlineEdit(editableObj,column,IdIngredientes) {
      // no change change made then return false
      if($(editableObj).attr('data-old_value') === editableObj.innerHTML)
      
      return false;
      // send ajax to update value
      //$(editableObj).css("background","#FFF  right");
      
      $.ajax({
        url: "controllers/Ajax/saveInlineEdit.php",
        type: "POST",
        dataType: "json",
        data:'column='+column+'&value='+editableObj.innerHTML+'&IdIngredientes='+IdIngredientes,
      success: function(response) {
        
      console.log(IdIngredientes);
      // set updated value as old value
        //$(editableObj).attr('data-old_value',editableObj.innerHTML);
        //$(editableObj).css("background","#FDFDFD");
      },
      error: function () {

      }
      });
     
    }*/

  </script>

