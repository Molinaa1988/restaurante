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





									 <?php
											 if(isset($_POST['fechai'])){
													 $fechai=$_POST['fechai'];
											 }else{
													 $fechai=date('Y-m-d');
											 }
										?>
						<div class="row">
									<!-- <div class="col-md-12">
										<center><button class="btn btn-primary" onclick="reporteElectronico();">Cierre de caja</button><center><br>
											<input type="hidden" name="message" id="message" value="x" autocomplete="off" required>
									</div> -->
						</div>
						 <div hidden="true"> <!-- CON ESTA ETIQUETA OCULTO LOS REPORTES  -->
             <div class="row">
                  <div class="col-md-4">
										<div class="row">
												 <div class="col-md-6">

												<input type="hidden" name="cortex" id="cortex" autocomplete="off" required>
												<button class="btn btn-success" onclick="corteX();">Corte X</button><BR>
												 <!-- <button type="hidden" class="btn btn-success" onclick="Imprimir();">Prueba impresion</button><br>  -->

												<?php

											 function CalcularCeros($numeroDoc)
											{
												if ($numeroDoc == "")
												{
													 $ceros = "0001";
												}
												else if ($numeroDoc >= 0 && $numeroDoc < 10 )
												{
													 $ceros = str_pad($numeroDoc, 4, "000", STR_PAD_LEFT);
												}
												else if ($numeroDoc >= 10 && $numeroDoc < 100)
												{
													$ceros = str_pad($numeroDoc, 4, "00", STR_PAD_LEFT);
												}
												else if ($numeroDoc >= 100 && $numeroDoc < 1000)
												{
													 $ceros = str_pad($numeroDoc, 4, "0", STR_PAD_LEFT);
												}
												else
												{
													$ceros = $numeroDoc;
												}
													return $ceros;
											}

												$DatosCorrelativoTickets = controllerCierre::DatosCorrelativoTickets();
															$ti = $DatosCorrelativoTickets["Menor"];
															$tf	= $DatosCorrelativoTickets["Mayor"] + 1;
															$mayorTicket = CalcularCeros($tf);
												$DatosTotalVentaTickets= controllerCierre::DatosTotalVentaTickets()
															$tTotal = $DatosTotalVentaTickets["Total"];
												$DatosFCF = controllerCierre::DatosFCF();
															$fcfi = $DatosFCF["Menor"];
															$fcff	= $DatosFCF["Mayor"];
															$fcfTtotal = $DatosFCF["Total"];
												$DatosCCF = controllerCierre::DatosCCF();
															$ccfi = $DatosCCF["Menor"];
															$ccff	= $DatosCCF["Mayor"];
															$ccfTtotal = $DatosCCF["Total"];
												$DatosDevolucion = controllerCierre::DatosDevolucion();
															$devolucion= $DatosDevolucion["Total"];
															if ($devolucion == "")
															{
																$devolucion = "0.00";
															}
															else {
																$devolucion;
															}
															$subTotal = $tTotal + $fcfTtotal + $ccfTtotal;
															$Total = ($tTotal + $fcfTtotal + $ccfTtotal) - $devolucion

												?>
												RESUMEN CORTE X <br>
												Ticket
												<input type="hidden" name="corteX" id="corteX" placeholder="ti" value="CORTE X" autocomplete="off">

													<input class="form-control" name="ti" id="ti" placeholder="ti" value="<?php echo $ti; ?>" autocomplete="off">
													<input class="form-control" name="tf" id="tf" placeholder="tf" value="<?php echo $mayorTicket; ?>" autocomplete="off">
													<input class="form-control" name="tTtotal" id="tTtotal" placeholder="tTtotal" value="<?php echo $tTotal ?>" autocomplete="off">
												FCF
													<input class="form-control" name="fcfi" id="fcfi" placeholder="fcfi" value="<?php echo $fcfi  ?>" autocomplete="off">
													<input class="form-control" name="fcff" id="fcff" placeholder="fcff" value="<?php echo $fcff ?>" autocomplete="off">
													<input class="form-control" name="fcfTtotal" id="fcfTtotal" placeholder="fcfTtotal" value="<?php echo $fcfTtotal ?>" autocomplete="off">
												CCF
													<input class="form-control" name="ccfi" id="ccfi" placeholder="ccfi" value="<?php echo $ccfi ?>" autocomplete="off">
													<input class="form-control" name="ccff" id="ccff" placeholder="ccff" value="<?php echo $ccff ?>" autocomplete="off">
													<input class="form-control" name="ccfTtotal" id="ccfTtotal" placeholder="ccfTtotal" value="<?php echo $ccfTtotal ?>" autocomplete="off">
												Devoluciones
													<input class="form-control" name="devolucion" id="devolucion" placeholder="devolucion" value="<?php echo $devolucion ?>" autocomplete="off">
													Sub-Total
														<input class="form-control" name="subTotal" id="subTotal" placeholder="Total" value="<?php echo $subTotal ?>">
												Total
													<input class="form-control" name="Total" id="Total" placeholder="Total" value="<?php echo $Total ?>" autocomplete="off">


													</div>
										<div class="col-md-6">
											<input type="hidden" name="cortez" id="cortez" autocomplete="off" required>
											<button class="btn btn-success" onclick="corteZ();">Corte Z</button><BR>
											 <!-- <button type="hidden" class="btn btn-success" onclick="Imprimir();">Prueba impresion</button><br>  -->

											<?php
											$DatosCorrelativoTickets = controllerCierre::DatosCorrelativoTickets();
														$ti = $DatosCorrelativoTickets["Menor"];
														$tf	= $DatosCorrelativoTickets["Mayor"] + 1;
														$mayorTicket = CalcularCeros($tf);
											$DatosTotalVentaTickets= controllerCierre::DatosTotalVentaTickets();
														$tTotal = $DatosTotalVentaTickets["Total"];
											$DatosFCF = controllerCierre::DatosFCF();
														$fcfi = $DatosFCF["Menor"];
														$fcff	= $DatosFCF["Mayor"];
														$fcfTtotal = $DatosFCF["Total"];
											$DatosCCF = controllerCierre::DatosCCF();
														$ccfi = $DatosCCF["Menor"];
														$ccff	= $DatosCCF["Mayor"];
														$ccfTtotal = $DatosCCF["Total"];
											$DatosDevolucion = controllerCierre::DatosDevolucion();
														$devolucion= $DatosDevolucion["Total"];
														if ($devolucion == "")
														{
															$devolucion = "0.00";
														}
														else {
															$devolucion;
														}
														$subTotal = $tTotal + $fcfTtotal + $ccfTtotal;
														$Total = ($tTotal + $fcfTtotal + $ccfTtotal) - $devolucion;

											?>
											RESUMEN CORTE Z <br>
											Ticket
											<input type="hidden" name="corteZ" id="corteZ" placeholder="ti" value="CORTE Z" autocomplete="off">

												<input class="form-control" name="ti" id="ti" placeholder="ti" value="<?php echo $ti; ?>" autocomplete="off">
												<input class="form-control" name="tf" id="tf" placeholder="tf" value="<?php echo $mayorTicket; ?>" autocomplete="off">
												<input class="form-control" name="tTtotal" id="tTtotal" placeholder="tTtotal" value="<?php echo $tTotal ?>" autocomplete="off">
											FCF
												<input class="form-control" name="fcfi" id="fcfi" placeholder="fcfi" value="<?php echo $fcfi  ?>" autocomplete="off">
												<input class="form-control" name="fcff" id="fcff" placeholder="fcff" value="<?php echo $fcff ?>" autocomplete="off">
												<input class="form-control" name="fcfTtotal" id="fcfTtotal" placeholder="fcfTtotal" value="<?php echo $fcfTtotal ?>" autocomplete="off">
											CCF
												<input class="form-control" name="ccfi" id="ccfi" placeholder="ccfi" value="<?php echo $ccfi ?>" autocomplete="off">
												<input class="form-control" name="ccff" id="ccff" placeholder="ccff" value="<?php echo $ccff ?>" autocomplete="off">
												<input class="form-control" name="ccfTtotal" id="ccfTtotal" placeholder="ccfTtotal" value="<?php echo $ccfTtotal ?>" autocomplete="off">
											Devoluciones
												<input class="form-control" name="devolucion" id="devolucion" placeholder="devolucion" value="<?php echo $devolucion ?>" autocomplete="off">
												Sub-Total
													<input class="form-control" name="subTotal" id="subTotal" placeholder="Total" value="<?php echo $subTotal ?>">
											Total
												<input class="form-control" name="Total" id="Total" placeholder="Total" value="<?php echo $Total ?>" autocomplete="off">
										</div>
									</div>
                  </div>
                  <div class="col-md-4">
											<center><button class="btn btn-success" onclick="corteGZ();">Corte gran Z</button></center>
										<form method="POST">
											<input type="hidden" name="cortegranz" id="cortegranz" value="enviado" autocomplete="off" required>
											<table>
											<thead>

											<th>
													<div class="input-group">
														<span class="input-group-addon">Año</span>
														<select class="form-control" name="anio" autocomplete="off" required>
																<option value="">Seleccione</option>
																<option value="2017">2017</option>
																<option value="2018">2018</option>
																<option value="2019">2019</option>
																<option value="2020">2020</option>
																<option value="2021">2021</option>
																<option value="2022">2022</option>
																<option value="2023">2023</option>
																<option value="2024">2024</option>
																<option value="2025">2025</option>
																<option value="2026">2026</option>
																<option value="2027">2027</option>
																<option value="2028">2028</option>
																<option value="2029">2029</option>
																<option value="2030">2030</option>
															</select>
													</div></th>
											<th><div class="input-group">
												<span class="input-group-addon">Mes</span>
												<select class="form-control" name="mes" autocomplete="off" required>
													  <option value="">Seleccione</option>
														<option value="1">Enero</option>
														<option value="2">Febrero</option>
														<option value="3">Marzo</option>
														<option value="4">Abril</option>
														<option value="5">Mayo</option>
														<option value="6">Junio</option>
														<option value="7">Julio</option>
														<option value="8">Agosto</option>
														<option value="9">Septiembre</option>
														<option value="10">Octubre</option>
														<option value="11">Noviembre</option>
														<option value="12">Diciembre</option>
													</select>
										  </div></th>
												<th><button class="btn btn-success">Buscar</button></th>

										 </table>
											<?php

											$DatosCorrelativoTicketsGranZ = controllerCierre::DatosCorrelativoTicketsGranZ();
														$tiZ = $DatosCorrelativoTicketsGranZ["Menor"];
														$tfZ	= $DatosCorrelativoTicketsGranZ["Mayor"] + 1;
														$mayorTicketZ = CalcularCeros($tfZ);
											$DatosTotalVentaTicketsGranZ= controllerCierre::DatosTotalVentaTicketsGranZ();
														$tTotalZ = $DatosTotalVentaTicketsGranZ["Total"];
											$DatosFCFGranZ = controllerCierre::DatosFCFGranZ();
														$fcfiZ = $DatosFCFGranZ["Menor"];
														$fcffZ	= $DatosFCFGranZ["Mayor"];
														$fcfTtotal = $DatosFCFGranZ["Total"];
											$DatosCCFGranZ = controllerCierre::DatosCCFGranZ();
														$ccfiZ = $DatosCCFGranZ["Menor"];
														$ccffZ	= $DatosCCFGranZ["Mayor"];
														$ccfTotalZ = $DatosCCFGranZ["Total"];
											$DatosDevolucionGranZ = controllerCierre::DatosDevolucionGranZ();
														$devolucionZ = $DatosDevolucionGranZ["Total"];
														if ($devolucionZ == ""){$devolucionZ = "0.00";}else {$devolucionZ;}
											$subTotalZ = $tTotalZ + $fcfTtotal + $ccfTotalZ;
											$TotalZ = ($tTotalZ + $fcfTtotal + $ccfTotalZ) - $devolucionZ
											?>
											RESUMEN CORTE GRAN Z <br>
											Ticket
												<input type="hidden" name="corteGZ" id="corteGZ" placeholder="ti" value="CORTE GRAN Z" autocomplete="off">


											  <input class="form-control" name="ti" id="tiZ" placeholder="tiZ" value="<?php echo $tiZ ?>" autocomplete="off">
												<input class="form-control" name="tf" id="tfZ" placeholder="tfZ" value="<?php echo $mayorTicketZ ?>" autocomplete="off">
												<input class="form-control" name="tTotal" id="tTotalZ" placeholder="tTotalZ" value="<?php echo $tTotalZ ?>" autocomplete="off">
											FCF
												<input class="form-control" name="fcfi" id="fcfiZ" placeholder="fcfiZ" value="<?php echo $fcfiZ  ?>" autocomplete="off">
												<input class="form-control" name="fcff" id="fcffZ" placeholder="fcffZ" value="<?php echo $fcffZ  ?>" autocomplete="off">
												<input class="form-control" name="fcfTotal" id="fcfTotalZ" placeholder="fcfTotalZ" value="<?php echo $fcfTtotal  ?>" autocomplete="off">
											CCF
												<input class="form-control" name="ccfi" id="ccfiZ" placeholder="ccfiZ" value="<?php echo $ccfiZ  ?>" autocomplete="off">
												<input class="form-control" name="ccff" id="ccffZ" placeholder="ccffZ" value="<?php echo $ccffZ  ?>" autocomplete="off">
												<input class="form-control" name="ccfTotal" id="ccfTotalZ" placeholder="ccfTotalZ" value="<?php echo $ccfTotalZ  ?>" autocomplete="off">
											Devoluciones
												<input class="form-control" name="devolucion" id="devolucionZ" placeholder="devolucionZ" value="<?php echo $devolucionZ ?>" autocomplete="off">
											Sub-Total
												<input class="form-control" name="subTotalZ" id="subTotalZ" placeholder="Total" value="<?php echo $subTotalZ ?>" autocomplete="off" >
											Total
												<input class="form-control" name="Total" id="TotalZ" placeholder="Total" value="<?php echo $TotalZ ?>" autocomplete="off" >
											</form>
                  </div>
                  <div class="col-md-4">
										<center><button width="50%" class="btn btn-success" onclick="cintaAuditoria();">Cinta de auditoria<br></button></center>
										<form method="post">

											<table>
											<thead>
										<th>
											<div class="input-group">
												<span class="input-group-addon">Fecha</span>
												<input type="date" class="form-control" name="fecha" id="fecha" autocomplete="off" required>
											</div>
										</th>
										<th>
										<button width="50%" class="btn btn-success">Buscar<br></button>
										</th>
									</table>

									RESUMEN CINTA DE AUDITORIA <br>
									CINTA DE AUDITORIA
										<textarea rows="22" cols="52">

											<?php
											$ListarLeyendaCinta = controllerCierre::ListarLeyendaCinta();
	                   										echo $ListarLeyendaCinta["Restaurante"]. "\n";
											echo $ListarLeyendaCinta["Contribuyente"]. "\n";
											echo $ListarLeyendaCinta["NroDeRegistro"]. "\n";
											echo $ListarLeyendaCinta["Giro"]. "\n";
											echo $ListarLeyendaCinta["Direccion"]. "\n";

											$ListarTicketCinta = controllerCierre::ListarTicketCinta();
											foreach($ListarTicketCinta as $row => $item){
												if ($item["TipoComprobante"] == "T")
											                 { ?>

                RESTAURANTE FUEGOYBRASA
            EDGAR ANTONIO AVILES GONZALEZ
        NRC 257875-6  NIT 1123-250890-103-8
                          GIRO: RESTAURANTES
SEGUNDO DESVIO SANTA MARIA CONTIGUO A GASOLINERA ALBA, SANTA MARIA, USULUTAN
Caja # 1,                                                       Ticket:  <?php echo $item["NumeroDoc"]. "\n";  ?>
========================================
ATENDIO:
CLIENTE:
FECHA:  <?php echo $item["Fecha"]  ?>                                 HORA: <?php echo $item["Hora"]. "\n";  ?>
========================================
DESCRIPCION                             |CANT|  P.U  |  TOTAL
========================================
<?php
$vistaDetallePedidosEnCaja = controllerRealizarVenta::vistaDetallePedidosEnCaja($item["IdPedido"]);
foreach($vistaDetallePedidosEnCaja as $row => $itemPedido){
	$total = $itemPedido["precio"]*$itemPedido["cantidad"];
echo $itemPedido["descripcion"]."              ".$itemPedido["cantidad"]."      ".$itemPedido["precio"]."      ".$english_format_number = number_format($total, 2, '.', ''). "\n";
}
?>
========================================
SUBTOTAL GRAVADO.........$                            <?php echo $item["Total"]. "\n";  ?>
SUBTOTAL EXENTO............$                                 0.00
SUBTOTAL NO SUJETAS.....$                                0.00
        TOTAL...........................$                            <?php echo $item["Total"]. "\n"  ?>
        PROPINA.......................$                              <?php echo $item["Propina"]  ?>

    TOTAL A PAGAR................$                            <?php echo $item["TotalPagar"]  ?>

            G = ART. GRAVADO E = ART.EXENTO
                                  N = NO SUJ
													<?php if ($item["TotalPagar"]>200) {?>
Nombre:________________________________
NIT o DUI:_______________________________
FIRMA:__________________________________
														<?php } ?>
            RESOLUCION No. ASC-15041-011487-2017
                               de fecha 30-08-2017
                    ¡GRACIAS POR SU PREFERENCIA!
                          LO ESPERAMOS PRONTO.
													<?php
												}
												else if ($item["TipoComprobante"] == "DEV")
												{?>
													RESTAURANTE FUEGOYBRASA
											EDGAR ANTONIO AVILES GONZALEZ
									NRC 257875-6  NIT 1123-250890-103-8
																		GIRO: RESTAURANTES
					SEGUNDO DESVIO SANTA MARIA CONTIGUO A GASOLINERA ALBA, SANTA MARIA, USULUTAN
FECHA:  <?php echo $item["Fecha"]  ?>                                 HORA: <?php echo $item["Hora"]. "\n";  ?>
DEVOLUCION,                                                    Ticket:  <?php echo $item["NumeroDoc"]. "\n";  ?>
========================================
DESCRIPCION                             |CANT|  P.U  |  TOTAL
========================================
<?php
$vistaDetallePedidosEnCaja = controllerRealizarVenta::vistaDetallePedidosEnCaja($item["IdPedido"]);
foreach($vistaDetallePedidosEnCaja as $row => $itemPedido){
	$total = $itemPedido["precio"]*$itemPedido["cantidad"];
echo $itemPedido["descripcion"]."              ".$itemPedido["cantidad"]."     -".$itemPedido["precio"]."     -".$english_format_number = number_format($total, 2, '.', '')."G". "\n";
}
?>
========================================
UBTOTAL GRAVADO.........$                           -<?php echo $item["Total"]. "\n";  ?>
SUBTOTAL EXENTO............$                                 0.00
SUBTOTAL NO SUJETAS.....$                                0.00
        TOTAL...........................$                           -<?php echo $item["Total"]. "\n"  ?>
        PROPINA.......................$                             -<?php echo $item["Propina"]  ?>

    TOTAL A PAGAR................$                           -<?php echo $item["TotalPagar"]. "\n"  ?>
		A TIQUETE #:  <?php echo $item["Serie"]. "\n"   ?>
    Nombre:  <?php echo $item["NombreCliente"]. "\n"   ?>
    NIT o DUI: <?php echo $item["Documento"]. "\n"   ?>
    FIRMA: _________________________________
            RESOLUCION No. ASC-15041-011487-2017
                               de fecha 30-08-2017
                    ¡GRACIAS POR SU PREFERENCIA!
                          LO ESPERAMOS PRONTO.

												<?php }
												else if ($item["TipoComprobante"] == "CORTE X")
												{ ?>

		RESTAURANTE FUEGOYBRASA
	  EDGAR ANTONIO AVILES GONZALEZ
	NRC 257875-6  NIT 1123-250890-103-8
			GIRO: RESTAURANTES
SEGUNDO DESVIO SANTA MARIA CONTIGUO A GASOLINERA ALBA, SANTA MARIA, USULUTAN
CORTE X                                                        Ticket:  <?php echo $item["NumeroDoc"]. "\n";  ?>
========================================
CAJA 01
FECHA:  <?php echo $item["Fecha"]  ?>                                 HORA:  <?php echo $item["Hora"]. "\n";  ?>
========================================
TICKET
Inicial                                                                              <?php echo $item["Serie"]. "\n";?>
Final                                                                                <?php echo $item["NumeroDoc"]. "\n";?>
                                                                                     $ <?php echo $item["MontoTicket"]. "\n";?>
CONSUMIDOR FINAL
Inicial                                                                              <?php echo $item["CorrelativoFCF"]. "\n";?>
Final                                                                                <?php echo $item["CorrelativoFCF2"]. "\n";?>
                                                                                     $ <?php echo $item["MontoFCF"]. "\n";?>
CREDITO FISCAL
Inicial                                                                              <?php echo $item["CorrelativoCCF"]. "\n";?>
Final                                                                                <?php echo $item["CorrelativoCCF2"]. "\n";?>
                                                                                     $ <?php echo $item["MontoCCF"]. "\n";?>
========================================
     Dotacion Inicial....$                                                0.00
     Sub Total..............$                                                <?php echo $item["TotalPagar"]. "\n";?>
     Venta Gravada......$                                                <?php echo $item["TotalPagar"]. "\n";?>
     Venta Exenta.........$                                                0.00
     Venta No Sujetas...$                                               0.00
     Menos Devolucion.$                                               <?php echo $item["Propina"]. "\n";?>
     Venta Total.............$                                               <?php echo $item["Total"]. "\n";?>
     Venta Contado.......$                                               <?php echo $item["Total"]. "\n";?>
     Venta Credito..........$                                              0.00

												<?php }
												else if ($item["TipoComprobante"] == "CORTE Z")
												{ ?>

		RESTAURANTE FUEGOYBRASA
	  EDGAR ANTONIO AVILES GONZALEZ
	NRC 257875-6  NIT 1123-250890-103-8
			GIRO: RESTAURANTES
SEGUNDO DESVIO SANTA MARIA CONTIGUO A GASOLINERA ALBA, SANTA MARIA, USULUTAN
CORTE Z                                                        Ticket:  <?php echo $item["NumeroDoc"]. "\n";  ?>
========================================
CAJA 01
FECHA:  <?php echo $item["Fecha"]  ?>                                 HORA:  <?php echo $item["Hora"]. "\n";  ?>
========================================
TICKET
Inicial                                                                              <?php echo $item["Serie"]. "\n";?>
Final                                                                                <?php echo $item["NumeroDoc"]. "\n";?>
                                                                                     $ <?php echo $item["MontoTicket"]. "\n";?>
CONSUMIDOR FINAL
Inicial                                                                              <?php echo $item["CorrelativoFCF"]. "\n";?>
Final                                                                                <?php echo $item["CorrelativoFCF2"]. "\n";?>
                                                                                     $ <?php echo $item["MontoFCF"]. "\n";?>
CREDITO FISCAL
Inicial                                                                              <?php echo $item["CorrelativoCCF"]. "\n";?>
Final                                                                                <?php echo $item["CorrelativoCCF2"]. "\n";?>
                                                                                     $ <?php echo $item["MontoCCF"]. "\n";?>
========================================
     Dotacion Inicial....$                                                0.00
     Sub Total..............$                                                <?php echo $item["TotalPagar"]. "\n";?>
     Venta Gravada......$                                                <?php echo $item["TotalPagar"]. "\n";?>
     Venta Exenta.........$                                                0.00
     Venta No Sujetas...$                                               0.00
     Menos Devolucion.$                                               <?php echo $item["Propina"]. "\n";?>
     Venta Total.............$                                               <?php echo $item["Total"]. "\n";?>
     Venta Contado.......$                                               <?php echo $item["Total"]. "\n";?>
     Venta Credito..........$                                              0.00

												<?php }
												else if ($item["TipoComprobante"] == "CORTE GRAN Z")
												{ ?>


		RESTAURANTE FUEGOYBRASA
	  EDGAR ANTONIO AVILES GONZALEZ
	NRC 257875-6  NIT 1123-250890-103-8
			GIRO: RESTAURANTES
SEGUNDO DESVIO SANTA MARIA CONTIGUO A GASOLINERA ALBA, SANTA MARIA, USULUTAN
CORTE GRAN Z                                           Ticket:  <?php echo $item["NumeroDoc"]. "\n";  ?>
========================================
CAJA 01
FECHA:  <?php echo $item["Fecha"]  ?>                                 HORA:  <?php echo $item["Hora"]. "\n";  ?>
========================================
TICKET
Inicial                                                                              <?php echo $item["Serie"]. "\n";?>
Final                                                                                <?php echo $item["NumeroDoc"]. "\n";?>
                                                                                     $ <?php echo $item["MontoTicket"]. "\n";?>
CONSUMIDOR FINAL
Inicial                                                                              <?php echo $item["CorrelativoFCF"]. "\n";?>
Final                                                                                <?php echo $item["CorrelativoFCF2"]. "\n";?>
                                                                                     $ <?php echo $item["MontoFCF"]. "\n";?>
CREDITO FISCAL
Inicial                                                                              <?php echo $item["CorrelativoCCF"]. "\n";?>
Final                                                                                <?php echo $item["CorrelativoCCF2"]. "\n";?>
                                                                                     $ <?php echo $item["MontoCCF"]. "\n";?>
========================================
Dotacion Inicial....$                                                0.00
Sub Total..............$                                                <?php echo $item["TotalPagar"]. "\n";?>
Venta Gravada......$                                                <?php echo $item["TotalPagar"]. "\n";?>
Venta Exenta.........$                                                0.00
Venta No Sujetas...$                                               0.00
Menos Devolucion.$                                               <?php echo $item["Propina"]. "\n";?>
Venta Total.............$                                               <?php echo $item["Total"]. "\n";?>
Venta Contado.......$                                               <?php echo $item["Total"]. "\n";?>
Venta Credito..........$                                              0.00
												<?php }

											}
											$ListarLeyendaCinta = controllerCierre::ListarLeyendaCinta();
																				echo $ListarLeyendaCinta["Restaurante"]. "\n";
											echo $ListarLeyendaCinta["Contribuyente"]. "\n";
											echo $ListarLeyendaCinta["NroDeRegistro"]. "\n";
											echo $ListarLeyendaCinta["Giro"]. "\n";
											echo $ListarLeyendaCinta["Direccion"]. "\n";
							 ?>


										</textarea>
										<?php
										if(isset($item["TipoComprobante"]))
										{
											$cinta = $item["TipoComprobante"];
										}
										else
										{
											$cinta = "";
										}
										 ?>
										<input type="hidden" name="cinta" id="cinta" value="<?php echo $cinta ?>" autocomplete="off" >
										</form>
                  </div>
              </div>
						</div>

