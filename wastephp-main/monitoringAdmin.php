<?php
session_start();
require 'functions.php';

if (!isset($_SESSION["login"])) {
    echo "<script>
            alert('Anda Harus Login Terlebih Dahulu!');
            document.location.href ='login.php';
          </script>";
}

$id = $_SESSION["IdAdmin"];
$biodata = query("SELECT * FROM admins WHERE IdAdmin = '$id'")[0];
$conn = mysqli_connect("localhost", "root", "", "sampah");
$nama = mysqli_query($conn, "SELECT namaSampah FROM stock_sampah ORDER BY idStock ASC");
$stock = mysqli_query($conn, "SELECT stock FROM stock_sampah ORDER BY idStock ASC");

$title = "Grafik Monitoring";

// Ambil data dari tabel saldo_bank berdasarkan idTransaksi
$saldoBank = query("SELECT * FROM saldo_bank ORDER BY idTransaksi ASC");

// Buat dataset untuk grafik Saldo Bank
$idTransaksiList = [];
$jumlahTransaksi = [];
$totalSaldoPerId = [];

foreach ($saldoBank as $row) {
    $idTransaksi = $row['idTransaksi'];

    // Catat idTransaksi unik
    if (!in_array($idTransaksi, $idTransaksiList)) {
        $idTransaksiList[] = $idTransaksi;
    }

    // Catat jumlah per idTransaksi
    $jumlahTransaksi[$idTransaksi] = $row['totalSaldo'];

    // Catat total saldo per idTransaksi
    $totalSaldoPerId[$idTransaksi] = $row['jumlah'];
}

// Format data untuk grafik
$jumlahTransaksiDataset = array_values($jumlahTransaksi);
$totalSaldoDataset = array_values($totalSaldoPerId);
?>

<?php include_once("header.php"); ?>
<?php include_once("sidebar.php"); ?>

<!--**********************************
	Content body start
***********************************-->
<div class="content-body">
    <div class="container-fluid">
        <!-- row -->
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <!-- Grafik Jumlah Stok Sampah -->
                    <div class="col-lg-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Jumlah Stock Sampah</h4>
                            </div>
                            <div class="card-body">
                                <div class="container">
                                    <canvas id="myChart" width="100%" height="50%"></canvas>
                                </div>

                                <script>
                                    var ctx = document.getElementById("myChart");
                                    var myChart = new Chart(ctx, {
                                        type: 'bar',
                                        data: {
                                            labels: ["Kresek", "Plastik", "Karah Warna", "Botol mineral plastik", "Botol mineral kaca", "Gelas mineral plastik", "Kaleng", "Kardus/Karton", "Dedaunan", "Sampah hasil masak", "Besi", "Baja", "Tembaga", "Aluminium", "Zeng", "Kain", "Sandal dan Sepatu", "Lampu"],
                                            datasets: [{
                                                label: 'Jumlah Stock',
                                                data: [<?php while ($p = mysqli_fetch_array($stock)) { echo '"' . $p['stock'] . '",'; } ?>],
                                                backgroundColor: [
                                                    'rgba(255,99,132,1)',
                                                    'rgba(54, 162, 235, 1)',
                                                    'rgba(255, 206, 86, 1)',
                                                    'rgba(75, 192, 192, 1)',
                                                    'rgba(153, 102, 255, 1)',
                                                    'rgba(255, 159, 64, 1)',
                                                    'rgba(255, 99, 132, 1)',
                                                    'rgba(54, 162, 235, 1)',
                                                    'rgba(255, 206, 86, 1)',
                                                    'rgba(75, 192, 192, 1)',
                                                    'rgba(153, 102, 255, 1)',
                                                    'rgba(255, 159, 64, 1)',
                                                    'rgba(55, 100, 180, 1)',
                                                    'rgba(60, 170, 240, 1)',
                                                    'rgba(25, 20, 80, 1)',
                                                    'rgba(175, 195, 195, 1)',
                                                    'rgba(150, 100, 250, 1)',
                                                    'rgba(77, 66, 55, 1)'
                                                ],
                                                borderColor: 'transparent',
                                                borderWidth: 2.5,
                                                barPercentage: 0.8,
                                            }]
                                        },
                                        options: {
                                            scales: {
                                                yAxes: [{
                                                    ticks: {
                                                        stepSize: 15
                                                    }
                                                }]
                                            }
                                        }
                                    });
                                </script>
                            </div>
                        </div>
                    </div>

                    <!-- Grafik Saldo Bank -->
                    <div class="col-lg-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Grafik Saldo Bank</h4>
                            </div>
                            <div class="card-body">
                                <div id="chart-saldo-bank"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--**********************************
	Content body end
***********************************-->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    // Data untuk grafik Saldo Bank dari PHP
    var idTransaksiList = <?php echo json_encode($idTransaksiList); ?>;
    var jumlahTransaksiDataset = <?php echo json_encode($jumlahTransaksiDataset); ?>;
    var totalSaldoDataset = <?php echo json_encode($totalSaldoDataset); ?>;

    // Konfigurasi grafik Saldo Bank
    var optionsSaldoBank = {
        series: [
            {
                name: 'Total Saldo',
                data: jumlahTransaksiDataset,
            },
            {
                name: 'Jumlah Transaksi',
                data: totalSaldoDataset,
            },
        ],
        chart: {
            type: 'line', // Tipe grafik
            height: 350,
            zoom: { enabled: false },
        },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth' },
        title: { text: 'Grafik Saldo Bank Berdasarkan ID Transaksi', align: 'left' },
        xaxis: {
            categories: idTransaksiList, // idTransaksi sebagai sumbu X
        },
        yaxis: [
            {
                title: { text: 'Jumlah Transaksi' },
                min: 0,
                tickAmount: 5, // Pastikan kelipatan terlihat lebih jelas\
                labels: {
                    formatter: function (value) {
                        return value.toLocaleString(); // Format angka dengan koma
                    },
                },
            },
            {
                opposite: true,
                min: 0,
                tickAmount: 5, // Pastikan kelipatan terlihat lebih jelas
                title: { text: 'Total Saldo' },
                labels: {
                    formatter: function (value) {
                        return value.toLocaleString(); // Format angka dengan koma
                    },
                },
            },
        ],
    };

    // Render grafik Saldo Bank
    var chartSaldoBank = new ApexCharts(document.querySelector("#chart-saldo-bank"), optionsSaldoBank);
    chartSaldoBank.render();
</script>

<?php include_once("footer.php"); ?>
