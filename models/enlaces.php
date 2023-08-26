<?php

class EnlacesModels{

	public function enlacesModel($enlaces){

		if($enlaces == "inicio" ||  // Login
		   $enlaces == "ingreso" || //Dashboard
			 $enlaces == "proveedores" ||
			 $enlaces == "personal" ||
		   $enlaces == "usuarios" ||
			 $enlaces == "cliente" ||
			 $enlaces == "clientes1" ||
			 $enlaces == "categoria" ||
			 $enlaces == "inventario" ||
			 $enlaces == "ingredientes" ||
			 $enlaces == "compra" ||
			 $enlaces == "gastoIngreso" ||
			 $enlaces == "caja" ||
			 $enlaces == "caja1" ||
			 $enlaces == "cierre" ||
			 $enlaces == "prueba" ||
			 $enlaces == "salon" ||
			 $enlaces == "menuPedido" ||
			 $enlaces == "cocina" ||
			 $enlaces == "configuraciones" ||
		   $enlaces == "salir" ||
			 $enlaces == "MODELO" ||
			 $enlaces == "comprobantes" ||
			 $enlaces == "extras" ||
			 $enlaces == "informacion" ||
			 $enlaces == "sucesos" ||
//Reportes
  		 $enlaces == "ReporteVentasporDia" ||
			 $enlaces == "ReporteVentasporDiaDetalle" ||

			 $enlaces == "ReporteVentas" ||

			 $enlaces == "ReporVenDiaIdPed" ||
			 $enlaces == "ReporteIngredientes" ||
			 $enlaces == "ReporteItemsPorDia" ||

			 $enlaces == "ReporteVentasporAnio" ||
			 $enlaces == "ReporteComparacionporAnios" ||
			 $enlaces == "ReporteMejoresVendedores" ||
			 $enlaces == "ReportePlatosmasVendidos" ||
			 $enlaces == "ReporteBebidasmasVendidas" ||
			 $enlaces == "ReporteVendedor" ||
			 $enlaces == "ReporteExistenciaMinima" ||
			 $enlaces == "ReporteIngresoEgresospordia" ||
			 $enlaces == "ReporteIngresoEgresospormes" ||
			 $enlaces == "ReporteIngresoEgresosporanio" ||
			 $enlaces == "ReporteCompraspordia" ||
			 $enlaces == "ReporteCompraspormes" ||
			 $enlaces == "ReporteComprasporanio" ||
			 $enlaces == "ReporteGastospordia" ||
			 $enlaces == "ReporteGastospormes" ||
			 $enlaces == "ReporteGastosporanio" ||
			 $enlaces == "ReporteCuentasporcobrarpendientes" ||
			 $enlaces == "ReporteCuentasporcobrar" ||
			 $enlaces == "ReporteCuentasporpagarpendientes" ||
			 $enlaces == "ReporteCuentasporpagarsolventes" ||
			 $enlaces == "ReporteTickets" ||
 			 $enlaces == "ReporteCortesias" || 
			 $enlaces == "ReporteEliminados")
			 {
			$module = "views/modules/".$enlaces.".php";
		}

		else if($enlaces == "index"){
			$module = "views/modules/ingreso.php";
		}
			else if($enlaces == "ok"){
			$module = "views/modules/registroCategorias.php";
		}
		else{
			$module = "views/modules/ingreso.php";
		}
		return $module;
	}
}
