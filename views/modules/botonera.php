
  <aside class="main-sidebar">
    <section class="sidebar">

      <div class="user-panel">
        <div class="pull-left image">
          <?php
           if ($_SESSION["puesto"] == "1"){
           echo '<img src="views/dist/img/logo.png" class="img-circle" alt="User Image"/>';
         } else if($_SESSION["puesto"] == "6"){
            echo '<img src="views/dist/img/cajera.png" class="img-circle" alt="User Image">';
          }else { echo '<img src="views/dist/img/mesero.png" class="img-circle" alt="User Image">'; }
       ?>
        </div>
        <div class="pull-left info">
          <p><?php echo $_SESSION['usuario']; ?></p>
          <?php
             $estadoCaja = controllerCaja::ultimoIdCajaCajaChica();
              $estadoCaja["IdFcaja"];
              $date = new DateTime($estadoCaja["Fecha"]);
              $estadoCaja["MontoApertura"];
              $estadoCaja["Estado"];


          if($estadoCaja["Estado"] == "A")
     { echo '<a href="cierre"><i class="fa fa-circle text-success"></i>OnLine</a>';}
     else
     { echo  '<a href="cierre"><i class="fa fa-circle text-danger"></i>OffLine</a>';} ?>

        </div>
      </div>

      <ul class="sidebar-menu">
        <li class="header">Navegacion</li>
           <?php if($_SESSION["puesto"] == 1 || $_SESSION["puesto"] == 6) { ?>
        <li class="active"> <a href="inicio"><i class="fa fa-home"></i> <span>Inicio</span></a></li>
        <?php } ?>
   <?php if($_SESSION["puesto"] == 1) { ?>
        <li class="treeview">
   <a href="#"><i class="fa fa-user"></i> <span>Administracion</span>
     <span class="pull-right-container">
       <i class="fa fa-angle-left pull-right"></i>
     </span>
   </a>
   <ul class="treeview-menu">

     <li><a href="proveedores">Proveedores</a></li>
     <li><a href="personal">Empleados</a></li>
       <li><a href="categoria">Categoria</a></li>
     <li><a href="inventario">Inventario</a></li>
     <li><a href="compra">Compra</a></li>
     <li><a href="gastoIngreso">Gasto - Ingreso</a></li>
     <!-- <li><a href="#">Cuentas por pagar</a></li>
     <li><a href="#">Cuentas por cobrar</a></li> -->
     <!-- <li><a href="MODELO">MODELO</a></li> --> -->
   </ul>
 </li>
      <?php } ?>
    <?php if($_SESSION["puesto"] == 1 ||  $_SESSION["puesto"] == 3 || $_SESSION["puesto"] == 6) { ?>
               <li class="treeview">
              <a href="#"><i class="fa fa-money"></i> <span>Facturacion</span>
              <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
              </span>
              </a>
              <ul class="treeview-menu">
              <li><a href="caja">Caja</a></li>
              <li><a href="compra">Compra</a></li>
              <li><a href="gastoIngreso">Gasto - Ingreso</a></li>
              <!-- <li><a href="#">Devoluciones</a></li> -->
              <li><a href="cierre">Cierre</a></li>
              <!-- <li><a href="prueba">Prueba</a></li>
              <li><a href="menuPedido">Menu</a></li> -->
              </ul>
              </li>
               <?php } ?>
               <?php if($_SESSION["puesto"] == 1 || $_SESSION["puesto"] == 5 || $_SESSION["puesto"] == 3) { ?>
              <li><a href="salon"><i class="fa fa-pencil"></i> <span>Salon</span></a></li>
              <?php } ?>
                   <?php if($_SESSION["puesto"] == 1 || $_SESSION["puesto"] == 4) { ?>
              <li><a href="cocina"><i class="fa fa-cutlery"></i> <span>Cocina</span></a></li>
              <?php } ?>
     <?php if($_SESSION["puesto"] == 1 || $_SESSION["puesto"] == 6) { ?>
               <li class="treeview">
          <a href="#"><i class="fa fa-pie-chart"></i> <span>Reportes</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="ReporteVentasporDia">Balance por dia</a></li>


            <!-- <li><a href="#">Anulados</a></li>
            <li><a href="#">Eliminados</a></li> -->

            <li><a href="ReporteVentas">Ventas</a></li>
            <!-- <li><a href="ReporteVentasporMes">Ventas por Mes</a></li> -->

            <!-- <li><a href="ReporteVentasporAnio">Ventas por Año</a></li>-->
            <!--<li><a href="ReporteComparacionporAnios">Comparacion por Años</a></li>-->
            <li><a href="ReporteMejoresVendedores">Mejores Vendedores</a></li>
            <li><a href="ReportePlatosmasVendidos">Platos mas Vendidos</a></li>
            <li><a href="ReporteBebidasmasVendidas">Bebidas mas Vendidas</a></li>
            <!--<li><a href="ReporteExistenciaMinima">Existencia Minima</a></li>-->

            <!--<li><a href="ReporteIngresoEgresospordia">Ingreso & Egresos por dia</a></li>-->
            <!--<li><a href="ReporteIngresoEgresospormes">Ingreso & Egresos por mes</a></li>-->
            <!--<li><a href="ReporteIngresoEgresosporanio">Ingreso & Egresos por año</a></li>-->
            <!--<li><a href="ReporteCompraspordia">Compras por dia</a></li>-->
            <!--<li><a href="ReporteCompraspormes">Compras por mes</a></li>-->
            <!--<li><a href="ReporteComprasporanio">Compras por año</a></li>-->
            <!--<li><a href="ReporteGastospordia">Gastos por dia</a></li>-->
            <!--<li><a href="ReporteGastospormes">Gastos por mes</a></li>-->
            <!--<li><a href="ReporteGastosporanio">Gastos por año</a></li>-->
            <!--<li><a href="ReporteCuentasporcobrarpendientes">Cuentas por cobrar pendientes</a></li>-->
            <!--<li><a href="ReporteCuentasporcobrarsolventes">Cuentas por cobrar solventes</a></li>-->
            <li><a href="ReporteCuentasporcobrar">Cuentas por cobrar</a></li>
            <li><a href="ReporteCortesias">Cortesías</a></li>
          </ul>
        </li>
        <?php } ?>
     <?php if($_SESSION["puesto"] == 1) { ?>
        <li class="treeview">
       <a href="#"><i class="fa fa-gear"></i> <span>Ajustes</span>
       <span class="pull-right-container">
       <i class="fa fa-angle-left pull-right"></i>
       </span>
       </a>
       <ul class="treeview-menu">
       <li><a href="usuarios">Usuarios de sistema</a></li>
       <li><a href="configuraciones">Configuracion de sistema</a></li>
       <li><a href="informacion">Informacion del restaurante</a></li>
       <li><a href="comprobantes">Comprobantes</a></li>
       <li><a href="ReporteTickets">Tickets</a></li>
       </ul>
       </li>
       <?php } ?>

      </ul>

    </section>
  </aside>
