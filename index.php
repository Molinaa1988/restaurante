<?php

require_once "models/enlaces.php";
require_once "models/ingreso.php";

require_once "models/modelInicio.php";
require_once "models/modelReportes.php";
require_once "models/modelProveedores.php";
require_once "models/modelPersonal.php";
require_once "models/modelUsuario.php";
require_once "models/modelCliente.php";
require_once "models/modelCategoria.php";
require_once "models/modelInventario.php";
require_once "models/modelCompra.php";
require_once "models/modelGastoIngreso.php";
require_once "models/modelCaja.php";
require_once "models/modelRealizarVenta.php";
require_once "models/modelCierre.php";
require_once "models/modelSalon.php";
require_once "models/modelConfiguraciones.php";
require_once "models/modelCocina.php";
require_once "models/modelComprobantes.php";
require_once "models/modelExtras.php";
require_once "models/modelSucesos.php";

require_once "controllers/template.php";
require_once "controllers/enlaces.php";
require_once "controllers/ingreso.php";

require_once "controllers/controllerInicio.php";
require_once "controllers/controllerReportes.php";
require_once "controllers/controllerProveedores.php";
require_once "controllers/controllerPersonal.php";
require_once "controllers/controllerCliente.php";
require_once "controllers/controllerUsuario.php";
require_once "controllers/controllerCategoria.php";
require_once "controllers/controllerInventario.php";
require_once "controllers/controllerCompra.php";
require_once "controllers/controllerGastoIngreso.php";
require_once "controllers/controllerCaja.php";
require_once "controllers/controllerRealizarVenta.php";
require_once "controllers/controllerCierre.php";
require_once "controllers/controllerSalon.php";
require_once "controllers/controllerConfiguraciones.php";
require_once "controllers/controllerCocina.php";
require_once "controllers/controllerComprobantes.php";
require_once "controllers/controllerExtras.php";
require_once "controllers/controllerSucesos.php";


$template = new TemplateController();
$template -> template();
