<?php
session_start();
if(!$_SESSION["validar"]){
	header("location:ingreso");
	exit();
}
?>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<?php
include "views/modules/cabezote.php";
include "views/modules/botonera.php";

?>

  <div class="content-wrapper">
    <section class="content">
      <div class="row">
        <form method="POST">
           <div class="col-md-3" align="center">
             <input class="form-control" name="numero1" id="numero1" placeholder="numero1" autocomplete="off">
           </div>
           <div class="col-md-3" align="center">
             <input class="form-control" name="numero2" id="numero2" placeholder="numero2" autocomplete="off">
           </div>
           <div class="col-md-3" align="center">
             <input class="form-control" name="total" id="total" value="<?php echo $resultado ?>" placeholder="total" autocomplete="off">
           </div>
           <div class="col-md-3" align="center">
             <button type="submit" class="btn btn-primary">Sumar</button>
           </div>
        </form>
       </div>
       <br>
     </section>
   </div>
 </div>
</body>
<?php


?>





  <script type="text/javascript">

  // Mostrat vuelto
  // $('#numero2').on("keyup", function() {
  //   var numero1 = $("#numero1").val();
  //   var numero2 = $("#numero2").val();
  //   var total = numero1-numero2;
  //   $("#total").val(total.toFixed(2));
  // });







  </script>
