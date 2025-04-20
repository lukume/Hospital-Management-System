<?php
    include '../db_connect.php';
    require('../fpdf/fpdf.php');

    $vid = $_GET['vid'];
    $qry = $conn->query("SELECT  prescription.*, med_details.id as mid, med_details.packing, med_details.price, medicine.mname FROM  prescription INNER JOIN med_details ON med_details.id=prescription.med_id INNER JOIN medicine On medicine.id=med_details.med_id WHERE prescription.visit_id='$vid'");

    $doc_idd = $conn->query("SELECT * FROM patients_visit WHERE id='$vid'")->fetch_array()['doc_id'];
    $p_idd = $conn->query("SELECT * FROM patients_visit WHERE id='$vid'")->fetch_array()['patient_id'];
    $doc = $conn->query("SELECT * FROM doctors WHERE id='$doc_idd'");
    $pat = $conn->query("SELECT * FROM patients WHERE id='$p_idd'");
    foreach ($doc->fetch_array() as $k => $val) {
        $m[$k] = $val;
    }

    foreach ($pat->fetch_array() as $k => $val) {
        $p[$k] = $val;
    }

    $bill = $conn->query("SELECT * FROM bill WHERE visit_id='$vid'");
    foreach ($bill->fetch_array() as $k => $val) {
        $b[$k] = $val;
    }

    $pdf = new FPDF('p', 'mm', 'A4');

    $pdf->AddPage();

    $pdf->SetFont('Arial', 'B', 20);
    $pdf->Cell(71, 10, '', 0, 0);
    $pdf->Cell(59, 5, 'Invoice', 0, 0);
    $pdf->Cell(59, 10, '', 0, 1);

    $pdf->SetFont('Arial', '', 15);
    $pdf->Cell(180, 2, '--------------------------------------------', 0, 1, 'C');
    $pdf->Cell(25, 5, '', 0,1);

    $pdf->SetFont('Arial', 'B', 15);
    $pdf->Cell(34, 5, 'Invoice N0: ', 0, 0);
    $pdf->SetFont('Arial', '', 15);
    $pdf->Cell(100, 5, $b['invoice_no'], 0, 0);
    $pdf->SetFont('Arial', 'B', 15);
    $pdf->Cell(34, 5, 'Doctor Details', 0, 1);

    $pdf->SetFont('Arial', 'B', 15);
    $pdf->Cell(34, 5, 'Date: ', 0, 0);
    $pdf->SetFont('Arial', '', 15);
    $pdf->Cell(100, 5, date('d M, Y', strtotime($b['bill_date'])), 0, 0);
    $pdf->SetFont('Arial', 'B', 15);
    $pdf->Cell(59, 5, '---------------------', 0, 1);

    $pdf->Cell(134, 5, '', 0, 0);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(25, 5, 'Doc ID: ', 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(34, 5, $m['docid'], 0, 1);

    $pdf->Cell(134, 5, '', 0, 0);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(25, 5, 'Doc Fee: ', 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(34, 5, "KES".number_format($m['docfees'], 2), 0, 1);

    $pdf->Cell(34, 10, '', 0, 1);

    $pdf->Cell(120, 5, '', 0, 0);
    $pdf->SetFont('Arial', 'B', 15);
    $pdf->Cell(59, 5, 'Patient Details', 0, 1);

    $pdf->Cell(120, 5, '', 0, 0);
    $pdf->SetFont('Arial', 'B', 15);
    $pdf->Cell(59, 5, '---------------------', 0, 1);

    $pdf->Cell(120, 5, '', 0, 0);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(34, 5, 'Patient Names: ', 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(40, 5, $p['pname'], 0, 1);

    $pdf->Cell(120, 5, '', 0, 0);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(34, 5, 'Patient N0: ', 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(40, 5, $p['pno'], 0, 1);

    $pdf->Cell(34, 10, '', 0, 1);

    $pdf->SetFont('Arial', 'B', 10);
    // Table Heading
    $pdf->Cell(10, 6, '#', 1, 0, 'C');
    $pdf->Cell(60, 6, 'Medicine', 1, 0, 'C');
    $pdf->Cell(40, 6, 'Packing', 1, 0, 'C');
    $pdf->Cell(40, 6, 'Price', 1, 0, 'C');
    $pdf->Cell(20, 6, 'Dosage', 1, 1, 'C');
    // Table heading ends

    $serial = 1;
    $total = 0; 
    while ($row = $qry->fetch_array()) {
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(10, 6, $serial, 1, 0, 'C');
        $pdf->Cell(60, 6, $row['mname'], 1, 0, 'C');
        $pdf->Cell(40, 6, $row['packing'], 1, 0, 'C');
        $pdf->Cell(40, 6, "KES".number_format($row['price'], 2), 1, 0, 'C');
        $pdf->Cell(20, 6, $row['dosage'], 1, 1, 'C');
        $serial++;
        $total += $row['price'];
        $grand_total = $total + $m['docfees'];
    }

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(110, 6, 'Total', 1, 0, 'R');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(40, 6, "KES".number_format($total, 2), 1, 1, 'C');

    $pdf->Cell(34, 10, '', 0, 1);
    $pdf->Cell(34, 10, '', 0, 1);

    $pdf->Cell(130, 5, '', 0, 0);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(59, 5, '---------------------------------------', 0, 1);

    $pdf->Cell(130, 5, '', 0, 0);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(30, 5, 'Grand Total: ', 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(34, 5, "KES".number_format($grand_total, 2), 0, 1);

    $pdf->Cell(130, 5, '', 0, 0);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(25, 5, 'Status: ', 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(34, 5, 'Not Paid', 0, 1);
    
    $pdf->Output();