<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

require('fpdf/fpdf.php');
include 'db.php';

$username = $_SESSION['username'];

// Fetch user details
$query = "SELECT email FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$email = htmlspecialchars($user['email'], ENT_QUOTES);

// Fetch blood donation records
$query1 = "SELECT blood_group, quantity, location FROM blood_groups WHERE username = ?";
$stmt1 = $conn->prepare($query1);
$stmt1->bind_param("s", $username);
$stmt1->execute();
$result1 = $stmt1->get_result();

// Create PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Title
$pdf->Cell(0, 10, 'Blood Donation Report', 0, 1, 'C');
$pdf->Ln(10);

// Thank You Message
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 10, "Dear $username,\n\nThank you for your generous blood donations. Your contributions play a vital role in saving lives and ensuring a steady blood supply for those in need.", 0, 'L');
$pdf->Ln(5);

// User information
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, "User Details:", 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, "Username: $username", 0, 1);
$pdf->Cell(0, 10, "Email: $email", 0, 1);
$pdf->Ln(10);

// Table Header
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 10, 'Blood Group', 1);
$pdf->Cell(50, 10, 'Quantity', 1);
$pdf->Cell(90, 10, 'Location', 1);
$pdf->Ln();

// Table Content
$pdf->SetFont('Arial', '', 12);
if ($result1->num_rows > 0) {
    while ($row = $result1->fetch_assoc()) {
        $pdf->Cell(50, 10, htmlspecialchars($row['blood_group'], ENT_QUOTES), 1);
        $pdf->Cell(50, 10, htmlspecialchars($row['quantity'], ENT_QUOTES), 1);
        $pdf->Cell(90, 10, htmlspecialchars($row['location'], ENT_QUOTES), 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(0, 10, 'No blood donation records found.', 1, 1, 'C');
}
$pdf->Ln(10);

// Inspiring Quote
$pdf->SetFont('Arial', 'I', 12);
$pdf->SetTextColor(128, 0, 128);
$pdf->MultiCell(0, 10, '"The gift of blood is the gift of life. There is no substitute for human blood."');
$pdf->Ln(5);

// Future Goals
$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(0, 10, "Your donations have a lasting impact. We encourage you to continue donating and inspiring others to join this noble cause. Together, we can build a healthier and stronger community.");
$pdf->Ln(5);

// Final Encouragement
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Keep donating, keep saving lives!', 0, 1, 'C');

// Output the PDF
$pdf->Output('D', 'Blood_Donation_Report.pdf');
?>
