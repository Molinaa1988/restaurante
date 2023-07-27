<?php @ob_start();
date_default_timezone_set('America/El_Salvador');

?>
<!DOCTYPE html>
<html lang="en">
<head>


  <meta charset="utf-8">

  <title>RESTAURANTE</title>
  <link rel="icon" href="views/assets/img/icorest.ico" type="image/ico" />

  <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="views/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="views/dist/css/AdminLTE.min.css">

  <!-- <link rel="stylesheet" href="views/dist/css/skins/_all-skins.min.css"> -->
  <link rel="stylesheet" href="views/plugins/iCheck/flat/blue.css">
  <link rel="stylesheet" href="views/plugins/morris/morris.css">
  <link rel="stylesheet" href="views/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <link rel="stylesheet" href="views/plugins/datepicker/datepicker3.css">
  <link rel="stylesheet" href="views/plugins/daterangepicker/daterangepicker.css">
  <!-- <link rel="stylesheet" href="views/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css"> -->

  <link rel="stylesheet" href="views/plugins/morris/example.css">
  <link href="views/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" >
  <link href="views/dist/css/skins/skin-blue.min.css" rel="stylesheet" type="text/css" />
  <!-- <link href="views/dist/css/sweetalert.css" rel="stylesheet" type="text/css" /> -->
  <link rel="stylesheet" href="views/plugins/datatables/dataTables.bootstrap.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <!-- <link rel="stylesheet" href="views/dist/css/animate.css"> -->




<!-- <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script> -->
<!-- <script>
  $.widget.bridge('uibutton', $.ui.button);
</script> -->
<!-- <script src="views/bootstrap/js/bootstrap.min.js"></script> -->
<!-- <script src="views/plugins/sparkline/jquery.sparkline.min.js"></script> -->
<!-- <script src="views/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script> -->
<!-- <script src="views/plugins/knob/jquery.knob.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>

<!-- <script src="views/plugins/daterangepicker/daterangepicker.js"></script>
<script src="views/plugins/datepicker/bootstrap-datepicker.js"></script> -->
<!-- <script src="views/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script> -->
<!-- <script src="views/plugins/slimScroll/jquery.slimscroll.min.js"></script> -->
<script src="views/plugins/fastclick/fastclick.js"></script>
<!-- <script src="views/dist/js/pages/dashboard.js"></script> -->
<!-- <script src="views/dist/js/demo.js"></script> -->


<!-- <script src="views/plugins/morris/raphael-min.js"></script>
<script src="views/plugins/morris/morris.js"></script> -->

<script src="views/plugins/jQuery/jquery-2.1.4.min.js"></script>
<script src="views/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="views/dist/js/app.min.js" type="text/javascript"></script>
<script src="views/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="views/plugins/datatables/dataTables.bootstrap.min.js"></script>
<!--SWEETE ALERT  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.4/sweetalert2.all.js"></script>
<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script> -->
<!-- Mascara -->
<script src="views/dist/js/mascara.js"></script>
<script src="views/dist/js/jquery.keyboard.js"></script>
<script src="views/dist/js/jquery.keyboard.extension-autocomplete.js"></script>
<script src="views/dist/js/jquery.keyboard.extension-typing.js"></script>
<script src="views/dist/js/jquery.mousewheel.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script> -->
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> -->
  <link rel="stylesheet" href="views/dist/css/keyboard.css">
  <link rel="stylesheet" href="views/dist/css/keyboard-dark.css">
  <link rel="stylesheet" href="views/assets/css/mystyle.css">







</head>

<body>

  <div class="container-fluid">

    <section class="row">

    <!--=====================================
    COLUMNA CONTENIDO
    ======================================-->

    <?php

      $modulos = new Enlaces();
      $modulos -> enlacesController();

    ?>

    <!--====  Fin de COLUMNA CONTENIDO  ====-->

    </section>

  </div>


  <script src="views/dist/js/validarIngreso.js"></script>



  <!--Este codigo fuunciona para traducir los datatable a espanoll -->




</body>

</html>
