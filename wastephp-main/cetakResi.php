<?php
require 'fpdf/fpdf.php';
require 'functions.php';

// Ambil data berdasarkan idTarik
$idTarik = $_GET['idTarik'];
$penarikan = query("SELECT * FROM penarikan WHERE idTarik = '$idTarik'")[0];
$idUser = $penarikan['idUser'];
$user = query("SELECT * FROM users WHERE idUser = '$idUser'")[0];

// Inisialisasi FPDF
$pdf = new FPDF('P', 'mm', array(80, 150)); // Ukuran kertas custom menyerupai resi ATM
$pdf->AddPage();
$pdf->SetMargins(5, 5, 5);
$pdf->SetFont('Arial', '', 10);

// Header
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 8, 'PT. Waste Bank Mks', 0, 1, 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 5, 'Jl. Contoh No. 123, Jakarta', 0, 1, 'C');
$pdf->Cell(0, 5, 'Telp: (021) 12345678', 0, 1, 'C');
$pdf->Ln(2);
$pdf->Cell(0, 5, str_repeat('-', 40), 0, 1, 'C');

// Detail Transaksi
$pdf->Ln(2);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 5, 'Resi Penarikan Saldo', 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(30, 5, 'ID Penarikan:', 0, 0);
$pdf->Cell(0, 5, $penarikan['idTarik'], 0, 1);

$pdf->Cell(30, 5, 'Nama Penarik:', 0, 0);
$pdf->Cell(0, 5, $user['namaUser'], 0, 1);

$pdf->Cell(30, 5, 'Tanggal:', 0, 0);
$pdf->Cell(0, 5, $penarikan['tglTarik'], 0, 1);

$pdf->Cell(30, 5, 'Waktu:', 0, 0);
$pdf->Cell(0, 5, date('H:i:s'), 0, 1);

$pdf->Cell(30, 5, 'Jumlah:', 0, 0);
$pdf->Cell(0, 5, "Rp. " . number_format($penarikan['jmlPenarikan'], 2, ",", "."), 0, 1);

// Footer
$pdf->Ln(10);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 5, str_repeat('-', 40), 0, 1, 'C');
$pdf->Ln(2);
$pdf->Cell(0, 5, 'Terima Kasih', 0, 1, 'C');
$pdf->Cell(0, 5, 'Telah Menggunakan Layanan Kami', 0, 1, 'C');
$pdf->Ln(5);
$pdf->Cell(0, 5, '***', 0, 1, 'C');

// Output file PDF
$pdf->Output('I', 'Resi_Penarikan_' . $penarikan['idTarik'] . '.pdf');
?>
