<?php
  include ('../config/conexion.php');
  include ('../config/variables.php');

  $idStore = $_POST['idStore'];
  $idUser = $_POST['idUser'];

  $total = $_POST['inputTotal'];
  $totalDesc = $_POST['inputTotal2'];
  $descuentoDesc = $_POST['inputDesc'];
  $cantDesc = $_POST['inputCantDesc'];
  
  $inputNombre = $_POST['inputNombre'];
  $inputAP = $_POST['inputAP'];
  $inputAM = (isset($_POST['inputAM'])) ? $_POST['inputAM'] : null;
  $inputRFC = $_POST['inputRFC'];
  $inputTel = (isset($_POST['inputTel'])) ? $_POST['inputTel'] : null;
  $inputCel = (isset($_POST['inputCel'])) ? $_POST['inputCel'] : null;
  $inputMail = (isset($_POST['inputMail'])) ? $_POST['inputMail'] : null;
  $inputStreet = (isset($_POST['inputCalle'])) ? $_POST['inputCalle'] : null;
  $inputNum = (isset($_POST['inputNum'])) ? $_POST['inputNum'] : null;
  $inputCol = (isset($_POST['inputCol'])) ? $_POST['inputCol'] : null;
  $inputMun = (isset($_POST['inputMun'])) ? $_POST['inputMun'] : null;
  $inputEdo = (isset($_POST['inputEdo'])) ? $_POST['inputEdo'] : null;
  
  $cad = '';
  $ban = true; 
  $msgErr = '';
  
  //fpdf
  require('../fpdf/fpdf.php');
  
	
	
    class PDF extends FPDF{
	  // Cabecera de página
      function Header(){
        $this->SetFont('Arial','B',8);
        // Movernos a la derecha
        $this->Cell(1,1);
        // Título      
        $this->Cell(50, 25, '', 0, 0, 'C', $this->Image('../assets/img/felcy_2.png', 20, 12, 50));
		$this->Cell(0, 25, utf8_decode('COTIZACIÓN'), 0, 1, 'R');							
        // Salto de línea
        $this->Ln(9);
      }
      // Pie de página
      function Footer(){
		  include ('../config/conexion.php');
		  $idStore = $_POST['idStore'];
		  //Obtenemos información de la tienda
			$sqlGetStore = "SELECT * FROM $tStore WHERE id='$idStore' ";
			$resGetStore = $con->query($sqlGetStore);
			$rowGetStore = $resGetStore->fetch_assoc();
			$nameStore = $rowGetStore['nombre'];
			$addressStore = $rowGetStore['direccion'];
			$rfcStore = $rowGetStore['rfc'];
			$telStore = $rowGetStore['tel'];
        // Posición: a 3,5 cm del final
        $this->SetY(-45);
        $this->SetFont('Arial','I',8);
        $this->Cell(10, 7, $nameStore, 0, 1, 'L');
        $this->Cell(10, 7, $addressStore, 0, 1, 'L');
        $this->Cell(10, 7, $rfcStore, 0, 1, 'L');
        $this->Cell(0, 7, $telStore, 0, 1, 'L');
        $this->Cell(0,7,'Pag. '.$this->PageNo().'/{nb}', 0, 0, 'R');
      }
    }//Fin class PDF
    // Creación del objeto de la clase heredada
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Times','',12);
	$pdf->Cell(100, 10, utf8_decode('Cliente: '.$inputNombre.' '.$inputAP.' '.$inputAM), 0, 0, 'L');
	$pdf->Cell(50, 10, utf8_decode('Fecha: '.$dateNow), 0, 1, 'R');
    
	$pdf->SetFillColor(0, 128, 255); //fondo azul
	$pdf->SetTextColor(250, 255, 240); //letra color blanco
	$pdf->SetFont('Times','',10);
	$pdf->Cell(10, 7, utf8_decode('No.'), 1, 0, 'C', true);
	$pdf->Cell(40, 7, utf8_decode('Imagen'), 1, 0, 'C', true);
	$pdf->Cell(70, 7, utf8_decode('Concepto'), 1, 0, 'C', true);
	$pdf->Cell(20, 7, utf8_decode('C.U.'), 1, 0, 'C', true);
	$pdf->Cell(20, 7, utf8_decode('Cantidad'), 1, 0, 'C', true);
	$pdf->Cell(20, 7, utf8_decode('C.T.'), 1, 1, 'C', true);
  
  
  //Insertamos Cotizador
  $sqlInsertPricer = "INSERT INTO $tPricer (nombre, ap, am, calle, numero, colonia, municipio, estado, telefono, celular, correo, rfc, creado) VALUES ('$inputNombre', '$inputAP', '$inputAM', '$inputStreet', '$inputNum', '$inputCol', '$inputMun', '$inputEdo', '$inputTel', '$inputCel', '$inputMail', '$inputRFC', '$dateNow $timeNow' ) ";
  if($con->query($sqlInsertPricer) === TRUE){
	  $idPricer = $con->insert_id;
	  //Insertamos cotizacion_info
	  $sqlInsertPriceInfo = "INSERT INTO $tPriceInfo (folio, usuario_id, tienda_id, fecha, subtotal, porc_desc, total, cotizador_id) VALUES ('$dateNow', '$idUser', '$idStore', '$dateNow $timeNow', '$total', '$descuentoDesc', '$totalDesc', '$idPricer' ) ";
	  if($con->query($sqlInsertPriceInfo) === TRUE){
		  $idPriceInfo = $con->insert_id;
		  $pdf->SetFillColor(229, 229, 229);
		  $pdf->SetTextColor(3, 3, 3);
		  $banColor = false;
		  //Insertamos los productos de la cotización
		  for($i = 0; $i < count($_POST['id']); $i++){
			$idProduct = $_POST['id'][$i];
            $cant = $_POST['inputCant'][$i];
            $costoU = $_POST['inputPrecioU'][$i];
            $costoF = $_POST['inputPrecioF'][$i];
			$sqlInsertProductPrice = "INSERT INTO $tPriceProd (producto_id, cotizacion_id, cantidad, costo_unitario, costo_total) VALUES ('$idProduct', '$idPriceInfo', '$cant', '$costoU', '$costoF') ";
			if($con->query($sqlInsertProductPrice) === TRUE){
				$sqlGetProductInfo = "SELECT img, nombre, descripcion FROM $tProduct WHERE id='$idProduct' ";
				$resGetProductInfo = $con->query($sqlGetProductInfo);
				$rowGetProductInfo = $resGetProductInfo->fetch_assoc();
				$pdf->Cell(10, 30, $i+1, 1, 0, 'C', $banColor);
				$pdf->Cell(40, 30, '', 1, 0, 'C', $pdf->Image('../uploads/'.$rowGetProductInfo['img'], $pdf->GetX()+5, $pdf->GetY()+5, 30, 25));
				$pdf->Cell(70, 30, utf8_decode($rowGetProductInfo['nombre']), 1, 0, 'C', $banColor);
				$pdf->Cell(20, 30, utf8_decode($costoU), 1, 0, 'C', $banColor);
				$pdf->Cell(20, 30, utf8_decode($cant), 1, 0, 'C', $banColor);
				$pdf->Cell(20, 30, utf8_decode($costoF), 1, 1, 'C', $banColor);
				$banColor = !$banColor;
				//continue;
			}else{
				$ban = false;
				$msgErr .= 'Error: No se pude insertar el producto de la cotización. '.$con->error;
				break;
			}
		  }
		  //Insertamos total
		    $pdf->Cell(10, 7, '', 1, 0, 'C');
			$pdf->Cell(40, 7, '', 1, 0, 'C');
			$pdf->Cell(70, 7, '', 1, 0, 'C');
			$pdf->Cell(20, 7, '', 1, 0, 'C');
			$pdf->Cell(20, 7, 'Subtotal', 1, 0, 'C');
			$pdf->Cell(20, 7, $total, 1, 1, 'C');
			$pdf->Cell(10, 7, '', 1, 0, 'C');
			$pdf->Cell(40, 7, '', 1, 0, 'C');
			$pdf->Cell(70, 7, '', 1, 0, 'C');
			$pdf->Cell(20, 7, '', 1, 0, 'C');
			$pdf->Cell(20, 7, 'Descuento', 1, 0, 'C');
			$pdf->Cell(20, 7, $descuentoDesc.' %', 1, 1, 'C');
			$pdf->Cell(10, 7, '', 1, 0, 'C');
			$pdf->Cell(40, 7, '', 1, 0, 'C');
			$pdf->Cell(70, 7, '', 1, 0, 'C');
			$pdf->Cell(20, 7, '', 1, 0, 'C');
			$pdf->Cell(20, 7, 'Total', 1, 0, 'C');
			$pdf->Cell(20, 7, $totalDesc, 1, 1, 'C');
	  }else{
		  $ban = false;
		  $msgErr .= 'Error: No se pudo insertar la información de la cotización.';
	  }
  }else{
	  $ban = false;
	  $msgErr .= 'Error: No se pudo insertar cotizador.';
  }
  $pdf->Output();
  /*if($ban){
	  echo "Exito";
  }else{
	  echo "Fracaso<br>";
	  echo $msgErr;
  }*/

?>