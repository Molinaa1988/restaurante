<?php
          require_once "../../models/modelConfiguraciones.php";

          if(isset($_FILES["imagen"]["name"])){
// Esta es la ruta donde se guardara el archivo y con que nombre en este caso logo.jpeg
                 $ruta = "../../views/dist/img/logo/logo.jpeg";
// Aqui asignamos a la variable la imagen la que enviamos por medio de post y el ajax
                 $imagen = imagecreatefromjpeg($_FILES["imagen"]["tmp_name"]);
// Con esta funcion recortamos la imagen
                 // $imagenArreglada = imagecrop($imagen, ["x"=>0, "y"=>0, "width"=>600, "height"=>300]);
// Con esta funcion mandarmos la imagen y a donde queremos que se guarde
                 imagejpeg($imagen, $ruta);

                 $respuesta =	modelConfiguraciones::subirLogo('logo');
                 echo json_encode($respuesta);
               }





    ?>
