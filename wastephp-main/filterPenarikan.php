<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "sampah");

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

if (!isset($_SESSION["login"])) {
    echo "<script>
            alert('Anda Harus Login Terlebih Dahulu!');
            document.location.href ='login.php';
          </script>";
    exit;
}

$title = "Filter Penarikan";

// Filter data jika form disubmit
if (isset($_POST['filter'])) {
    $tanggalAwal = $_POST['tanggalAwal'] ?? '';
    $tanggalAkhir = $_POST['tanggalAkhir'] ?? '';
    $userId = $_POST['userId'] ?? '';

    $query = "SELECT p.*, u.namaUser 
              FROM penarikan p 
              LEFT JOIN users u ON p.idUser = u.idUser 
              WHERE 1";

    if (!empty($tanggalAwal) && !empty($tanggalAkhir)) {
        $query .= " AND p.tglTarik BETWEEN '$tanggalAwal' AND '$tanggalAkhir'";
    }

    if (!empty($userId)) {
        $query .= " AND p.idUser = '$userId'";
    }

    $query .= " ORDER BY p.idTarik ASC";
    $penarikan = query($query);
} else {
    // Data default jika tidak ada filter
    $penarikan = query("SELECT p.*, u.namaUser 
                        FROM penarikan p 
                        LEFT JOIN users u ON p.idUser = u.idUser 
                        ORDER BY p.idTarik ASC");
}

// Mendapatkan daftar nama user untuk dropdown filter
$users = query("SELECT idUser, namaUser FROM users");
?>

<?php include_once("header.php"); ?>
<?php include_once("sidebar.php"); ?>

<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <div class="container-fluid">
        <h2 class="text-center">Filter Penarikan</h2>
        <div class="card mt-4">
            <div class="card-header">
                <h4 class="card-title">Form Filter</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="tanggalAwal" class="form-label">Tanggal Awal</label>
                            <input type="date" class="form-control" name="tanggalAwal">
                        </div>
                        <div class="col-md-4">
                            <label for="tanggalAkhir" class="form-label">Tanggal Akhir</label>
                            <input type="date" class="form-control" name="tanggalAkhir">
                        </div>
                        <div class="col-md-4">
                            <label for="userId" class="form-label">Nama User</label>
                            <select class="form-control" name="userId">
                                <option value="">Semua User</option>
                                <?php foreach ($users as $user): ?>
                                    <option value="<?php echo $user['idUser']; ?>">
                                        <?php echo $user['namaUser']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" name="filter" class="btn btn-primary">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel Data Penarikan -->
        <div class="card mt-4">
            <div class="card-header">
                <h4 class="card-title">Hasil Penarikan</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr align="center">
                                <th>No</th>
                                <th>ID Penarikan</th>
                                <th>Tanggal Penarikan</th>
                                <th>ID User</th>
                                <th>Nama User</th>
                                <th>Jumlah Penarikan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($penarikan)): ?>
                                <?php $i = 1; ?>
                                <?php foreach ($penarikan as $row): ?>
                                    <tr align="center">
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $row['idTarik']; ?></td>
                                        <td><?php echo $row['tglTarik']; ?></td>
                                        <td><?php echo $row['idUser']; ?></td>
                                        <td><?php echo $row['namaUser']; ?></td>
                                        <td><?php echo "Rp. " . number_format($row['jmlPenarikan'], 2, ",", "."); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" align="center">Tidak ada data yang ditemukan</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!--**********************************
    Content body end
***********************************-->

<?php include_once("footer.php"); ?>
