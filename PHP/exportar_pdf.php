<?php
require('fpdf/fpdf.php'); // Asegúrate de que la ruta sea correcta
include "conexion.php";

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(190, 10, 'Lista de Empleados', 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(30, 10, 'ID', 1);
$pdf->Cell(60, 10, 'Nombre', 1);
$pdf->Cell(50, 10, 'Cargo', 1);
$pdf->Cell(50, 10, 'Salario', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 12);

$result = $conexion->query("SELECT * FROM empleados");
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(30, 10, $row['id'], 1);
    $pdf->Cell(60, 10, $row['nombre'], 1);
    $pdf->Cell(50, 10, $row['cargo'], 1);
    $pdf->Cell(50, 10, $row['salario'], 1);
    $pdf->Ln();
}

$pdf->Output('D', 'empleados.pdf'); 

$conn->close();
?>
