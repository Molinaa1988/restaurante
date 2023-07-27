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

<script>
function imprimir(){
	var objeto=document.getElementById('imprimeme');  //obtenemos el objeto a imprimir
	var ventana=window.open('','_blank');  //abrimos una ventana vacía nueva
	ventana.document.write(objeto.innerHTML);  //imprimimos el HTML del objeto en la nueva ventana
	ventana.document.close();  //cerramos el documento
	ventana.print();  //imprimimos la ventana
	ventana.close();  //cerramos la ventana
}
</script>

  <div class="content-wrapper">
    <section class="content">

			<?php
					if(isset($_POST['fechai'])){
							$fechai=$_POST['fechai'];
					}else{
							$fechai=date('Y-m-d');
					}
			 ?>
			                     <div class="row">
			                 <div class="col-md-12">
			                     <!-- Advanced Tables -->
			                     <div class="panel panel-primary">
			                         <div class="panel-heading">
			                             Reporte ingresos y egresos por mes
			                         </div>
			                         <div class="panel-body">

			                          <div class="panel panel-default">
			                         <div class="panel-body">

																 <?php
												                                  $fechai=date('Y-m-d');
												                                 if(!empty($_GET['Año']) and !empty($_GET['Mes'])){
												                                     $Año=($_GET['Año']);
												                                     $Mes=($_GET['Mes']);

												                                 }else{
												                                     $Año='';
												                                     $Mes='';

												                                 }
												                             ?>

																	 <form name="gor" action="" method="get" class="form-inline">
		                            <div class="row-fluid">
		                                <div class="col-xs-6 col-sm-3" align="center">
		                                    <strong>Año</strong><br>
		                                    <select class="form-control" name="Año">
		                                        <option value="2017" <?php if($Año=='2017'){ echo 'selected'; } ?>>2017</option>
		                                        <option value="2018" <?php if($Año=='2018'){ echo 'selected'; } ?>>2018</option>
		                                        <option value="2019" <?php if($Año=='2019'){ echo 'selected'; } ?>>2019</option>
		                                        <option value="2020" <?php if($Año=='2020'){ echo 'selected'; } ?>>2020</option>
		                                        <option value="2021" <?php if($Año=='2021'){ echo 'selected'; } ?>>2021</option>
		                                        <option value="2022" <?php if($Año=='2022'){ echo 'selected'; } ?>>2022</option>
		                                        <option value="2023" <?php if($Año=='2023'){ echo 'selected'; } ?>>2023</option>
		                                        <option value="2024" <?php if($Año=='2024'){ echo 'selected'; } ?>>2024</option>
		                                    </select>
		                                </div>
		                                <div class="col-xs-6 col-sm-3" align="center">
		                                    <strong>Mes</strong><br>
		                                 <select class="form-control" name="Mes">
		                                        <option value="Enero" <?php if($Mes=='Enero'){ echo 'selected'; } ?>>Enero</option>
		                                        <option value="Febrero" <?php if($Mes=='Febrero'){ echo 'selected'; } ?>>Febrero</option>
		                                        <option value="Marzo" <?php if($Mes=='Marzo'){ echo 'selected'; } ?>>Marzo</option>
		                                        <option value="Abril" <?php if($Mes=='Abril'){ echo 'selected'; } ?>>Abril</option>
		                                        <option value="Mayo" <?php if($Mes=='Mayo'){ echo 'selected'; } ?>>Mayo</option>
		                                        <option value="Junio" <?php if($Mes=='Junio'){ echo 'selected'; } ?>>Junio</option>
		                                        <option value="Julio" <?php if($Mes=='Julio'){ echo 'selected'; } ?>>Julio</option>
		                                        <option value="Agosto" <?php if($Mes=='Agosto'){ echo 'selected'; } ?>>Agosto</option>
		                                        <option value="Septiembre" <?php if($Mes=='Septiembre'){ echo 'selected'; } ?>>Septiembre</option>
		                                        <option value="Octubre" <?php if($Mes=='Octubre'){ echo 'selected'; } ?>>Octubre</option>
		                                        <option value="Noviembre" <?php if($Mes=='Noviembre'){ echo 'selected'; } ?>>Noviembre</option>
		                                        <option value="Diciembre" <?php if($Mes=='Diciembre'){ echo 'selected'; } ?>>Diciembre</option>
		                                    </select>
		                                </div>
		                                <div class="col-xs-6 col-sm-3" align="center"><br>

		                                    <button type="submit" class="btn btn-icon waves-effect waves-light btn-primary m-b-5"><strong>Consultar</strong></button>
		                                </div>
		                                     <div class="col-xs-6 col-sm-3" align="center"><br>

		                                    <button onclick="imprimir();" class="btn btn-success"><i class=" fa fa-print "></i> Imprimir</button>
		                                </div>
		                            </div><br>
		                            </form>

			                         <div style="width:100%; height:700px; overflow: auto;">
			                          <div id="imprimeme">
			                                      <br>
			                                      <div class="hidden">
			                                      	<table  width="100%" style="border: 1px solid #660000; -moz-border-radius: 13px;-webkit-border-radius: 12px;padding: 10px;">
			                                      <tr>
			                                         <td>
			                                             <center>
			                                             <img src="../../img/logo.jpg" width="75px" height="75px"><br>
			                                             </center>
			                                         </td>
			                                         <td align="center">
			                                             <div style="font-size: 25px;"><strong><em>FUEGO&BRASAS</em></strong></div>
			                                                Fecha: <?php echo $fechai; ?> <br>
			                                         </td>
			                                         <td>
			                                             <center>

			                                             </center>
			                                         </td>
			                                      </tr>
			                                     </table><br>
			                                       <hr/>
			                                           <div style="font-size: 14px;"align="center">
			                                              <strong>Reporte ingresos y egresos por mes</strong><br>
			                                         </div>
			                                         <hr/>
			                                     </div>

																		 <div class="table-responsive">
																		                                <table class="table table-striped table-bordered table-hover"  width="100%"  border="0">
																		                                    <thead>
																		                                        <tr>
																		                                          <th><center>Dia</center></th>
																		                                           <th><center>Total</center></th>
																		                                        </tr>
																		                                    </thead>
																		                                    <tbody>
																		                                                        <?php

																		                                                           $_fecha1 = date("H");
																		                                                           $_fecha2 = date("H");

																		                                                        if ($Año == "2017")    /*----------2017---------*/
																		                                                        {
																		                                                          if ($Mes == "Enero")
																		                                                          {
																		                                                            $_fecha1="2017-01-01";
																		                                                            $_fecha2="2017-01-30";
																		                                                          }

																		                                                          elseif ($Mes == "Febrero")
																		                                                          {
																		                                                            $_fecha1="2017-02-01";
																		                                                            $_fecha2="2017-02-28";
																		                                                          }

																		                                                          elseif ($Mes == "Marzo")
																		                                                          {
																		                                                            $_fecha1="2017-03-01";
																		                                                            $_fecha2="2017-03-31";
																		                                                          }

																		                                                          elseif ($Mes == "Abril")
																		                                                          {
																		                                                            $_fecha1="2017-04-01";
																		                                                            $_fecha2="2017-04-30";
																		                                                          }

																		                                                          elseif ($Mes == "Mayo")
																		                                                          {
																		                                                            $_fecha1="2017-05-01";
																		                                                            $_fecha2="2017-05-31";
																		                                                          }
																		                                                           elseif ($Mes == "Junio")
																		                                                          {
																		                                                            $_fecha1="2017-06-01";
																		                                                            $_fecha2="2017-06-30";
																		                                                          }
																		                                                           elseif ($Mes == "Julio")
																		                                                          {
																		                                                            $_fecha1="2017-07-01";
																		                                                            $_fecha2="2017-07-31";
																		                                                          }
																		                                                           elseif ($Mes == "Agosto")
																		                                                          {
																		                                                            $_fecha1="2017-08-01";
																		                                                            $_fecha2="2017-08-31";
																		                                                          }
																		                                                           elseif ($Mes == "Septiembre")
																		                                                          {
																		                                                            $_fecha1="2017-09-01";
																		                                                            $_fecha2="2017-09-30";
																		                                                          }
																		                                                           elseif ($Mes == "Octubre")
																		                                                          {
																		                                                            $_fecha1="2017-10-01";
																		                                                            $_fecha2="2017-10-31";
																		                                                          }
																		                                                           elseif ($Mes == "Noviembre")
																		                                                          {
																		                                                            $_fecha1="2017-11-01";
																		                                                            $_fecha2="2017-11-30";
																		                                                          }
																		                                                           elseif ($Mes == "Diciembre")
																		                                                          {
																		                                                            $_fecha1="2017-12-01";
																		                                                            $_fecha2="2017-12-31";
																		                                                          }
																		                                                           }
																		                                                           else if ($Año == "2018") /*----------2018---------*/
																		                                                           {
																		                                                          if ($Mes == "Enero")
																		                                                          {
																		                                                            $_fecha1="2017-01-01";
																		                                                            $_fecha2="2017-01-31";
																		                                                          }

																		                                                          elseif ($Mes == "Febrero")
																		                                                          {
																		                                                            $_fecha1="2017-02-01";
																		                                                            $_fecha2="2017-02-28";
																		                                                          }

																		                                                          elseif ($Mes == "Marzo")
																		                                                          {
																		                                                            $_fecha1="2017-03-01";
																		                                                            $_fecha2="2017-03-31";
																		                                                          }

																		                                                          elseif ($Mes == "Abril")
																		                                                          {
																		                                                            $_fecha1="2017-04-01";
																		                                                            $_fecha2="2017-04-30";
																		                                                          }

																		                                                          elseif ($Mes == "Mayo")
																		                                                          {
																		                                                            $_fecha1="2017-05-01";
																		                                                            $_fecha2="2017-05-31";
																		                                                          }
																		                                                           elseif ($Mes == "Junio")
																		                                                          {
																		                                                            $_fecha1="2017-06-01";
																		                                                            $_fecha2="2017-06-30";
																		                                                          }
																		                                                           elseif ($Mes == "Julio")
																		                                                          {
																		                                                            $_fecha1="2017-07-01";
																		                                                            $_fecha2="2017-07-31";
																		                                                          }
																		                                                           elseif ($Mes == "Agosto")
																		                                                          {
																		                                                            $_fecha1="2017-08-01";
																		                                                            $_fecha2="2017-08-31";
																		                                                          }
																		                                                           elseif ($Mes == "Septiembre")
																		                                                          {
																		                                                            $_fecha1="2017-09-01";
																		                                                            $_fecha2="2017-09-30";
																		                                                          }
																		                                                           elseif ($Mes == "Octubre")
																		                                                          {
																		                                                            $_fecha1="2017-10-01";
																		                                                            $_fecha2="2017-10-31";
																		                                                          }
																		                                                           elseif ($Mes == "Noviembre")
																		                                                          {
																		                                                            $_fecha1="2017-11-01";
																		                                                            $_fecha2="2017-11-30";
																		                                                          }
																		                                                           elseif ($Mes == "Diciembre")
																		                                                          {
																		                                                            $_fecha1="2017-12-01";
																		                                                            $_fecha2="2017-12-31";
																		                                                          }
																		                                                           }
																		                                                            else if ($Año == "2019") /*----------2019---------*/
																		                                                           {
																		                                                          if ($Mes == "Enero")
																		                                                          {
																		                                                            $_fecha1="2019-01-01";
																		                                                            $_fecha2="2019-01-31";
																		                                                          }

																		                                                          elseif ($Mes == "Febrero")
																		                                                          {
																		                                                            $_fecha1="2019-02-01";
																		                                                            $_fecha2="2019-02-28";
																		                                                          }

																		                                                          elseif ($Mes == "Marzo")
																		                                                          {
																		                                                            $_fecha1="2019-03-01";
																		                                                            $_fecha2="2019-03-31";
																		                                                          }

																		                                                          elseif ($Mes == "Abril")
																		                                                          {
																		                                                            $_fecha1="2019-04-01";
																		                                                            $_fecha2="2019-04-30";
																		                                                          }

																		                                                          elseif ($Mes == "Mayo")
																		                                                          {
																		                                                            $_fecha1="2019-05-01";
																		                                                            $_fecha2="2019-05-31";
																		                                                          }
																		                                                           elseif ($Mes == "Junio")
																		                                                          {
																		                                                            $_fecha1="2019-06-01";
																		                                                            $_fecha2="2019-06-30";
																		                                                          }
																		                                                           elseif ($Mes == "Julio")
																		                                                          {
																		                                                            $_fecha1="2019-07-01";
																		                                                            $_fecha2="2019-07-31";
																		                                                          }
																		                                                           elseif ($Mes == "Agosto")
																		                                                          {
																		                                                            $_fecha1="2019-08-01";
																		                                                            $_fecha2="2019-08-31";
																		                                                          }
																		                                                           elseif ($Mes == "Septiembre")
																		                                                          {
																		                                                            $_fecha1="2019-09-01";
																		                                                            $_fecha2="2019-09-30";
																		                                                          }
																		                                                           elseif ($Mes == "Octubre")
																		                                                          {
																		                                                            $_fecha1="2019-10-01";
																		                                                            $_fecha2="2019-10-31";
																		                                                          }
																		                                                           elseif ($Mes == "Noviembre")
																		                                                          {
																		                                                            $_fecha1="2019-11-01";
																		                                                            $_fecha2="2019-11-30";
																		                                                          }
																		                                                           elseif ($Mes == "Diciembre")
																		                                                          {
																		                                                            $_fecha1="2019-12-01";
																		                                                            $_fecha2="2019-12-31";
																		                                                          }
																		                                                           }
																		                                                            else if ($Año == "2020") /*----------2020---------*/
																		                                                           {
																		                                                          if ($Mes == "Enero")
																		                                                          {
																		                                                            $_fecha1="2020-01-01";
																		                                                            $_fecha2="2020-01-31";
																		                                                          }

																		                                                          elseif ($Mes == "Febrero")
																		                                                          {
																		                                                            $_fecha1="2020-02-01";
																		                                                            $_fecha2="2020-02-29";
																		                                                          }

																		                                                          elseif ($Mes == "Marzo")
																		                                                          {
																		                                                            $_fecha1="2020-03-01";
																		                                                            $_fecha2="2020-03-31";
																		                                                          }

																		                                                          elseif ($Mes == "Abril")
																		                                                          {
																		                                                            $_fecha1="2020-04-01";
																		                                                            $_fecha2="2020-04-30";
																		                                                          }

																		                                                          elseif ($Mes == "Mayo")
																		                                                          {
																		                                                            $_fecha1="2020-05-01";
																		                                                            $_fecha2="2020-05-31";
																		                                                          }
																		                                                           elseif ($Mes == "Junio")
																		                                                          {
																		                                                            $_fecha1="2020-06-01";
																		                                                            $_fecha2="2020-06-30";
																		                                                          }
																		                                                           elseif ($Mes == "Julio")
																		                                                          {
																		                                                            $_fecha1="2020-07-01";
																		                                                            $_fecha2="2020-07-31";
																		                                                          }
																		                                                           elseif ($Mes == "Agosto")
																		                                                          {
																		                                                            $_fecha1="2020-08-01";
																		                                                            $_fecha2="2020-08-31";
																		                                                          }
																		                                                           elseif ($Mes == "Septiembre")
																		                                                          {
																		                                                            $_fecha1="2020-09-01";
																		                                                            $_fecha2="2020-09-30";
																		                                                          }
																		                                                           elseif ($Mes == "Octubre")
																		                                                          {
																		                                                            $_fecha1="2020-10-01";
																		                                                            $_fecha2="2020-10-31";
																		                                                          }
																		                                                           elseif ($Mes == "Noviembre")
																		                                                          {
																		                                                            $_fecha1="2020-11-01";
																		                                                            $_fecha2="2020-11-30";
																		                                                          }
																		                                                           elseif ($Mes == "Diciembre")
																		                                                          {
																		                                                            $_fecha1="2020-12-01";
																		                                                            $_fecha2="2020-12-31";
																		                                                          }
																		                                                           }
																		                                                            else if ($Año == "2021") /*----------2021---------*/
																		                                                           {
																		                                                          if ($Mes == "Enero")
																		                                                          {
																		                                                            $_fecha1="2021-01-01";
																		                                                            $_fecha2="2021-01-31";
																		                                                          }

																		                                                          elseif ($Mes == "Febrero")
																		                                                          {
																		                                                            $_fecha1="2021-02-01";
																		                                                            $_fecha2="2021-02-28";
																		                                                          }

																		                                                          elseif ($Mes == "Marzo")
																		                                                          {
																		                                                            $_fecha1="2021-03-01";
																		                                                            $_fecha2="2021-03-31";
																		                                                          }

																		                                                          elseif ($Mes == "Abril")
																		                                                          {
																		                                                            $_fecha1="2021-04-01";
																		                                                            $_fecha2="2021-04-30";
																		                                                          }

																		                                                          elseif ($Mes == "Mayo")
																		                                                          {
																		                                                            $_fecha1="2021-05-01";
																		                                                            $_fecha2="2021-05-31";
																		                                                          }
																		                                                           elseif ($Mes == "Junio")
																		                                                          {
																		                                                            $_fecha1="2021-06-01";
																		                                                            $_fecha2="2021-06-30";
																		                                                          }
																		                                                           elseif ($Mes == "Julio")
																		                                                          {
																		                                                            $_fecha1="2021-07-01";
																		                                                            $_fecha2="2021-07-31";
																		                                                          }
																		                                                           elseif ($Mes == "Agosto")
																		                                                          {
																		                                                            $_fecha1="2021-08-01";
																		                                                            $_fecha2="2021-08-31";
																		                                                          }
																		                                                           elseif ($Mes == "Septiembre")
																		                                                          {
																		                                                            $_fecha1="2021-09-01";
																		                                                            $_fecha2="2021-09-30";
																		                                                          }
																		                                                           elseif ($Mes == "Octubre")
																		                                                          {
																		                                                            $_fecha1="2021-10-01";
																		                                                            $_fecha2="2021-10-31";
																		                                                          }
																		                                                           elseif ($Mes == "Noviembre")
																		                                                          {
																		                                                            $_fecha1="2021-11-01";
																		                                                            $_fecha2="2021-11-30";
																		                                                          }
																		                                                           elseif ($Mes == "Diciembre")
																		                                                          {
																		                                                            $_fecha1="2021-12-01";
																		                                                            $_fecha2="2021-12-31";
																		                                                          }
																		                                                           }
																		                                                            else if ($Año == "2022") /*----------2022---------*/
																		                                                           {
																		                                                          if ($Mes == "Enero")
																		                                                          {
																		                                                            $_fecha1="2022-01-01";
																		                                                            $_fecha2="2022-01-30";
																		                                                          }

																		                                                          elseif ($Mes == "Febrero")
																		                                                          {
																		                                                            $_fecha1="2022-02-01";
																		                                                            $_fecha2="2022-02-28";
																		                                                          }

																		                                                          elseif ($Mes == "Marzo")
																		                                                          {
																		                                                            $_fecha1="2022-03-01";
																		                                                            $_fecha2="2022-03-31";
																		                                                          }

																		                                                          elseif ($Mes == "Abril")
																		                                                          {
																		                                                            $_fecha1="2022-04-01";
																		                                                            $_fecha2="2022-04-30";
																		                                                          }

																		                                                          elseif ($Mes == "Mayo")
																		                                                          {
																		                                                            $_fecha1="2022-05-01";
																		                                                            $_fecha2="2022-05-31";
																		                                                          }
																		                                                           elseif ($Mes == "Junio")
																		                                                          {
																		                                                            $_fecha1="2022-06-01";
																		                                                            $_fecha2="2022-06-30";
																		                                                          }
																		                                                           elseif ($Mes == "Julio")
																		                                                          {
																		                                                            $_fecha1="2022-07-01";
																		                                                            $_fecha2="2022-07-31";
																		                                                          }
																		                                                           elseif ($Mes == "Agosto")
																		                                                          {
																		                                                            $_fecha1="2022-08-01";
																		                                                            $_fecha2="2022-08-31";
																		                                                          }
																		                                                           elseif ($Mes == "Septiembre")
																		                                                          {
																		                                                            $_fecha1="2022-09-01";
																		                                                            $_fecha2="2022-09-30";
																		                                                          }
																		                                                           elseif ($Mes == "Octubre")
																		                                                          {
																		                                                            $_fecha1="2022-10-01";
																		                                                            $_fecha2="2022-10-30";
																		                                                          }
																		                                                           elseif ($Mes == "Noviembre")
																		                                                          {
																		                                                            $_fecha1="2022-11-01";
																		                                                            $_fecha2="2022-11-30";
																		                                                          }
																		                                                           elseif ($Mes == "Diciembre")
																		                                                          {
																		                                                            $_fecha1="2022-12-01";
																		                                                            $_fecha2="2022-12-31";
																		                                                          }
																		                                                           }
																		                                                            else if ($Año == "2023") /*----------2023---------*/
																		                                                           {
																		                                                           if ($Mes == "Enero")
																		                                                          {
																		                                                            $_fecha1="2023-01-01";
																		                                                            $_fecha2="2023-01-31";
																		                                                          }

																		                                                          elseif ($Mes == "Febrero")
																		                                                          {
																		                                                            $_fecha1="2023-02-01";
																		                                                            $_fecha2="2023-02-28";
																		                                                          }

																		                                                          elseif ($Mes == "Marzo")
																		                                                          {
																		                                                            $_fecha1="2023-03-01";
																		                                                            $_fecha2="2023-03-31";
																		                                                          }

																		                                                          elseif ($Mes == "Abril")
																		                                                          {
																		                                                            $_fecha1="2023-04-01";
																		                                                            $_fecha2="2023-04-30";
																		                                                          }

																		                                                          elseif ($Mes == "Mayo")
																		                                                          {
																		                                                            $_fecha1="2023-05-01";
																		                                                            $_fecha2="2023-05-31";
																		                                                          }
																		                                                           elseif ($Mes == "Junio")
																		                                                          {
																		                                                            $_fecha1="2023-06-01";
																		                                                            $_fecha2="2023-06-30";
																		                                                          }
																		                                                           elseif ($Mes == "Julio")
																		                                                          {
																		                                                            $_fecha1="2023-07-01";
																		                                                            $_fecha2="2023-07-31";
																		                                                          }
																		                                                           elseif ($Mes == "Agosto")
																		                                                          {
																		                                                            $_fecha1="2023-08-01";
																		                                                            $_fecha2="2023-08-31";
																		                                                          }
																		                                                           elseif ($Mes == "Septiembre")
																		                                                          {
																		                                                            $_fecha1="2023-09-01";
																		                                                            $_fecha2="2023-09-30";
																		                                                          }
																		                                                           elseif ($Mes == "Octubre")
																		                                                          {
																		                                                            $_fecha1="2023-10-01";
																		                                                            $_fecha2="2023-10-31";
																		                                                          }
																		                                                           elseif ($Mes == "Noviembre")
																		                                                          {
																		                                                            $_fecha1="2023-11-01";
																		                                                            $_fecha2="2023-11-30";
																		                                                          }
																		                                                           elseif ($Mes == "Diciembre")
																		                                                          {
																		                                                            $_fecha1="2023-12-01";
																		                                                            $_fecha2="2023-12-31";
																		                                                          }
																		                                                           }
																		                                                            else if ($Año == "2024") /*----------2024---------*/
																		                                                           {
																		                                                         if ($Mes == "Enero")
																		                                                          {
																		                                                            $_fecha1="2024-01-01";
																		                                                            $_fecha2="2024-01-31";
																		                                                          }

																		                                                          elseif ($Mes == "Febrero")
																		                                                          {
																		                                                            $_fecha1="2024-02-01";
																		                                                            $_fecha2="2024-02-29";
																		                                                          }

																		                                                          elseif ($Mes == "Marzo")
																		                                                          {
																		                                                            $_fecha1="2024-03-01";
																		                                                            $_fecha2="2024-03-31";
																		                                                          }

																		                                                          elseif ($Mes == "Abril")
																		                                                          {
																		                                                            $_fecha1="2024-04-01";
																		                                                            $_fecha2="2024-04-30";
																		                                                          }

																		                                                          elseif ($Mes == "Mayo")
																		                                                          {
																		                                                            $_fecha1="2024-05-01";
																		                                                            $_fecha2="2024-05-31";
																		                                                          }
																		                                                           elseif ($Mes == "Junio")
																		                                                          {
																		                                                            $_fecha1="2024-06-01";
																		                                                            $_fecha2="2024-06-30";
																		                                                          }
																		                                                           elseif ($Mes == "Julio")
																		                                                          {
																		                                                            $_fecha1="2024-07-01";
																		                                                            $_fecha2="2024-07-31";
																		                                                          }
																		                                                           elseif ($Mes == "Agosto")
																		                                                          {
																		                                                            $_fecha1="2024-08-01";
																		                                                            $_fecha2="2024-08-31";
																		                                                          }
																		                                                           elseif ($Mes == "Septiembre")
																		                                                          {
																		                                                            $_fecha1="2024-09-01";
																		                                                            $_fecha2="2024-09-30";
																		                                                          }
																		                                                           elseif ($Mes == "Octubre")
																		                                                          {
																		                                                            $_fecha1="2024-10-01";
																		                                                            $_fecha2="2024-10-31";
																		                                                          }
																		                                                           elseif ($Mes == "Noviembre")
																		                                                          {
																		                                                            $_fecha1="2024-11-01";
																		                                                            $_fecha2="2024-11-30";
																		                                                          }
																		                                                           elseif ($Mes == "Diciembre")
																		                                                          {
																		                                                            $_fecha1="2024-12-01";
																		                                                            $_fecha2="2024-12-31";
																		                                                          }
																		                                                           }
																		                                                          ?>


																		                                   <?php
																		                                                $neto=0;

																																										 $respuesta = controllerReportes::ReporteIngresoEgresospormes1($_fecha1,$_fecha2);
																																																		foreach($respuesta as $row => $item){
																		                                                    $neto=$neto+$item['Total'];
																		                                            ?>
																		                                        <tr class="odd gradeX">
																		                                        <td><center><?php echo $item['Dia'] ?></center></td>
																		                                        <td><center>$ <?php echo $item['Total'] ?></center></td>


																		                                        </tr>
																		                                        <?php } ?>
																		                                         <tr>
																		                                                    <td><div align="right"><strong><h4>Total Ingresos</h4></strong></div></td>
																		                                                    <td><div align="center"><strong><h4>$ <?php echo ($neto); ?></h4></strong></div></td>
																		                                                        </tr>
																		                                    </tbody>
																		                                </table>
																		                            </div>



																		  <div class="table-responsive">
																		                                <table class="table table-striped table-bordered table-hover"  width="100%"  border="0">
																		                                    <thead>
																		                                        <tr>
																		                                          <th><center>Dia</center></th>
																		                                           <th><center>Total</center></th>
																		                                        </tr>
																		                                    </thead>
																		                                    <tbody>



																		                                   <?php
																		                                                $neto=0;

																																									 $respuesta = 	controllerReportes::ReporteIngresoEgresospormes2($_fecha1,$_fecha2);
																																																		foreach($respuesta as $row => $item){
																		                                                    $neto=$neto+$item['Total'];
																		                                            ?>
																		                                        <tr class="odd gradeX">
																		                                        <td><center><?php echo $item['Dia'] ?></center></td>
																		                                        <td><center>$ <?php echo $item['Total'] ?></center></td>


																		                                        </tr>
																		                                        <?php } ?>
																		                                         <tr>
																		                                                    <td><div align="right"><strong><h4>Total Egresos</h4></strong></div></td>
																		                                                    <td><div align="center"><strong><h4>$ <?php echo ($neto); ?></h4></strong></div></td>
																		                                                        </tr>
																		                                    </tbody>
																		                                </table>
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
