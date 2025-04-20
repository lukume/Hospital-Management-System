<?php
    require('../fpdf/fpdf.php');
    include '../db_connect.php';

    $d_from = $_GET['d_from'];
    $d_to = $_GET['d_to'];

    $qry = $conn->query("SELECT  patients_visit.*, patients.pno, doctors.docid FROM  patients_visit INNER JOIN patients ON patients.id=patients_visit.patient_id INNER JOIN doctors ON doctors.id=patients_visit.doc_id WHERE patients_visit.visit_date BETWEEN '$d_from' AND '$d_to'");


    $pdf = new FPDF('p', 'mm', 'A4');

    $pdf->AddPage();

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(71, 10, '', 0, 0);
    $pdf->Cell(59, 5, 'D Hospital', 0, 0, 'C');
    $pdf->Cell(59, 10, '', 0, 1);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(71, 10, '', 0, 0);
    $pdf->Cell(59, 5, 'Patient Visits', 0, 0, 'C');
    $pdf->Cell(59, 10, '', 0, 1);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(71, 10, '', 0, 0);
    $pdf->Cell(59, 5, 'From: '.$d_from.' To: '.$d_to, 0, 0, 'C');
    $pdf->Cell(59, 10, '', 0, 1);

    $pdf->SetFont('Arial', 'B', 15);
    $pdf->Cell(71, 10, '', 0, 0);
    $pdf->Cell(59, 5, '', 0, 0, 'C');
    $pdf->Cell(59, 10, '', 0, 1);

    $pdf->SetFont('Arial', 'B', 8);
    // heading of the table
    $pdf->Cell(10, 6, 'S1', 1, 0, 'C');
    $pdf->Cell(30, 6, 'Patient N0', 1, 0, 'C');
    $pdf->Cell(30, 6, 'Doctor N0', 1, 0, 'C');
    $pdf->Cell(40, 6, 'Visit Date', 1, 0, 'C');
    $pdf->Cell(20, 6, 'BP', 1, 0, 'C');
    $pdf->Cell(20, 6, 'Weight', 1, 0, 'C');
    $pdf->Cell(40, 6, 'Disease', 1, 1, 'C');
    // Heading of the table ends

    $pdf->SetFont('Arial', '', 8);
    $s1 = 1;
    while ($row = $qry->fetch_array()) {
        $pdf->Cell(10, 6, $s1, 1, 0, 'C');
        $pdf->Cell(30, 6, $row['pno'], 1, 0, 'C');
        $pdf->Cell(30, 6, $row['docid'], 1, 0, 'C');
        $pdf->Cell(40, 6, date('d M, Y', strtotime($row['visit_date'])), 1, 0, 'C');
        $pdf->Cell(20, 6, $row['bp'], 1, 0, 'C');
        $pdf->Cell(20, 6, $row['weight'].'kg', 1, 0, 'C');
        $pdf->Cell(40, 6, $row['disease'], 1, 1, 'C');

        $s1++;
    }

    $pdf->Output();
?>