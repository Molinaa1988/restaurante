<?php

class controllerInventario{
	#REGISTRO DE USUARIOS
	#------------------------------------
	public function registroInventario(){

		if(isset($_POST["precioR"])){
			$datosController = array("idcategoria"=>$_POST["idcategoriaR"],
								     "precio"=>$_POST["precioR"],
                      				 "stock"=>$_POST["stockR"],
                      				 "descripcion"=>$_POST["descripcionR"],
									 "tipoitem"=>$_POST["tipoitemR"],
									 "familia"=>$_POST["familiaR"],
									 "Estado"=>$_POST["estadoR"]);
			$respuesta = modelInventario::registroInventario($datosController);
			if($respuesta == "success"){
        echo '<script>
			swal(
			{
					title: "Registrado",
					text: "Se registro exitosamente",
					type: "success",
					showCancelButton: false,
					confirmButtonColor: "#3085d6",
					cancelButtonColor: "#d33",
						confirmButtonText: "Ok"
				}
				).then(function () 
				{
						location = location;
				}
					);
    		</script>';
			}
			else
			{
				echo "No paso nada";
			}
		}
	}





	public function actualizarInventario(){
		if(isset($_POST["idA"])){
			$datosController = array("id"=>$_POST["idA"],
											"idcategoria"=>$_POST["idcategoriaA"],
											"precio"=>$_POST["precioA"],
											"stock"=>$_POST["stockA"],
											"descripcion"=>$_POST["descripcionA"],
											"Estado"=>$_POST["estadoA"]);
		$respuesta = modelInventario::actualizarInventario($datosController);
			if($respuesta == "success"){
				echo '<script> swal({
			title: "Editado",
			text: "Se edito exitosamente.",
			type: "success",
			showCancelButton: false,
			confirmButtonColor: "#54c6dd",
			confirmButtonText: "Ok",
			closeOnConfirm: false
		});</script>';
			header("location:inventario");
		}
		else{
		// header("location:index.php");

		}
	}
	
}

		public function vistaInventario(){
		$respuesta = modelInventario::vistaInventario();
		return $respuesta;
	}

	public function vistaIngredientesUsados($fecha){
		$respuesta = modelInventario::vistaIngredientesUsados($fecha);
		return $respuesta;
	}

	public function vistaIngredientesUsadosS($fecha){
		$respuesta = modelInventario::vistaIngredientesUsadosS($fecha);
		return $respuesta;
	}

	public function vistaIngredientes(){
		$respuesta = modelInventario::vistaIngredientes();
		return $respuesta;
	}



	public function vistaCategoria($idCat){
			$datosController = array("idcategoria"=>$idCat);
			$respuesta = modelInventario::vistaCategoria($datosController);
	    return $respuesta;
	}

		public function borrarInventario(){
	if(isset($_POST["idPersonalE"]))
		{
            $datosController = $_POST["idPersonalE"];
			$respuesta = modelInventario::borrarInventario($datosController);
			if($respuesta == "success")
			{
				echo '<script> swal({
				title: "Eliminado",
				text: "Se elimino exitosamente.",
				type: "success",
				showCancelButton: false,
				confirmButtonColor: "#54c6dd",
				confirmButtonText: "Ok",
				closeOnConfirm: false
				});
				</script>';
				header("location:inventario");
			}
		}
			else{
			header("location:index");
			}
		}
	}




public function registroIngrediente(){


		if(isset($_POST["descripcionI"])){	
		$datosController = array("descripcion"=>$_POST["descripcionI"],
								  "unidad"=>$_POST["unidadI"],
								  "cantidad"=>$_POST["cantidadI"]);
		$respuesta = modelInventario::registroIngredientes($datosController);
		
		if($respuesta == "success"){
	echo '<script>

	swal({
	  title: "Registrado",
	  text: "Se registro exitosamente",
	  type: "success",
	  showCancelButton: false,
	  confirmButtonColor: "#3085d6",
	  cancelButtonColor: "#d33",
		confirmButtonText: "Ok"
	}).then(function () {
	location = location;
	});

</script>';

		}
		else{
echo "No paso nada";
		}
	}
}


//funcion para agregar ingredientes a los platos