<!-- BOTONES -->

<script>


// document.getElementById("aperturaBtnDesabilitado").style.visibility = "hidden";
// document.getElementById("123").style.visibility = "hidden";



</script>

			 <br>

<div class="row">

<!-- HABILITADO APERTURA -->
<div id="btn1"  onclick="reporteElectronico();" class="col-lg-4 col-xs-6">
	<div id="aperturaBtnHabilitado" class="small-box bg-aqua">
		<div class="inner">
			<h3>Aperturar nueva  </h3>
			<p>Caja de fecha <?php echo date('Y-m-d') ?></p>
		</div>
		<div class="icon">
			<i class="fa fa-arrow-circle-up"></i>
		</div>
		<a href="#" class="small-box-footer">
 			<i class="fa fa-arrow-circle-right"></i>
		</a>
	</div>
</div>

<!-- DESABILITADO APERTURA -->
<div id="btn1.1" hidden class="col-lg-4 col-xs-6">
	<div id="aperturaBtnDesabilitado" class="small-box bg-gray">
		<div class="inner">
			<h3>Aperturar nueva  </h3>
			<p>Caja de fecha <?php echo date('Y-m-d') ?></p>
		</div>
		<div class="icon">
			<i class="fa fa-arrow-circle-up"></i>
		</div>
		<a href="#" class="small-box-footer">
 			<i class="fa fa-arrow-circle-right"></i>
		</a>
	</div>
