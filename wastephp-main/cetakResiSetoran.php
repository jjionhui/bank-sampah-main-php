<?php
require 'fpdf/fpdf.php';
require 'functions.php';

// Ambil ID Setoran dari form atau URL
$idSetor = $_GET['idSetoran'];

// Query data berdasarkan idSetor
$setoran = query("SELECT * FROM setoran WHERE idSetor = '$idSetor'")[0];
$idUser = $setoran['idUser'];
$idSampah = $setoran['idSampah'];

$user = query("SELECT namaUser FROM users WHERE idUser = '$idUser'")[0];
$sampah = query("SELECT namaSampah, harga FROM sampah WHERE idSampah = '$idSampah'")[0];

// Inisialisasi FPDF
$pdf = new FPDF('P', 'mm', array(80, 150)); // Ukuran kertas custom menyerupai resi ATM
$pdf->AddPage();
$pdf->SetMargins(5, 5, 5);
$pdf->SetFont('Arial', '', 10);

// Header Resi
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
$pdf->Cell(0, 5, 'Resi Setoran Sampah', 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(30, 5, 'ID Setoran:', 0, 0);
$pdf->Cell(0, 5, $setoran['idSetor'], 0, 1);

$pdf->Cell(30, 5, 'Nama Penyetor:', 0, 0);
$pdf->Cell(0, 5, $user['namaUser'], 0, 1);

$pdf->Cell(30, 5, 'Tanggal:', 0, 0);
$pdf->Cell(0, 5, $setoran['tglSetor'], 0, 1);

$pdf->Cell(30, 5, 'Nama Sampah:', 0, 0);
$pdf->Cell(0, 5, $sampah['namaSampah'], 0, 1);

$pdf->Cell(30, 5, 'Berat:', 0, 0);
$pdf->Cell(0, 5, $setoran['berat'] . ' KG', 0, 1);

$pdf->Cell(30, 5, 'Harga/KG:', 0, 0);
$pdf->Cell(0, 5, 'Rp. ' . number_format($sampah['harga'], 2, ',', '.'), 0, 1);

$pdf->Cell(30, 5, 'Total:', 0, 0);
$pdf->Cell(0, 5, 'Rp. ' . number_format($setoran['total'], 2, ',', '.'), 0, 1);

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
$pdf->Output('I', 'Resi_Setoran_' . $setoran['idSetor'] . '.pdf');
?>
