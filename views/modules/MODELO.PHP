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

		<?php

		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(40,10,'¡Hola, Mundo!');
		$pdf->Output();
		 ?>


     </section>
   </div>

 </div>
</body>

  <script>

	$(document).ready(function() {

	} );


  </script>
