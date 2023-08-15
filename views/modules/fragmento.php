<?php if($_SESSION["puesto"] >= 1)  { ?>
          <li class="active"> <a href="inicio"><i class="fa fa-home"></i> <span>Inicio</span></a></li>
          
          <?php } ?>

   <?php if(($_SESSION["puesto"] == 2)) { ?>
        <li class="treeview">
   <a href="#"><i class="fa fa-user"></i> <span>Administracion</span>
     <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
   </a>
   <ul class="treeview-menu">
     <li><a href="proveedores">Proveedores</a></li>
     <li><a href="personal">Empleados</a></li>
     <li><a href="categoria">Categoria</a></li>
     <li><a href="inventario">Inventario</a></li>
     <li><a href="compra">Compras</a></li>
     <li><a href="gastoIngreso">Gasto - Ingreso</a></li>
   </ul>
 </li>
      <?php } ?>
    <?php if($_SESSION["puesto"] >= 1 || $_SESSION["puesto"] <= 4) { ?>
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
              <li><a href="cierre">Cierre</a></li>
              </ul>
              </li>
               <?php } ?>
               <?php if($_SESSION["puesto"] == 1 || $_SESSION["puesto"] == 4){ ?>
              <li><a href="salon"><i class="fa fa-pencil"></i> <span>Salon</span></a></li>
              <?php } ?>
              
              <?php if($_SESSION["puesto"] == 6) { ?>
                  <li><a href="cocina"><i class="fa fa-cutlery"></i> <span>Cocina</span></a></li>
              
                  <?php } ?>

     <?php if($_SESSION["puesto"] = 1) { ?>
        <li class="treeview">
          <a href="#"><i class="fa fa-pie-chart"></i> <span>Reportes</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="ReporteVentasporDia">Balance por dia</a></li>
            <li><a href="ReporteVentas">Ventas</a></li>
            <li><a href="ReporteMejoresVendedores">Mejores Vendedores</a></li>
            <li><a href="ReportePlatosmasVendidos">Platos mas Vendidos</a></li>
            <li><a href="ReporteBebidasmasVendidas">Bebidas mas Vendidas</a></li>
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