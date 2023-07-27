<?php
  session_start();
  if(!$_SESSION["validar"]){
	  header("location:ingreso");
	  exit();
  }
?>
<style>
  tr, td {
    cursor: pointer;
  }
</style>
<body class="hold-transition skin-blue sidebar-collapse sidebar-mini">
  <div class="wrapper">
    <?php
      include "views/modules/cabezote.php";
      include "views/modules/botonera.php";
      $propina = 0;
      $totalPagar = 0;
    ?>
    <div id="Contente" class="content-wrapper">
      <section class="content">
        <?php
          $estadoCaja = controllerCaja::vereficarAperturaCaja();
          if($estadoCaja['Estado'] != 'A'){
        ?>
        <div class="row">
          <div class="col-md-12">
            <div class="box box-default">
              <div class="box-header with-border">
                <i class="fa fa-bullhorn"></i>
                <h3 class="box-title">Mensaje</h3>
              </div>
              <div class="box-body">
                <div class="callout callout-info">
                  <h4>CAJA CERRADA</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php
          }else{
            $UltimoIdCaja = controllerCaja::ultimoIdCaja();
        ?>
          <div class="row">
            <div class="col-md-8">
              <div class="box box-primary">
                <div class="box-header"><h3 class="box-title">Pedidos</h3></div>
                <div class="box-body">
                  <table id="TablaPedidos" class="table table-bordered compact table-striped table-hover border='0'">
                    <thead>
                      <th>Pedido</th>
                      <th>Mesa</th>
                      <th>Mesero</th>
                      <th>Monto</th>
                      <th>Cliente</th>
                      <th>Desc. / Carg.</th>
                      <!--th>ReAbrir</th-->
                    </thead>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="box box-primary">
                <div class="box-header"><h3 class="box-title">Detalle Pedido</h3></div>
                <div class="box-body">
                  <table  id="DetallePedido" class="table table-bordered table-striped table-hover  border="0"">
                    <thead>
                      <th>Cant</th>
                      <th>Producto</th>
                      <th>P/U</th>
                      <th>Importe</th>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-8">
              <div class="box box-primary">
                <div class="box-header"><h3 class="box-title">Datos del Comprobante</h3></div>
                <div class="box-body">
                  <form id="FrmPrincipal">
                    <input type="hidden" name="idPedido" value="0">
                    <div class="row">
                      <div id="dtsPrincipales" class="col-md-4 hidden">
                        <div class="row">
                          <div class="col-md-5">
                            <label>Forma de Pago</label>
                            <label class="custom-control custom-radio">
                              <input type="radio" name="formaPago" value="E" class="custom-control-input">
                              <span class="custom-control-indicator">Efectivo</span>
                            </label><br>
                            <label class="custom-control custom-radio">
                              <input type="radio" name="formaPago" value="T" class="custom-control-input">
                              <span class="custom-control-indicator">Tarjeta</span>
                            </label><br>
                            <label class="custom-control custom-radio">
                              <input type="radio" name="formaPago" value="CH" class="custom-control-input">
                              <span class="custom-control-indicator">Transaccion</span>
                            </label><br>
                            <label class="custom-control custom-radio">
                              <input type="radio" name="formaPago" value="CR" class="custom-control-input">
                              <span class="custom-control-indicator">Credito</span>
                            </label><br>
                            <!-- <div class="form-group">
                              <label for="formaPago">Forma de Pago</label>
                              <select  name="formaPago" id="formaPago" class="form-control">
                                <option value="" disabled selected>Seleccione Forma de Pago...</option>
                                <option value="E">Efectivo</option>
                                <option value="T">Tarjeta</option>
                                <option value="ET">E/T</option>
                                <option value="CH">Cheque</option>
                                <option value="CR">Credito</option>
                              </select>
                            </div> -->
                          </div>
                          <div class="col-md-7">
                            <div class="form-group">
                              <label for="comprobante">Comprobante</label><br>
                              <label class="custom-control custom-radio">
                                <input type="radio" name="comprobante" value="T" class="custom-control-input">
                                <span class="custom-control-indicator">Ticket</span>
                              </label><br>
                              <label class="custom-control custom-radio">
                                <input type="radio" name="comprobante" value="FCF" class="custom-control-input">
                                <span class="custom-control-indicator">Factura Comsumidor Final</span>
                              </label><br>
                              <label class="custom-control custom-radio">
                                <input type="radio" name="comprobante" value="CCF" class="custom-control-input">
                                <span class="custom-control-indicator">Comprobante Credito Fiscal</span>
                              </label><br>
                              <!-- <select  name="comprobante" id="comprobante" class="form-control">
                                <option value="" disabled selected>Seleccione Tipo Comprobate...</option>
                                <option value="T" data-subtext="(T)">Ticket</option>
                                <option value="FCF" data-subtext="(FCF)">Factura Comsumidor Final</option>
                                <option value="CCF" data-subtext="(CCF)">Comprobante Credito Fiscal</option>
                              </select> -->
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-check">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="chkFacturaConsumo" id="chkFacturaConsumo" value="1">
                                 Factura por Consumo
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div id="dtsSecundario" class="col-md-8">
                        <div class="row">
                          <div class="col-md-3">
                            <label id="lblnrocomprobante">  Nro Comprobante </label>
                            <input  class="form-control" name="nrocomprobanteC" id="nrocomprobanteC" placeholder="Nro Comprobante" autocomplete="off" >
                            <input  class="form-control" name="nrocomprobante" id="nrocomprobante" placeholder="Nro Comprobante" autocomplete="off" >
                          </div>
                          <div class="col-md-3">
                            <label id="lblBuscar" hidden>  Buscar cliente o<a href="cliente">&nbsp; registrar </a></label>
                              <input class="form-control" name="Buscar" id="Buscar" placeholder="Buscar por NRC" autocomplete="off" >
                            </div>
                            <div class="col-md-3">
                              <label id="lblNRC" hidden>  NRC </label>
                              <input class="form-control" name="NRC" id="NRC" placeholder="NRC" autocomplete="off" required  disabled>
                            </div>
                            <div class="col-md-3">
                              <label id="lblNIT" hidden>  NIT </label>
                              <input class="form-control" name="NIT" id="NIT" placeholder="NIT" autocomplete="off" required  disabled>
                            </div>
                            <div class="col-md-6">
                              <label id="lblCliente">  Cliente </label>
                              <input class="form-control" name="Cliente" id="Cliente" placeholder="Cliente" autocomplete="off">
                            </div>
                            <div class="col-md-6">
                              <label id="lblDepartamento" hidden>  Departamento </label>
                              <input class="form-control" name="Departamento" id="Departamento" placeholder="Departamento" autocomplete="off" required  disabled>
                            </div>
                            <div class="col-md-9">
                              <label id="lblDireccion" hidden>  Direccion </label>
                              <input class="form-control" name="Direccion" id="Direccion" placeholder="Direccion" autocomplete="off" required  disabled>
                            </div>
                            <div class="col-md-3">
                              <label id="lblMunicipio" hidden>  Municipio </label>
                              <input class="form-control" name="Municipio" id="Municipio" placeholder="Municipio" autocomplete="off" required  disabled>
                            </div>
                            <div class="col-md-12">
                              <label id="lblGiro" hidden>  Giro </label>
                              <input class="form-control" name="Giro" id="Giro" placeholder="Giro" autocomplete="off" required  disabled>
                            </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="box box-primary">
                <div class="box-header"><h3 class="box-title">Total Comprobante</h3></div>
                <div class="box-body">
                    <div class="row">
                      <div class="col-md-6 col-md-offset-3">
                        <form id="FrmTotales">
                          <label>  Importe </label>
                          <input class="form-control" name="Importe" id="Importe" placeholder="Ingrese importe" autocomplete="off" required>
                          <input type="hidden" class="form-control Sumar" name="ImporteE" id="ImporteE" placeholder="Ingrese Importe Efectivo" autocomplete="off">
                          <input type="hidden" class="form-control Sumar" name="ImporteT" id="ImporteT" placeholder="Ingrese Importe de Tarjeta" autocomplete="off">
                          <label id="lblIva">  Iva </label>
                          <input class="form-control" name="Iva" id="Iva" placeholder="Iva" autocomplete="off"  value ="0.00" readonly>

                          <label>  Propina </label>
                          <input class="form-control" name="Propina" id="Propina" placeholder="Propina" autocomplete="off"  readonly value ="0.00">
                          <label>  Exentos </label>
                          <input class="form-control" name="Exentos" id="Exentos" placeholder="Exentos" autocomplete="off"  readonly value ="0.00">
                          <label>  Retencion </label>
                          <input class="form-control" name="Retencion" id="Retencion" placeholder="Exentos" autocomplete="off"  readonly value ="0.00">
                          <label>  Total a cobrar </label>
                          <input class="form-control" name="TotalPagar" id="TotalPagar" placeholder="Total a cobrar" autocomplete="off" required readonly value ="0.00">
                          <label>  Vuelto </label>
                          <input class="form-control" name="vuelto" id="vuelto" placeholder="Vuelto" autocomplete="off" required readonly value=""><br>
                          <button type="button" id="submitRegistrar" class="btn btn-primary" onclick="pagarFinal()" disabled readonly>Registrar</button>
                        </form>
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        <?php
          }
        ?>
      </section>
    </div>
  </div>
