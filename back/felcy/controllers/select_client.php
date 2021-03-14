<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    if($_GET['action'] == 'listar'){
		$client = array();
		$ban = true;
        $sqlGetClients = "SELECT * FROM $tClients ";
        
        //Ordenar ASC y DESC
		$vorder = (isset($_POST['orderby'])) ? $_POST['orderby'] : "";
		if($vorder != ''){
            $sqlGetClients .= " ORDER BY ".$vorder;
		}else{
            $sqlGetClients .= " ORDER BY ap ";
        }
        
        //Ejecutamos query
        $resGetClients = $con->query($sqlGetClients);
        $datos = '';
		if($resGetClients->num_rows > 0){
			while ($rowGetClients = $resGetClients->fetch_assoc()) {
				$id = $rowGetClients['id'];
				$name = $rowGetClients['ap'].' '.$rowGetClients['am'].' '.$rowGetClients['nombre'];
				$tels = $rowGetClients['telefono'].'/'.$rowGetClients['celular'];
				$mail = $rowGetClients['correo'];
				$rfc = $rowGetClients['rfc'];
				$porc_desc = $rowGetClients['porc_desc'];
				$client[] = array('id'=>$id, 'nombre'=>$name, 'tels'=>$tels, 'correo'=>$mail, 'rfc'=>$rfc, 'porc_desc'=>$porc_desc);
			}
		}else{
			$ban = false;
			$msgErr = "No existen clientes registrados.";
		}
        
		if($ban){
			$cad = 'Clientes encontrados.';
			echo json_encode(array("error"=>0, "dataRes"=>$client,"msgErr"=>$cad));
		}else{
			echo json_encode(array("error"=>1, "msgErr"=>$msgErr));
		}
    }
    
?>
