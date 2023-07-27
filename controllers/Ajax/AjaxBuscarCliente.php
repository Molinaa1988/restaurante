        <?php
          require_once "../../models/modelRealizarVenta.php";
          // Busca proveedores para registrar compra

          $datosController = $_POST["nrcAjax"];
          $respuesta = modelRealizarVenta::BuscarCliente($datosController);
          echo json_encode($respuesta);

        ?>
