<?php 
session_start();
require 'functions.php';

// Memeriksa apakah pengguna sudah login
if (!isset($_SESSION["login"])) {
    echo "<script>
            alert('Anda Harus Login Terlebih Dahulu!');
            document.location.href ='login.php';
          </script>";
}

$id = $_SESSION["IdAdmin"];
$biodata = query("SELECT * FROM admins WHERE IdAdmin = '$id'")[0];

// Mengambil data saldo bank
$no = mysqli_query($conn, "SELECT * FROM saldo_bank");
$jumlahData = mysqli_num_rows($no);
$hitung = $jumlahData - 1;

if ($hitung < 0) {
    $saldoAkhir = 0;
} else {
    $saldo = query("SELECT * FROM saldo_bank")[$hitung];
    $saldoAkhir = ($saldo['totalSaldo']);
}

// Mengambil data stock sampah
$stock = query("SELECT stock FROM stock_sampah");

// Mengambil data pengguna
$users = mysqli_query($conn, "SELECT * FROM users");
$jumlahDataUsers = mysqli_num_rows($users);
$total = 0;
foreach ($stock as $row) {
    $total += $row['stock'];
}

$title = "Admin";



// Mengambil data dari tabel penjualan
$penjualan = query("SELECT tglPenjualan, SUM(harga * berat) AS totalPendapatan FROM penjualan GROUP BY tglPenjualan ORDER BY tglPenjualan ASC");

// Format data untuk grafik
$tanggalPenjualan = [];
$totalPendapatanPerTanggal = [];

foreach ($penjualan as $row) {
    $tanggalPenjualan[] = $row['tglPenjualan'];
    $totalPendapatanPerTanggal[] = (float) $row['totalPendapatan'];
}

// Fetch Penarikan Data
$penarikan = query("SELECT * FROM penarikan ORDER BY tglTarik ASC");

// Ambil data dari database
$penarikan = query("SELECT * FROM penarikan");

// Buat dataset untuk grafik
$penarikanDatasets = [];
$tanggalSetoranUnique = [];

foreach ($penarikan as $row) {
    $tanggal = $row['tglTarik'];
    $userId = $row['idUser'];

    // Rekap jumlah per user per tanggal
    if (!isset($penarikanDatasets[$userId])) {
        $penarikanDatasets[$userId] = [];
    }

    if (!isset($penarikanDatasets[$userId][$tanggal])) {
        $penarikanDatasets[$userId][$tanggal] = 0;
    }

    $penarikanDatasets[$userId][$tanggal] += $row['jmlPenarikan'];

    // Catat tanggal unik untuk x-axis grafik
    if (!in_array($tanggal, $tanggalSetoranUnique)) {
        $tanggalSetoranUnique[] = $tanggal;
    }
}

// Format data untuk grafik
$formattedPenarikanDatasets = [];
foreach ($penarikanDatasets as $userId => $dataPerTanggal) {
    $formattedPenarikanDatasets[] = [
        'name' => "User $userId",
        'data' => array_values(array_replace(array_fill_keys($tanggalSetoranUnique, 0), $dataPerTanggal)),
    ];
}

// Ambil data setoran untuk grafik berdasarkan idUser
$query = "
    SELECT 
        u.idUser, 
        s.tglSetor, 
        SUM(s.berat * sa.harga) AS total_setoran
    FROM setoran s
    JOIN users u ON s.idUser = u.idUser
    JOIN sampah sa ON s.idSampah = sa.idSampah
    GROUP BY u.idUser, s.tglSetor
    ORDER BY s.tglSetor ASC
";

$dataSetoran = query($query);

