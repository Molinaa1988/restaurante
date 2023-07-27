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

			<?php
					if(isset($_POST['fechai'])){
							$fechai=$_POST['fechai'];
					}else{
							$fechai=date('Y-m-d');
					}
			 ?>
			                     <div class="row">
			                 <div class="col-md-12">
			                     <!-- Advanced Tables -->
			                     <div class="panel panel-primary">
			                         <div class="panel-heading">
			                             Reporte de platos y bebidas vendidas
			                         </div>
			                         <div class="panel-body">

			                          <div class="panel panel-default">
			                         <div class="panel-body">

                                        <?php

                                if(!empty($_GET['fecha']) )
                                {
                                        $fecha=($_GET['fecha']);
                                }
                                else
                                {
                                        $fecha=date('Y-m-d');
                                        
                                }
                                    ?>



    <form name="gor" action="" method="get" class="form-inline">
        <div class="row-fluid">
                    <div class="col-xs-6 col-sm-3" align="center">
                        <strong>Fecha</strong><br>
                        <input type="date" class="form-control" name="fecha" autocomplete="off" required value="<?php echo $fecha; ?>">
                </div>
                <div class="col-xs-6 col-sm-3" align="center"><br>
                    <button type="submit" class="btn btn-icon waves-effect waves-light btn-primary m-b-5"><strong>Consultar</strong></button>
                </div>

                <!-- boton para descontar ingredientes     

                <div class="col-xs-6 col sm-3" align="center"><br>
                    <button type="button" class="btn btn-icon waves-effect waves-light btn-primary m-b-5"
                     data-toggle="modal" data-target="#modalDesI"> Ver ingredientes usados &nbsp; 
                     <i class="fa fa-cutlery"></i></button>
                </div>                                 -->      
                
                <div class="col-xs-6 col-sm-3" align="center"><br>
                        <!-- <button onclick="imprimir();" class="btn btn-success"><i class=" fa fa-print "></i> Imprimir</button> -->
                </div>
        </div>
    </form>

<div style="width:100%; height:700px; overflow: auto;">
<div id="imprimeme">
        <br>
        <div class="hidden">
        <table  width="100%" style="border: 1px solid #660000; -moz-border-radius: 
        13px;-webkit-border-radius: 12px; border-radius: 12px; padding: 10px;">
        
        </table><br>
        <hr/>
            <div style="font-size: 14px;"align="center">
                <strong>Reporte de items mas vendidos</strong><br>
            </div>
            <hr/>
        </div>



<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover"  width="100%"  border="0">

				<thead>
                    <tr>
                        <th><center>Cantidad</center></th>
                        <th><center>Descripcion</center></th>
                        <th><center>Precio Venta</center></th>
                        <th><center>Total</center></th>


                    </tr>
                </thead>
                <tbody>
            <?php
                            $neto=0;

                $respuesta =  controllerReportes::ReporteItemsPorDia($fecha);
                  foreach($respuesta as $row => $item){
                                $neto=$neto+$item['Total'];
                        ?>
                    <tr class="odd gradeX">
                    <td><center><?php echo $item['Cantidad'] ?></center></td>
                        <td><center><?php echo utf8_encode($item['Descripcion']) ?></center></td>
                        <td><div align="center"><?php echo $item['PrecioVenta'] ?></div></td>
                        <td align="center">$ <?php echo $item['Total'] ?></td>
                    </tr>
                    <?php } ?>

              </tbody>

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

<!-- Modal para ver ingredientes usados 270421 RM-->


<div class="modal fade" id="modalDesI" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form name="form1" method="post" action="">
    <input type="hidden" name="tipoitemR" value="2">
    <input type="hidden" name="familiaR" value="1">
    <input class="form-control" name="desR" placeholder="Des" value="rrr" autocomplete="off" type="hidden" required>
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h3 align="center" class="modal-title" id="myModalLabel">Ingredientes usados</h3>
              </div>
            
            
           

              
<!--- PARA MOSTRAR LA TABLA CON LOS INGREDIENTES-->

    
    <div class="modal-body">
        <table class="table table-bordered datatable table-striped table-hover width="100%"  border="0"">
        <thead>
        <th class="hidden">ID</th>
        <th><center>Ingrediente</center></th>
        <th><center>Unidad o medida</center></th>
        <th><center>Cantidad por plato</center></th>
        <th><center>Total usado</center></th>
        </thead>
        <tbody>
          <?php

                $ids = array();
                $totales = array(); 
                $idsP = array();
                $respuesta = controllerInventario::vistaIngredientesUsados($fecha);
                foreach($respuesta as $row => $item){
                  
          ?>
        
          <tr class="odd gradeX">
              <!-- <td class="hidden"><center><?php echo $item['IdIngredientes'] ?></center></td> -->
              
              <td><center><?php echo $item['DescripcionIng'] ?></center></td>
              <td><center><?php echo $item['UnidadMedida'] ?></center></td>
              <td><center><?php echo $item['CantidadU'] ?></center></td>
              <td><center><?php echo $item['Total'] ?></center></td>
              <td>

              </td>

              
          </tr>
        <?php 
        $ids[$row]=$item['IdIngredientes']; 
        $totales[$row]=$item['Total'];
        $idsP[$row]=$item['IdPedido'];
        } 
        ?>        
            
        
        </tbody>
        </table>
   
    </div>
       
        <div class ="modal-footer">
            <div class="col-md-12">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button> 
            <button type="submit" class="btn btn-primary">Descontar del stock</button>
            </div>                
        </div>

          </div>
          </div>
          </form>
          </div>

         <?php
       
       $registro = new controllerInventario();
       $registro -> descontarIngredientes($ids, $totales);
       $registro -> actualizarItemsDescontados($idsP);
      
       if(isset($_GET["action"])){
       if($_GET["action"] == "ok"){
       echo "Registro Exitoso";
       }
       }

        
        ?>
                
    