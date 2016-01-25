<<<<<<< HEAD
<?php
define('FPDF_FONTPATH','../font/');
require('../fpdf.php');

$pdf=new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'Hello World!');
$pdf->Output();
?>
=======
<?php
define('FPDF_FONTPATH','../font/');
require('../fpdf.php');

$pdf=new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'Hello World!');
$pdf->Output();
?>
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
