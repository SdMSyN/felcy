<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
	$msgErr = '';
	
    $idClient = $_POST['idClient'];
    $inputNombre = $_POST['inputNombre'];
    $inputAP = $_POST['inputAP'];
    $inputAM = (isset($_POST['inputAM'])) ? $_POST['inputAM'] : null;
    $inputRFC = $_POST['inputRFC'];
    $inputPorcDesc = $_POST['inputPorcDesc'];
    $inputTel = (isset($_POST['inputTel'])) ? $_POST['inputTel'] : null;
    $inputCel = (isset($_POST['inputCel'])) ? $_POST['inputCel'] : null;
    $inputMail = (isset($_POST['inputMail'])) ? $_POST['inputMail'] : null;
    $inputStreet = (isset($_POST['inputCalle'])) ? $_POST['inputCalle'] : null;
    $inputNum = (isset($_POST['inputNum'])) ? $_POST['inputNum'] : null;
    $inputCol = (isset($_POST['inputCol'])) ? $_POST['inputCol'] : null;
    $inputMun = (isset($_POST['inputMun'])) ? $_POST['inputMun'] : null;
    $inputEdo = (isset($_POST['inputEdo'])) ? $_POST['inputEdo'] : null;
    

	$sqlUpdateClient = "UPDATE $tClients SET nombre='$inputNombre', ap='$inputAP', am='$inputAM', calle='$inputStreet', numero='$inputNum', colonia='$inputCol', municipio='$inputMun', estado='$inputEdo', telefono='$inputTel', celular='$inputCel', correo='$inputMail', rfc='$inputRFC', porc_desc='$inputPorcDesc', actualizado='$dateNow $timeNow' WHERE id='$idClient' ";

	if($con->query($sqlUpdateClient) === TRUE ){
		echo json_encode(array("error"=>0, "msgErr"=>$msgErr));
	}else{
		$msgErr = 'Error: No se puedo modificar cliente.'.$con->error;
		echo json_encode(array("error"=>1, "msgErr"=>$msgErr));
	}
  
?> 