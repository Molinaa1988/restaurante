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

?>

  <div class="content-wrapper">
    <section class="content">


            <div class="row">
              <div class="col-lg-12">
                <div class="box box-primary">
                  <div class="box-header"><center><h3 class="box-title">Informacion del negocio</h3></center></div>
                  <div class="box-body">

      							<?php
      $registro = new controllerConfiguraciones();
      $registro -> actualizarInformacionTicket();

      		$respuestaTicket= controllerConfiguraciones::informacionTicket();
      		$Restaurante = $respuestaTicket["Restaurante"];
          $Contribuyente = $respuestaTicket["Contribuyente"];
          $NroDeRegistro= $respuestaTicket["NroDeRegistro"];
          $NIT = $respuestaTicket["NIT"];
          $Giro = $respuestaTicket["Giro"];
          $Direccion = $respuestaTicket["Direccion"];
          $Resolucion = $respuestaTicket["Resolucion"];
          $Mensaje= $respuestaTicket["Mensaje"];
					$Mensaje2= $respuestaTicket["Mensaje2"];
					$logo= $respuestaTicket["logo"];

      ?>

      		            <div class="row">
                        <div class="col-lg-3">
                          <div class="box box-default">
                            <div class="box-header"><h3 class="box-title">Configuracion de ticket</h3></div>
                            <div class="box-body">
      												<form method="post">
                              <label>  Nombre de negocio </label>
                              <input class="form-control" name="nombreNegocio"  autocomplete="off" value="<?php echo $Restaurante ?>"><br>
                              <label>  Nombre de contribuyente </label>
                              <input class="form-control" name="nombreContribuyente" autocomplete="off" value="<?php echo $Contribuyente ?>"><br>
                              <label>  Nro de registro </label>
                              <input class="form-control" name="nroRegistro" autocomplete="off" value="<?php echo $NroDeRegistro ?>"><br>
                              <label>  NIT </label>
                              <input class="form-control" name="nit" autocomplete="off" value="<?php echo $NIT ?>"><br>
                              <label>  Giro </label>
                              <input class="form-control" name="giro" autocomplete="off" value="<?php echo $Giro ?>"><br>
                              <label>  Direccion </label>
                              <input class="form-control" name="direccion" autocomplete="off" value="<?php echo $Direccion ?>"><br>
                              <label>  Resolucion de hacienda </label>
                              <input class="form-control" name="resolucion" autocomplete="off" value="<?php echo $Resolucion ?>"><br>
                              <label>  Mensaje de ticket 1 </label>
                              <input class="form-control" name="mensaje" autocomplete="off" value="<?php echo $Mensaje ?>"><br>
															<label>  Mensaje de ticket 2 </label>
															<input class="form-control" name="mensaje2" autocomplete="off" value="<?php echo $Mensaje2 ?>"><br>
      												   <center><button type="submit" class="btn btn-primary">Actualizar</button></center>
      												</form>
                            </div>
                            </div>
                          </div>
                          <div class="col-lg-9">
                            <div class="box box-default">
                              <!-- <div class="box-header"><h3 class="box-title">Informe por correo</h3></div> -->
                              <div class="box-body">
                            <div class="row">
                              	<div class="col-lg-4">
                                	<label>  	Logo </label>

																	<img src='views/dist/img/logo/<?php echo $logo ?>.jpeg' id='blah' class="img-responsive" alt="Responsive image"  width="256" height="256">

																	<input type='file' name="fileToUpload" class="form-control-file" id="logo" />
																	<center><button type="submit" name="submit" onclick="subirLogo();" class="btn btn-primary">Subir</button></center>
                              	</div>

<!--
																<div class="col-lg-6">
																	<label>  	Logo </label>
																	<img src='views/dist/img/logo/logo.jpeg' id='blah' class="img-responsive" alt="Responsive image"  width="256" height="256">
																	<input type='file' name="logo" class="form-control-file" id="logo" />
																	<center><button type="submit" name="submit" onclick="subirLogo();" class="btn btn-primary">Subir</button></center>
																</div> -->

                              <!-- <div class="col-lg-3">
                                <label>  Contraseña (emisor) </label>
                                <input type="password" class="form-control" name="Contrasena" id="Contrasena" placeholder="Contraseña" value="<?php echo $respuestaCorreo["Contrasena"] ?>" autocomplete="off" required>
                              </div>
                              <div class="col-lg-3">
                                <label>  Comprobar contraseña </label>
      												<table>
      													<th><input type="password" class="form-control" name="comprobacionContrasena" id="comprobacionContrasena" placeholder="Comprobar" value="" autocomplete="off" required></th>
      													<th><span id="noMatch" hidden class="text-danger"><i class="fa fa-times fa-2x"></i></span></th>
      													<th><span id="Match" hidden class="text-success"><i class="fa fa-check fa-2x"></i> </th>
      												</table>
                              </div>
                              <div class="col-lg-3">
                                <label>  Correo receptor </label>
                                <input type="email" class="form-control" name="EmailReceptor" id="EmailReceptor" placeholder="Correo receptor" autocomplete="off" value="<?php echo $respuestaCorreo["EmailReceptor"] ?>" required>		<br>
                              </div>
      												 <center><button id="submitEmail" type="submit" class="btn btn-primary">Actualizar</button></center> -->

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

 </div>
</body>


  <script>

	$(document).ready(function() {

	} );

// SIRVE PARA VIZUALIZAR LA IMAGEN CUANDO SE SELECIONE EN EXAMINAR
	function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}
// SIRVE PARA VIZUALIZAR LA IMAGEN CUANDO SE SELECIONE EN EXAMINAR
$("#logo").change(function(){
    readURL(this);
});


function subirLogo() {
	var imagen = $('#logo')[0].files[0];
	// var imagen = archivo[0];
	var imagenSize = imagen.size;
var datos = new FormData();

datos.append("imagen", imagen);

console.log(imagenSize);
		$.ajax({
			url:"controllers/Ajax/AjaxInformacion.php",
			method:"POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType:"json",
			success:function(html)
			{
				if(html == 'success'){

					alert("funciono");

				}else{
					alert("No funciono");
				}
			}
		});
}




  </script>
