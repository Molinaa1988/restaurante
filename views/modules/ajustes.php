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
        <div class="col-md-12">    
            <!-- Advanced Tables -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="fa fa-address-card-o" aria-hidden="true"></i>Ajustes de clasificaciones
                </div>
                <div class="panel-body">


               	 <form role="form">
              			<div class="box-body">


					        <div class="col-md-12">
 							    <div class="col-md-6">
                				     <div class="form-group">
                                            <label for="exampleInputPassword1">Codigo</label>
                                            <input type="text" class="form-control" name="fechai" autocomplete="off" required value="" placeholder="Ingrese el codigo">
                			       </div>
							    </div>
							</div>

 							<div class="col-md-12">
 							    <div class="col-md-6">
                				     <div class="form-group">
                                            <label for="exampleInputPassword1">Fecha</label>
                                            <input type="date" class="form-control" name="fechai" autocomplete="off" required value="">
                			       </div>
							    </div>

							     <div class="col-md-6">
                				     <div class="form-group">
                                            <label for="exampleInputPassword1">Categoria</label>
                                            <input type="text" class="form-control" name="fechai" autocomplete="off" required value="">
                			       </div>
							    </div>
							</div>

                        <div class="col-md-12">
							 <div class="col-md-6">
               				   	<div class="form-group">
                                     <label for="exampleInputEmail1">Codigo de grupo</label>
                                     <input type="text" class="form-control" id="exampleInputEmail1">
                                </div>
							</div>

 				            <div class="col-md-6">
               				   <div class="form-group">
                                       	
                                        <label for="exampleInputPassword1">Codigo de tela</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1">
                			
                			   </div>
							</div>
						</div>

	                     <div class="col-md-12">
 							<div class="col-md-6">
                				 <div class="form-group">
                                        <label for="exampleInputPassword1">Codigo de producto</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1">
                			   </div>
							</div>
	                        <div class="col-md-6">
                				 <div class="form-group">
                                        <label for="exampleInputPassword1">Defecto</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1">
                			   </div>
							</div>



						</div>
                        <div class="col-md-12">
	                        <div class="col-md-6">
               				   	<div class="form-group">
                                     <label for="exampleInputEmail1">Codigo de talla</label>
                                     <input type="text" class="form-control" id="exampleInputEmail1">
                                </div>
							</div>

 				            <div class="col-md-6">
               				   <div class="form-group">
                                       	
                                        <label for="exampleInputPassword1">Codigo de color</label>
                                         <input type="text" class="form-control" id="exampleInputEmail1">
                			
                			   </div>
							</div>
							</div>

                             <div class="box-footer" align="right">
                                   <button type="submit" class="btn btn-primary">Cancelar</button>
                                   <button type="submit" class="btn btn-primary">Registrar</button>

                                    <br>
                             </div>
              			</div>
            		</form>



                    <div class="col-xs-12">
                        <div class="box box-primary">

                            <div class="box-body table-responsive">
                                <table id="tbl_acciones" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="display:none;">Id</th>
                                            <th>Codigo</th>
                                            <th>Fecha</th>
                                            <th>Categoria</th>
                                            <th>C.Grupo</th>   
                                            <th>C.Tela</th>  
                                            <th>C.Producto</th>  
                                            <th>Defecto</th>  
                                            <th>C.Talla</th>  
                                            <th>C.Color</th>  
                                        </tr>
                                    </thead>
                                    <tbody id="tbl_body_table">

                             
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
           </section>
   </div>





    </section>
  </div>
  <footer class="main-footer">
    <strong>Copyright &copy; 2017 <a href="#">Grupo SJD</a>.</strong> Todos los derechos reservados.
  </footer>
</div>
</body>

