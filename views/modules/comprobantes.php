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
        // PARA ELIMINAR COMPROBANTES QUE SON DE OTROS DIAS  (MODIFICAR SOLO COMPROBANTES.PHP Y MODELCOMPROBANTES.PHP LA SECCION COMENTADA)
        // 	 if(isset($_POST['fechai'])){
        //  		$fechai='2019-05-10';
        // }else{
        // 	 		$fechai='2019-05-10';
        //  }
        $fechai = "";
        $comprobante = "";
        if(isset($_POST['fechai'])){
          $fechai = $_POST['fechai'];
          $comprobante = $_POST['documentos'];
        }else{
          $fechai=date('Y-m-d');
          $comprobante = 'T';
        }

				$apertura = new controllerComprobantes();
				$apertura -> verificarClave();
      ?>

      <div class="row">
        <form name="gor" action="" method="POST" class="form-inline">
          <div class="col-md-4" align="center">
            <?php
              if(isset($_GET["clave"])){
            ?>
            <br>
            <center><a href="eliminados">Eliminados</a></center>
            <?php
              }
            ?>
          </div>
          <div class="col-md-4" align="center">
            <strong>Fecha inicial</strong>
            <center> 
              <input type="date" class="form-control" name="fechai" autocomplete="off" required value="<?php echo $fechai;?>">
              <select class="form-control" name="documentos" autocomplete="off" required>
                <option value = "T" <?php if($comprobante === 'T'){ ?> selected <?php } ?> >Ticket</option>
                <option value = "CCF_FCF" <?php if($comprobante === 'CCF_FCF'){ ?> selected <?php } ?> >Facturas</option>
              </select>
              <button type="submit" class="btn btn-icon waves-effect waves-light btn-primary m-b-5"><strong>Consultar</strong></button>  &nbsp;</center></form>
            </center>
          </div>
          <div class="col-md-4" align="center">
            <strong>Fecha final</strong>
            <!-- <form name="" action="" method="POST" class="form-inline"> -->
            <center><input type="text" class="form-control" name="clave" autocomplete="off" required value=""></center>
          </div>
        </form>
      </div>
      <br>


      <div class="row">
        <div class="col-md-12">
          <!-- <button id="" class="btn btn-danger" onclick="total();">EJECUTAR</button> -->
          <div class="box box-primary">
            <div class="box-header"><h3 class="box-title">Comprobantes</h3></div>
              <div class="box-body">
                <table id="TablaPedidos" class="table table-bordered compact table-striped table-hover border="0" ">
                  <thead>
                    <!-- <th style="width:20px;">TipoComp</th> -->
                    <th style="width:20px;">TipoComp</th>
                    <th style="width:10px;">#Comp/I</th>
                    <!-- <th style="width:10px;">#Comp/F</th> -->
                    <th style="width:75px;">SubTotal</th>
                    <th style="width:20px;">Total</th>
                    <th style="width:20px;">Hora</th>
                    <th style="width:5px;">Acciones</th>
                  </thead>
                  <tbody id="bodyTablaPedidos">
                    <?php
                      $respuesta = controllerComprobantes::comprobantesC($fechai);
                      // echo '<pre>';
                      // var_dump($respuesta);
                      // echo '</pre>';
                      foreach($respuesta[0] as $row => $item){
                        $col = '';
                        if ($comprobante == 'T') {
                          $col = 'IdcomprobanteC';
                        }else{
                          $col = 'IdComprobante';
                        }
                    ?>
                    <tr class="odd gradeX">
                      <!-- <td><center><?php echo $item[$col] ?></center></td> -->
                      <td><center><?php if ($item['TipoComprobante'] == 'T') {echo 'Ticket';} elseif($item['TipoComprobante'] =='FCF'){echo 'Factura';} elseif($item['TipoComprobante'] == 'CCF'){echo 'Credito F';}elseif($item['TipoComprobante'] =='CORTE X'){echo 'CORTE X';}elseif($item['TipoComprobante'] =='CORTE Z'){echo 'CORTE Z';}elseif($item['TipoComprobante'] =='CORTE GRAN Z'){echo 'CORTE GRAN Z';}?></center></td>
                      <td><center><?php echo $item['NumeroDoc'] ?></center></td>
                      <!-- <td><center><?php echo $item['Serie'] ?></center></td> -->
                      <td><center><?php echo $item["Total"]; ?></center></td>
                      <td><center><?php echo $item['TotalPagar'] ?></center></td>
                      <td><center><?php echo $item['Hora'] ?></center></td>
                      <td><center>
                        <input type="hidden" id="InfoComp<?php echo $item[$col] ?>" value='<?php echo json_encode($item); ?>'>
                        <button id="Anular" class="btn btn-warning" onClick="Anular('#InfoComp<?php echo $item[$col] ?>')">A</button>
                        <?php
                          if(isset($_GET["clave"])){
                        ?>
                          <button id="eliminar<?php echo $item[$col] ?>" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                        <?php
                          }
                        ?>
                        <?php
                          if ($item === end($respuesta)) {
                        ?>
                        <?php
                          }
                        ?>
                        &nbsp;&nbsp;
                        <!--button id="imprimir<?php echo $item['IdComprobante'] ?>" class="btn btn-success"><i class="fa fa-print"></i></button-->
                      </center></td>
                    </tr>
                    <script>
                      $( "#eliminar<?php echo $item[$col] ?>" ).click(function( event ) {
                        var IdComprobante = <?php echo $item[$col] ?>;
                        var NumeroDoc = <?php echo $item['NumeroDoc'] ?>;
                        var IdPedido = <?php echo $item["IdPedido"] ?>;
                        swal({
                          title: 'Eliminar',
                          text: "Esta seguro de eliminar el comprobante?",
                          type: 'warning',
                          showCancelButton: true,
                          confirmButtonColor: '#3085d6',
                          cancelButtonColor: '#d33',
                          confirmButtonText: 'Eliminar',
                          cancelButtonText: 'Cancelar'
                        }).then((result) => {
                          $.ajax({
                            url:"controllers/Ajax/AjaxComprobantes.php",
                            method:"POST",
                            data:{IdcomprobanteAJAX:IdComprobante,NumeroDocAjax:NumeroDoc,IdPedidoAjax:IdPedido},
                            dataType:"text",
                            success:function(html){
                              location.reload();
                            }
                          });
                        })
                      });
                    </script>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</body>
<script>
  function Anular(idInput) {
    var Data = $(idInput).val();
    Data = JSON.parse(Data);
    var sendInfo = {
      IdPedido: Data["IdPedido"]
    }
    console.log(Data);
    // console.log(sendInfo);
    $.ajax({
		  async: true,
      url : 'controllers/Ajax/AjaxExtras.php', // la URL para la petición
		  data: {"AccionAjax": "Anular", "AjaxData": sendInfo},
		  type: 'POST',
			dataType : 'json', // el tipo de información que se espera de respuesta
			success : function(json) {
				console.log(json);
        location.reload();
			},
			error : function(xhr, status) {
				console.log('Disculpe, existió un problema');
			},
			complete : function(xhr, status) {
				console.log('Petición realizada');
			}
		});
  }
</script>
