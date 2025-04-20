<?php
    require('../fpdf/fpdf.php');
    include 'db_connect.php';

    $pdf = new FPDF('p', 'mm', 'A4');

    $pdf->AddPage();

    $pdf->SetFont('Arial', 'B', 20);
    $pdf->Cell(71, 10, '', 0, 0);
    $pdf->Cell(59, 5, 'Doctor Details', 0, 0);
    $pdf->Cell(59, 10, '', 0, 1);

    $pdf->SetFont('Arial', 'B', 15);
    $pdf->Cell(71, 5, 'WET', 0, 0);
    $pdf->Cell(59, 5, '', 0, 0);
    $pdf->Cell(59, 5, 'Details', 0, 1);

    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(130, 5, 'Near Voi', 0, 0);
    $pdf->Cell(25, 5, 'Customer ID:', 0, 0);
    $pdf->Cell(34, 5, 'CUS200', 0, 1);

    $pdf->Cell(130, 5, 'City, 751001', 0, 0);
    $pdf->Cell(25, 5, 'Invoice Date:', 0, 0);
    $pdf->Cell(34, 5, '12th Jan 2019', 0, 1);

    $pdf->Cell(50, 10, '', 0, 1);

    $pdf->SetFont('Arial', 'B', 10);
    // heading of the table
    $pdf->Cell(10, 6, 'S1', 1, 0, 'C');
    $pdf->Cell(80, 6, 'Description', 1, 0, 'C');
    $pdf->Cell(23, 6, 'Qty', 1, 0, 'C');
    $pdf->Cell(30, 6, 'Unit Price', 1, 0, 'C');
    $pdf->Cell(20, 6, 'Sales Tax', 1, 0, 'C');
    $pdf->Cell(20, 6, 'Total', 1, 1, 'C');
    // Heading of the table ends

    $pdf->SetFont('Arial', 'B', 10);

    $pdf->Output();