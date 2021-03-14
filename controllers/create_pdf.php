<?php

	//fpdf
  require('../fpdf/fpdf.php');
	
    class PDF extends FPDF{
    // Cabecera de página
      function Header(){
        $this->SetFont('Arial','B',8);
        // Movernos a la derecha
        $this->Cell(1,1);
        // Título      
        $this->Cell(50, 25, '', 0, 0, 'C', $this->Image('../assets/img/logo.jpg', 20, 12, 50));
		$this->Cell(0, 25, utf8_decode('COTIZACIÓN'), 0, 1, 'R');							
        // Salto de línea
        $this->Ln(9);
      }
      // Pie de página
      function Footer(){
        // Posición: a 3,5 cm del final
        $this->SetY(-45);
        $this->SetFont('Arial','I',8);
        $this->Cell(10, 7, 'Nombre', 0, 1, 'L');
        $this->Cell(10, 7, 'Dirección', 0, 1, 'L');
        $this->Cell(10, 7, 'RFC', 0, 1, 'L');
        $this->Cell(0, 7, 'Teléfono', 0, 1, 'L');
        $this->Cell(0,7,'Pag. '.$this->PageNo().'/{nb}', 0, 0, 'R');
      }
    }//Fin class PDF
    // Creación del objeto de la clase heredada
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Times','',9);
	
	$pdf->Cell(100, 10, utf8_decode('Cliente:'), 0, 0, 'L');
	$pdf->Cell(50, 10, utf8_decode('Fecha:'), 0, 1, 'R');
	
	$pdf->SetFont('Times','',7);
	$pdf->Cell(10, 7, utf8_decode('No.'), 1, 0, 'C');
	$pdf->Cell(40, 7, utf8_decode('Imagen'), 1, 0, 'C');
	$pdf->Cell(70, 7, utf8_decode('Concepto'), 1, 0, 'C');
	$pdf->Cell(20, 7, utf8_decode('C.U.'), 1, 0, 'C');
	$pdf->Cell(20, 7, utf8_decode('Cantidad'), 1, 0, 'C');
	$pdf->Cell(20, 7, utf8_decode('C.T.'), 1, 1, 'C');
	
	for($i = 0; $i < 5; $i++){
		$pdf->Cell(10, 30, $i+1, 1, 0, 'C');
		$pdf->Cell(40, 30, '', 1, 0, 'C', $pdf->Image('../assets/img/logo.jpg', $pdf->GetX()+5, $pdf->GetY()+5, 30));
		$pdf->Cell(70, 30, utf8_decode('Desc'), 1, 0, 'C');
		$pdf->Cell(20, 30, utf8_decode('C.U.'), 1, 0, 'C');
		$pdf->Cell(20, 30, utf8_decode('Cant.'), 1, 0, 'C');
		$pdf->Cell(20, 30, utf8_decode('Importe'), 1, 1, 'C');
	}
	
	$pdf->Output();
	
?>