// Menyusun data untuk grafik setoran
$data_setoran_per_user = [];
foreach ($dataSetoran as $row) {
    if (!isset($data_setoran_per_user[$row['idUser']])) {
        $data_setoran_per_user[$row['idUser']] = [];
    }
    
    // Menambahkan total setoran ke array berdasarkan idUser dan tanggal
    if (!isset($data_setoran_per_user[$row['idUser']][$row['tglSetor']])) {
        $data_setoran_per_user[$row['idUser']][$row['tglSetor']] = 0;
    }
    
    // Menambahkan total setoran ke array berdasarkan idUser dan tanggal
    $data_setoran_per_user[$row['idUser']][$row['tglSetor']] += $row['total_setoran'];
}

// Menghilangkan duplikasi idUser dan tanggal
$uniqueUsersSetoran = array_keys($data_setoran_per_user);
$tanggalSetoranUnique = array_unique(array_reduce($data_setoran_per_user, function($carry, $item) {
   return array_merge($carry, array_keys($item));
}, []));

// Format data untuk grafik setoran
$setoranDatasets = [];
foreach ($uniqueUsersSetoran as $userId) {
   // Siapkan data untuk setiap user
   $userDataSetoran = [];
   
   foreach ($tanggalSetoranUnique as $date) {
       // Jika tidak ada setoran untuk tanggal ini, masukkan 0
       if (isset($data_setoran_per_user[$userId][$date])) {
           $userDataSetoran[] = (float)$data_setoran_per_user[$userId][$date];
       } else {
           $userDataSetoran[] = 0;
       }
   }

   // Tambahkan dataset ke grafik setoran
   array_push($setoranDatasets, [
       'name' => "ID User: " . htmlspecialchars($userId),
       'data' => array_values($userDataSetoran),
   ]);
}
?>

<?php include_once("header.php"); ?>
<?php include_once("sidebar.php"); ?>

<!--**********************************
	Content body start
***********************************-->
<div class="content-body">
	<div class="container-fluid">
		<!-- Dashboard Header -->
		<div class="card bg-primary text-white mb-4" style="height: 150px; position: relative;">
			<div class="card-body d-flex align-items-center justify-content-center">
				<h1 class="text-white">Dashboard</h1>
			</div>
		</div>

		<!-- Row for Media Body -->
		<div class="row mt-5">
			<div class="col-xl-4 col-lg-6 col-sm-6">
				<div class="widget-stat card bg-success">
					<div class="card-body p-4">
						<div class="media">
							<span class="me-3">
								<i class="la la-dollar"></i>
							</span>
							<div class="media-body text-white">
								<p class="mb-1">Jumlah Saldo Bank</p>
								<h3 class="text-white"><?php echo "Rp. " . number_format($saldoAkhir, 2, ",", ".") ?></h3>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-4 col-lg-6 col-sm-6">
				<div class="widget-stat card bg-primary">
					<div class="card-body p-4">
						<div class="media">
							<span class="me-3">
								<i class="la la-book"></i>
							</span>
							<div class="media-body text-white">
								<p class="mb-1">Jumlah Stock Sampah</p>
								<h3 class="text-white"><?php echo $total . " KG" ?></h3>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-4 col-lg-6 col-sm-6">
				<div class="widget-stat card bg-warning">
					<div class="card-body p-4">
						<div class="media">
							<span class="me-3">
								<i class="la la-users"></i>
							</span>
							<div class="media-body text-white">
								<p class="mb-1">Jumlah User Yang Aktif</p>
								<h3 class="text-white"><?php echo $jumlahDataUsers; ?></h3>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>

        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data Penarikan Pengguna</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive active-projects style-1">
                            <div class="tbl-caption">
                                <h4 class="heading mb-0">Data Penarikan Pengguna</h4>
                                <div class="d-flex">
                                    <a href="filterPenarikan.php" class="btn btn-secondary btn-sm me-2">Filter</a>
                                    <a href="penarikanAdmin.php" class="btn btn-primary btn-sm">+ Tambah</a>
                                </div>
                            </div>
                            <table id="empoloyees-tblwrapper" class="table">
                                <thead>
                                    <tr align="center">
                                        <th>No</th>
                                        <th>ID Penarikan</th>
                                        <th>Tanggal Penarikan</th>
                                        <th>ID User</th>
                                        <th>Nama Penarik</th>
                                        <th>Jumlah Saldo yang Ditarik</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($penarikan as $row) : ?>
                                        <?php $kode = $row["idUser"]; ?>
                                        <?php $namaUser = query("SELECT namaUser FROM users WHERE idUser = '$kode' "); ?>
                                        <tr align="center">
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $row['idTarik'] ?></td>
                                            <td><?php echo $row['tglTarik'] ?></td>
                                            <td><?php echo $row['idUser'] ?></td>
                                            <?php foreach ($namaUser as $user) : ?>
                                                <td><?php echo $user['namaUser']; ?></td>
                                            <?php endforeach; ?>
                                            <td><?php echo "Rp. " . number_format($row['jmlPenarikan'], 2, ",", ".") ?></td>
                                        </tr>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik Penarikan per User -->
        <div class="row mt-5">
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Grafik Penarikan per User</h4>
                        <div id="penarikanChart"></div> <!-- Div untuk grafik penarikan -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik Setoran per User -->
        <div class="row mt-5">
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Grafik Setoran per User</h4>
                        <div id="setoranChart"></div> <!-- Div untuk grafik setoran -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Grafik Penjualan -->
        <div class="row mt-5">
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Grafik Pendapatan Berdasarkan Tanggal Penjualan</h4>
                        <div id="penjualanChart"></div> <!-- Div untuk grafik penjualan -->
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- End of container-fluid -->
</div> <!-- End of content-body -->

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> <!-- Library ApexCharts -->
<script>
// Data untuk grafik penarikan
var optionsPenarikan = {
    series: <?php echo json_encode($formattedPenarikanDatasets); ?>,
    chart: {
        type: 'area',
        height: 350,
        zoom: { enabled: false }
    },
    dataLabels: { enabled: false },
    stroke: { curve: 'smooth' },
    title: { text: 'Jumlah Penarikan per User', align: 'left' },
    xaxis: { categories: <?php echo json_encode($tanggalSetoranUnique); ?> },
};

