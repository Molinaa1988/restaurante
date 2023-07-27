<?php

  require_once "../models/modelCompra.php";
  require_once "../models/modelRealizarVenta.php";
  // Busca proveedores para registrar compra
  if (isset($_POST['duiNitAjax']))
  {
  $datosController = $_POST["duiNitAjax"];
  $respuesta = modelCompra::encontrarProveedor($datosController);


 ?>
          <script>
           $("#proveedorR").val("<?php
           echo($respuesta["RazonSocial"]);
           ?>");
           $("#idProveedorR").val("<?php
           echo($respuesta["IdProveedor"]);
           ?>");
          </script>

<?php
}
?>


                                      
