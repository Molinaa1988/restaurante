<!-- Reporte para mostrar los ingredientes 27042021 RM -->

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



  <div class="content-wrapper">
    <section class="content">
      <div class="row-fluid">
          <div class="col-md-4" align="center">

          </div>
          <div class="col-md-4" align="center"><br>
              <!-- <a href="ReporteVentasporDia"><i class="btn  btn-primary m-b-5">Regresar</i> </a> -->
          </div>
          <div class="col-md-4" align="center"><br>

          </div>
      </div>

      <div class="col-md-11" align="center"><br>
              <button type="submit" class="btn btn-icon waves-effect waves-light btn-primary m-b-5" data-toggle="modal" data-target="#modalRegistrar"> Agregar ingredientes al plato &nbsp; <i class="fa fa-floppy-o"></i></button>
              </div> <br>
              <div class="col-md-4" align="center"><br>

          </div>

        <div class="row">
       
    <div class="col-md-12">
    
        <?php
        $respuesta;
        $IdItems = $_GET['var'];
        $respuesta = controllerReportes::ReporNomItem($IdItems);
        ?>

        <!-- Advanced Tables -->
        <div class="panel panel-primary">
            <div class="panel-heading">
                Ingredientes para el plato  <?php echo $respuesta['Descripcion']; ?>
            </div>
            <div class="panel-body">

            <div class="panel panel-default">
            <div class="panel-body">



            <div style="width:100%; height:700px; overflow: auto;">
            <div id="imprimeme">
                        <br>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover"  width="100%"  border="0">
                <thead>
                    <tr>

                    <th><center>Ingredientes</center></th>
                    <th><center>Unidad o Medida</center></th>
                    <th><center>Cantidad Usada</center></th>
                    <th><center>Plato</center></th>
                    <th><center>Acciones</center></th> 


                    </tr>
                </thead>
                <tbody>
            <?php
            $total = 0;



        $respuesta;
        $IdItems = $_GET['var'];
        $respuesta = controllerReportes::ReporteIngredientes($IdItems);
        foreach($respuesta as $row => $item){
        //$total=$total+($item['Precio']*$item['Cantidad']);
        ?>

        <tr class="odd gradeX">
        <td><center><?php echo $item['DescripcionIng'] ?></center></td>
        <td><div align="center"><?php echo $item['UnidadMedida'] ?></div></td>
        <td><center><?php echo $item['CantidadU'] ?></center></td>
        <td><center><?php echo $item['Descripcion'] ?></center></td>
        <td><center>
        <a href="#" data-toggle="modal" data-target="#ModalEliminar<?php echo $item['IdRelacion']; ?>" 
        class="btn btn-primary btn-danger"><i class=" fa fa-trash"></i></a> 
				
				</center></td>
        
        </tr>

        <?php } ?>


        
        
        </tbody>
        <!--  -->

        </table>
        
        </div>
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

   


<!--  Modal registrar-->
<div class="modal fade" id="modalRegistrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form name="form1" method="post" action="">
          <input type="hidden" name="tipoitemR" value="2">
          <input type="hidden" name="familiaR" value="1">
          
          <input type="hidden" name="IdItems" value ="<?php echo $IdItems ?>">
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
                            <span class="input-group-addon">Ingredientes</span>
                            <!-- select picker para mostrar todos los ingredientes -->
                            <select class="selectpicker"  name ="IdIngredientes" id="IdIngredientes" required  data-live-search="true">
                                      <?php
                                      $resultado = controllerCategoria::vistaIngredientes();
                                      $contador=0;
                                      foreach ($resultado as $row => $misdatos) {
                                      ?>
                                      <option value="<?php echo $misdatos['IdIngredientes']  ?>"><?php echo $misdatos["DescripcionIng"]; ?></option>
                                      <?php }?>          
                                  </select>
                              
                            </div>
                        </div>
                        <div class="col-md-6">
                            <input class="form-control" name="CantidadU" placeholder="Cantidad necesaria" autocomplete="off" required><br>
                        </div>

                        <br>
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



  <!-- Modal Eliminar-->
   <!--Modal Eliminar  -->
   <div class="modal fade" id="ModalEliminar<?php echo $item['IdRelacion']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <form name="contado"  method="post">
                <input type="hidden" name="idRelacionE" value="<?php echo $item['IdRelacion']; ?>">
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
                                una vez eliminada la informacion de <strong>"<?php echo $item['DescripcionIng']; ?>"</strong> no podrá ser recuperada.</h4>
                            </div>
                        </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-danger">Eliminar</button>

                        </div>
                    </div>
                </div>
                </form>
            </div>

                                                  


              <?php
    $registro = new controllerInventario();
    $registro -> registroIngPorItems($IdIngredientes,$Total);
    $registro -> borrarRelacion();
    if(isset($_GET["action"])){
    if($_GET["action"] == "ok"){
    echo "Registro Exitoso";
    }
    }


?>