</body>
<div class="modal fade" id="MdlDescCarg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title" id="myModalLabel">Descuento / Gargo</h3>
      </div>
      <div class="panel-body">
        <form id="FrmDescCarg" action="javascript: AddDescCargo()">
          <span id="msmAlert"></span>
          <div class="form-group">
            <label for="">Accion</label>
            <select class="form-control" name="AccionSle" id="AccionSle" required>
              <option value="" selected disabled>Seleccione...</option>
              <option value="AD">Agregar Descuento</option>
              <option value="AC">Agregar Cargo</option>
              <option value="DD">Elimnar Descuento</option>
              <option value="DC">Eliminar Cargo</option>
            </select>
          </div>
          <div class="form-group">
            <label for="">Porcentaje</label>
            <input
              class="form-control" type="number" name="InputPorcentaje" id="InputPorcentaje" aria-describedby="helpId" min="1" max="100"  data-monto="0" placeholder="Porcentaje" autocomplete="off" required>
          </div>
          <button type="submit" class="btn btn-primary btn-lg btn-block">Agregar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  var TblPedido = '';
  var DetallePedido = '';
  $(document).ready(function() {
    // $('#formaPago').selectpicker();
    getPedido();
    TblPedido = $("#TablaPedidos").DataTable({
      "ordering": false,
      "info":     true,
      "bFilter": true,
			"language": {
        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
      }
    });
    DetallePedido = $("#DetallePedido").DataTable({
      "ordering": false,
      "info":     false,
      "bFilter": false,
      "paging":   true,
			"language": {
        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
      }
    });

		$('#nrocomprobante').hide();
    OcultarCCF()

  })
  function getPedido(){
	  var Accion = "Yes";
	  $.ajax({
		  url: "controllers/Ajax/AjaxPedido.php",
		  method:"POST",
      data:{ AccionAjax:Accion },
		  dataType: 'json',
		  success: function(datas){
        TblPedido.clear().draw();
        datas.forEach(data => {
          var ReAbrir = `<form name="form1" method="post" action="">
            <input type="hidden" name="idA" value="CAJA">
            <input type="hidden" name="idPedidoRE" value = "${data.idpedido}">
            <input type="hidden" name="mesaReapertura" value="${data.nromesa}">
            <button type="submit" class="btn btn-warning btn-block"><i class="fa fa-folder-open-o fa-2x"></i></button>
          </form>`;

          TblPedido.row.add([
            data.idpedido,
            data.nromesa,
            data.mesero,
            data.total,
            data.Cliente,
            '<button id="BtnDescCargo" type="button" data-toggle="modal" class="btn btn-success btn-block" data-target="#MdlDescCarg"><i class="fa fa-percent fa-2x"></i></button>'
					]).draw(false);
        });
      },
      complete: function(c) {
        setTimeout(() => {
          getPedido();
        }, 1000);
      }
    })
  }
  var infoMesa = '';
  $('#TablaPedidos').on('click', 'tr', function () {
    const data = TblPedido.row(this).data();
    if (!data) {
      return;
    }

    var getIva = false;
    infoMesa = data;
    if ($('input:radio[name=comprobante]:checked').val() === 'CCF') {
      getIva = true;
    }
    $('#InputPorcentaje').attr('data-monto', data[3]);

    loadDetallePedido(data[0], getIva)
  });


  function loadDetallePedido(IdPedido, accion) {
    $.ajax({
      url:"controllers/Ajax/AjaxDetallePedido.php",
      method:"POST",
      data:{idPedidoA:IdPedido},
      dataType:"json",
      success:function(resp)
      {
        if (resp.Existe != 'No') {
          $('input[name=nrocomprobanteC]').val(resp.Existe[0]['NumeroDoc']);
        }

        DetallePedido.clear().draw();
        // console.log(totales);

        var subtotal = 0;
        resp['DetallePedido'].forEach(plato => {
          var precio = plato.precio;
          var total = plato.total;
          if (accion) {
            precio = parseFloat(precio / 1.13).toFixed(3);
            total = parseFloat(total / 1.13).toFixed(2);
            if (plato.IdItem == "209") {
              total = 0 - total;
            }
            // console.log(total);
            subtotal += parseFloat(total);
          }else{
            if (plato.IdItem == "209") {
              total = 0 - total;
            }
            subtotal += parseFloat(total);
          }

          DetallePedido.row.add([
            plato.cantidad,
            plato.descripcion,
            precio,
            total
					]).draw(false);
        });

        if (accion) {
          var iva = parseFloat(subtotal) * 0.13
          $('input[name=Iva]').val(parseFloat(iva).toFixed(2))

          DetallePedido.row.add([
            '',
            '',
            'Suma',
            parseFloat(subtotal).toFixed(2)
          ]).draw(false);

          DetallePedido.row.add([
            '',
            '',
            'Iva',
            parseFloat(iva).toFixed(2)
          ]).draw(false);

          DetallePedido.row.add([
            '',
            '',
            'Subtotal',
            parseFloat(iva + subtotal).toFixed(2)
          ]).draw(false);
        }else{
          DetallePedido.row.add([
            '',
            '',
            'Subtotal',
            parseFloat(subtotal).toFixed(2)
          ]).draw(false);
        }



        $('input[name=idPedido]').val(IdPedido);
        var totales = resp['Totales'];

        $('input[name=Propina]').val(parseFloat(totales.Propina).toFixed(2))
        $('input[name=Exentos]').val(parseFloat(totales.Exentos).toFixed(2))
        $('input[name=Retencion]').val(parseFloat(totales.Retencion).toFixed(2))
        var Total = parseFloat(totales.Subtotal) + parseFloat(totales.Propina) - parseFloat(totales.Exentos) -  parseFloat(totales.Retencion);
        $('input[name=TotalPagar]').val(parseFloat(Total).toFixed(2))


        $('#dtsPrincipales').removeClass('hidden');
        $('#Importe').val('');
        $('#submitRegistrar').prop('disabled', true);
      }
    });
  }




  $('input:radio[name=comprobante]').change(()=>{
    const comprobante = $('input:radio[name=comprobante]:checked');
    // console.log(comprobante.val());

    if (comprobante.val() === "T") {
      $.ajax({
        url:"controllers/Ajax/AjaxUltimosNrosComprobante.php",
        method:"POST",
        data:{ticket:'ticket'},
        dataType: 'json',
        success:function(resp){
          $("#nrocomprobanteC").val(resp['ComprobanteC']);
          $("#nrocomprobante").val(resp['Comprobante']);
          $("#nrocomprobanteC").prop('readonly', true);
          loadDetallePedido($('input[name=idPedido]').val(), false)
          OcultarCCF();
        }
      });
      $('#chkFacturaConsumo').prop('checked', false);
      $('#chkFacturaConsumo').prop('disabled', true);

    }else if (comprobante.val() === "FCF") {
      $("#nrocomprobante").val("");
      $("#nrocomprobanteC").val("");
      $("#nrocomprobanteC").prop('readonly', false);
      loadDetallePedido($('input[name=idPedido]').val(), false)
      $('#chkFacturaConsumo').prop('disabled', false);

      OcultarCCF();
    }else if(comprobante.val() === "CCF"){
      $("#nrocomprobante").val("");
      $("#nrocomprobanteC").val("");
      $("#nrocomprobanteC").prop('readonly', false);
      $('#chkFacturaConsumo').prop('disabled', false);
      loadDetallePedido($('input[name=idPedido]').val(), true)
      MostratCFF();
    }
  })

  function MostratCFF() {
    $('#lblBuscar').toggle();
    $('#Buscar').show();
    $('#lblNRC').toggle();
    $('#NRC').show();
    $('#lblNIT').toggle();
    $('#NIT').show();
    $('#lblDepartamento').toggle();
    $('#Departamento').show();
    $('#lblDireccion').toggle();
    $('#Direccion').show();
    $('#lblMunicipio').toggle();
    $('#Municipio').show();
    $('#lblGiro').toggle();
    $('#Giro').show();
    // $('#lblIva').show();
    // $('#Iva').show();
    $( "#Cliente" ).prop( "readonly", true );
  }

  function OcultarCCF() {
    $('#lblBuscar').hide();
    $('#Buscar').hide();
    $('#lblNRC').hide();
    $('#NRC').hide();
    $('#lblNIT').hide();
    $('#NIT').hide();
    $('#lblDepartamento').hide();
    $('#Departamento').hide();
    $('#lblDireccion').hide();
    $('#Direccion').hide();
    $('#lblMunicipio').hide();
    $('#Municipio').hide();
    $('#lblGiro').hide();
    $('#Giro').hide();
    $('#lblIva').hide();

    $('#Iva').hide();
    $('#Iva').val((0.00).toFixed(2));
    $( "#Cliente" ).prop( "readonly", false );
  }


  // Buscar cliente
	$("#Buscar").keyup(function(){
	  var Buscar = $(this).val();
	  $.ajax({
	    url:"controllers/Ajax/AjaxBuscarCliente.php",
	    method:"POST",
	    data:{nrcAjax:Buscar},
	    dataType: 'json',
	    success:function(resp){
        const data =  resp[0];
	      // $("#proveedorR").html(html);
        if (resp.length != 0) {
          $("#NRC").val(data.NRC);
          $("#NIT").val(data.NIT);
          $("#Cliente").val(data.Cliente);
          $("#Departamento").val(data.Departamento);
          $("#Direccion").val(data.Direccion);
          $("#Municipio").val(data.Municipio);
          $("#Giro").val(data.Giro);
        }
	    }
	  });
	});

  $('#Importe').keyup(function () {
    if ($('input[name=TotalPagar]').val() < 0 || isNaN($('#Importe').val()) || $('input[name=idPedido]').val() == "0") {
      $('#submitRegistrar').prop('disabled', true);
      return;
    }
    // console.log($('#Importe').val());
    var vuelto  = $('#Importe').val() - $('input[name=TotalPagar]').val();
    // console.log(vuelto);
    if (vuelto < 0) {
      $('#vuelto').val(0.00);
      $('#submitRegistrar').prop('disabled', true);
    }else{
      $('#vuelto').val(vuelto.toFixed(2));
      $('#submitRegistrar').prop('disabled', false);
    }
  })


  var frmPrincipal = $('#FrmPrincipal');
  var frmTotales = $('#FrmTotales');

  function pagarFinal() {
    var info = {};
    frmPrincipal.serializeArray().forEach(input => {
      info[input.name] = input.value;
    });

    frmTotales.serializeArray().forEach(input => {
      info[input.name] = input.value;
    });
    if (info.nrocomprobanteC.trim() == "") {
      alert(`El comprobante es obligatorio`);
      console.error(`El comprobante es obligatorio`);
      return;
    }

    if (info.formaPago.trim() === "") {
      alert(`La forma de pago es obligatorio`);
      console.error(`La forma de pago es obligatorio`);
      return;
    }

    if (info.comprobante.trim() === "") {
      alert(`El comprobante es obligatorio`);
      console.error(`El comprobante es obligatorio`);
      return;
    }


    // console.log(info);

    // frmPrincipal[0].reset();


    $.ajax({
	    url:"controllers/Ajax/AjaxRealizarVenta.php",
	    method:"POST",
	    data:{AccionAjax: 'RealizarVenta', DtsAjax: info},
	    dataType: 'json',
	    success:function(resp){
        pagar()
        swal({
					title: "Registrado",
					text: "Se registro exitosamente",
					type: "success",
					showCancelButton: false,
					confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Ok"
				}).then(function () {
          DetallePedido.clear().draw();
          frmPrincipal[0].reset();
          frmTotales[0].reset();
          pagar();
				});
      }
    });

  }


  function pagar() {

    $( "#TotalPagar" ).prop( "disabled", false );
    var total = infoMesa[3];
    var propina = $( "#Propina" ).val();
    var totalpagar = $( "#TotalPagar" ).val();
    var idPedido = $( "input[name=idPedido]" ).val();
    var nrocomprobanteC = $( "#nrocomprobanteC" ).val();
    var mesero = infoMesa[2];
    var cliente = $( "#Cliente" ).val();
    var nrc = $( "#NRC" ).val();
    var Exentos = $( "#Exentos" ).val();
    var Retencion = $( "#Retencion" ).val();
    var Importe = $("#Importe").val();
    var Tarjeta = $("#ImporteT").val();

    // Ticket
    if($('input:radio[name=comprobante]:checked').val() == 'T') {
      var Ruta = 'controllers/Ajax/AjaxImprimirPDF.php?tipo=t';
      Ruta += '&totalA='+total;
      Ruta += '&propinaA='+propina;
      Ruta += '&totalpagarA='+totalpagar;
      Ruta += '&idPedidoA='+idPedido;
      Ruta += '&nrocomprobanteCA='+nrocomprobanteC;
      Ruta += '&meseroA='+mesero;
      Ruta += '&Exentos='+Exentos;
      Ruta += '&Retencion='+Retencion;
      Ruta += '&Importe='+Importe;
      Ruta += '&Tarjeta='+Tarjeta;
      // console.log(Ruta);

      window.open(Ruta,'_blank');
    } else if($('input:radio[name=comprobante]:checked').val() == 'FCF') {
      // consumidor final
        var consumo = 0;
        if ($('#chkFacturaConsumo').prop('checked')) {
          consumo = 1;
        }
        var Ruta = 'controllers/Ajax/AjaxImprimirPDF.php?tipo=fcf';
        Ruta += '&totalA='+total;
        Ruta += '&propinaA='+propina;
        Ruta += '&totalpagarA='+totalpagar;
        Ruta += '&idPedidoA='+idPedido;
        Ruta += '&nrocomprobanteCA='+nrocomprobanteC;
        Ruta += '&meseroA='+mesero;
        Ruta += '&Acliente='+cliente;
        Ruta += '&Exentos='+Exentos;
        Ruta += '&Retencion='+Retencion;
        Ruta += '&Importe='+Importe;
        Ruta += '&Tarjeta='+Tarjeta;
        Ruta += '&Consumo='+consumo;

        // console.log(Ruta);
        window.open(Ruta,'_blank');
    } else if($('input:radio[name=comprobante]:checked').val() == 'CCF') {
      // Credito Fiscal
      if (nrc == "") {
        swal('Caja', 'Necesita Ingresar el NRC');
      }else{
        var consumo = 0;
        if ($('#chkFacturaConsumo').prop('checked')) {
          consumo = 1;
        }
        var Ruta = 'controllers/Ajax/AjaxImprimirPDF.php?tipo=ccf';
        Ruta += '&totalA='+total;
        Ruta += '&propinaA='+propina;
        Ruta += '&totalpagarA='+totalpagar;
        Ruta += '&idPedidoA='+idPedido;
        Ruta += '&nrocomprobanteCA='+nrocomprobanteC;
        Ruta += '&meseroA='+mesero;
        Ruta += '&Acliente='+cliente;
        Ruta += '&Anrc='+nrc;
        Ruta += '&Retencion='+Retencion;
        Ruta += '&Exentos='+Exentos;
        Ruta += '&Importe='+Importe;
        Ruta += '&Tarjeta='+Tarjeta;
        Ruta += '&Consumo='+consumo;
        // console.log(Ruta);
        window.open(Ruta,'new');
      }
    }
  }

  function AddDescCargo() {

    var Doc = $('input:radio[name=comprobante]:checked').val();
    if(Doc == null){


      var alert = `
      <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
        </button>
        Seleccione un Comprobante
      </div>
      `;
      $('#msmAlert').html(alert);
      setTimeout(() => {
        $('#msmAlert').html('');
      }, 2000 );
      return;
    }
    var Iva =  false;
    if(Doc == "CCF"){
      Iva = true;
    }

    var dtsDescCargo = {
      idPedido: $('input[name=idPedido]').val(),
      accion: $('#AccionSle').val(),
      porcentaje: $('input[name=InputPorcentaje]').val(),
      monto: $('input[name=InputPorcentaje]').data('monto')
    }
    if (dtsDescCargo.accion === "AD" || dtsDescCargo.accion === "DD") {
      dtsDescCargo.idItem = "209";
    }else{
      dtsDescCargo.idItem = "210";
    }

    $.ajax({
	    url:"controllers/Ajax/AjaxRealizarVenta.php",
	    method:"POST",
	    data:{AccionAjax: 'DescuentoCargo', DtsAjax: dtsDescCargo},
	    dataType: 'json',
	    success:function(resp){
        // console.log(resp);
        infoMesa[3] = resp.Infototal;
        loadDetallePedido(resp.idPedido, Iva);
        $('#MdlDescCarg').modal('hide');
      }
    })
  }

</script>