</div>


<!-- HABILITADO REAPERTURA -->
<div id="btn2" hidden onclick="prueba();" class="col-lg-4 col-xs-6">
	<div id="reaperturaBtnHabilitado" class="small-box bg-green">
		<div class="inner">
			<h3>Reaperturar caja</h3>
			<p> De fecha <?php echo date('Y-m-d') ?></p>
		</div>
		<div class="icon">
			<i class="fa fa-refresh"></i>
		</div>
		<a href="#" class="small-box-footer">
 			<i class="fa fa-arrow-circle-right"></i>
		</a>
	</div>
</div>

<!-- DESABILITADO REAPERTURA -->
<div id="btn2.2"   class="col-lg-4 col-xs-6">
	<div id="reaperturaBtnDesabilitado" class="small-box bg-gray">
		<div class="inner">
			<h3>Reaperturar caja</h3>
			<p> De fecha <?php echo date('Y-m-d') ?></p>
		</div>
		<div class="icon">
			<i class="fa fa-refresh"></i>
		</div>
		<a href="#" class="small-box-footer">
 			<i class="fa fa-arrow-circle-right"></i>
		</a>
	</div>
</div>

<!-- HABILITADO CERRAR CAJA -->
<div id="btn3" hidden onclick="reporteElectronico();" class="col-lg-4 col-xs-6">
	<div class="small-box bg-yellow">
		<div class="inner">
			<h3>Cerrar caja</h3>
			<p>De fecha <?php echo date('Y-m-d') ?></p>
		</div>
		<div class="icon">
			<i class="fa fa fa-lock"></i>
		</div>
		<a href="ReporteVentasporDia" class="small-box-footer">
 			<i class="fa fa-arrow-circle-right"></i>
		</a>
	</div>
