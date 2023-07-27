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

$NotificacionesSinVer = 0;
   $respuesta = controllerSucesos::vistaSucesosSinVer();
    foreach($respuesta as $row => $item){
      $Notificaciones = $Notificaciones + 1;
        }
        if($Notificaciones > 0)
        {
          controllerSucesos::actualizarSucesosVistos();
        }
?>

  <div class="content-wrapper">
    <section class="content">

      <div class="box box-primary">
      <div class="box-header">
      <h3 class="box-title">Sucesos</h3></div>
      <div class="box-body">
                                  <table class="table table-bordered datatable table-striped table-hover width="100%"  border="0"">
                                  <thead>
                                  <th class="hidden">ID</th>
                                  <th>Fecha/Hora</th>
                                  <th>Descripcion</th>
                                  <th>Realizo</th>
                                  <th>Autorizo</th>

                                  </thead>
                                  <tbody>
                                    <?php
                                                   $respuesta = controllerSucesos::vistaSucesos();
                                                    foreach($respuesta as $row => $item){

                                             ?>
                                         <tr class="odd gradeX">
                                             <td class="hidden"><center><?php echo $item['idsucesos'] ?></center></td>
                                             <td><center><?php echo $item['fecha'] ?></center></td>
                                             <td><center><?php echo $item['suceso'] ?></center></td>
                                             <td><center><?php $mesero = controllerSalon::Mesero($item['IdPersonal']); $meseroFinal = $mesero["Nombres"]; echo $meseroFinal; ?></center></td>
                                             <td><center><?php $usuario = controllerSalon::Usuario($item['IdUsuario']); $usuarioFinal = $usuario["Usuario"]; echo $usuarioFinal; ?></center></td>

                                         </tr>

                                         <?php } ?>

                                    </tbdody>
                                  </table>

                                  </div>
                                </div>

     </section>
   </div>

 </div>
</body>

  <script>

	$(document).ready(function() {

	} );


  </script>
