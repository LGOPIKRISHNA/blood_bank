<?php
session_start(); // Start session to access session variables

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    echo "You must be an admin to access this page.";
    exit(); // Stop the execution if not an admin
}

require_once('fpdf.php'); // Include the TCPDF library

// Database connection
include 'db.php';

// Fetch blood groups from the database, including the email field
$query = "SELECT blood_group, quantity, location, email FROM blood_groups";
$result = $conn->query($query);

// Create a new TCPDF object
$pdf = new FPDF();
// $pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Blood Groups Report');
$pdf->SetMargins(10, 10, 10);
$pdf->AddPage();

// Set the header
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, 'Available Blood Groups Report', 0, 1, 'C');

// Add a line break
$pdf->Ln(10);

// Set the table header
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(40, 7, 'Blood Group', 1);
$pdf->Cell(40, 7, 'Quantity', 1);
$pdf->Cell(40, 7, 'Location', 1);
$pdf->Cell(40, 7, 'Email', 1);
$pdf->Ln();

// Set the table rows
$pdf->SetFont('helvetica', '', 10);
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(40, 7, $row['blood_group'], 1);
    $pdf->Cell(40, 7, $row['quantity'], 1);
    $pdf->Cell(40, 7, $row['location'], 1);
    $pdf->Cell(40, 7, $row['email'], 1);
    $pdf->Ln();
}

// Output the PDF as a download
$pdf->Output('blood_groups_report1.pdf', 'D');
exit();
?>