var chart = new ApexCharts(document.querySelector("#chart"), optionsPenarikan);
chart.render();

var chartPenarikan = new ApexCharts(document.querySelector("#penarikanChart"), optionsPenarikan);
chartPenarikan.render();

// Data untuk grafik setoran
var optionsSetoran = {
   series: <?php echo json_encode($setoranDatasets); ?>,
   chart: { type: 'area', height: 350, zoom: { enabled: false } },
   dataLabels: { enabled: false },
   stroke: { curve: 'smooth' },
   title: { text: 'Jumlah Setoran per User', align: 'left' },
   xaxis: { categories: <?php echo json_encode(array_values($tanggalSetoranUnique)); ?> },
};

var chartSetoran = new ApexCharts(document.querySelector("#setoranChart"), optionsSetoran);
chartSetoran.render();

    // Data untuk grafik penjualan
    var optionsPenjualan = {
        series: [{
            name: 'Total Pendapatan',
            data: <?php echo json_encode($totalPendapatanPerTanggal); ?>
        }],
        chart: {
            type: 'line', // Jenis grafik
            height: 350,
            zoom: { enabled: false }
        },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth' },
        title: { text: 'Grafik Pendapatan Berdasarkan Tanggal Penjualan', align: 'left' },
        xaxis: {
            categories: <?php echo json_encode($tanggalPenjualan); ?>,
            title: { text: 'Tanggal Penjualan' },
        },
        yaxis: {
            title: { text: 'Total Pendapatan (Rp)' },
            labels: {
                formatter: function(value) {
                    return "Rp. " + value.toLocaleString();
                }
            }
        },
    };

    var chartPenjualan = new ApexCharts(document.querySelector("#penjualanChart"), optionsPenjualan);
    chartPenjualan.render();

</script>

<?php include_once("footer.php"); ?>
