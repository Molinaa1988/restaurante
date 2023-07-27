        <?php
        require_once "../../views/src/fpdf/fpdf.php";
        require_once "../../models/modelSalon.php";
        require_once "../../models/modelConfiguraciones.php";

        if(isset($_POST["idPedidoC"])){
            $cantidadComida = 0;
           	$respuesta = modelSalon::idDetallePedido($_POST["idPedidoC"]);
                     foreach($respuesta as $row => $item){
                       if($item['Estado'] == 'M')
                         {
                           $cantidadComida++;
                         }
                       }
            echo json_encode($cantidadComida);
          }

        if(isset($_POST["idPedidoB"])){
            $cantidadBebida = 0;
            $respuesta = modelSalon::idDetallePedido($_POST["idPedidoB"]);
                     foreach($respuesta as $row => $item){
                       if($item['Estado'] == 'B')
                       {
                           $cantidadBebida++;
                       }
                      }
            echo json_encode($cantidadBebida);
          }

        ?>
