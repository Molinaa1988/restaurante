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
		                        if ($_SESSION["puesto"] == "1")
								{
		                        	echo '<img style="max-width: 30%" src="views/dist/img/logo.png" class="user-image img-responsive"/>';
								} 
								else if($_SESSION["puesto"] == "6")
								{
		                        	echo '<img style="max-width: 90%" src="views/dist/img/logo.png" class="user-image img-responsive"/>';
		                        }
		                    ?>
		                    <div class="">
		                    	<h1 class="text-info">Bienvenido<br> <?php echo $_SESSION['usuario']; ?><br></h1>
		                        <strong class="text-info"> * * * 
									<?php 
									
									if ($_SESSION["puesto"] == "1")
									{
										echo 'Administrador/a';
									} 
									else if($_SESSION["puesto"] == "6")
									{
										echo 'Cajero/a';
									} 
									?>  * * *  
								</strong>
		                    </div>
		                </div>
		            </div>
