 <?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
	$descuento = array();
	$rfc = $_POST['rfc'];
	$ban = false;
	$msgErr = '';
	
	$sqlGetDesc = "SELECT * FROM $tClients WHERE rfc='$rfc' ";
	$resGetDesc = $con->query($sqlGetDesc);
	if($resGetDesc->num_rows > 0){
		$rowGetDesc = $resGetDesc->fetch_assoc();
		$id = $rowGetDesc['id'];
		$nombre = $rowGetDesc['nombre'];
		$ap = $rowGetDesc['ap'];
		$am = $rowGetDesc['am'];
		$calle = $rowGetDesc['calle'];
		$num = $rowGetDesc['numero'];
		$col = $rowGetDesc['colonia'];
		$mun = $rowGetDesc['municipio'];
		$edo = $rowGetDesc['estado'];
		$tel = $rowGetDesc['telefono'];
		$cel = $rowGetDesc['celular'];
		$mail = $rowGetDesc['correo'];
		$desc = $rowGetDesc['porc_desc'];
		$descuento[] = array('id'=>$id, 'nombre'=>$nombre, 'ap'=>$ap, 'am'=>$am, 'calle'=>$calle, 'num'=>$num, 'col'=>$col, 'mun'=>$mun, 'edo'=>$edo, 'tel'=>$tel, 'cel'=>$cel, 'mail'=>$mail, 'desc'=>$desc, 'rfc'=>$rfc);
		$ban = true;
	}else{
		$ban = false;
		$msgErr .= 'Error: No existe el RFC.';
	}
	
	if($ban){
        echo json_encode(array("error"=>0, "dataRes"=>$descuento));
    }else{
        echo json_encode(array("error"=>1, "msgErr"=>$msgErr));
    }
	
?>