public function registroIngPorItems(){


	if(isset($_POST["CantidadU"])){	
	$datosController = array("IdIngredientes"=>$_POST["IdIngredientes"],
							  "IdItems"=>$_POST["IdItems"],
							  "CantidadU"=>$_POST["CantidadU"]);
	$respuesta = modelInventario::registroIngPorItems($datosController);
	
	if($respuesta == "success"){
echo '<script>

swal({
  title: "Registrado",
  text: "Se registro exitosamente",
  type: "success",
  showCancelButton: false,
  confirmButtonColor: "#3085d6",
  cancelButtonColor: "#d33",
	confirmButtonText: "Ok"
}).then(function () {
location = location;
});

</script>';

	}
	else{
echo "No paso nada";
	}
}
}

	public function actualizarIngredientes(){
		if(isset($_POST["idIA"])){
			$datosController = array("id"=>$_POST["idIA"],
											"descripcion"=>$_POST["descripcionIA"],
											"unidad"=>$_POST["unidadIA"],
											"cantidad"=>$_POST["cantidadIA"]);

		$respuesta = modelInventario::actualizarIngredientes($datosController);
			if($respuesta == "success"){
				echo '<script>

				swal({
				  title: "Actualizado",
				  text: "Se actualizó exitosamente",
				  type: "success",
				  showCancelButton: false,
				  confirmButtonColor: "#3085d6",
				  cancelButtonColor: "#d33",
					confirmButtonText: "Ok"
				}).then(function () {
				location = location;
				});
			
			</script>';
		}
		else{
		// header("location:index.php");

		}
	}
	
}

	public function borrarIngrediente(){
		if(isset($_POST["idIngE"])){
				$datosController = $_POST["idIngE"];
				$respuesta = modelInventario::borrarIngrediente($datosController);
				if($respuesta == "success"){
			echo '<script> swal({
		title: "Eliminado",
		text: "Se elimino exitosamente.",
		type: "success",
		showCancelButton: false,
		confirmButtonColor: "#54c6dd",
		confirmButtonText: "Ok",
		
	}).then(function () {
		location = location;
		});
		</script>';
				}
				else{
				header("location:index.php");
				}
			}
		}

		public function borrarRelacion(){
			if(isset($_POST["idRelacionE"])){
					$datosController = $_POST["idRelacionE"];
					$respuesta = modelInventario::borrarRelacion($datosController);
					if($respuesta == "success"){
				echo '<script> swal({
			title: "Eliminado",
			text: "Se elimino exitosamente.",
			type: "success",
			showCancelButton: false,
			confirmButtonColor: "#54c6dd",
			confirmButtonText: "Ok",
			
		}).then(function () {
			location = location;
			});
			</script>';
					}
					else{
					header("location:index.php");
					}
				}
			}

//funcion para borrar los ingredientes por platos

  
// funciones para los items e ingredientes usados
	public function descontarIngredientes($IdIngredientes, $Total){
		//if(isset($_POST["desR"])){
			
		
		for($i=0;$i<count($IdIngredientes); $i++){
			$respuesta = modelInventario::descontarIngredientes($IdIngredientes[$i], $Total[$i]);
			if($respuesta == "success"){
				echo '<script>

				swal({
				  title: "Actualizado",
				  text: "Se actualizó exitosamente",
				  type: "success",
				  showCancelButton: false,
				  confirmButtonColor: "#3085d6",
				  cancelButtonColor: "#d33",
					confirmButtonText: "Ok"
				}).then(function () {
				location = location;
				});
			
			</script>';

		}}
		//}
	}

	public function actualizarItemsDescontados($IdPedido){
		//if(isset($_POST["desR"])){
		for ($i=0;$i<count($IdPedido);$i++){
		$respuesta = modelInventario::actualizarItemsDescontados($IdPedido[$i]);
		if($respuesta == "success"){
			echo '<script>

			swal({
			  title: "Actualizado",
			  text: "Se actualizó exitosamente",
			  type: "success",
			  showCancelButton: false,
			  confirmButtonColor: "#3085d6",
			  cancelButtonColor: "#d33",
				confirmButtonText: "Ok"
			}).then(function () {
			location = location;
			});
		
		</script>';	
		}}
		//}
	}


}