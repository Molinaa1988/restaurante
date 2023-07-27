<?php
          require_once "../../models/modelRealizarVenta.php";
          // Busca proveedores para registrar compra

          $datosController = $_POST["nrcAjax"];
          $respuesta = modelRealizarVenta::BuscarClientes1($datosController);
          echo json_encode($respuesta);

        ?>
