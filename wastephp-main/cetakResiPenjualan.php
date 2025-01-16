<?php
require 'fpdf/fpdf.php';
require 'functions.php';

// Ambil ID Penjualan dari URL
$idJual = $_GET['idJual'];

// Query data berdasarkan idJual
$penjualan = query("SELECT * FROM penjualan WHERE idJual = '$idJual'")[0];
$idSampah = $penjualan['idSampah'];

$sampah = query("SELECT namaSampah FROM sampah WHERE idSampah = '$idSampah'")[0];

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
$pdf->Cell(0, 5, 'Resi Penjualan Sampah', 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(30, 5, 'ID Penjualan:', 0, 0);
$pdf->Cell(0, 5, $penjualan['idJual'], 0, 1);

$pdf->Cell(30, 5, 'Nama Sampah:', 0, 0);
$pdf->Cell(0, 5, $sampah['namaSampah'], 0, 1);

$pdf->Cell(30, 5, 'Berat:', 0, 0);
$pdf->Cell(0, 5, $penjualan['berat'] . ' KG', 0, 1);

$pdf->Cell(30, 5, 'Tanggal:', 0, 0);
$pdf->Cell(0, 5, $penjualan['tglPenjualan'], 0, 1);

$pdf->Cell(30, 5, 'Nama Pembeli:', 0, 0);
$pdf->Cell(0, 5, $penjualan['namaPembeli'], 0, 1);

$pdf->Cell(30, 5, 'Nomor Pembeli:', 0, 0);
$pdf->Cell(0, 5, $penjualan['nomorPembeli'], 0, 1);

$pdf->Cell(30, 5, 'Harga:', 0, 0);
$pdf->Cell(0, 5, 'Rp. ' . number_format($penjualan['harga'], 2, ',', '.'), 0, 1);

$pdf->Cell(30, 5, 'Total:', 0, 0);
$pdf->Cell(0, 5, 'Rp. ' . number_format($penjualan['totalPendapatan'], 2, ',', '.'), 0, 1);

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
$pdf->Output('I', 'Resi_Penjualan_' . $penjualan['idJual'] . '.pdf');
?>
