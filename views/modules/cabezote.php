
<header class="main-header">

    <a href="#" class="logo">
      <span class="logo-mini"><b>R</b></span>
      <span class="logo-lg">Restaurante</span>
    </a>

    <nav class="navbar navbar-static-top" role="navigation">
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

<!-- NOTIFICACIONES -->
    <?php if($_SESSION["puesto"] == 1 || $_SESSION["puesto"] == 3) { ?>
<li class="dropdown notifications-menu">
  <a href="sucesos">
    <i class="fa fa-bell-o"></i>
                <?php
                $Notificaciones = 0;
                  $conSucesos = new controllerSucesos();
                   $respuesta = $conSucesos-> vistaSucesosSinVer();
                    foreach($respuesta as $row => $item){
                      $Notificaciones = $Notificaciones + 1;
                        }
                        if($Notificaciones > 0)
                        {
                         ?>
                      <span class="label label-warning"><?php echo $Notificaciones ?></span>
                      <?php
                     } ?>
                   </a>
                 </li>
                 <?php
               } ?>



<!-- Usuario -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- <img src="views/dist/img/cajera.png" class="user-image" alt="User Image"> -->
              <?php
               if ($_SESSION["puesto"] == "1"){
               echo '<img src="views/dist/img/logo.png" class="user-image" style="width:30px;height:30px;" alt="User Image"/>';
             } else if($_SESSION["puesto"] == "6"){
                echo '<img src="views/dist/img/cajera.png" class="user-image" style="width:30px;height:30px;" alt="User Image">';
               }else { echo '<img src="views/dist/img/mesero.png" class="user-image" style="width:30px;height:30px;" alt="User Image">'; }
           ?>
              <span class="hidden-xs"><?php echo $_SESSION['usuario']; ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <!-- <img src="views/dist/img/cajera.png" class="img-circle" alt="User Image"> -->
                <?php
                 if ($_SESSION["puesto"] == "1"){
                 echo '<img src="views/dist/img/logo.png"  class="img-circle" alt="User Image"/>';
               } else if($_SESSION["puesto"] == "6"){
                  echo '<img src="views/dist/img/cajera.png"  class="img-circle" alt="User Image">';
                 }else { echo '<img src="views/dist/img/mesero.png" class="img-circle" alt="User Image">'; }
             ?>
                <p>
                  <?php echo $_SESSION['usuario']; ?>
                </p>
              </li>

              <li class="user-footer">
                <div class="pull-right">

                  <a href="salir" class="btn btn-default btn-flat">Salir</a>

                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
