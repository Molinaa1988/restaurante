<?php


	class Ingreso{
		public function ingresoController(){
			//PARA IDENTIFICAR SI ES MOVIL, TABLET O ESCRITORIO
			$dispositivo;
			$tablet_browser = 0;
			$mobile_browser = 0;
			$body_class = 'desktop';

			// if (preg_match("/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i", strtolower($_SERVER['HTTP_USER_AGENT'])){
			// 	$tablet_browser++;
			// 	$body_class = "tablet";
			// }

			if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
				$mobile_browser++;
				$body_class = "mobile";
			}

			if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
				$mobile_browser++;
				$body_class = "mobile";
			}

			$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
			$mobile_agents = array(
				'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
				'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
				'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
				'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
				'newt','noki','palm','pana','pant','phil','play','port','prox',
				'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
				'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
				'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
				'wapr','webc','winw','winw','xda ','xda-'
			);

			if (in_array($mobile_ua,$mobile_agents)) {
				$mobile_browser++;
			}

			if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
				$mobile_browser++;
				//Check for tablets on opera mini alternative headers
				$stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
				if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
					$tablet_browser++;
				}
			}
			if ($tablet_browser > 0) {
				$dispositivo = 'Tablet';
				// Si es tablet has lo que necesites
				// print 'es tablet';
			} else if ($mobile_browser > 0) {
				$dispositivo = 'Mobil';
				// Si es dispositivo mobil has lo que necesites
		   		// print 'es un mobil';
			} else {
				$dispositivo = 'Escritorio';
				// Si es ordenador de escritorio has lo que necesites
		   		// print 'es un ordenador de escritorio';
			}

			if(isset($_POST["usuarioIngreso"])){
				if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["usuarioIngreso"]) && preg_match('/^[a-zA-Z0-9]+$/', $_POST["passwordIngreso"])){
			   		#$encriptar = crypt($_POST["passwordIngreso"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
					$datosController = array(
						"Usuario"=>$_POST["usuarioIngreso"],
						"password"=>$_POST["passwordIngreso"]
					);
					$respuesta = IngresoModels::ingresoModel($datosController, "usuario");
					
					if ($respuesta) {
						$intentos = $respuesta["intentos"];
						$usuarioActual = $_POST["usuarioIngreso"];
						$maximoIntentos = 2;
						if($intentos < $maximoIntentos){
							if($respuesta["Usuario"] == $_POST["usuarioIngreso"] && $respuesta["Clave"] == $_POST["passwordIngreso"]){
								$intentos = 0;
								$datosController = array("usuarioActual"=>$usuarioActual, "actualizarIntentos"=>$intentos);
								$respuestaActualizarIntentos = IngresoModels::intentosModel($datosController, "usuario");
								session_start();
								$_SESSION["validar"] = true;
								$_SESSION["usuario"] = $respuesta["Usuario"];
								$_SESSION["puesto"] = $respuesta["Puesto"];
								$_SESSION["idusuario"] = $respuesta["IdUsuario"];
								$_SESSION["IdPersonal"] = $respuesta["IdPersonal"];
								$_SESSION["dispositivo"] = $dispositivo;
								header("location:inicio");
							} else {
								++$intentos;
								$datosController = array("usuarioActual"=>$usuarioActual, "actualizarIntentos"=>$intentos);
								$respuestaActualizarIntentos = IngresoModels::intentosModel($datosController, "usuario");
								echo '<div class="alert alert-danger">Error al ingresar</div>';
								//echo $respuesta["Usuario"];
								//echo $respuesta["Clave"];
								// 	header("location:inicio");
							}
						} else {
							$intentos = 0;
							$datosController = array("usuarioActual"=>$usuarioActual, "actualizarIntentos"=>$intentos);
							$respuestaActualizarIntentos = IngresoModels::intentosModel($datosController, "usuario");
							echo '<div class="alert alert-danger">Ha fallado 3 veces, demuestre que no es un robot</div>';
						}
					} else {
						echo '<div class="alert alert-danger">Usuario no existe</div>';
					}

				}
			}
		}
	}
?>
