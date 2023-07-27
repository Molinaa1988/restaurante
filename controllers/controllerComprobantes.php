<?php


function searchForType($type, $array) {
	foreach ($array as $key => $val) {
		if ($val['TipoComprobante'] == $type) {
			return $key;
		}
	}
	return null;
 }

class controllerComprobantes{

	function comprobantesC($fechai){
		$respuesta = [];
		if (isset($_POST['documentos'])) {
			$tipoDoc = $_POST['documentos'];
			if ($tipoDoc === 'T') {
				$respuesta = modelComprobantes::comprobantesC($fechai);
			}else{
				$respuesta = modelComprobantes::comprobantes($fechai);
			}
		}
		return array($respuesta, searchForType('CORTE Z', $respuesta));
	}

// 	function comprobantesC($fechai){
// 		$respuesta = modelComprobantes::comprobantesC($fechai);
// 	   return $respuesta;
//    }

	function comprobantesEliminados($fechai){
 $respuesta = modelComprobantes::comprobantesEliminados($fechai);
 return $respuesta;
}

		function verificarClave(){
					if(isset($_POST["clave"])){
 		if($_POST['clave']=='1990')
		{
			?>
			<script>
			<?php
			echo "window.location='comprobantes?clave=si'";
			?>
			</script>
			<?php
		}
		elseif($_POST['clave']=='extras')
		{
			?>
			<script>
			<?php
			echo "window.location='extras'";
			?>
			</script>
			<?php
		}
		else {
			echo '<script>
			swal({
				title: "Error",
				text: "Fecha erronea",
				type: "warning",
				showCancelButton: false,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
					confirmButtonText: "Ok"
			}).then(function () {
			location = location;
			});
	</script>';
		}
	}
}

}
