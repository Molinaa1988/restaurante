    
<?php


require_once "../../models/modelReportes.php";
require_once "../../models/modelComprobantes.php";

$modelRepo = new modelReportes();
$modelComp = new modelComprobantes();



if (isset($_POST['AccionAjax'])) {
    $Accion = $_POST['AccionAjax'];

    // esta funcion es para cacular los ceros y que aparezcan como 0001 en vez de solo 1 
    function CalcularCeros($numeroDoc)
    {
        $ceros = 0;
        if ($numeroDoc == "")
        {
            $ceros = "00001";
        }
        else if ($numeroDoc >= 0 && $numeroDoc < 10 )
        {
            $ceros = "0000";
        }
    
        else if ($numeroDoc >= 10 && $numeroDoc < 100)
        {
            $ceros = "000";
        }
        else if ($numeroDoc >= 100 && $numeroDoc < 1000)
        {
            $ceros = "00";
        }
        else if ($numeroDoc >= 1000 && $numeroDoc < 10000)
        {
            $ceros = "0";
        }
        else if ($numeroDoc > 10000)
        {
            $ceros = "";
        }
        return $ceros;
    }
    
    
    if ($Accion === 'TaO') {

        $Dts = $_POST['Id']; //traemos los idpedido del comprobanteC juntos por comas
        $idsC=explode(',',$Dts); // los separamos
        
        // los cambiamos a O
        // pero antes es de obtener la lista de ids de comprobante que pueden no ser los mismos
        for ($i=0; $i<count($idsC) ; $i++) { 

            // $DtsC = $modelComp -> ComprobanteUnicoC($idsC[$i]); //para sacar los datos del comprobanteC
            // $nro = $DtsC[3]; //scamos el nro de ticket
            // //echo $nro; 

            // // con ese nro de ticket debemos obtener el id de comproabante
            // $id = $modelComp ->  Compro($nro); 

            // //ahora ya tenemos el $id de comprobante y el $idsC[$i] de comprobantec 
            // echo $id[0].'----';

            //-------------TODO LO ANTERIOR YA NO -------------
            
            //--------------CON LOS IDPEDIDO DE COMPROBANTEC SE HARA TODO----------

            // echo $idsC[$i].'+++'; // estos son los idpedidos

            $r = $modelRepo -> cambiarTicket($idsC[$i]); //para pasar el comprobanteC a O
            $r = $modelRepo->cambiarTicketC($idsC[$i]); //para pasar el comprobante a O

            //-----AHORA QUE YA PASAMOS TODO, SE TIENE QUE ORDENAR

           

        }   

        
        $otrosC = $modelRepo->otrosMayoresC($idsC[0]); // array de otros de comprobantec mayores que el primer t marcado

        foreach ($otrosC as $key => $id) {
            //----------ORDENAMOS LOS O DE COMPROBANTE------------
            $corre = $modelRepo->menorCorrelativoO( $id['IdPedido'] ); // sacamos el correlativo del numero anterior que era otro
            $cor = $corre['NumeroDoc'];
            $int = (int) $cor;
            $int2 = $int + 1; 
    
            $ceros= CalcularCeros( $int2 );
            $num = $ceros.$int2; //le agregamos los 000
            $r = $modelRepo->cambiarCorrelativo( $id['IdPedido'] , $num);  // cambiamos su numerodoc en la tabla

            //----------ORDENAMOS LOS O DE COMPROBANTEC------------
            $corre = $modelRepo->menorCorrelativoOC( $id['IdPedido'] );
            $cor = $corre['NumeroDoc'];
            $int = (int) $cor;
            $int2 = $int + 1; 
    
            $ceros= CalcularCeros( $int2 );
            $num = $ceros.$int2;
            $r = $modelRepo->cambiarCorrelativoC( $id['IdPedido'] , $num); 


            ///------------EN ESTE PUNTO YA CAMBIAMOS A OTROS LOS TICKETS MARCADOS Y ORDENAMOS LOS OTROS-----
            
        }

        ///----------------AHORA HAY QUE ORDENAR LOS TICKETS DESDE EL MARCADO EN ADELANTE--------
                
        $ticsC = $modelRepo->ticketsMayoresC($idsC[0]); // array de tickets de comprobantec mayores que el primer t marcado
        
        foreach ($ticsC as $key => $id) {
            
            //----------ORDENAMOS LOS T DE COMPROBANTE---------------
            $corre = $modelRepo->menorCorrelativo($id['IdPedido']); // sacamos el correlativo del numero anterior que era ticket
            $cor = $corre['NumeroDoc'];
            $int = (int) $cor;
            $int2 = $int + 1; 

            $ceros= CalcularCeros( $int2 );
            $num = $ceros.$int2; //le agregamos los 000
            $r = $modelRepo->cambiarCorrelativo( $id['IdPedido'], $num);  // cambiamos su numerodoc en la tabla

            //------------AHORA ORDENAMOS LOS T DE COMPROBANTEC----------
            $corre = $modelRepo->menorCorrelativoC( $id['IdPedido'] );
            $cor = $corre['NumeroDoc'];
            $int = (int) $cor;
            $int2 = $int + 1; 

            $ceros= CalcularCeros( $int2 );
            $num = $ceros.$int2;
            $r = $modelRepo->cambiarCorrelativoC( $id['IdPedido'] , $num);
    

        }
        
        echo json_encode("success");
        
        // echo json_encode($rC);

    }
        

}






?>