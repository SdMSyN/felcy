<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
	$idClient = $_POST['id'];
	$client = array();
	$ban = true;
	$sqlGetClients = "SELECT * FROM $tClients WHERE id='$idClient' ";
	
	//Ejecutamos query
	$resGetClients = $con->query($sqlGetClients);
	$datos = '';
	if($resGetClients->num_rows > 0){
		while ($rowGetClients = $resGetClients->fetch_assoc()) {
			$id = $rowGetClients['id'];
			$ap = $rowGetClients['ap'];
			$am = $rowGetClients['am'];
			$name = $rowGetClients['nombre'];
			$street = $rowGetClients['calle'];
			$num = $rowGetClients['numero'];
			$col = $rowGetClients['colonia'];
			$mun = $rowGetClients['municipio'];
			$edo = $rowGetClients['estado'];
			$tel = $rowGetClients['telefono'];
			$cel = $rowGetClients['celular'];
			$mail = $rowGetClients['correo'];
			$rfc = $rowGetClients['rfc'];
			$porc_desc = $rowGetClients['porc_desc'];
			$client[] = array('id'=>$id, 'ap'=>$ap, 'am'=>$am, 'nombre'=>$name, 'calle'=>$street, 'num'=>$num, 'col'=>$col, 'mun'=>$mun, 'edo'=>$edo, 'tel'=>$tel, 'cel'=>$cel, 'correo'=>$mail, 'rfc'=>$rfc, 'porc_desc'=>$porc_desc);
		}
	}else{
		$ban = false;
		$msgErr = "No existe el cliente.";
	}
	
	if($ban){
		$cad = 'Clientes encontrados.';
		echo json_encode(array("error"=>0, "dataRes"=>$client,"msgErr"=>$cad));
	}else{
		echo json_encode(array("error"=>1, "msgErr"=>$msgErr));
	}
    
?>