</div>

<!-- DESABILITADO CERRAR CAJA -->
<div id="btn3" class="col-lg-4 col-xs-6">
	<div class="small-box bg-gray">
		<div class="inner">
			<h3>Cerrar caja</h3>
			<p>De fecha <?php echo date('Y-m-d') ?></p>
		</div>
		<div class="icon">
			<i class="fa fa fa-lock"></i>
		</div>
		<a href="ReporteVentasporDia" class="small-box-footer">
 			<i class="fa fa-arrow-circle-right"></i>
		</a>
	</div>
</div>

		</div>



<!-- FIN DE BOTONES  -->




        </section>
      </div>
		</div>

		<div class="modal fade" id="AperturaNueva" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="SepCuentaModal">
		  	<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="gridSystemModalLabel"><span>Apertura Nueva</span></h4>
					</div>
					<div class="modal-body">
						<!-- <div class="container"> -->
							<div class="row">

							</div>
						<!-- </div> -->
					</div>
				</div>
			</div>
		</div>




			 <script>

			 window.onload = function() {
			 	 // document.getElementById("123").style.visibility = "hidden";
			 };




			 document.getElementById("btn1").style.cursor = "pointer";
			 document.getElementById("btn2").style.cursor = "pointer";
			 document.getElementById("btn3").style.cursor = "pointer";



			 function prueba() {
				 // alert("Hello! I am an alert box!!");
				 document.getElementById("btn1").style.display = "none";
	 		}


			 var conn = true;
			 $(document).ready(function() {
	   			checkConnection();

	   function checkConnection() {
			 if(navigator.onLine){
				 conn = true;
	 // alert('Online');
	 			} else {
		 	 		conn = false;
	 // alert('Offline');
	 			}
	   }
	 })

	 function corteX() {
		 swal({
			 title: "Corte",
			 text: "Desea emitir el corte?",
			 type: "question",
			 showCancelButton: true,
			 confirmButtonColor: "#3085d6",
			 cancelButtonColor: "#d33",
			 confirmButtonText: "Emitir",
		 }).then(function () {
			 if ($("#Total").val()==0)
			 {
				 swal(
					 'Error',
					 'No existe ningun dato para emitir',
					 'error'
				 )
			 }
			 else {
				 var ti = $("#ti").val();
				 var tf = $("#tf").val();
				 var Total = $("#Total").val();
				 var subTotal = $("#subTotal").val();
				 var corte = $("#corteX").val();
				 var devolucion = $("#devolucion").val();
				 var tTtotal = $("#tTtotal").val();
				 var fcfi = $("#fcfi").val();
				 var fcff = $("#fcff").val();
				 var fcfTtotal = $("#fcfTtotal").val();
				 var ccfi = $("#ccfi").val();
				 var ccff = $("#ccff").val();
				 var ccfTtotal = $("#ccfTtotal").val();
				 $.ajax({
					 url:"controllers/Ajax/AjaxCierre.php",
					 method:"POST",
					 data: {ti: ti, tf: tf, Total: Total, subTotal: subTotal, corte: corte, devolucion: devolucion, tTtotal: tTtotal, fcfi: fcfi, fcff: fcff, fcfTtotal: fcfTtotal, ccfi: ccfi, ccff: ccff, ccfTtotal: ccfTtotal},
					 dataType: 'text',
					 success:function(html)
					 {
						 swal({
							 title: "Emitido",
							 text: "Sea a emitido el corte",
							 type: "success",
							 showCancelButton: false,
							 confirmButtonColor: "#3085d6",
							 cancelButtonColor: "#d33",
							 confirmButtonText: "Ok",
						 }).then(function () {
							 location = location;
								});
					 }
				 });
			 }
		});
	}
	function corteZ() {
		swal({
			title: "Corte",
			text: "Desea emitir el corte?",
			type: "question",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Emitir",
		}).then(function () {
			if ($("#Total").val()==0)
			{
				swal(
					'Error',
					'No existe ningun dato para emitir',
					'error'
				)
			}
			else {
				var ti = $("#ti").val();
				var tf = $("#tf").val();
				var Total = $("#Total").val();
				var subTotal = $("#subTotal").val();
				var corte = $("#corteZ").val();
				var devolucion = $("#devolucion").val();
				var tTtotal = $("#tTtotal").val();
				var fcfi = $("#fcfi").val();
				var fcff = $("#fcff").val();
				var fcfTtotal = $("#fcfTtotal").val();
				var ccfi = $("#ccfi").val();
				var ccff = $("#ccff").val();
				var ccfTtotal = $("#ccfTtotal").val();
				$.ajax({
					url:"controllers/Ajax/AjaxCierre.php",
					method:"POST",
					data: {ti: ti, tf: tf, Total: Total, subTotal: subTotal, corte: corte, devolucion: devolucion, tTtotal: tTtotal, fcfi: fcfi, fcff: fcff, fcfTtotal: fcfTtotal, ccfi: ccfi, ccff: ccff, ccfTtotal: ccfTtotal},
					dataType: 'text',
					success:function(html)
					{
						swal({
							title: "Emitido",
							text: "Sea a emitido el corte",
							type: "success",
							showCancelButton: false,
							confirmButtonColor: "#3085d6",
							cancelButtonColor: "#d33",
							confirmButtonText: "Ok",
						}).then(function () {
							location = location;
							 });
					}
				});
			}
	 });
	}

	function corteZcierre() {
		var ti = $("#ti").val();
		var tf = $("#tf").val();
		var Total = $("#Total").val();
		var subTotal = $("#subTotal").val();
		var corte = $("#corteZ").val();
		var devolucion = $("#devolucion").val();
		var tTtotal = $("#tTtotal").val();
		var fcfi = $("#fcfi").val();
		var fcff = $("#fcff").val();
		var fcfTtotal = $("#fcfTtotal").val();
		var ccfi = $("#ccfi").val();
		var ccff = $("#ccff").val();
		var ccfTtotal = $("#ccfTtotal").val();
		$.ajax({
			url:"controllers/Ajax/AjaxCierre.php",
			method:"POST",
			data: {ti: ti, tf: tf, Total: Total, subTotal: subTotal, corte: corte, devolucion: devolucion, tTtotal: tTtotal, fcfi: fcfi, fcff: fcff, fcfTtotal: fcfTtotal, ccfi: ccfi, ccff: ccff, ccfTtotal: ccfTtotal},
			dataType: 'text',
			success:function(html)
			{
				swal({
					title: "Emitido",
					text: "Sea a emitido el corte",
					type: "success",
					showCancelButton: false,
					confirmButtonColor: "#3085d6",
					cancelButtonColor: "#d33",
					confirmButtonText: "Ok",
				}).then(function () {
					location = location;
					 });
			}
		});
	}

 		function corteGZ() {
	 swal({
		 title: "Corte",
		 text: "Desea emitir el corte?",
		 type: "question",
		 showCancelButton: true,
		 confirmButtonColor: "#3085d6",
		 cancelButtonColor: "#d33",
		 confirmButtonText: "Emitir",
	 }).then(function () {
		 if ($("#TotalZ").val()==0)
		 {
			 swal(
				 'Error',
				 'No existe ningun dato para emitir',
				 'error'
			 )
		 }
		 else {
			 var ti = $("#tiZ").val();
			 var tf = $("#tfZ").val();
			 var Total = $("#TotalZ").val();
			 var subTotal = $("#subTotalZ").val();
			 var corte = $("#corteGZ").val();
			 var devolucion = $("#devolucionZ").val();
			 var tTtotal = $("#tTotalZ").val();
			 var fcfi = $("#fcfiZ").val();
			 var fcff = $("#fcffZ").val();
			 var fcfTtotal = $("#fcfTotalZ").val();
			 var ccfi = $("#ccfiZ").val();
			 var ccff = $("#ccffZ").val();
			 var ccfTtotal = $("#ccfTotalZ").val();
			 $.ajax({
				 url:"controllers/Ajax/AjaxCierre.php",
				 method:"POST",
				 data: {ti: ti, tf: tf, Total: Total, subTotal: subTotal, corte: corte, devolucion: devolucion, tTtotal: tTtotal, fcfi: fcfi, fcff: fcff, fcfTtotal: fcfTtotal, ccfi: ccfi, ccff: ccff, ccfTtotal: ccfTtotal},
				 dataType: 'text',
				 success:function(html)
				 {
					 swal({
						 title: "Emitido",
						 text: "Sea a emitido el corte",
						 type: "success",
						 showCancelButton: false,
						 confirmButtonColor: "#3085d6",
						 cancelButtonColor: "#d33",
						 confirmButtonText: "Ok",
					 }).then(function () {
						 location = location;
							});
				 }
			 });
		 }
	});
	}


	function cintaAuditoria() {
		swal({
			title: "Cinta de auditorial",
			text: "Desea emitir la cinta de auditoria?",
			type: "question",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Emitir",
		}).then(function () {
			if ($("#cinta").val()=="")
			{
				swal(
					'Error',
					'No existe ningun dato para emitir',
					'error'
				)
			}
			else {
				var fecha = $("#fecha").val();
				$.ajax({
					url:"controllers/Ajax/AjaxCierre.php",
					method:"POST",
					data: {fecha: fecha},
					dataType: 'text',
					success:function(html)
					{
						swal({
							title: "Emitido",
							text: "Sea a emitido la cinta de Auditoria",
							type: "success",
							showCancelButton: false,
							confirmButtonColor: "#3085d6",
							cancelButtonColor: "#d33",
							confirmButtonText: "Ok",
						}).then(function () {
							location = location;
							 });
					}
				});
			}
	 });
 }

			 function reporteElectronico() {

				 <?php
				 $cantidadCuentas = 0;
				 $respuesta = modelRealizarVenta::conteoDeMesasPendientes();
				 foreach($respuesta as $row => $item){
				 		 $cantidadCuentas++;
				 	 }
				  ?>
					var cantidadCuentas = <?php //echo $cantidadCuentas ?>;
				 swal({
			     title: "Cierre de caja",
			     text: "Desea hacer el corte del dia?",
			     type: "question",
			     showCancelButton: true,
			     confirmButtonColor: "#3085d6",
			     cancelButtonColor: "#d33",
			     confirmButtonText: "Cerrar",
				 }).then(function () {
					 if(cantidadCuentas == 0){
						 reporteElectronicoAjax();
						 corteZcierre();
					 }
					 else {
						 swal(
							 'Error',
							 'Falta cuentas que cancelar',
							 'error'
						 )
						 var alerta = 'si';
						 $.ajax({
							 method:"POST",
							 data:{cierreAlerta:alerta},
							 url:"controllers/Ajax/AjaxCierre.php",
							 dataType:"text",
							 success:function(html)
							 {
							 }
						 });
					 }
		 		});
			}

			  function reporteElectronicoAjax() {
						var mensaje = $("#message").val();
					$.ajax({
						method:"POST",
						data:{mensajeAjax:mensaje},
			      url:"controllers/Ajax/AjaxCierre.php",
			      dataType:"text",
			      success:function(html)
			      {
if(conn)
{
	swal(
		'Enviado',
		'Se envio el reporte exitosamente',
		'success'
	)
}
else {
	swal(
		'Error',
		'No se pudo enviar el reporte por falta de internet',
		'error'
	)
}
						 }
			    });

				}



			 </script>
