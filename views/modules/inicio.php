<?php
session_start();
if(!$_SESSION["validar"]){
	header("location:ingreso");
	exit();
}
?>

<script>
$(document).ready(function() {
<?php

if($_SESSION["puesto"] == 5)
{
	echo "window.location='salon'";
}
elseif($_SESSION["puesto"] == 6) {
	echo "window.location='cocina'";
}

?>
} );
</script>


<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<?php
include "views/modules/cabezote.php";
include "views/modules/botonera.php";
?>

  <div class="content-wrapper">
    <section class="content">

			


		            <div class="row">
		                <div align="center">
		                       <?php
									switch ($_SESSION["puesto"]) 
										{
											case 1:
												echo '<img style="max-width: 30%" src="views/dist/img/logo.png" class="user-image img-responsive"/>';
											break;
											case 2:
												echo '<img style="max-width: 30%" src="views/dist/img/logo.png" class="user-image img-responsive"/>';
											break;
											case 3:
												echo '<img style="max-width: 30%" src="views/dist/img/logo.png" class="user-image img-responsive"/>';
											break;
											case 4:
												echo '<img style="max-width: 30%" src="views/dist/img/logo.png" class="user-image img-responsive"/>';
											break;
											case 5:
												echo '<img style="max-width: 30%" src="views/dist/img/logo.png" class="user-image img-responsive"/>';
											break;
											case 6:
												echo '<img style="max-width: 30%" src="views/dist/img/logo.png" class="user-image img-responsive"/>';
											break;
										}
								?>
		                <div class="">
		                    <h1 class="text-info">Bienvenido<br></h1>
		                        	<strong class="text-info">
									<?php 
									switch ($_SESSION["puesto"]) 
									{
										case 1:
											echo 'Programador';
										break;
										case 2:
											echo 'Gerencia';
										break;
										case 3:
											echo 'Administrador';
										break;
										case 4:
											echo 'Cajero/a';
										break;
										case 5:
											echo 'Mesero/a';
										break;
										case 6:
											echo 'Cocinero/a';
										break;
									}
									?>   
								</strong>
		                    </div>
		                </div>
		            </div>
